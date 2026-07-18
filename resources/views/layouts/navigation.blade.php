<nav id="navigation-bar"
    class="sticky top-0 z-50 border-b border-[#D4A017]/20 bg-[#130E07]/95 text-[#FAF3E0] backdrop-blur">
    <!-- Primary Navigation Menu -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between">
        <div class="relative flex items-center justify-between h-24">

            @php
                $navCart = session('cart', []);
                $navCartCount = array_sum(array_column($navCart, 'quantity'));
            @endphp

            <div class="absolute">
                <button id="cart-drawer-open" type="button"
                    class="relative inline-flex items-center rounded-md border border-transparent text-[#D4A017] transition hover:bg-[#D4A017]/10">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>

                    <span id="cart-badge"
                        class="absolute -top-2 -right-2 inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-[#C0392B] text-white text-xs font-semibold px-2">{{ $navCartCount }}</span>
                </button>
            </div>

            <div class="flex items-center">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if (auth()->user()->is_admin || auth()->user()->is_staff)
                            <a href="{{ route('menu') }}"
                                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('menu') ? 'border-[#D4A017] text-white' : 'border-transparent text-white hover:text-[#D4A017] hover:border-[#D4A017]' }}">
                                {{ __('Home') }}
                            </a>
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('admin.orders.index') }}"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('admin.orders.*') ? 'border-[#D4A017] text-white' : 'border-transparent text-white hover:text-[#D4A017] hover:border-[#D4A017]' }}">
                                    {{ __('Admin') }}
                                </a>
                            @elseif(auth()->user()->is_staff)
                                <a href="{{ route('staff.dashboard') }}"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out {{ request()->routeIs('staff.dashboard') ? 'border-[#D4A017] text-white' : 'border-transparent text-white hover:text-[#D4A017] hover:border-[#D4A017]' }}">
                                    {{ __('Staff') }}
                                </a>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>



        </div>

        <!-- Center Logo -->
        <div class="absolute inset-x-0 flex justify-center pointer-events-none">
            <div class="pointer-events-auto shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('storage/logo.png') }}" alt="Logo"
                        class="h-20 mt-2 sm:h-24 sm:mt-0  w-auto">
                </a>
            </div>
        </div>

        <!-- Cart / Settings -->
        <div class="flex items-center sm:ms-6 gap-3">
            @guest
                <a href="{{ route('login') }}"
                    class="hidden sm:inline-flex hover:bg-[#D4A017]/10 hover:bg-[#D4A017]/10 hover:text-[#D4A017] px-3 py-2 rounded">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-flex hover:bg-[#D4A017]/10 hover:bg-[#D4A017]/10 hover:text-[#D4A017] px-3 py-2 rounded">
                    Register
                </a>
            @endguest

            @auth
                <button id="user-dropdown-button" data-dropdown-toggle="user-dropdown" type="button"
                    class="inline-flex items-center rounded-md border border-[#D4A017]/20 bg-[#1E1409] px-3 py-2 text-sm font-medium text-[#FAF3E0] transition hover:border-[#D4A017] hover:bg-[#D4A017]/10 hover:text-[#D4A017]">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div id="user-dropdown"
                    class="z-50 hidden w-48 divide-y divide-[#D4A017]/10 rounded-lg bg-[#1E1409] border border-[#D4A017]/20 shadow-2xl">
                    <div class="px-4 py-3 text-xs text-gray-600">
                        @if (auth()->user()->is_admin)
                            <span
                                class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Admin</span>
                        @elseif(auth()->user()->is_staff)
                            <span
                                class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">Staff</span>
                        @else
                            <span
                                class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Customer</span>
                        @endif
                    </div>

                    <ul class="py-2 text-sm text-[#FAF3E0]/80" aria-labelledby="user-dropdown-button">
                        @if (auth()->user()->is_admin)
                            <li>
                                <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 hover:bg-[#D4A017]/10">
                                    {{ __('Admin Dashboard') }}
                                </a>
                            </li>
                        @elseif(auth()->user()->is_staff)
                            <li>
                                <a href="{{ route('staff.dashboard') }}" class="block px-4 py-2 hover:bg-[#D4A017]/10">
                                    {{ __('Staff Dashboard') }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('menu') }}" class="block px-4 py-2 hover:bg-[#D4A017]/10">
                                    {{ __('Browse Menu') }}
                                </a>
                            </li>
                        @endif
                    </ul>

                    <div class="py-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full px-4 py-2 text-left text-sm text-[#C0392B] hover:bg-[#C0392B]/10 hover:text-red-300">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Hamburger -->
        <div class="-me-2 flex items-center sm:hidden">
            <button data-collapse-toggle="mobile-menu" type="button" aria-controls="mobile-menu" aria-expanded="false"
                class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-[#D4A017] hover:bg-[#D4A017]/10 focus:outline-none focus:bg-[#D4A017]/10 focus:text-[#D4A017] transition duration-150 ease-in-out">
                <span class="sr-only">Open main menu</span>
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-menu" class="hidden sm:hidden">
        @auth
            @if (auth()->user()->is_admin || auth()->user()->is_staff)
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('menu') }}"
                        class="block px-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('menu') ? 'border-[#D4A017] bg-[#166226] text-white' : 'border-transparent text-white hover:border-[#D4A017] hover:bg-[#166226]' }}">
                        {{ __('Home') }}
                    </a>
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.orders.index') }}"
                            class="block px-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('admin.orders.*') ? 'border-[#D4A017] bg-[#166226] text-white' : 'border-transparent text-white hover:border-[#D4A017] hover:bg-[#166226]' }}">
                            {{ __('Admin') }}
                        </a>
                    @elseif(auth()->user()->is_staff)
                        <a href="{{ route('staff.dashboard') }}"
                            class="block px-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('staff.dashboard') ? 'border-[#D4A017] bg-[#166226] text-white' : 'border-transparent text-white hover:border-[#D4A017] hover:bg-[#166226]' }}">
                            {{ __('Staff') }}
                        </a>
                    @endif
                </div>
            @endif
        @else
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('login') }}"
                    class="block px-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('login') ? 'border-[#D4A017] bg-[#166226] text-white' : 'border-transparent text-white hover:border-[#D4A017] hover:bg-[#166226]' }}">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}"
                    class="block px-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out {{ request()->routeIs('register') ? 'border-[#D4A017] bg-[#166226] text-white' : 'border-transparent text-white hover:border-[#D4A017] hover:bg-[#166226]' }}">
                    {{ __('Register') }}
                </a>
            </div>
        @endauth

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-[#D4A017] bg-white text-gray-800">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <div class="px-4 py-2">
                        @if (auth()->user()->is_admin)
                            <span
                                class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Admin</span>
                        @elseif(auth()->user()->is_staff)
                            <span
                                class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">Staff</span>
                        @else
                            <span
                                class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Customer</span>
                        @endif
                    </div>

                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.orders.index') }}"
                            class="block px-4 py-2 text-base font-medium text-[#FAF3E0]/80 hover:bg-[#D4A017]/10">
                            {{ __('Admin Dashboard') }}
                        </a>
                    @elseif(auth()->user()->is_staff)
                        <a href="{{ route('staff.dashboard') }}"
                            class="block px-4 py-2 text-base font-medium text-[#FAF3E0]/80 hover:bg-[#D4A017]/10">
                            {{ __('Staff Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('menu') }}"
                            class="block px-4 py-2 text-base font-medium text-[#FAF3E0]/80 hover:bg-[#D4A017]/10">
                            {{ __('Browse Menu') }}
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full px-4 py-2 text-left text-base font-medium text-[#C0392B] hover:bg-[#C0392B]/10 hover:text-red-300">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>

</nav>

<!-- Cart Drawer -->
<div id="cart-drawer-backdrop" class="fixed inset-0 bg-black/40 hidden z-40"></div>
<aside id="cart-drawer"
    class="fixed inset-y-0 right-0 z-50 flex w-full max-w-md translate-x-full transform flex-col border-l border-[#D4A017]/20 bg-[#1E1409] shadow-2xl transition duration-300 ease-in-out">

    <!-- Header -->
    <div class="border-b border-[#D4A017]/20 bg-gradient-to-r from-yellow-950 to-yellow-600 p-6">
        <div class="flex items-start justify-between gap-4">

            <div>
                <p class="text-sm uppercase tracking-[0.15em] text-yellow-500">
                    Current Order
                </p>

                <h2 class="mt-1 text-2xl font-bold text-[#FAF3E0]">
                    Your Cart
                </h2>

                <p id="cart-item-count" class="mt-2 text-sm text-[#FAF3E0]/60">
                    0 items
                </p>
            </div>

            <button id="cart-drawer-close" type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[#D4A017]/20 bg-[#130E07] text-[#FAF3E0] transition hover:bg-[#D4A017]/10 hover:text-[#D4A017]"
                aria-label="Close cart">

                <span class="text-2xl leading-none">&times;</span>

            </button>

        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 space-y-5 overflow-y-auto p-5">

        <!-- Login -->
        <div id="cart-auth-panel" class="hidden rounded-xl border border-[#D4A017]/20 bg-[#130E07] p-5">

            <p class="mb-4 text-sm leading-6 text-[#FAF3E0]/70">
                Sign in or create an account to save your order and checkout faster.
            </p>

            <div class="flex gap-3">

                <a href="{{ route('login') }}"
                    class="flex-1 rounded-lg bg-yellow-600 px-4 py-3 text-center font-semibold text-white transition hover:bg-yellow-700">
                    Log In
                </a>

                <a href="{{ route('register') }}"
                    class="flex-1 rounded-lg border border-[#D4A017]/20 bg-transparent px-4 py-3 text-center font-semibold text-[#FAF3E0] transition hover:bg-[#D4A017]/10 hover:text-[#D4A017]">
                    Sign Up
                </a>

            </div>

        </div>

        <!-- Cart Items -->
        <div id="cart-items-list" class="space-y-4 rounded-xl border border-[#D4A017]/20 bg-[#130E07] p-5">

            <div class="text-center text-sm text-[#FAF3E0]/45">
                No items yet. Add something delicious from the menu.
            </div>

        </div>

        <!-- Guest Phone -->
        <div id="guest-phone-panel" class="hidden space-y-3">

            <label for="guest-phone" class="block text-sm font-medium text-[#FAF3E0]">

                Phone Number

            </label>

            <input id="guest-phone" type="tel" placeholder="555-555-5555"
                class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] placeholder:text-[#FAF3E0]/35 focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

            <p class="text-xs text-[#FAF3E0]/45">
                Phone number is required for guest checkout.
            </p>

        </div>

    </div>

    <!-- Footer -->
    <div class="border-t border-[#D4A017]/20 bg-[#130E07] p-5">

        <!-- Totals -->
        <div class="space-y-3 rounded-xl border border-[#D4A017]/20 bg-[#1A120A] p-5 text-sm">

            <div class="flex justify-between text-[#FAF3E0]/70">
                <span>Item Total</span>
                <span id="cart-item-total">$0.00</span>
            </div>

            <div class="flex justify-between text-[#FAF3E0]/70">
                <span>Tax</span>
                <span id="cart-sub-total">$0.00</span>
            </div>

            <div class="flex justify-between border-t border-[#D4A017]/20 pt-4 text-lg font-bold text-[#D4A017]">

                <span>Order Total</span>

                <span id="cart-order-total">$0.00</span>

            </div>

        </div>

        <!-- Checkout -->
        <div class="mt-5 space-y-3">

            <button id="cart-checkout-button"
                class="w-full rounded-lg bg-yellow-600 px-4 py-3 font-semibold text-white transition hover:bg-yellow-700 disabled:cursor-not-allowed disabled:opacity-40"
                disabled>

                Checkout

            </button>

            <p id="cart-empty-note" class="text-center text-sm leading-6 text-[#FAF3E0]/45">

                Login or create an account to keep your order saved.

            </p>

        </div>

    </div>

</aside>

<script>
    window.whenJQueryReady(function($) {
        function initializeCartDrawer() {
            const $cartDrawer = $('#cart-drawer');
            const $cartBackdrop = $('#cart-drawer-backdrop');
            const $cartOpenBtn = $('#cart-drawer-open');
            const $cartCloseBtn = $('#cart-drawer-close');
            const $cartBadge = $('#cart-badge');
            const $cartItemCount = $('#cart-item-count');
            const $cartItemsList = $('#cart-items-list');
            const $cartItemTotal = $('#cart-item-total');
            const $cartSubTotal = $('#cart-sub-total');
            const $cartOrderTotal = $('#cart-order-total');
            const $cartCheckoutButton = $('#cart-checkout-button');
            const $cartEmptyNote = $('#cart-empty-note');
            const $cartAuthPanel = $('#cart-auth-panel');
            const $guestPhonePanel = $('#guest-phone-panel');
            const $guestPhoneInput = $('#guest-phone');
            const cartRemoveBaseUrl = '/cart/remove';
            const cartUpdateBaseUrl = '/cart/update';
            const cartGetUrl = '{{ route('cart.get', [], false) }}';
            const checkoutUrl = '{{ route('checkout', [], false) }}';

            function toggleCartDrawer(open) {
                if (open) {
                    $cartDrawer.removeClass('translate-x-full');
                    $cartBackdrop.removeClass('hidden');
                    $('body').addClass('overflow-hidden');
                } else {
                    $cartDrawer.addClass('translate-x-full');
                    $cartBackdrop.addClass('hidden');
                    $('body').removeClass('overflow-hidden');
                }
            }

            function updateCheckoutButtonState(cart, isGuest) {
                if (!cart.length) {
                    $cartCheckoutButton.prop('disabled', true).text('Checkout');
                    return;
                }

                if (isGuest) {
                    const phoneValue = $guestPhoneInput.val().trim();
                    $cartCheckoutButton.prop('disabled', !phoneValue).text(phoneValue ? 'Checkout' :
                        'Enter phone to checkout');
                } else {
                    $cartCheckoutButton.prop('disabled', false).text('Checkout');
                }
            }

            function escapeHtml(value) {
                return $('<div>').text(value || '').html();
            }

            function updateCartItem(itemId, quantity, instructions) {
                return $.ajax({
                    url: `${cartUpdateBaseUrl}/${itemId}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify({
                        quantity,
                        instructions
                    })
                });
            }

            function renderCart(data) {
                const cartData = data.cart || {};
                const cart = Array.isArray(cartData) ? cartData : Object.values(cartData);
                const itemCount = Number(data.count ?? cart.reduce((sum, item) => sum + (Number(item
                    .quantity) || 0), 0));
                const fallbackSubtotal = cart.reduce((sum, item) => sum + ((Number(item
                    .price) || 0) * (Number(item.quantity) || 0)), 0);
                const subtotal = Number(data.subtotal ?? fallbackSubtotal);
                const taxPercentage = Number(data.tax_percentage ?? 0);
                const taxAmount = Number(data.tax_amount ?? (subtotal * (taxPercentage / 100)));
                const orderTotal = Number(data.total ?? (subtotal + taxAmount));

                $cartBadge.text(itemCount);
                $cartItemCount.text(`${itemCount} item${itemCount !== 1 ? 's' : ''}`);

                if (!cart.length) {
                    $cartItemsList.html(
                        `<div class="rounded-lg p-6 text-center">
                            <div class="text-base font-semibold text-gray-800 text-white">Your cart is empty</div>
                            <p class="mt-1 text-sm text-gray-300">Add something delicious from the menu.</p>
                        </div>`
                    );
                    $cartItemTotal.text('$0.00');
                    $cartSubTotal.text('$0.00');
                    $cartOrderTotal.text('$0.00');
                    $cartEmptyNote.text('Add items to your cart to see the order summary.');
                    $guestPhonePanel.addClass('hidden');
                    @if (auth()->check())
                        $cartAuthPanel.addClass('hidden');
                    @else
                        $cartAuthPanel.removeClass('hidden');
                    @endif
                    updateCheckoutButtonState(cart, {{ auth()->check() ? 'false' : 'true' }});
                    return;
                }

                $cartItemsList.html(cart.map(item => {
                    const quantity = Number(item.quantity) || 0;
                    const price = Number(item.price) || 0;
                    const instructions = item.special_instructions ? escapeHtml(item
                        .special_instructions) : '';
                    const itemId = item.id || '';
                    return `
                    <div class="w-full text-left px-4 py-2 rounded-lg category-btn border border-yellow-600/20 bg-white/10 text-yellow-500 border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-100">${escapeHtml(item.name || 'Unnamed item')}</h3>
                                        <p class="text-xs text-gray-400">$${price.toFixed(2)} each</p>
                                    </div>
                                    <button type="button" data-item="${itemId}" class="text-xs font-semibold text-red-500 hover:text-red-700 cart-remove-button">Remove</button>
                                </div>

                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <div class="inline-flex h-9 items-center overflow-hidden rounded border border-yellow-900">
                                        <button type="button" data-item="${itemId}" data-quantity="${quantity}" data-direction="-1"
                                            class="cart-quantity-button flex h-9 w-9 items-center justify-center text-lg text-yellow-500 hover:bg-[#D4A017]/10">-</button>
                                        <span class="flex h-9 min-w-10 items-center justify-center border-x border-yellow-900 px-3 text-sm font-semibold text-yellow-500">${quantity}</span>
                                        <button type="button" data-item="${itemId}" data-quantity="${quantity}" data-direction="1"
                                            class="cart-quantity-button flex h-9 w-9 items-center justify-center text-lg text-yellow-500 hover:bg-[#D4A017]/10">+</button>
                                    </div>

                                    <div class="text-right">
                                        <div class="font-semibold text-yellow-500">$${(price * quantity).toFixed(2)}</div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-400" for="cart-instructions-${itemId}">
                                        Instructions
                                    </label>
                                    <textarea id="cart-instructions-${itemId}" data-item="${itemId}" data-quantity="${quantity}" rows="2"
                                        class="bg-white/5 cart-instructions-input w-full resize-none rounded border border-yellow-700 px-3 py-2 text-sm text-[#FAF3E0]/80 focus:border-yellow-600 focus:outline-none focus:ring-1 focus:ring-yellow-600"
                                        placeholder="No onions, extra salsa...">${instructions}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                }).join(''));

                $cartItemTotal.text(`$${subtotal.toFixed(2)}`);
                $cartSubTotal.text(`$${taxAmount.toFixed(2)} (${taxPercentage.toFixed(2)}%)`);
                $cartOrderTotal.text(`$${orderTotal.toFixed(2)}`);
                $cartEmptyNote.text(
                    '{{ auth()->check() ? '' : 'If you have an account, login to save your order for later.' }}'
                );

                @if (auth()->check())
                    $cartAuthPanel.addClass('hidden');
                    $guestPhonePanel.addClass('hidden');
                    updateCheckoutButtonState(cart, false);
                @else
                    $cartAuthPanel.removeClass('hidden');
                    $guestPhonePanel.removeClass('hidden');
                    updateCheckoutButtonState(cart, true);
                @endif

                $('.cart-remove-button').on('click', function() {
                    const itemId = $(this).data('item');
                    if (!itemId) {
                        return;
                    }
                    $.ajax({
                            url: `${cartRemoveBaseUrl}/${itemId}`,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            dataType: 'json'
                        })
                        .done(fetchCart)
                        .fail(console.error);
                });

                $('.cart-quantity-button').on('click', function() {
                    const itemId = $(this).data('item');
                    const currentQuantity = Number($(this).data('quantity')) || 0;
                    const direction = Number($(this).data('direction')) || 0;
                    const nextQuantity = Math.max(currentQuantity + direction, 0);
                    const instructions = $(`#cart-instructions-${itemId}`).val() || '';

                    if (!itemId) {
                        return;
                    }

                    updateCartItem(itemId, nextQuantity, instructions)
                        .done(fetchCart)
                        .fail(console.error);
                });

                $('.cart-instructions-input').on('blur', function() {
                    const itemId = $(this).data('item');
                    const quantity = Number($(this).data('quantity')) || 1;
                    const instructions = $(this).val().trim();

                    if (!itemId) {
                        return;
                    }

                    updateCartItem(itemId, quantity, instructions)
                        .done(fetchCart)
                        .fail(console.error);
                });
            }

            function fetchCart() {
                $.ajax({
                        url: cartGetUrl,
                        method: 'GET',
                        dataType: 'json'
                    })
                    .done(renderCart)
                    .fail(console.error);
            }

            $(document).on('cart-updated', fetchCart);

            $cartOpenBtn.on('click', function() {
                fetchCart();
                toggleCartDrawer(true);
            });

            $cartCloseBtn.on('click', function() {
                toggleCartDrawer(false);
            });

            $cartBackdrop.on('click', function() {
                toggleCartDrawer(false);
            });

            $guestPhoneInput.on('input', function() {
                fetchCart();
            });

            $cartCheckoutButton.on('click', function() {
                $.ajax({
                        url: cartGetUrl,
                        method: 'GET',
                        dataType: 'json'
                    })
                    .done(function(data) {
                        if (!Object.keys(data.cart || {}).length) {
                            return;
                        }

                        @if (auth()->check())
                            window.location.href = checkoutUrl;
                        @else
                            const phone = $guestPhoneInput.val().trim();
                            if (!phone) {
                                $guestPhoneInput.focus();
                                return;
                            }
                            window.location.href =
                                `${checkoutUrl}?phone=${encodeURIComponent(phone)}`;
                        @endif
                    })
                    .fail(console.error);
            });

            $cartBadge.text({{ $navCartCount }});
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCartDrawer);
        } else {
            initializeCartDrawer();
        }
    });
</script>
