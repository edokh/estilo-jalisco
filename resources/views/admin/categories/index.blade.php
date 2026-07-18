@extends('layouts.app')

@section('title', 'Categories - Admin')

@section('content')
    <div class="mx-auto max-w-7xl px-6 py-10">
        <div class="mb-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <h1 class="font-serif text-5xl text-[#FAF3E0]">Categories</h1>
            <a href="{{ route('admin.categories.create') }}"
                class="rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-[#a93226]">
                + Add Category
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-[#130E07]">
                    <tr>
                        <th
                            class="border-b border-[#D4A017]/20 px-6 py-4 text-left text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                            Name</th>
                        <th
                            class="border-b border-[#D4A017]/20 px-6 py-4 text-left text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                            Description</th>
                        <th
                            class="border-b border-[#D4A017]/20 px-6 py-4 text-left text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                            Order</th>
                        <th
                            class="border-b border-[#D4A017]/20 px-6 py-4 text-left text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                            Active</th>
                        <th
                            class="border-b border-[#D4A017]/20 px-6 py-4 text-left text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-b border-[#D4A017]/10 bg-[#1E1409] transition duration-200 hover:bg-[#130E07]">
                            <td class="px-6 py-5 font-semibold text-[#FAF3E0]">{{ $category->name }}</td>
                            <td class="px-6 py-5 text-sm text-[#FAF3E0]/60">{{ Str::limit($category->description, 50) }}
                            </td>
                            <td class="px-6 py-5 font-semibold text-[#D4A017]">{{ $category->order }}</td>
                            <td class="px-6 py-5 font-semibold text-[#D4A017]">
                                <span
                                    class="inline-flex items-center rounded-full px-4 py-2 text-xs font-bold uppercase tracking-wider

    {{ $category->active
        ? 'border border-emerald-500/30 bg-emerald-500/15 text-emerald-400'
        : 'border border-[#C0392B]/30 bg-[#C0392B]/15 text-[#C0392B]' }}">
                                    {{ $category->active ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td class="space-x-4 px-6 py-5">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="font-semibold text-[#D4A017] transition hover:text-[#e6b325]">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                    style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="font-semibold text-[#C0392B] transition hover:text-[#d35445]">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">

                                    <div class="mb-5 text-6xl">
                                        📂
                                    </div>

                                    <h2 class="font-serif text-3xl text-[#D4A017]">
                                        No Categories Found
                                    </h2>

                                    <p class="mt-3 text-[#FAF3E0]/60">
                                        Your menu doesn't have any categories yet.
                                    </p>

                                    <a href="{{ route('admin.categories.create') }}"
                                        class="mt-6 rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition hover:bg-[#a93226]">
                                        Create First Category
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
