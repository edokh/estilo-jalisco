@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-16 lg:py-24">
    <div class="lg:flex lg:items-center lg:justify-between gap-8">
        <div class="lg:w-1/2">
            <small class="inline-block bg-amber-50 text-[#ed8a23] px-3 py-1 rounded-full font-bold text-sm">WELCOME TO OUR RESTAURANT</small>
            <h1 class="mt-6 text-4xl lg:text-5xl font-extrabold leading-tight">Your Go-To Spot For Great <span class="text-[#ed8a23]">Food</span> And <span class="text-[#ed8a23]">Good Times</span></h1>
            <p class="mt-4 text-gray-600">Join us for delicious meals and memorable moments — order online for pickup or delivery.</p>
            <a href="{{ route('menu') }}" class="inline-block mt-6 bg-[#ed8a23] hover:bg-[#f7c600] text-white font-bold py-3 px-6 rounded-full shadow-md">Order Now</a>
        </div>
        <div class="lg:w-1/2 flex items-center justify-center">
            <img src="{{ asset('storage/hero-dish.jpg') }}" alt="Dish" class="w-96 rounded-2xl shadow-xl object-cover">
        </div>
    </div>
</div>
@endsection
