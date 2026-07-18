@extends('layouts.app')

@section('title', 'Order Details - Admin')

@section('content')
    <div class="mx-auto max-w-7xl px-6 py-10">

        <!-- Header -->
        <div class="mb-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <h1 class="font-serif text-5xl text-[#FAF3E0]">
                    {{ $order->order_number }}
                </h1>

                <p class="mt-2 text-[#FAF3E0]/60">
                    Order Details
                </p>
            </div>

            <a href="{{ route('admin.orders.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-6 py-3 font-semibold text-[#FAF3E0] transition hover:border-[#D4A017] hover:bg-[#D4A017]/10 hover:text-[#D4A017]">
                ← Back to Orders
            </a>

        </div>

        <div class="grid gap-8 lg:grid-cols-2">

            <!-- LEFT COLUMN -->
            <div class="space-y-8">

                <!-- Customer Information -->
                <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-xl">

                    <h2 class="mb-6 font-serif text-3xl text-[#D4A017]">
                        Customer Information
                    </h2>

                    <div class="space-y-4 text-[#FAF3E0]/80">

                        <div>
                            <span class="font-semibold text-[#D4A017]">
                                Name
                            </span>

                            <p class="mt-1">
                                {{ $order->customer_name }}
                            </p>
                        </div>

                        <div>
                            <span class="font-semibold text-[#D4A017]">
                                Phone
                            </span>

                            <p class="mt-1">
                                {{ $order->customer_phone }}
                            </p>
                        </div>

                        @if ($order->customer_email)
                            <div>
                                <span class="font-semibold text-[#D4A017]">
                                    Email
                                </span>

                                <p class="mt-1">
                                    {{ $order->customer_email }}
                                </p>
                            </div>
                        @endif

                        @if ($order->customer_notes)
                            <div class="rounded-lg bg-[#130E07] p-4">

                                <span class="font-semibold text-[#D4A017]">
                                    Notes
                                </span>

                                <p class="mt-2 text-[#FAF3E0]/70">
                                    {{ $order->customer_notes }}
                                </p>

                            </div>
                        @endif

                    </div>

                </div>

                <!-- Order Items -->
                <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-xl">

                    <h2 class="mb-6 font-serif text-3xl text-[#D4A017]">
                        Order Items
                    </h2>

                    <div class="space-y-4">

                        @foreach ($order->items as $item)
                            <div
                                class="rounded-lg border border-[#D4A017]/10 bg-[#130E07] p-5 transition hover:border-[#D4A017]/30">

                                <div class="flex items-center justify-between">

                                    <div>

                                        <h3 class="font-semibold text-[#FAF3E0]">
                                            {{ $item->foodItem->name }}
                                        </h3>

                                        <p class="mt-1 text-sm text-[#FAF3E0]/50">
                                            Quantity × {{ $item->quantity }}
                                        </p>

                                        @if ($item->special_instructions)
                                            <div class="mt-3 rounded bg-[#1E1409] p-3">

                                                <span class="text-xs font-semibold uppercase tracking-wider text-[#D4A017]">
                                                    Instructions
                                                </span>

                                                <p class="mt-1 text-sm text-[#FAF3E0]/70">
                                                    {{ $item->special_instructions }}
                                                </p>

                                            </div>
                                        @endif

                                    </div>

                                    <div class="text-right">

                                        <div class="text-xl font-bold text-[#D4A017]">
                                            ${{ number_format($item->subtotal, 2) }}
                                        </div>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

            <!-- RIGHT COLUMN -->
            <div class="space-y-8">

                <!-- Order Summary -->
                <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-xl">

                    <h2 class="mb-6 font-serif text-3xl text-[#D4A017]">
                        Order Summary
                    </h2>

                    <div class="space-y-4">

                        <div class="flex justify-between border-b border-[#D4A017]/10 pb-4 text-[#FAF3E0]/80">

                            <span>
                                Original Total
                            </span>

                            <span class="font-semibold">
                                ${{ number_format($order->original_price, 2) }}
                            </span>

                        </div>

                        @if ($order->discount_amount > 0)
                            <div class="flex justify-between border-b border-[#D4A017]/10 pb-4">

                                <span class="text-[#FAF3E0]/80">
                                    Discount
                                </span>

                                <span class="font-semibold text-emerald-400">
                                    -${{ number_format($order->discount_amount, 2) }}
                                </span>

                            </div>
                        @endif

                        <div class="flex justify-between border-b border-[#D4A017]/10 pb-4 text-[#FAF3E0]/80">

                            <span>
                                Tax ({{ number_format($order->tax_percentage, 2) }}%)
                            </span>

                            <span class="font-semibold">
                                ${{ number_format($order->tax_amount, 2) }}
                            </span>

                        </div>

                        <div class="flex items-center justify-between pt-2">

                            <span class="text-xl font-bold text-[#FAF3E0]">
                                Final Total
                            </span>

                            <span class="text-3xl font-bold text-[#D4A017]">
                                ${{ number_format($order->final_price, 2) }}
                            </span>

                        </div>

                    </div>
                    <!-- Payment Status -->
                    <div class="mt-8 rounded-xl border border-[#D4A017]/20 bg-[#130E07] p-6">

                        <div class="mb-2 text-sm font-semibold uppercase tracking-widest text-[#D4A017]">
                            Payment Status
                        </div>

                        <div class="text-2xl font-bold {{ $order->paid ? 'text-emerald-400' : 'text-[#C0392B]' }}">
                            {{ $order->paid ? '✓ PAID' : '✗ UNPAID' }}
                        </div>

                        @if ($order->paid_at)
                            <div class="mt-2 text-sm text-[#FAF3E0]/60">
                                Paid on {{ $order->paid_at->format('M d, Y H:i') }}
                            </div>
                        @endif

                    </div>

                </div>

                <!-- Order Status -->
                <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-xl">

                    <h2 class="mb-6 font-serif text-3xl text-[#D4A017]">
                        Order Status
                    </h2>

                    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-5">

                        @csrf

                        <select name="status"
                            class="w-full rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] transition focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>
                                Preparing
                            </option>

                            <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>
                                Ready
                            </option>

                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>

                        </select>

                        <button type="submit"
                            class="w-full rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-[#a93226]">
                            Update Status
                        </button>

                    </form>

                    @if (!$order->paid)
                        <form method="POST" action="{{ route('admin.orders.mark-paid', $order) }}" class="mt-4">

                            @csrf

                            <button type="submit"
                                class="w-full rounded-lg bg-emerald-600 px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-emerald-700">
                                Mark as Paid
                            </button>

                        </form>
                    @endif

                </div>

                <!-- Timeline -->
                <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 shadow-xl">

                    <h2 class="mb-6 font-serif text-3xl text-[#D4A017]">
                        Timeline
                    </h2>

                    <div class="space-y-5 text-[#FAF3E0]/80">

                        <div class="flex justify-between border-b border-[#D4A017]/10 pb-3">
                            <span class="font-semibold text-[#D4A017]">
                                Created
                            </span>

                            <span>
                                {{ $order->created_at->format('M d, Y H:i:s') }}
                            </span>
                        </div>

                        <div class="flex justify-between border-b border-[#D4A017]/10 pb-3">
                            <span class="font-semibold text-[#D4A017]">
                                Last Updated
                            </span>

                            <span>
                                {{ $order->updated_at->format('M d, Y H:i:s') }}
                            </span>
                        </div>

                        @if ($order->paid_at)
                            <div class="flex justify-between">

                                <span class="font-semibold text-[#D4A017]">
                                    Paid
                                </span>

                                <span class="text-emerald-400">
                                    {{ $order->paid_at->format('M d, Y H:i:s') }}
                                </span>

                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
