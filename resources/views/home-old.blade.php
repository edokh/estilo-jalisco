@extends('layouts.app')

@section('content')
    <div class="bg-[#faf8f5] text-gray-900">

        <!-- Hero -->
        <section class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-24 lg:py-32">
                <div class="grid lg:grid-cols-2 gap-16 items-center">

                    <!-- Content -->
                    <div>

                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#f5e6d1] text-[#C58B45] font-semibold mb-6">
                            ✦ Authentic Mexican Food
                        </span>

                        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
                            Discover
                            <br>
                            {{ $restaurantName }}
                            <span class="text-[#C58B45]">
                                Flavors
                            </span>
                        </h1>

                        <p class="mt-8 text-lg text-gray-600 leading-relaxed max-w-xl">
                            Experience unforgettable flavors prepared from fresh ingredients,
                            traditional recipes, and modern culinary excellence.
                        </p>

                        <div class="flex flex-wrap gap-4 mt-10">
                            <a href="{{ route('menu') }}"
                                class="px-8 py-4 rounded-full border border-[#C58B45] text-[#C58B45] font-semibold hover:bg-[#C58B45] hover:text-white transition">
                                Order Now
                            </a>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-2 gap-5 mt-14">

                            <div class="bg-white rounded-3xl shadow-lg p-6">
                                <h3 class="text-5xl font-bold text-[#C58B45]">
                                    {{ $categoryCount }}
                                </h3>
                                <p class="text-gray-500 mt-2">
                                    Active Categories
                                </p>
                            </div>

                            <div class="bg-white rounded-3xl shadow-lg p-6">
                                <h3 class="text-5xl font-bold text-[#C58B45]">
                                    {{ $availableDishCount }}
                                </h3>
                                <p class="text-gray-500 mt-2">
                                    Available Dishes
                                </p>
                            </div>

                        </div>

                    </div>

                    <!-- Image -->
                    <div class="relative flex justify-center">

                        <div class="absolute w-[450px] h-[450px] bg-[#f5e6d1] rounded-full"></div>

                        <img src="{{ $topDish?->image ?: 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=1200' }}"
                            alt="{{ $topDish?->name ?: 'Food' }}"
                            class="relative z-10 w-[500px] h-[500px] object-cover rounded-full shadow-2xl border-[12px] border-white">

                        <div class="absolute bottom-10 left-0 z-20 bg-white rounded-2xl shadow-xl p-5 max-w-xs">
                            <p class="text-[#C58B45] font-bold">
                                {{ $topDish ? 'Most ordered: ' . $topDish->name : 'Fresh Ingredients' }}
                            </p>
                            <p class="text-gray-500 text-sm">
                                {{ $topDish ? ($topDish->description ?: 'Prepared Daily') : 'Prepared Daily' }}
                            </p>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <!-- About -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">

                <div class="grid lg:grid-cols-2 gap-16 items-center">

                    <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?q=80&w=1200" alt="Restaurant"
                        class="rounded-3xl shadow-xl h-[500px] w-full object-cover">

                    <div>

                        <p class="text-[#C58B45] font-semibold uppercase tracking-widest mb-3">
                            About Us
                        </p>

                        <h2 class="text-5xl font-bold mb-6">
                            Estilo Jalisco: Authentic Mexican Flavor
                        </h2>

                        <p class="text-gray-600 leading-relaxed mb-6">
                            We bring together exceptional ingredients, skilled chefs,
                            and a welcoming atmosphere to create unforgettable dining experiences.
                        </p>

                        <p class="text-gray-600 leading-relaxed mb-8">
                            Every dish is carefully crafted to deliver authentic flavors
                            and memorable moments for you and your family.
                        </p>

                        <a href="#reservation"
                            class="inline-flex px-8 py-4 rounded-full bg-[#C58B45] text-white font-semibold">
                            Learn More
                        </a>

                    </div>

                </div>

            </div>
        </section>

        <!-- Menu -->
        <section id="menu" class="py-24">

            <div class="max-w-7xl mx-auto px-6">

                <div class="text-center mb-16">
                    <p class="text-[#C58B45] font-semibold uppercase tracking-widest">
                        Our Menu
                    </p>

                    <h2 class="text-5xl font-bold mt-3">
                        Popular Dishes
                    </h2>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                    @forelse ($popularDishes as $dish)
                        <div
                            class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">

                            <img src="{{ $dish->image ?: 'https://via.placeholder.com/1200x900?text=' . urlencode($dish->name) }}"
                                class="w-full h-64 object-cover">

                            <div class="p-6">

                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-2xl font-bold">
                                        {{ $dish->name }}
                                    </h3>

                                    <span class="text-[#C58B45] text-xl font-bold">
                                        ${{ number_format($dish->getPriceWithDiscount(), 2) }}
                                    </span>
                                </div>

                                <p class="text-gray-600">
                                    {{ $dish->description ?? 'Fresh ingredients, authentic flavor and premium quality.' }}
                                </p>

                            </div>

                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500">
                            No menu items are available right now. Please check back soon.
                        </div>
                    @endforelse

                </div>

            </div>

        </section>

        <!-- Testimonials -->
        <section class="py-24 bg-white">

            <div class="max-w-7xl mx-auto px-6">

                <div class="text-center mb-16">
                    <p class="text-[#C58B45] uppercase font-semibold">
                        Testimonials
                    </p>

                    <h2 class="text-5xl font-bold mt-3">
                        What Our Customers Say
                    </h2>
                </div>

                <div class="grid md:grid-cols-3 gap-8">

                    @for ($i = 0; $i < 3; $i++)
                        <div class="bg-[#faf8f5] p-8 rounded-3xl">
                            <div class="text-[#C58B45] text-2xl mb-4">
                                ★★★★★
                            </div>

                            <p class="text-gray-600 leading-relaxed">
                                Amazing food, friendly staff, and a wonderful atmosphere.
                                Highly recommended for family dinners.
                            </p>

                            <div class="mt-6 font-semibold">
                                John Smith
                            </div>
                        </div>
                    @endfor

                </div>

            </div>

        </section>

        <!-- Reservation -->
        <section id="reservation" class="py-24 bg-[#f5e6d1]">

            <div class="max-w-4xl mx-auto px-6 text-center">

                <p class="uppercase text-[#C58B45] font-semibold">
                    Reservation
                </p>

                <h2 class="text-5xl font-bold mt-4">
                    Book Your Table Today
                </h2>

                <p class="text-gray-600 mt-6 max-w-2xl mx-auto">
                    Reserve your seat and enjoy a unique dining experience with
                    friends and family. We're open from {{ $openTime }} to {{ $closeTime }}.
                </p>

                <div class="mt-10">
                    <a href="{{ route('menu') }}"
                        class="inline-flex px-10 py-4 rounded-full bg-[#C58B45] text-white font-semibold hover:bg-[#ae7539] transition">
                        Order Now
                    </a>
                </div>
            </div>

        </section>

        <!-- Footer -->
        <footer class="bg-green-300 border-t border-gray-200 py-10">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div>
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('storage/logo.png') }}" alt="Logo"
                                class="h-20 mt-2 sm:h-24 sm:mt-0  w-auto">
                        </a>
                        <p class="text-gray-900 mt-2">
                            Premium {{ $restaurantName }} Dining Experience
                        </p>
                    </div>

                    <div class="text-gray-900">
                        © {{ date('Y') }} {{ $restaurantName }}.
                        All Rights Reserved.
                    </div>

                </div>
            </div>
        </footer>
    </div>
@endsection
