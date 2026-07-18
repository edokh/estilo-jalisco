@extends('layouts.app')

@section('title', 'Edit Review - Admin')

@section('content')
    <div class="min-h-screen bg-[#0A0A0A] text-[#F5E6C8] py-10">
        <div class="max-w-2xl mx-auto px-6">

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-black text-[#D4A017] uppercase tracking-wider">
                    Edit Review
                </h1>
                <p class="mt-2 text-[#F5E6C8]/70">
                    Update the customer review.
                </p>
            </div>

            <!-- Form -->
            <div class="rounded-2xl border border-[#D4A017]/20 bg-[#130E07] shadow-2xl overflow-hidden">
                <div class="h-1 bg-[#D4A017]"></div>

                <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Author -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                            Author *
                        </label>

                        <input type="text" name="author" required value="{{ old('author', $review->author) }}"
                            class="w-full rounded-lg border border-[#D4A017]/20 bg-[#0A0A0A] px-4 py-3 text-[#F5E6C8] placeholder:text-[#F5E6C8]/40 focus:border-[#D4A017] focus:ring-2 focus:ring-[#D4A017]/20 outline-none">

                        @error('author')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Review -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                            Review *
                        </label>

                        <textarea name="text" rows="5" required
                            class="w-full rounded-lg border border-[#D4A017]/20 bg-[#0A0A0A] px-4 py-3 text-[#F5E6C8] placeholder:text-[#F5E6C8]/40 focus:border-[#D4A017] focus:ring-2 focus:ring-[#D4A017]/20 outline-none">{{ old('text', $review->text) }}</textarea>

                        @error('text')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                            Rating *
                        </label>

                        <select name="rating" required
                            class="w-full rounded-lg border border-[#D4A017]/20 bg-[#0A0A0A] px-4 py-3 text-[#F5E6C8] focus:border-[#D4A017] focus:ring-2 focus:ring-[#D4A017]/20 outline-none">

                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>

                        @error('rating')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                            Review Date *
                        </label>

                        <input type="date" name="date" required
                            value="{{ old('date', $review->date->format('Y-m-d')) }}"
                            class="w-full rounded-lg border border-[#D4A017]/20 bg-[#0A0A0A] px-4 py-3 text-[#F5E6C8] focus:border-[#D4A017] focus:ring-2 focus:ring-[#D4A017]/20 outline-none">

                        @error('date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 rounded-lg bg-[#D4A017] px-6 py-3 font-bold uppercase tracking-wider text-[#0A0A0A] transition hover:bg-[#E6B325]">
                            Update Review
                        </button>

                        <a href="{{ route('admin.reviews.index') }}"
                            class="flex-1 rounded-lg border border-[#D4A017]/30 bg-[#1A1A1A] px-6 py-3 text-center font-bold uppercase tracking-wider text-[#F5E6C8] transition hover:border-[#D4A017] hover:bg-[#222]">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
