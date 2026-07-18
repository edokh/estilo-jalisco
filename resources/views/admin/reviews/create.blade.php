@extends('layouts.app')

@section('title', 'Create Review - Admin')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-[#F5E6C4]">
                Create Review
            </h1>

            <p class="mt-2 text-[#8E7A66]">
                Add a new customer review.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.reviews.store') }}"
            class="rounded-3xl border border-[#D4A017]/20 bg-[#1A1208] p-8 shadow-2xl shadow-black/40 space-y-6">

            @csrf

            <!-- Author -->
            <div>
                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                    Author *
                </label>

                <input type="text" name="author" required value="{{ old('author') }}" placeholder="Customer name"
                    class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] placeholder:text-[#7A6A58] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                @error('author')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Review -->
            <div>
                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                    Review *
                </label>

                <textarea name="text" rows="6" required placeholder="Write the customer's review..."
                    class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] placeholder:text-[#7A6A58] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">{{ old('text') }}</textarea>

                @error('text')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-2">

                <!-- Rating -->
                <div>
                    <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                        Rating *
                    </label>

                    <select name="rating" required
                        class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>
                                {{ $i }} {{ str_repeat('★', $i) }}
                            </option>
                        @endfor

                    </select>

                    @error('rating')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                        Review Date *
                    </label>

                    <input type="date" name="date" required value="{{ old('date', now()->format('Y-m-d')) }}"
                        class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                    @error('date')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-2">

                <button type="submit"
                    class="flex-1 rounded-xl bg-[#D4A017] px-6 py-3 font-bold text-[#130E07] transition hover:bg-[#E5B82E]">
                    Create Review
                </button>

                <a href="{{ route('admin.reviews.index') }}"
                    class="flex-1 rounded-xl border border-[#D4A017]/20 bg-[#130E07] px-6 py-3 text-center font-bold text-[#F5E6C4] transition hover:bg-[#20170D]">
                    Cancel
                </a>

            </div>

        </form>

    </div>
@endsection
