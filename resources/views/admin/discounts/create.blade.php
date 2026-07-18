@extends('layouts.app')

@section('title', 'Create Discount - Admin')

@section('content')
    <div class="min-h-screen bg-[#130E07] px-6 py-10">
        <div class="mx-auto max-w-3xl">

            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-[#D4A017]">
                        Administration
                    </p>

                    <h1 class="mt-2 font-serif text-4xl text-[#FAF3E0]">
                        Create Discount
                    </h1>
                </div>

                <a href="{{ route('admin.discounts.index') }}"
                    class="rounded-lg border border-[#D4A017] px-5 py-2 text-[#D4A017] transition hover:bg-[#D4A017] hover:text-[#130E07]">
                    ← Back
                </a>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('admin.discounts.store') }}"
                class="space-y-6 rounded-2xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-2xl">

                @csrf

                <!-- Discount Name -->
                <div>
                    <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                        Discount Name *
                    </label>

                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] placeholder:text-gray-500 focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                        Description
                    </label>

                    <textarea name="description" rows="4"
                        class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] placeholder:text-gray-500 focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Food Item -->
                <div>
                    <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                        Apply To
                    </label>

                    <select name="food_item_id"
                        class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                        <option value="">-- All Items --</option>

                        @foreach ($foodItems as $item)
                            <option value="{{ $item->id }}" {{ old('food_item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('food_item_id')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type + Value -->
                <div class="grid gap-6 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                            Discount Type *
                        </label>

                        <select name="type" required
                            class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                            <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>
                                Percentage (%)
                            </option>

                            <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>
                                Fixed Amount ($)
                            </option>

                        </select>

                        @error('type')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                            Value *
                        </label>

                        <input type="number" step="0.01" name="value" required value="{{ old('value') }}"
                            class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] placeholder:text-gray-500 focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                        @error('value')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Dates -->
                <div class="grid gap-6 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                            Start Date *
                        </label>

                        <input type="datetime-local" name="start_date" required value="{{ old('start_date') }}"
                            class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                        @error('start_date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                            End Date *
                        </label>

                        <input type="datetime-local" name="end_date" required value="{{ old('end_date') }}"
                            class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                        @error('end_date')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Active -->
                <div class="rounded-lg border border-[#D4A017]/20 bg-[#130E07] p-4">
                    <label class="flex items-center gap-3 text-[#FAF3E0]">
                        <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                            class="h-5 w-5 rounded border-[#D4A017] bg-[#130E07] text-[#D4A017] focus:ring-[#D4A017]">

                        <span>Active Discount</span>
                    </label>

                    @error('active')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">

                    <button type="submit"
                        class="flex-1 rounded-lg bg-[#D4A017] px-6 py-3 font-semibold text-[#130E07] transition hover:bg-[#E6B325]">
                        Create Discount
                    </button>

                    <a href="{{ route('admin.discounts.index') }}"
                        class="flex-1 rounded-lg border border-[#D4A017] px-6 py-3 text-center font-semibold text-[#D4A017] transition hover:bg-[#D4A017] hover:text-[#130E07]">
                        Cancel
                    </a>

                </div>

            </form>
        </div>
    </div>
@endsection
