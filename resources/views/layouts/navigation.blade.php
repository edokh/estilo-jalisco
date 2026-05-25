<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-[#1d7d32] border-b border-[#f7c600] text-white">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-24">

            <div class="absolute">
                <button id="cart-drawer-open" type="button"
                    class="relative inline-flex items-center border border-transparent text-sm font-medium rounded-md  text-amber-400 hover:bg-gray-100 focus:outline-none transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>

                    <span id="cart-badge"
                        class="absolute -top-2 -right-2 inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-red-600 text-white text-xs font-semibold px-2">0</span>
                </button>
            </div>

            <div class="flex items-center">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if (auth()->user()->is_admin || auth()->user()->is_staff)
                            <x-nav-link :href="route('menu')" :active="request()->routeIs('menu')">
                                {{ __('Home') }}
                            </x-nav-link>
                            @if (auth()->user()->is_admin)
                                <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                                    {{ __('Admin') }}
                                </x-nav-link>
                            @elseif(auth()->user()->is_staff)
                                <x-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">
                                    {{ __('Staff') }}
                                </x-nav-link>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>


            <!-- Center Logo -->
            <div class="absolute inset-x-0 flex justify-center pointer-events-none">
                <div class="pointer-events-auto shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-28 w-auto">
                        {{-- <x-application-logo class="block h-9 w-auto fill-current text-gray-800" /> --}}
                    </a>
                </div>
            </div>

            <!-- Cart / Settings -->
            <div class="flex items-center sm:ms-6 gap-3">
                @guest
                    <a href="{{ route('login') }}"
                        class="hidden sm:inline-flex hover:bg-gray-100 text-white hover:text-gray-700 px-3 py-2 rounded">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="hidden sm:inline-flex hover:bg-gray-100 text-white hover:text-gray-700 px-3 py-2 rounded">
                        Register
                    </a>
                @endguest
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- User Info Section -->
                            <div class="px-4 py-3 text-xs text-gray-600 border-b">
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

                            <!-- Menu Options -->
                            @if (auth()->user()->is_admin)
                                <x-dropdown-link :href="route('admin.orders.index')">
                                    {{ __('Admin Dashboard') }}
                                </x-dropdown-link>
                            @elseif(auth()->user()->is_staff)
                                <x-dropdown-link :href="route('staff.dashboard')">
                                    {{ __('Staff Dashboard') }}
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('menu')">
                                    {{ __('Browse Menu') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="text-red-600 hover:text-red-700 hover:bg-red-50">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-[#f7c600] hover:bg-[#13401a] focus:outline-none focus:bg-[#13401a] focus:text-[#f7c600] transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        @auth
            @if (auth()->user()->is_admin || auth()->user()->is_staff)
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('menu')" :active="request()->routeIs('menu')">
                        {{ __('Home') }}
                    </x-responsive-nav-link>
                    @if (auth()->user()->is_admin)
                        <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            {{ __('Admin') }}
                        </x-responsive-nav-link>
                    @elseif(auth()->user()->is_staff)
                        <x-responsive-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">
                            {{ __('Staff') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endif
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            </div>
        @endauth

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- User Role Badge -->
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

                    <!-- Dashboard Link -->
                    @if (auth()->user()->is_admin)
                        <x-responsive-nav-link :href="route('admin.orders.index')">
                            {{ __('Admin Dashboard') }}
                        </x-responsive-nav-link>
                    @elseif(auth()->user()->is_staff)
                        <x-responsive-nav-link :href="route('staff.dashboard')">
                            {{ __('Staff Dashboard') }}
                        </x-responsive-nav-link>
                    @else
                        <x-responsive-nav-link :href="route('menu')">
                            {{ __('Browse Menu') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>

    <!-- Cart Drawer -->
    <div id="cart-drawer-backdrop" class="fixed inset-0 bg-black/40 hidden z-40"></div>
    <aside id="cart-drawer"
        class="fixed inset-y-0 right-0 z-50 flex w-full max-w-md transform translate-x-full flex-col bg-white shadow-2xl transition duration-300 ease-in-out">
        <div class="border-b bg-gradient-to-r from-green-700 to-green-600 p-6 text-white">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-green-100">Current order</p>
                    <h2 class="text-2xl font-bold">Your Cart</h2>
                    <p id="cart-item-count" class="mt-1 text-sm text-green-100">0 items</p>
                </div>
                <button id="cart-drawer-close" type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white hover:bg-white/20"
                    aria-label="Close cart">
                    <span class="text-2xl leading-none">&times;</span>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-5 space-y-5">
            <div id="cart-auth-panel" class="hidden rounded-lg border border-green-100 bg-green-50 p-4">
                <div class="text-sm text-gray-600 mb-3">Sign up or log in to save your order and checkout faster.</div>
                <div class="flex gap-3">
                    <a href="{{ route('login') }}"
                        class="flex-1 inline-flex justify-center items-center px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">Log
                        In</a>
                    <a href="{{ route('register') }}"
                        class="flex-1 inline-flex justify-center items-center px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">Sign
                        Up</a>
                </div>
            </div>

            <div id="cart-items-list" class="space-y-4">
                <div class="text-sm text-gray-500">No items yet. Add something delicious from the menu.</div>
            </div>

            <div id="guest-phone-panel" class="space-y-3 hidden">
                <label for="guest-phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input id="guest-phone" type="tel" placeholder="555-555-5555"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-gray-700" />
                <p class="text-xs text-gray-500">Phone is required to proceed for guest checkout.</p>
            </div>
        </div>

        <div class="border-t bg-white p-5 space-y-4">
            <div class="rounded-lg bg-gray-50 p-4 text-sm text-gray-700 space-y-3">
                <div class="flex justify-between">
                    <span>Item Total</span>
                    <span id="cart-item-total">$0.00</span>
                </div>
                <div class="flex justify-between">
                    <span>Sub-Total</span>
                    <span id="cart-sub-total">$0.00</span>
                </div>
                <div class="border-t pt-3 flex justify-between font-semibold text-gray-900">
                    <span>Order Total</span>
                    <span id="cart-order-total">$0.00</span>
                </div>
            </div>

            <div class="space-y-3">
                <button id="cart-checkout-button"
                    class="w-full inline-flex justify-center items-center px-4 py-3 rounded bg-green-600 text-white font-semibold hover:bg-green-700 disabled:opacity-50"
                    disabled>
                    Checkout
                </button>
                <p id="cart-empty-note" class="text-sm text-gray-500">Need an account? Login or signup will keep your
                    order saved.</p>
            </div>
        </div>
    </aside>
</nav>

<script>
    window.whenJQueryReady(function($) {
        document.addEventListener('DOMContentLoaded', function() {
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
            const cartRemoveBaseUrl = '{{ url('/cart/remove') }}';
            const cartUpdateBaseUrl = '{{ url('/cart/update') }}';
            const cartGetUrl = '{{ route('cart.get') }}';
            const checkoutUrl = '{{ route('checkout') }}';

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
                const orderTotal = Number(data.total ?? cart.reduce((sum, item) => sum + ((Number(item
                    .price) || 0) * (Number(item.quantity) || 0)), 0));

                $cartBadge.text(itemCount);
                $cartItemCount.text(`${itemCount} item${itemCount !== 1 ? 's' : ''}`);

                if (!cart.length) {
                    $cartItemsList.html(
                        `<div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-center">
                            <div class="text-base font-semibold text-gray-800">Your cart is empty</div>
                            <p class="mt-1 text-sm text-gray-500">Add something delicious from the menu.</p>
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
                    const instructions = item.special_instructions ? escapeHtml(item.special_instructions) : '';
                    const itemId = item.id || '';
                    return `
                    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">${escapeHtml(item.name || 'Unnamed item')}</h3>
                                        <p class="text-xs text-gray-500">$${price.toFixed(2)} each</p>
                                    </div>
                                    <button type="button" data-item="${itemId}" class="text-xs font-semibold text-red-500 hover:text-red-700 cart-remove-button">Remove</button>
                                </div>

                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <div class="inline-flex h-9 items-center overflow-hidden rounded border border-gray-300">
                                        <button type="button" data-item="${itemId}" data-quantity="${quantity}" data-direction="-1"
                                            class="cart-quantity-button flex h-9 w-9 items-center justify-center text-lg text-gray-700 hover:bg-gray-100">-</button>
                                        <span class="flex h-9 min-w-10 items-center justify-center border-x border-gray-300 px-3 text-sm font-semibold text-gray-900">${quantity}</span>
                                        <button type="button" data-item="${itemId}" data-quantity="${quantity}" data-direction="1"
                                            class="cart-quantity-button flex h-9 w-9 items-center justify-center text-lg text-gray-700 hover:bg-gray-100">+</button>
                                    </div>

                                    <div class="text-right">
                                        <div class="font-semibold text-gray-900">$${(price * quantity).toFixed(2)}</div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500" for="cart-instructions-${itemId}">
                                        Instructions
                                    </label>
                                    <textarea id="cart-instructions-${itemId}" data-item="${itemId}" data-quantity="${quantity}" rows="2"
                                        class="cart-instructions-input w-full resize-none rounded border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500"
                                        placeholder="No onions, extra salsa...">${instructions}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                }).join(''));

                $cartItemTotal.text(`$${orderTotal.toFixed(2)}`);
                $cartSubTotal.text(`$${orderTotal.toFixed(2)}`);
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

            fetchCart();
        });
    });
</script>
