@extends('layouts.app')

@section('title', 'Reviews - Admin')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- Header -->
        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-4xl font-bold text-[#F5E6C4]">Reviews</h1>
                <p class="mt-2 text-[#8E7A66]">
                    Manage customer reviews displayed on your website.
                </p>
            </div>

            <a href="{{ route('admin.reviews.create') }}"
                class="inline-flex items-center rounded-xl bg-[#D4A017] px-6 py-3 font-semibold text-[#130E07] transition hover:bg-[#E5B82E]">
                + Add Review
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-3xl border border-[#D4A017]/20 bg-[#1A1208] shadow-2xl shadow-black/40">

            <table class="min-w-full">
                <thead class="bg-[#130E07]">
                    <tr class="border-b border-[#D4A017]/20">

                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                            Author
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                            Review
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                            Rating
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                            Date
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold uppercase tracking-wider text-[#D4A017]">
                            Actions
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse ($reviews as $review)

                        <tr class="border-b border-[#D4A017]/10 transition hover:bg-[#130E07]">

                            <td class="px-6 py-5 font-semibold text-[#F5E6C4]">
                                {{ $review->author }}
                            </td>

                            <td class="px-6 py-5 text-[#B8A082]">
                                {{ Str::limit($review->text, 80) }}
                            </td>

                            <td class="px-6 py-5 text-center">
                                <div class="text-lg text-[#D4A017]">
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $review->rating ? '★' : '☆' }}
                                    @endfor
                                </div>
                            </td>

                            <td class="px-6 py-5 text-center text-[#B8A082]">
                                {{ \Carbon\Carbon::parse($review->date)->format('M d, Y') }}
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-center gap-3">

                                    <a href="{{ route('admin.reviews.edit', $review) }}"
                                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-500">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this review?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-500">
                                            Delete
                                        </button>

                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="mx-auto max-w-md">

                                    <h3 class="mb-2 text-2xl font-bold text-[#F5E6C4]">
                                        No Reviews Found
                                    </h3>

                                    <p class="mb-6 text-[#8E7A66]">
                                        Start by creating your first customer review.
                                    </p>

                                    <a href="{{ route('admin.reviews.create') }}"
                                        class="inline-flex rounded-xl bg-[#D4A017] px-6 py-3 font-semibold text-[#130E07] transition hover:bg-[#E5B82E]">
                                        Create Review
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
