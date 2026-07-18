@extends('layouts.app')

@section('title', 'Edit Category - Admin')

@section('content')
    <div class="mx-auto max-w-3xl px-6 py-10">

        <h1 class="mb-10 font-serif text-5xl text-[#FAF3E0]">
            Edit Category
        </h1>

        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data"
            class="space-y-6 rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-xl">

            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div>
                <label class="mb-3 block text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                    Category Name *
                </label>

                <input type="text" name="name" required value="{{ old('name', $category->name) }}"
                    class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] placeholder:text-[#FAF3E0]/40 transition focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                @error('name')
                    <span class="mt-2 block text-sm text-[#C0392B]">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="mb-3 block text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                    Description
                </label>

                <textarea name="description" rows="4"
                    class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] placeholder:text-[#FAF3E0]/40 transition focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">{{ old('description', $category->description) }}</textarea>

                @error('description')
                    <span class="mt-2 block text-sm text-[#C0392B]">{{ $message }}</span>
                @enderror
            </div>

            <!-- Current Image -->
            <div>
                <label class="mb-3 block text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                    Image
                </label>

                @if ($category->image)
                    <div class="mb-5">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                            class="h-32 w-32 rounded-xl border border-[#D4A017]/20 object-cover shadow-lg">
                    </div>
                @endif

                <input type="file" name="image" accept="image/*"
                    class="block w-full cursor-pointer rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] file:mr-4 file:rounded-md file:border-0 file:bg-[#C0392B] file:px-4 file:py-2 file:font-semibold file:text-white hover:file:bg-[#a93226]">

                @error('image')
                    <span class="mt-2 block text-sm text-[#C0392B]">{{ $message }}</span>
                @enderror
            </div>

            <!-- Display Order -->
            <div>
                <label class="mb-3 block text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                    Order (Display Position)
                </label>

                <input type="number" name="order" value="{{ old('order', $category->order) }}"
                    class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] transition focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                @error('order')
                    <span class="mt-2 block text-sm text-[#C0392B]">{{ $message }}</span>
                @enderror
            </div>

            <!-- Active -->
            <div>
                <label class="flex items-center gap-3 text-[#FAF3E0]">

                    <input type="checkbox" name="active" value="1"
                        {{ old('active', $category->active) ? 'checked' : '' }}
                        class="h-5 w-5 rounded border-[#D4A017]/40 bg-[#130E07] text-[#C0392B] focus:ring-[#D4A017]">

                    <span class="font-medium">
                        Active
                    </span>

                </label>

                @error('active')
                    <span class="mt-2 block text-sm text-[#C0392B]">{{ $message }}</span>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex flex-col gap-4 pt-4 sm:flex-row">

                <button type="submit"
                    class="flex-1 rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-[#a93226]">
                    Update Category
                </button>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex-1 rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-6 py-3 text-center font-semibold text-[#FAF3E0] transition duration-200 hover:border-[#D4A017] hover:bg-[#D4A017]/10 hover:text-[#D4A017]">
                    Cancel
                </a>

            </div>

        </form>

    </div>
@endsection
