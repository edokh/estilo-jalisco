@extends('layouts.app')

@section('content')
    <nav class="fixed inset-x-0 top-0 z-[200] flex items-center justify-between bg-gradient-to-b from-[#0d0904]/95 to-transparent px-10 py-4"
        aria-label="Primary">

        <div class="flex items-center">
            <a href="#main-content" class="flex items-center">
                <img src="{{ asset('storage/logo.png') }}" alt="{{ $restaurantName }} logo"
                    class="h-13 w-13 rounded-full object-cover">
            </a>

            <span class="ml-3 font-serif text-lg tracking-wide text-[#D4A017]">
                {{ $restaurantName }}
            </span>
        </div>

        <div class="nav-backdrop fixed inset-0 z-[240] hidden bg-black/60 backdrop-blur-sm" aria-hidden="true">
        </div>

        <ul id="primary-nav" class="flex items-center gap-7">

            <li>
                <a href="#reviews"
                    class="text-xs uppercase tracking-[0.12em] text-[#FAF3E0]/80 transition hover:text-[#D4A017]">
                    Reviews
                </a>
            </li>

            <li>
                <a href="#location"
                    class="text-xs uppercase tracking-[0.12em] text-[#FAF3E0]/80 transition hover:text-[#D4A017]">
                    Location
                </a>
            </li>

            <li>
                <a href="{{ route('menu') }}" style="padding: 0.55rem 1.3rem;"
                    class="bg-[#C0392B] text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:bg-[#a93226]">
                    Order Online
                </a>
            </li>

        </ul>
    </nav>



    <!-- ═══════════════════════════════════ HERO ═══════════════════════════════════ -->
    <main id="main-content">

        <section class="relative flex h-[100dvh] items-end overflow-hidden">

            {{-- Background --}}
            <div class="absolute inset-0 bg-cover bg-center brightness-[0.35] saturate-[0.8]"
                style="background-image:url('{{ asset('storage/exterior.jpeg') }}'); background-position:center 30%;">
            </div>

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-[#0d0904] via-[#0d0904]/60 to-[#0d0904]/10"></div>

            {{-- Content --}}
            <div
                class="relative z-10 mx-auto grid w-full max-w-6xl grid-cols-1 gap-12 px-[2rem] pb-[5rem] md:grid-cols-[1fr_auto] md:px-[4.5rem]">

                {{-- Left --}}
                <div>

                    <p class="flex items-center gap-3 text-xs uppercase tracking-[0.35em] text-[#D4A017] mb-4">
                        <span class="h-px w-8 bg-[#D4A017]"></span>
                        Omaha, Nebraska · South Side
                    </p>

                    <h1 class="mb-5 font-serif text-5xl font-bold leading-none text-white md:text-8xl">
                        Authentic
                        <br>
                        <em class="italic text-[#D4A017]">
                            {{ $restaurantName }}
                        </em>
                        <br>
                        flavor.
                    </h1>

                    <p class="mb-8 max-w-xl text-base font-light leading-7 text-[#FAF3E0]/70">
                        Bold recipes rooted in the soul of Jalisco, Mexico —
                        birria, fajitas, tortas, and more,
                        crafted fresh every day in the heart of South Omaha.
                    </p>

                    {{-- Featured Dish --}}
                    @if ($topDish)
                        <div
                            class="mb-6 inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2">
                            <img src="{{ asset('storage/' . $topDish->image) }}" alt="{{ $topDish->name }}"
                                class="h-10 w-10 rounded-full object-cover">

                            <div class="text-sm">
                                <div class="text-[#D4A017] font-semibold">
                                    Most Popular Dish
                                </div>

                                <div class="text-[#FAF3E0]">
                                    {{ $topDish->name }}
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Restaurant Stats --}}
                    <div class="mb-8 flex flex-wrap gap-6 text-sm">

                        <div>
                            <div class="text-2xl font-bold text-[#D4A017]">
                                {{ $availableDishCount }}
                            </div>
                            <div class="text-[#FAF3E0]/60 uppercase tracking-wider text-xs">
                                Dishes
                            </div>
                        </div>

                        <div>
                            <div class="text-2xl font-bold text-[#D4A017]">
                                {{ $categoryCount }}
                            </div>
                            <div class="text-[#FAF3E0]/60 uppercase tracking-wider text-xs">
                                Categories
                            </div>
                        </div>

                        <div>
                            <div class="text-2xl font-bold text-[#D4A017]">
                                {{ number_format($orderCount) }}
                            </div>
                            <div class="text-[#FAF3E0]/60 uppercase tracking-wider text-xs">
                                Orders Served
                            </div>
                        </div>

                    </div>

                    <div>

                        <a href="{{ route('menu') }}"
                            class="inline-block bg-[#C0392B] px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-[#a93226]">

                            Order Online

                        </a>

                    </div>

                </div>

                {{-- Hours Card --}}
                <div class="hidden min-w-[240px] rounded border border-[#D4A017]/20 bg-white/5 p-7 md:block"
                    style="max-height:25rem;">

                    <h4 class="mb-4 text-[11px] font-bold uppercase tracking-[0.25em] text-[#D4A017]">
                        Hours
                    </h4>

                    <ul id="hero-hours" class="space-y-2 leading-6 text-[#FAF3E0]/70"
                        style="font-family:'Barlow',sans-serif;">

                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                            <li class="flex justify-between text-sm">
                                <span class="font-bold text-white">
                                    {{ $day }}
                                </span>

                                <span>
                                    {{ $openTime }} – {{ $closeTime }}
                                </span>
                            </li>
                        @endforeach

                    </ul>

                    <div class="border-t border-[#D4A017]/20 pt-5">

                        <h4 class="mb-2 text-[11px] font-bold uppercase tracking-[0.25em] text-[#D4A017]">
                            Address
                        </h4>

                        <p class="text-sm leading-6 text-[#FAF3E0]/70">
                            1837 Vinton St
                            <br>
                            Omaha, NE 68108
                        </p>

                        <a href="tel:{{ preg_replace('/\D/', '', $phone) }}"
                            class="mt-3 block font-semibold text-[#D4A017]">

                            {{ $phone }}

                        </a>

                    </div>

                </div>

            </div>

        </section>

        <!-- ═══════════════════════════════════ FOOD SHOWCASE ═══════════════════════════════════ -->
        <section id="food" class="bg-[#1E1409]">
            <div class="mx-auto max-w-6xl px-6 py-20 lg:px-10">

                <p class="mb-3 text-xs uppercase tracking-[0.3em] text-[#D4A017]">
                    From Our Kitchen
                </p>

                <h2 class="mb-12 font-serif text-4xl leading-tight text-[#FAF3E0] md:text-5xl">
                    Real food.<br>
                    Real Jalisco.
                </h2>

                <div class="grid auto-rows-[220px] gap-5 md:grid-cols-3">

                    @foreach ($popularDishes as $dish)
                        <div class="group relative overflow-hidden rounded-md {{ $loop->first ? 'md:row-span-2' : '' }}">
                            <img src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}" loading="lazy"
                                decoding="async"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent">
                            </div>

                            <div class="absolute bottom-4 left-4 {{ $loop->first ? 'bottom-5 left-5' : '' }}">
                                <span class="{{ $loop->first ? 'text-xl' : 'text-lg' }} font-serif text-white">
                                    {{ $dish->name }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ route('menu') }}"
                        class="inline-flex items-center rounded border border-[#D4A017]/30 px-8 py-4 text-xs font-medium uppercase tracking-[0.12em] text-[#FAF3E0] transition duration-200 hover:border-[#D4A017] hover:bg-[#D4A017]/10 hover:text-[#D4A017]">

                        See Full Menu

                        <span class="ml-2">→</span>

                    </a>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════ REVIEWS ═══════════════════════════════════ -->
        <section id="reviews" class="border-t border-[#D4A017]/10 bg-[#1E1409]">
            <div class="mx-auto max-w-6xl px-6 py-20 lg:px-10">

                <p class="mb-3 text-xs uppercase tracking-[0.3em] text-[#D4A017]">
                    What People Are Saying
                </p>

                <h2 class="mb-12 font-serif text-4xl leading-tight text-[#FAF3E0] md:text-5xl">
                    Loved by<br>
                    <em class="italic text-[#D4A017]">{{ $restaurantName }}.</em>
                </h2>

                @php
                    $averageRating = $reviews->count() ? round($reviews->avg('rating'), 1) : 0;
                    $fullStars = floor($averageRating);
                    $hasHalfStar = $averageRating - $fullStars >= 0.5;
                @endphp

                <!-- Rating Summary -->
                <div class="mb-12 flex items-center gap-6">

                    <div class="font-serif text-6xl font-bold leading-none text-[#D4A017]">
                        {{ number_format($averageRating, 1) }}
                    </div>

                    <div>

                        <div class="text-2xl tracking-widest text-[#D4A017]">

                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $fullStars)
                                    ★
                                @elseif($hasHalfStar && $i == $fullStars + 1)
                                    ☆
                                @else
                                    <span class="opacity-30">★</span>
                                @endif
                            @endfor

                        </div>

                        <div class="mt-2 text-xs uppercase tracking-[0.12em] text-[#FAF3E0]/50">
                            {{ $reviews->count() }}
                            {{ Str::plural('Review', $reviews->count()) }}
                        </div>

                    </div>

                </div>

                <!-- Reviews -->
                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">

                    @forelse($reviews as $review)
                        <div
                            class="rounded-md border border-[#D4A017]/10 bg-white/5 p-6 transition hover:border-[#D4A017]/30">

                            <div class="mb-4 text-sm tracking-widest text-[#D4A017]">

                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        ★
                                    @else
                                        <span class="opacity-25">★</span>
                                    @endif
                                @endfor

                            </div>

                            <p class="mb-6 text-sm leading-7 text-[#FAF3E0]/70">
                                {{ $review->text }}
                            </p>

                            <div>

                                <span class="block font-semibold text-[#FAF3E0]">
                                    {{ $review->author }}
                                </span>

                                <span class="text-xs text-[#FAF3E0]/40">
                                    {{ \Carbon\Carbon::parse($review->date)->format('F d, Y') }}
                                </span>

                            </div>

                        </div>

                    @empty

                        <div class="col-span-full rounded-md border border-[#D4A017]/10 bg-white/5 p-10 text-center">

                            <p class="text-[#FAF3E0]/60">
                                No reviews yet.
                            </p>

                        </div>
                    @endforelse

                </div>

                <!-- Button -->
                <div class="mt-12 text-center">

                    <a href="https://maps.google.com/?q=Estilo+Jalisco+Mexican+Restaurant+1837+Vinton+St+Omaha+NE+68108"
                        target="_blank" rel="noopener"
                        class="inline-flex items-center rounded border border-[#FAF3E0]/30 px-8 py-4 text-xs font-medium uppercase tracking-[0.12em] text-[#FAF3E0] transition duration-200 hover:border-[#D4A017] hover:bg-[#D4A017]/10 hover:text-[#D4A017]">

                        View on Google Maps
                        <span class="ml-2">↗</span>

                    </a>

                </div>

            </div>
        </section>

        <!-- ═══════════════════════════════════ LOCATION ════════════════════════════════════ -->
        <section id="location" class="border-t border-[#D4A017]/10 bg-[#1E1409]">
            <div class="mx-auto grid max-w-6xl gap-12 px-6 py-20 lg:grid-cols-2 lg:px-10">

                {{-- Left: Photo --}}
                <div class="relative">

                    <img src="{{ asset('storage/exterior.jpeg') }}" alt="{{ $restaurantName }} restaurant exterior"
                        loading="lazy" decoding="async" class="w-full rounded object-cover brightness-90">

                    <span
                        class="absolute left-6 top-6 bg-[#C0392B] px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-white">
                        South Omaha
                    </span>

                </div>

                {{-- Right --}}
                <div class="flex flex-col gap-8">

                    {{-- Heading --}}
                    <div>

                        <p class="mb-3 text-xs uppercase tracking-[0.3em] text-[#D4A017]">
                            Find Us
                        </p>

                        <h2 class="font-serif text-4xl leading-tight text-[#FAF3E0] md:text-5xl">
                            Come visit<br>
                            <span class="italic text-[#D4A017]">{{ $restaurantName }}</span>.
                        </h2>

                    </div>

                    {{-- Address --}}
                    <div>

                        <h4 class="mb-2 text-[11px] uppercase tracking-[0.25em] text-[#D4A017]">
                            Address
                        </h4>

                        <p class="leading-8 text-[#FAF3E0]/80">
                            1837 Vinton St<br>
                            Omaha, NE 68108
                        </p>

                        <a href="https://maps.google.com/?q=Estilo+Jalisco+Mexican+Restaurant+1837+Vinton+St+Omaha+NE+68108"
                            target="_blank" rel="noopener"
                            class="mt-4 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.15em] text-[#D4A017] hover:underline">

                            ↗ Open in Google Maps

                        </a>

                    </div>

                    {{-- Phone --}}
                    <div>

                        <h4 class="mb-2 text-[11px] uppercase tracking-[0.25em] text-[#D4A017]">
                            Phone
                        </h4>

                        <a href="tel:{{ preg_replace('/\D/', '', $phone) }}"
                            class="text-[#FAF3E0]/80 transition hover:text-[#D4A017]">

                            {{ $phone }}

                        </a>

                    </div>

                    {{-- Hours --}}
                    <div>

                        <h4 class="mb-2 text-[11px] uppercase tracking-[0.25em] text-[#D4A017]">
                            Hours
                        </h4>

                        <div class="mb-2 flex items-center gap-2 text-sm text-[#FAF3E0]/80">

                            <span id="status-dot" class="h-2 w-2 rounded-full"></span>

                            <span id="status-text"></span>

                        </div>

                        <p id="todays-hours" class="mb-3 text-sm text-[#FAF3E0]/50">
                            {{ $openTime }} – {{ $closeTime }}
                        </p>

                        <div id="location-hours" class="space-y-2">

                            @foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                <div class="flex justify-between text-sm text-[#FAF3E0]/70">
                                    <span>{{ $day }}</span>
                                    <span>{{ $openTime }} – {{ $closeTime }}</span>
                                </div>
                            @endforeach

                        </div>

                    </div>

                    {{-- Social --}}
                    <div>

                        <h4 class="mb-3 text-[11px] uppercase tracking-[0.25em] text-[#D4A017]">
                            Follow Us
                        </h4>

                        <div class="flex gap-3">

                            <a href="https://www.instagram.com/estilojaliscoomaha" target="_blank" rel="noopener"
                                class="rounded border border-[#D4A017]/30 px-4 py-2 text-xs uppercase tracking-[0.1em] text-[#FAF3E0] transition hover:border-[#D4A017] hover:text-[#D4A017]">

                                Instagram

                            </a>

                            <a href="https://www.tiktok.com/@estilojaliscoomaha" target="_blank" rel="noopener"
                                class="rounded border border-[#D4A017]/30 px-4 py-2 text-xs uppercase tracking-[0.1em] text-[#FAF3E0] transition hover:border-[#D4A017] hover:text-[#D4A017]">

                                TikTok

                            </a>

                        </div>

                    </div>

                    {{-- CTA --}}
                    <a href="{{ route('menu') }}"
                        class="inline-flex w-fit items-center rounded bg-[#C0392B] px-8 py-4 text-xs font-bold uppercase tracking-[0.12em] text-white transition hover:-translate-y-0.5 hover:bg-[#a93226]">
                        Order Online →
                    </a>
                </div>
            </div>
        </section>
    </main>


    <!-- ═══════════════════════════════════ FOOTER ═══════════════════════════════════ -->
    <footer class="border-t border-white/5 bg-[#130E07]">
        <div
            class="mx-auto flex max-w-6xl flex-col items-center justify-center gap-3 px-6 py-8 text-center text-sm text-[#FAF3E0]/40 md:flex-row">

            <span>
                © 2026 {{ $restaurantName }} Mexican Restaurant
            </span>

            <span class="hidden text-[#D4A017]/50 md:inline">•</span>

            <a href="tel:{{ preg_replace('/\D/', '', $phone) }}" class="text-[#D4A017] transition hover:text-[#e8b72d]">

                {{ $phone }}

            </a>

            <span class="hidden text-[#D4A017]/50 md:inline">•</span>

            <span>
                1837 Vinton St, Omaha, NE 68108
            </span>

        </div>
    </footer>

    <style>
        #navigation-bar {
            display: none;
        }
    </style>
@endsection
