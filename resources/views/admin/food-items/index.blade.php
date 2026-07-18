@extends('layouts.app')

@section('title', 'Food Items - Admin')

@section('content')
    <div class="mx-auto max-w-7xl px-6 py-10">

        <!-- Header -->
        <div class="mb-10 flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="font-serif text-5xl text-[#FAF3E0]">
                    Food Items
                </h1>

                <p class="mt-2 text-[#FAF3E0]/60">
                    Manage your restaurant menu.
                </p>
            </div>

            <a href="{{ route('admin.food-items.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-[#a93226]">
                + Add Food Item
            </a>

        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-xl border border-[#D4A017]/20 bg-[#1E1409] shadow-xl">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b border-[#D4A017]/20 bg-[#130E07]">

                        <tr>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Image
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Name
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Category
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Price
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Available
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($items as $item)
                            <tr class="border-b border-[#D4A017]/10 bg-[#1E1409] transition hover:bg-[#130E07]">

                                <!-- Image -->
                                <td class="px-6 py-4">

                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                            class="h-14 w-14 rounded-lg border border-[#D4A017]/20 object-cover">
                                    @else
                                        <div
                                            class="flex h-14 w-14 items-center justify-center rounded-lg border border-dashed border-[#D4A017]/20 text-xs text-[#FAF3E0]/40">
                                            No Image
                                        </div>
                                    @endif

                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4">

                                    <div class="font-semibold text-[#FAF3E0]">
                                        {{ $item->name }}
                                    </div>

                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4 text-[#FAF3E0]/70">

                                    {{ $item->category->name }}

                                </td>

                                <!-- Price -->
                                <td class="px-6 py-4">

                                    <span class="font-bold text-[#D4A017]">
                                        ${{ number_format($item->price, 2) }}
                                    </span>

                                </td>

                                <!-- Available -->
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $item->available
                                        ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/20'
                                        : 'bg-red-500/15 text-red-400 border border-red-500/20' }}">

                                        {{ $item->available ? 'Available' : 'Unavailable' }}

                                    </span>

                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-4">

                                        <a href="{{ route('admin.food-items.edit', $item) }}"
                                            class="font-medium text-[#D4A017] transition hover:text-yellow-300">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.food-items.destroy', $item) }}"
                                            class="inline" onsubmit="return confirm('Are you sure?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="font-medium text-[#C0392B] transition hover:text-red-400">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="px-6 py-14 text-center">

                                    <p class="mb-4 text-lg text-[#FAF3E0]/50">
                                        No food items found.
                                    </p>

                                    <a href="{{ route('admin.food-items.create') }}"
                                        class="font-semibold text-[#D4A017] hover:text-yellow-300">
                                        Create your first food item →
                                    </a>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
