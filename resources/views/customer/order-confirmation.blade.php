@extends('layouts.app')

@section('title', 'Order Confirmation - Estilo Jalisco')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">✅</div>
            <h1 class="text-3xl font-bold text-green-600 mb-2">Order Confirmed!</h1>
            <p class="text-gray-600">Thank you for your order</p>
        </div>

        <!-- Order Number -->
        <div class="bg-green-50 border-2 border-green-600 rounded-lg p-6 mb-8 text-center">
            <p class="text-gray-600 mb-2">Order Number</p>
            <h2 class="text-4xl font-bold text-green-600">{{ $order->order_number }}</h2>
        </div>

        <!-- Customer Information -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <h3 class="text-xl font-bold mb-4">Customer Information</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Name</p>
                    <p class="font-semibold">{{ $order->customer_name }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Phone</p>
                    <p class="font-semibold">{{ $order->customer_phone }}</p>
                </div>
                @if ($order->customer_email)
                    <div>
                        <p class="text-gray-600 text-sm">Email</p>
                        <p class="font-semibold">{{ $order->customer_email }}</p>
                    </div>
                @endif
                @if ($order->customer_notes)
                    <div class="col-span-2">
                        <p class="text-gray-600 text-sm">Special Notes</p>
                        <p class="font-semibold">{{ $order->customer_notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <h3 class="text-xl font-bold mb-4">Order Items</h3>
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Item</th>
                        <th class="text-center py-2">Qty</th>
                        <th class="text-right py-2">Price</th>
                        <th class="text-right py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-b">
                            <td class="py-3">
                                <div>{{ $item->foodItem->name }}</div>
                                @if ($item->special_instructions)
                                    <div class="mt-1 text-xs text-gray-500">
                                        <span class="font-semibold">Instructions:</span> {{ $item->special_instructions }}
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">${{ number_format($item->price, 2) }}</td>
                            <td class="text-right font-semibold">${{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Summary -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <div class="flex justify-between mb-3 pb-3 border-b">
                <span>Original Price:</span>
                <span>${{ number_format($order->original_price, 2) }}</span>
            </div>
            @if ($order->discount_amount > 0)
                <div class="flex justify-between mb-3 pb-3 border-b text-green-600">
                    <span>Discount:</span>
                    <span>-${{ number_format($order->discount_amount, 2) }}</span>
                </div>
            @endif
            <div class="flex justify-between mb-3 pb-3 border-b">
                <span>Tax ({{ number_format($order->tax_percentage, 2) }}%):</span>
                <span>${{ number_format($order->tax_amount, 2) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold">
                <span>Total:</span>
                <span class="text-orange-600">${{ number_format($order->final_price, 2) }}</span>
            </div>
        </div>

        <!-- Status -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h3 class="font-bold mb-2">Order Status</h3>
            <p class="text-sm text-gray-600 mb-2">Current Status:</p>
            <p class="text-lg font-semibold capitalize text-blue-600">{{ $order->status }}</p>
            <p class="text-sm text-gray-600 mt-4">
                Your order has been received and is being prepared. You will be notified once it's ready for pickup.
            </p>
        </div>

        <!-- Actions -->
        <div class="flex gap-4 justify-center">
            <a href="{{ route('menu') }}" class="bg-orange-600 text-white px-6 py-3 rounded font-bold hover:bg-orange-700">
                Back to Menu
            </a>
            <button onclick="window.print()" class="bg-gray-600 text-white px-6 py-3 rounded font-bold hover:bg-gray-700">
                Print Receipt
            </button>
        </div>
    </div>
</div>
@endsection
