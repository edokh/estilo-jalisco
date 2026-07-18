@extends('layouts.app')

@section('title', 'Create Food Item - Admin')

@section('content')
    <div class="mx-auto max-w-3xl px-6 py-10">

        <!-- Header -->
        <div class="mb-10">
            <h1 class="font-serif text-5xl text-[#FAF3E0]">
                Create Food Item
            </h1>

            <p class="mt-2 text-[#FAF3E0]/60">
                Add a new dish to your restaurant menu.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.food-items.store') }}" enctype="multipart/form-data"
            class="space-y-6 rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-xl">

            @csrf

            <!-- Category -->
            <div>
                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                    Category *
                </label>

                <select name="category_id" required
                    class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                    <option value="">-- Select Category --</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>

                @error('category_id')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div>
                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                    Item Name *
                </label>

                <input type="text" name="name" required value="{{ old('name') }}"
                    class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] placeholder:text-[#FAF3E0]/30 focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

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
                    class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] placeholder:text-[#FAF3E0]/30 focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">{{ old('description') }}</textarea>

                @error('description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                    Price (USD) *
                </label>

                <input type="number" name="price" step="0.01" required value="{{ old('price') }}"
                    class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                @error('price')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                    Image
                </label>

                <input type="file" name="image" accept="image/*"
                    class="block w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0]
                       file:mr-4 file:rounded-md file:border-0 file:bg-[#C0392B] file:px-4 file:py-2
                       file:font-semibold file:text-white hover:file:bg-[#a93226]">

                @error('image')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Order -->
            <div>
                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                    Display Order
                </label>

                <input type="number" name="order" value="{{ old('order', 0) }}"
                    class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                @error('order')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Available -->
            <div class="rounded-lg border border-[#D4A017]/20 bg-[#130E07] p-4">

                <label class="flex cursor-pointer items-center gap-3">

                    <input type="checkbox" name="available" value="1" {{ old('available', true) ? 'checked' : '' }}
                        class="h-5 w-5 rounded border-[#D4A017]/40 bg-[#1E1409] text-[#C0392B] focus:ring-[#D4A017]">

                    <span class="font-medium text-[#FAF3E0]">
                        Available for ordering
                    </span>

                </label>

                @error('available')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror

            </div>

            <!-- Buttons -->
            <div class="flex flex-col gap-4 pt-4 sm:flex-row">

                <button type="submit"
                    class="flex-1 rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-[#a93226]">
                    Create Item
                </button>

                <a href="{{ route('admin.food-items.index') }}"
                    class="flex-1 rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-6 py-3 text-center font-semibold text-[#FAF3E0] transition duration-200 hover:border-[#D4A017] hover:bg-[#2B1C0F]">
                    Cancel
                </a>

            </div>

        </form>

    </div>
@endsection
