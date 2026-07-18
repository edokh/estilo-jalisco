<div class="w-72 min-h-screen bg-[#130E07] border-r border-[#D4A017]/20 shadow-2xl shadow-black/40">
    <div class="p-6 border-b border-[#D4A017]/20">
        <h2 class="text-2xl font-bold text-[#F5E6C4]">
            Navigation
        </h2>
        <p class="mt-1 text-sm text-[#8E7A66]">
            Restaurant Control Panel
        </p>
    </div>

    <nav class="p-4 space-y-2">

        {{-- Customer --}}
        @if (!auth()->user()->is_admin && !auth()->user()->is_staff)
            <a href="{{ route('menu') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition duration-200 hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span class="text-xl">🍔</span>
                <span>Menu</span>
            </a>

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition duration-200 hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span class="text-xl">🛒</span>
                <span>My Orders</span>
            </a>
        @endif


        {{-- Staff --}}
        @if (auth()->user()->is_staff)
            <a href="{{ route('staff.dashboard') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition duration-200 hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span class="text-xl">📋</span>
                <span>Staff Dashboard</span>
            </a>

            <a href="{{ route('staff.orders.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition duration-200 hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span class="text-xl">🔄</span>
                <span>Manage Orders</span>
            </a>
        @endif


        {{-- Admin --}}
        @if (auth()->user()->is_admin)
            <div class="my-4 border-t border-[#D4A017]/10"></div>

            <p class="px-4 pb-2 text-xs uppercase tracking-[0.25em] text-[#8E7A66]">
                Administration
            </p>

            <a href="{{ route('admin.orders.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition duration-200 hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span class="text-xl">📦</span>
                <span>Orders</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition duration-200 hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span class="text-xl">📂</span>
                <span>Categories</span>
            </a>

            <a href="{{ route('admin.food-items.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition duration-200 hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span class="text-xl">🍕</span>
                <span>Food Items</span>
            </a>

            <a href="{{ route('admin.discounts.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition duration-200 hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span class="text-xl">💸</span>
                <span>Discounts</span>
            </a>

            <a href="{{ route('admin.settings.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition duration-200 hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span class="text-xl">⚙️</span>
                <span>Settings</span>
            </a>

            <a href="{{ route('admin.reviews.index') }}"
                class="flex items-center gap-3 rounded-xl px-4 py-3 text-[#F5E6C4] transition hover:bg-[#1A1208] hover:text-[#D4A017]">
                <span>⭐</span>
                <span>Reviews</span>
            </a>
        @endif

    </nav>
</div>
