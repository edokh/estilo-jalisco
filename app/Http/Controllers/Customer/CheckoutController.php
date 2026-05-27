<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\FoodItem;
use App\Models\RestaurantSetting;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CheckoutController extends Controller
{
    public function show()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Cart is empty');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $subtotal = round($subtotal, 2);
        $taxPercentage = RestaurantSetting::taxPercentage();
        $taxAmount = round($subtotal * ($taxPercentage / 100), 2);
        $total = round($subtotal + $taxAmount, 2);

        return view('customer.checkout', compact('cart', 'subtotal', 'taxPercentage', 'taxAmount', 'total'));
    }

    public function processGuestCheckout(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'customer_notes' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Cart is empty');
        }

        return $this->createOrder($validated, null, $cart);
    }

    public function processRegisteredCheckout(Request $request)
    {
        $validated = $request->validate([
            'customer_phone' => [
                Rule::requiredIf(! auth()->user()->phone),
                'nullable',
                'string',
                'max:20',
            ],
            'customer_notes' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu')->with('error', 'Cart is empty');
        }

        $user = auth()->user();
        $validated['customer_name'] = $user->name;
        $validated['customer_phone'] = $user->phone ?: $request->input('customer_phone', '');
        $validated['customer_email'] = $user->email;

        return $this->createOrder($validated, $user->id, $cart);
    }

    private function createOrder($data, $userId, $cart)
    {
        $originalPrice = 0;
        $items = [];

        foreach ($cart as $foodItemId => $item) {
            $foodItem = FoodItem::find($foodItemId);
            if (!$foodItem) continue;

            $quantity = $item['quantity'];
            $price = $item['price'];
            $subtotal = $price * $quantity;

            $items[] = [
                'food_item_id' => $foodItemId,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal,
                'special_instructions' => $item['special_instructions'] ?? null,
            ];

            $originalPrice += $foodItem->price * $quantity;
        }

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['subtotal'];
        }

        $subtotal = round($subtotal, 2);
        $taxPercentage = RestaurantSetting::taxPercentage();
        $taxAmount = round($subtotal * ($taxPercentage / 100), 2);
        $finalPrice = round($subtotal + $taxAmount, 2);

        $order = Order::create([
            'user_id' => $userId,
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_email' => $data['customer_email'] ?? null,
            'customer_notes' => $data['customer_notes'] ?? null,
            'original_price' => $originalPrice,
            'discount_amount' => $originalPrice - $subtotal,
            'tax_percentage' => $taxPercentage,
            'tax_amount' => $taxAmount,
            'final_price' => $finalPrice,
        ]);

        foreach ($items as $item) {
            OrderItem::create(array_merge($item, ['order_id' => $order->id]));
        }
        $whatsApp = new WhatsAppService();
        $whatsApp->notifyOrderCreated($order->load('items.foodItem'));

        session()->forget('cart');

        return redirect()->route('order.confirmation', $order->id)
            ->with('success', 'Order placed successfully!');
    }

    public function confirmation(Order $order)
    {
        $order->load('items', 'items.foodItem');
        return view('customer.order-confirmation', compact('order'));
    }
}
