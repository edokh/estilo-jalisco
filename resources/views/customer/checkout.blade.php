@extends('layouts.app')

@section('title', 'Checkout - Estilo Jalisco')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Order Summary -->
        <div class="md:col-span-2">
            <!-- Checkout Method Toggle -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Checkout Method</h2>
                <div class="flex gap-4">
                    @if (auth()->check())
                        <button onclick="showCheckoutMethod('registered')" id="registered-btn"
                                class="flex-1 px-4 py-2 bg-green-600 text-white rounded checkout-method-btn">
                            Registered User
                        </button>
                        <button onclick="showCheckoutMethod('guest')" id="guest-btn"
                                class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded checkout-method-btn">
                            Guest Checkout
                        </button>
                    @else
                        <button onclick="showCheckoutMethod('guest')" id="guest-btn"
                                class="flex-1 px-4 py-2 bg-green-600 text-white rounded checkout-method-btn">
                            Guest Checkout
                        </button>
                    @endif
                </div>
            </div>

            <!-- Guest Checkout Form -->
            <form id="guest-checkout-form" method="POST" action="{{ route('checkout.guest') }}" 
                  class="bg-white rounded-lg shadow p-6 space-y-4" style="display: none;">
                @csrf
                <h2 class="text-xl font-bold mb-4">Your Information</h2>

                <div>
                    <label class="block text-sm font-medium mb-2">Full Name *</label>
                    <input type="text" name="customer_name" required class="w-full px-3 py-2 border rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Phone Number *</label>
                    <input type="tel" name="customer_phone" value="{{ old('customer_phone', request('phone')) }}" required class="w-full px-3 py-2 border rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="customer_email" class="w-full px-3 py-2 border rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Special Notes</label>
                    <textarea name="customer_notes" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
                </div>

                <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded font-bold hover:bg-green-700">
                    Place Order
                </button>
            </form>

            <!-- Registered Checkout Form -->
            @if (auth()->check())
                <form id="registered-checkout-form" method="POST" action="{{ route('checkout.registered') }}"
                      class="bg-white rounded-lg shadow p-6 space-y-4">
                    @csrf
                    <h2 class="text-xl font-bold mb-4">Order Details</h2>

                    <div class="bg-blue-50 p-4 rounded space-y-2">
                        <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>Phone:</strong> {{ auth()->user()->phone ?? 'Not provided' }}</p>
                    </div>

                    @if (!auth()->user()->phone)
                        <div>
                            <label class="block text-sm font-medium mb-2">Phone Number *</label>
                            <input type="tel" name="customer_phone" required value="{{ old('customer_phone') }}" class="w-full px-3 py-2 border rounded">
                        </div>
                    @else
                        <input type="hidden" name="customer_phone" value="{{ auth()->user()->phone }}">
                    @endif

                    <div>
                        <label class="block text-sm font-medium mb-2">Special Notes</label>
                        <textarea name="customer_notes" rows="3" class="w-full px-3 py-2 border rounded"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded font-bold hover:bg-green-700">
                        Place Order
                    </button>
                </form>
            @endif
        </div>

        <!-- Order Items Summary -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-20">
                <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                <div id="order-items" class="space-y-3 mb-4">
                    @foreach ($cart as $itemId => $item)
                        <div class="flex justify-between text-sm pb-2 border-b">
                            <div>
                                <p class="font-semibold">{{ $item['name'] }}</p>
                                <p class="text-gray-600">x{{ $item['quantity'] }}</p>
                            </div>
                            <p class="font-semibold">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="text-lg font-bold flex justify-between">
                        <span>Total:</span>
                        <span class="text-orange-600">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.whenJQueryReady(function($) {
        $(function() {
            const $guestForm = $('#guest-checkout-form');
            const $registeredForm = $('#registered-checkout-form');
        const $guestBtn = $('#guest-btn');
        const $registeredBtn = $('#registered-btn');

        function showCheckoutMethod(method) {
            if (method === 'guest') {
                $guestForm.show();
                $registeredForm.hide();
                $guestBtn.removeClass('bg-gray-300 text-gray-700').addClass('bg-green-600 text-white');
                $registeredBtn.removeClass('bg-green-600 text-white').addClass('bg-gray-300 text-gray-700');
            } else {
                $registeredForm.show();
                $guestForm.hide();
                $registeredBtn.removeClass('bg-gray-300 text-gray-700').addClass('bg-green-600 text-white');
                $guestBtn.removeClass('bg-green-600 text-white').addClass('bg-gray-300 text-gray-700');
            }
        }

        @if (auth()->check())
            showCheckoutMethod('registered');
        @else
            showCheckoutMethod('guest');
        @endif
    });
});
</script>
@endsection
