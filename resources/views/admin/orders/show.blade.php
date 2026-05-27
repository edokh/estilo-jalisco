@extends('layouts.app')

@section('title', 'Order Details - Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">{{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-2 gap-8">
        <!-- Order Info -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Customer Information</h2>
                <div class="space-y-2">
                    <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                    @if ($order->customer_email)
                        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                    @endif
                    @if ($order->customer_notes)
                        <p><strong>Notes:</strong> {{ $order->customer_notes }}</p>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Order Items</h2>
                <div class="space-y-3">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                            <div>
                                <p class="font-semibold">{{ $item->foodItem->name }}</p>
                                <p class="text-sm text-gray-600">x{{ $item->quantity }}</p>
                                @if ($item->special_instructions)
                                    <p class="mt-1 text-xs text-gray-500">
                                        <span class="font-semibold">Instructions:</span> {{ $item->special_instructions }}
                                    </p>
                                @endif
                            </div>
                            <p class="font-bold">${{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary & Actions -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Order Summary</h2>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between pb-3 border-b">
                        <span>Original Total:</span>
                        <span>${{ number_format($order->original_price, 2) }}</span>
                    </div>
                    @if ($order->discount_amount > 0)
                        <div class="flex justify-between pb-3 border-b text-green-600">
                            <span>Discount:</span>
                            <span>-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between pb-3 border-b">
                        <span>Tax ({{ number_format($order->tax_percentage, 2) }}%):</span>
                        <span>${{ number_format($order->tax_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold">
                        <span>Final Total:</span>
                        <span class="text-orange-600">${{ number_format($order->final_price, 2) }}</span>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded">
                    <p class="text-sm"><strong>Payment Status:</strong></p>
                    <p class="text-lg font-bold {{ $order->paid ? 'text-green-600' : 'text-red-600' }}">
                        {{ $order->paid ? '✓ PAID' : '✗ UNPAID' }}
                    </p>
                    @if ($order->paid_at)
                        <p class="text-sm text-gray-600">Paid on: {{ $order->paid_at->format('M d, Y H:i') }}</p>
                    @endif
                </div>
            </div>

            <!-- Status & Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Order Status</h2>

                <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="mb-4">
                    @csrf
                    <select name="status" class="w-full px-4 py-2 border rounded mb-4">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold">
                        Update Status
                    </button>
                </form>

                @if (!$order->paid)
                    <form method="POST" action="{{ route('admin.orders.mark-paid', $order) }}">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold">
                            Mark as Paid
                        </button>
                    </form>
                @endif
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Timeline</h2>
                <div class="space-y-2 text-sm">
                    <p><strong>Created:</strong> {{ $order->created_at->format('M d, Y H:i:s') }}</p>
                    <p><strong>Last Updated:</strong> {{ $order->updated_at->format('M d, Y H:i:s') }}</p>
                    @if ($order->paid_at)
                        <p><strong>Paid:</strong> {{ $order->paid_at->format('M d, Y H:i:s') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
