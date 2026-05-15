<nav class="bg-orange-600 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">
            <a href="{{ route('menu') }}">🍔 Estilo Jalisco</a>
        </h1>

        <div class="flex items-center gap-6">
            @if (auth()->check())
                @if (auth()->user()->is_admin || auth()->user()->is_staff)
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.categories.index') }}" class="hover:bg-orange-700 px-3 py-2 rounded">
                            Admin Panel
                        </a>
                    @endif
                    @if (auth()->user()->is_staff)
                        <a href="{{ route('staff.dashboard') }}" class="hover:bg-orange-700 px-3 py-2 rounded">
                            Staff Dashboard
                        </a>
                    @endif
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="hover:bg-orange-700 px-3 py-2 rounded">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:bg-orange-700 px-3 py-2 rounded">
                    Login
                </a>
                <a href="{{ route('register') }}" class="hover:bg-orange-700 px-3 py-2 rounded">
                    Register
                </a>
            @endif

            <a href="{{ route('checkout') }}" class="bg-orange-700 hover:bg-orange-800 px-4 py-2 rounded cart-icon">
                🛒 <span class="cart-count">0</span>
            </a>
        </div>
    </div>
</nav>

<script>
    window.whenJQueryReady(function($) {
        $(function() {
            function updateCartCount() {
                $.ajax({
                url: '{{ route("cart.get") }}',
                method: 'GET',
                dataType: 'json'
            })
            .done(function(data) {
                $('.cart-count').text(data.count);
            })
            .fail(console.error);
        }

        updateCartCount();

        $(document).on('cart-updated', updateCartCount);
    });
});
</script>
