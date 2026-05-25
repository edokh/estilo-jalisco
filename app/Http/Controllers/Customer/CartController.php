<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, FoodItem $foodItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'instructions' => 'nullable|string|max:1000',
        ]);

        $instructions = trim($validated['instructions'] ?? '');
        $cart = session()->get('cart', []);

        if (isset($cart[$foodItem->id])) {
            $cart[$foodItem->id]['quantity'] += $validated['quantity'];
            $cart[$foodItem->id]['special_instructions'] = $instructions ?: null;
        } else {
            $cart[$foodItem->id] = [
                'id' => $foodItem->id,
                'name' => $foodItem->name,
                'price' => $foodItem->getPriceWithDiscount(),
                'image' => $foodItem->image,
                'quantity' => $validated['quantity'],
                'special_instructions' => $instructions ?: null,
                'original_price' => $foodItem->price,
            ];
        }

        session()->put('cart', $cart);

        $itemCount = array_sum(array_column($cart, 'quantity'));

        return response()->json(['success' => true, 'count' => $itemCount]);
    }

    public function removeFromCart(FoodItem $foodItem)
    {
        $cart = session()->get('cart', []);
        unset($cart[$foodItem->id]);
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function updateQuantity(Request $request, FoodItem $foodItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
            'instructions' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if ($validated['quantity'] <= 0) {
            unset($cart[$foodItem->id]);
        } elseif (isset($cart[$foodItem->id])) {
            $cart[$foodItem->id]['quantity'] = $validated['quantity'];
            $instructions = trim($validated['instructions'] ?? '');
            $cart[$foodItem->id]['special_instructions'] = $instructions ?: null;
        }

        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    public function getCart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $itemCount = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $itemCount += $item['quantity'];
        }

        return response()->json(['cart' => $cart, 'total' => $total, 'count' => $itemCount]);
    }
}
