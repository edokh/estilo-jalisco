@extends('layouts.app')

@section('title', 'Discounts - Admin')

@section('content')
    <div class="mx-auto max-w-7xl px-6 py-10">

        <!-- Header -->
        <div class="mb-10 flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

            <div>
                <h1 class="font-serif text-5xl text-[#FAF3E0]">
                    Discounts
                </h1>

                <p class="mt-2 text-[#FAF3E0]/60">
                    Manage promotional discounts and special offers.
                </p>
            </div>

            <a href="{{ route('admin.discounts.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-[#a93226]">
                + Add Discount
            </a>

        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-xl border border-[#D4A017]/20 bg-[#1E1409] shadow-xl">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b border-[#D4A017]/20 bg-[#130E07]">

                        <tr>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Name
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Item
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Type
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Value
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Valid Until
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Active
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($discounts as $discount)
                            <tr class="border-b border-[#D4A017]/10 bg-[#1E1409] transition hover:bg-[#130E07]">

                                <!-- Name -->
                                <td class="px-6 py-4">

                                    <div class="font-semibold text-[#FAF3E0]">
                                        {{ $discount->name }}
                                    </div>

                                </td>

                                <!-- Item -->
                                <td class="px-6 py-4 text-[#FAF3E0]/70">

                                    {{ $discount->foodItem?->name ?? 'All Items' }}

                                </td>

                                <!-- Type -->
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $discount->type === 'percentage'
                                        ? 'border border-blue-500/20 bg-blue-500/15 text-blue-400'
                                        : 'border border-emerald-500/20 bg-emerald-500/15 text-emerald-400' }}">

                                        {{ ucfirst($discount->type) }}

                                    </span>

                                </td>

                                <!-- Value -->
                                <td class="px-6 py-4">

                                    <span class="font-bold text-[#D4A017]">

                                        @if ($discount->type === 'percentage')
                                            {{ $discount->value }}%
                                        @else
                                            ${{ number_format($discount->value, 2) }}
                                        @endif

                                    </span>

                                </td>

                                <!-- End Date -->
                                <td class="px-6 py-4 text-[#FAF3E0]/70">

                                    {{ $discount->end_date->format('M d, Y') }}

                                </td>

                                <!-- Active -->
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $discount->active
                                        ? 'border border-emerald-500/20 bg-emerald-500/15 text-emerald-400'
                                        : 'border border-red-500/20 bg-red-500/15 text-red-400' }}">

                                        {{ $discount->active ? 'Active' : 'Inactive' }}

                                    </span>

                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-4">

                                        <a href="{{ route('admin.discounts.edit', $discount) }}"
                                            class="font-medium text-[#D4A017] transition hover:text-yellow-300">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.discounts.destroy', $discount) }}"
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

                                <td colspan="7" class="px-6 py-14 text-center">

                                    <p class="mb-4 text-lg text-[#FAF3E0]/50">
                                        No discounts found.
                                    </p>

                                    <a href="{{ route('admin.discounts.create') }}"
                                        class="font-semibold text-[#D4A017] hover:text-yellow-300">
                                        Create your first discount →
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
