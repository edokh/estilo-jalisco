@extends('layouts.app')

@section('title', 'Manage Orders - Staff Dashboard')

@section('content')
    <div class="mx-auto max-w-7xl px-6 py-10">
        <div class="mb-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h1 class="mb-3 font-serif text-5xl text-[#FAF3E0]">Order Management</h1>
                <p class="text-lg text-[#FAF3E0]/60">Review and update the status of incoming orders.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('staff.dashboard') }}"
                    class="rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-[#a93226]">Staff
                    Dashboard</a>
                <a href="{{ route('staff.orders.index') }}"
                    class="rounded-lg border border-[#D4A017]/30 bg-[#1E1409] px-6 py-3 font-semibold text-[#D4A017] transition duration-200 hover:bg-[#D4A017]/10">All
                    Orders</a>
            </div>
        </div>

        <div class="mb-10 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div
                class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 text-center shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                <div class="uppercase tracking-widest text-[#FAF3E0]/60">Pending</div>
                <div class="text-5xl font-bold text-[#C0392B]">{{ $pendingCount }}</div>
            </div>
            <div
                class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 text-center shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                <div class="uppercase tracking-widest text-[#FAF3E0]/60">Preparing</div>
                <div class="text-5xl font-bold text-[#D4A017]">{{ $preparingCount }}</div>
            </div>
            <div
                class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 text-center shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                <div class="uppercase tracking-widest text-[#FAF3E0]/60">Ready</div>
                <div class="text-5xl font-bold text-emerald-400">{{ $readyCount }}</div>
            </div>
            <div
                class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 text-center shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                <div class="uppercase tracking-widest text-[#FAF3E0]/60">Completed</div>
                <div class="text-5xl font-bold text-slate-300">{{ $completedCount }}</div>
            </div>
        </div>

        <div class="mb-10 rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-6 shadow-xl">
            <div class="flex flex-wrap gap-3 mb-6">
                @foreach ($statuses as $statusKey)
                    <a href="{{ route('staff.orders.index', $statusKey) }}"
                        class="rounded-lg px-5 py-3 font-semibold transition duration-200

{{ $status === $statusKey
    ? 'bg-[#C0392B] text-white shadow-lg'
    : 'border border-[#D4A017]/20 bg-[#130E07] text-[#FAF3E0]/80 hover:border-[#D4A017] hover:bg-[#D4A017]/10 hover:text-[#D4A017]' }}">
                        {{ ucfirst($statusKey) }}
                    </a>
                @endforeach
            </div>

            @forelse ($orders as $order)
                <div
                    class="mb-5 pl-2 rounded-xl border-l-4 bg-[#130E07] shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl

{{ $order->status === 'pending'
    ? 'border-[#C0392B]'
    : ($order->status === 'preparing'
        ? 'border-[#D4A017]'
        : ($order->status === 'ready'
            ? 'border-emerald-500'
            : 'border-slate-400')) }}">
                    <div class="mb-6 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h2 class="font-serif text-3xl text-[#D4A017]">{{ $order->order_number }}</h2>
                            <p class="text-lg text-[#FAF3E0]/60">{{ $order->customer_name }} ·
                                {{ $order->customer_phone }}</p>
                            @if ($order->customer_email)
                                <p class="mt-1 text-sm text-[#FAF3E0]/50">{{ $order->customer_email }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold tracking-tight text-[#D4A017]">
                                ${{ number_format($order->final_price, 2) }}</p>
                            <p class="uppercase tracking-widest text-[#FAF3E0]/60">
                                {{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-5 grid gap-5 lg:grid-cols-[1.6fr_1fr]">
                        <div>
                            <div class="mb-4 text-lg font-semibold text-[#D4A017]">Items</div>
                            <ul class="space-y-3">
                                @foreach ($order->items as $item)
                                    <li
                                        class="flex justify-between gap-4 border-b border-[#D4A017]/10 pb-3 text-[#FAF3E0] last:border-b-0">
                                        <span>
                                            {{ $item->quantity }} × {{ $item->foodItem->name }}
                                            @if ($item->special_instructions)
                                                <span
                                                    class="mt-2 block rounded-lg bg-[#1E1409] px-3 py-2 text-xs text-[#FAF3E0]/60">
                                                    <span class="font-semibold text-[#D4A017]">Instructions:</span>
                                                    {{ $item->special_instructions }}
                                                </span>
                                            @endif
                                        </span>
                                        <span>${{ number_format($item->subtotal, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-5">
                            <div class="mb-3 text-sm font-semibold uppercase tracking-widest text-[#FAF3E0]/60">Current
                                Status</div>
                            <span
                                class="inline-flex items-center rounded-full px-5 py-2 text-sm font-bold uppercase tracking-wider

    {{ $order->status === 'pending'
        ? 'border border-[#C0392B]/30 bg-[#C0392B]/15 text-[#C0392B]'
        : ($order->status === 'preparing'
            ? 'border border-[#D4A017]/30 bg-[#D4A017]/15 text-[#D4A017]'
            : ($order->status === 'ready'
                ? 'border border-emerald-500/30 bg-emerald-500/15 text-emerald-400'
                : 'border border-slate-500/30 bg-slate-700/20 text-slate-300')) }}">
                                {{ ucfirst($order->status) }}
                            </span>

                            @if ($order->customer_notes)
                                <div class="mt-5 rounded-lg bg-[#130E07] p-4 text-sm text-[#FAF3E0]/70">
                                    <div class="mb-2 font-semibold text-[#D4A017]">Notes</div>
                                    <p>{{ $order->customer_notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div
                        class="flex flex-col gap-5 border-t border-[#D4A017]/10 pt-5 lg:flex-row lg:items-center lg:justify-between">
                        <form method="POST" action="{{ route('staff.orders.status', $order) }}"
                            class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            @csrf
                            <label class="sr-only" for="status-{{ $order->id }}">Status</label>
                            <select id="status-{{ $order->id }}" name="status"
                                class="appearance-none rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] transition focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">
                                @foreach ($statuses as $statusKey)
                                    <option value="{{ $statusKey }}"
                                        {{ $order->status === $statusKey ? 'selected' : '' }}>{{ ucfirst($statusKey) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-[#a93226]">Update
                                Status</button>
                        </form>
                        <div class="rounded-lg bg-[#1E1409] px-5 py-4 text-right text-sm text-[#FAF3E0]/70">
                            <div>
                                <strong class="text-[#D4A017]">Paid:</strong>

                                <span class="{{ $order->paid ? 'text-emerald-400' : 'text-[#C0392B]' }}">
                                    {{ $order->paid ? 'Yes' : 'No' }}
                                </span>
                            </div>
                            @if ($order->paid)
                                <div class="mt-2 text-[#FAF3E0]/50">
                                    Paid at {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : '—' }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-[#D4A017]/20 bg-[#130E07] p-12 text-center shadow-xl">
                    <div class="flex flex-col items-center">

                        <div class="mb-5 text-6xl">
                            🍽️
                        </div>

                        <h2 class="font-serif text-3xl text-[#D4A017]">
                            No Orders Found
                        </h2>

                        <p class="mt-3 text-[#FAF3E0]/60">
                            There are no orders for this status at the moment.
                        </p>

                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
