 <div class="w-64 bg-gray-800 text-white min-h-screen p-4">
    <h2 class="text-xl font-bold mb-6">Navigation</h2>
    <ul class="space-y-2">
        {{-- Customer --}}
        @if (!auth()->user()->is_admin && !auth()->user()->is_staff)
            <li>
                <a href="{{ route('menu') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
                    🍔 Menu
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
                    🛒 My Orders
                </a>
            </li>
        @endif

        {{-- Staff --}}
        @if (auth()->user()->is_staff)
            <li>
                <a href="{{ route('staff.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
                    📋 Staff Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('staff.orders.index') }}" 
                   class="block px-3 py-2 rounded hover:bg-gray-700">
                    🔄 Manage Orders
                </a>
            </li>
        @endif

        {{-- Admin --}}
        @if (auth()->user()->is_admin)
            <li>
                <a href="{{ route('admin.orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
                    📦 Orders
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
                    📂 Categories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.food-items.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
                    🍕 Food Items
                </a>
            </li>
            <li>
                <a href="{{ route('admin.discounts.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
                    💸 Discounts
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">
                    ⚙️ Settings
                </a>
            </li>
        @endif
    </ul>
</div>
