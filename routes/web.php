<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FoodItemController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Staff\DashboardController;
use App\Models\Order;
use App\Services\WhatsAppService;
use Vonage\Messages\Channel\WhatsApp\WhatsAppText;
use Vonage\Client;
use Vonage\Client\Credentials\Keypair;
use Vonage\Messages\Channel\SMS\SMSText;

require __DIR__ . '/auth.php';

// Customer Routes
Route::get('/', [MenuController::class, 'index'])->name('menu');
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.orders.index');
        }

        if (auth()->user()->is_staff) {
            return redirect()->route('staff.dashboard');
        }
    }

    return redirect()->route('menu');
})->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('food-items', FoodItemController::class);
    Route::resource('discounts', DiscountController::class);

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/timings', [SettingsController::class, 'updateTimings'])->name('settings.timings');
    Route::post('/settings/tax', [SettingsController::class, 'updateTax'])->name('settings.tax');
    Route::post('/settings/whatsapp', [SettingsController::class, 'updateWhatsApp'])->name('settings.whatsapp');
    Route::post('/settings/holiday', [SettingsController::class, 'addHoliday'])->name('settings.holiday');
    Route::delete('/settings/holiday/{holiday}', [SettingsController::class, 'removeHoliday'])->name('settings.holiday.remove');

    Route::get('/orders', [OrderManagementController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderManagementController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{order}/mark-paid', [OrderManagementController::class, 'markAsPaid'])->name('orders.mark-paid');
});

// Staff Routes
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders/{status?}', [DashboardController::class, 'orders'])->name('orders.index')
        ->where('status', 'pending|preparing|ready|completed');
    Route::post('/orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.status');
});

Route::get('/orders/summary', function () {
    $user = auth()->user();
    if (! $user || ! ($user->is_admin || $user->is_staff)) {
        abort(403);
    }

    return response()->json([
        'total' => Order::count(),
        'pending' => Order::where('status', 'pending')->count(),
        'preparing' => Order::where('status', 'preparing')->count(),
        'ready' => Order::where('status', 'ready')->count(),
        'completed' => Order::where('status', 'completed')->count(),
        'latest_order_id' => Order::latest('id')->value('id'),
    ]);
})->middleware('auth')->name('orders.summary');

Route::get('/orders/stream', function () {
    $user = auth()->user();
    if (! $user || ! ($user->is_admin || $user->is_staff)) {
        abort(403);
    }

    ignore_user_abort(true);
    set_time_limit(0);

    $lastId = Order::latest('id')->value('id') ?? 0;

    return response()->stream(function () use (&$lastId) {
        $counter = 0;

        while (true) {
            if (connection_aborted()) {
                break;
            }

            $order = Order::where('id', '>', $lastId)->orderBy('id')->first();
            if ($order) {
                $lastId = $order->id;

                $payload = json_encode([
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name,
                    'status' => $order->status,
                    'created_at' => $order->created_at->toDateTimeString(),
                    'pending' => Order::where('status', 'pending')->count(),
                    'preparing' => Order::where('status', 'preparing')->count(),
                    'ready' => Order::where('status', 'ready')->count(),
                    'completed' => Order::where('status', 'completed')->count(),
                    'total' => Order::count(),
                ]);

                echo "event: order-created\n";
                echo "data: {$payload}\n\n";
                ob_flush();
                flush();
            }

            echo ": ping\n\n";
            ob_flush();
            flush();

            sleep(2);
            $counter += 2;

            if ($counter >= 300) {
                break;
            }
        }
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
    ]);
})->middleware('auth')->name('orders.stream');

Route::post('/cart/add/{foodItem}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{foodItem}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update/{foodItem}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::get('/cart', [CartController::class, 'getCart'])->name('cart.get');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout/guest', [CheckoutController::class, 'processGuestCheckout'])->name('checkout.guest');
Route::post('/checkout/registered', [CheckoutController::class, 'processRegisteredCheckout'])->middleware('auth')->name('checkout.registered');
Route::get('/order/{order}/confirmation', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

Route::middleware(['auth', 'verified'])->group(function () {
    // Authenticated user routes
});



Route::get('/test-whatsapp', function () {
    $to="9647850632690";
    $from="14157386102";
    $text="Test message from Estilo Jalisco";
    $message = new WhatsAppText($to, $from, $text);

    try {
        $privateKeyPath = base_path(config('services.vonage.private_key'));
        $credential = new Keypair(
            file_get_contents($privateKeyPath),
            config('services.vonage.application_id')
        );

        $sandboxBaseUrl = 'https://messages-sandbox.nexmo.com/v1/messages';
        $client = new Client($credential);
        $client->messages()->getAPIResource()->setBaseUrl($sandboxBaseUrl);
        $response = $client->messages()->send($message);

        return response()->json([
            'success' => true,
            'message' => 'WhatsApp test succeeded',
            'response' => $response,
        ], 200);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::get('/message', function () {
    // $to="9647800607869";
    $to="9647850632690";
    $from="14157386102";
    $text="Hello from Vonage!";
    $message = new WhatsAppText($to, $from, $text);

    $privateKeyPath =base_path(config('services.vonage.private_key'));
    $credential = new Keypair(
        file_get_contents($privateKeyPath),
        config('services.vonage.application_id')
    );

    $sandboxBaseUrl = 'https://messages-sandbox.nexmo.com/v1/messages';
    $client = new Client($credential);
    $client->messages()->getAPIResource()->setBaseUrl($sandboxBaseUrl);
    $client->messages()->send($message);

    return response()->json(['message' => 'Message sent successfully']);
});
