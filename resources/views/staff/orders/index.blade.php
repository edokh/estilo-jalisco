@extends('layouts.app')

@section('title', 'Manage Orders - Staff Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-end gap-6 mb-8">
        <div>
            <h1 class="text-3xl font-bold mb-2">Order Management</h1>
            <p class="text-gray-600">Review and update the status of incoming orders.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('staff.dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Staff Dashboard</a>
            <a href="{{ route('staff.orders.index') }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">All Orders</a>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow p-5 text-center">
            <div class="text-sm text-gray-500">Pending</div>
            <div class="text-3xl font-bold text-red-600">{{ $pendingCount }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5 text-center">
            <div class="text-sm text-gray-500">Preparing</div>
            <div class="text-3xl font-bold text-yellow-600">{{ $preparingCount }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5 text-center">
            <div class="text-sm text-gray-500">Ready</div>
            <div class="text-3xl font-bold text-green-600">{{ $readyCount }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-5 text-center">
            <div class="text-sm text-gray-500">Completed</div>
            <div class="text-3xl font-bold text-slate-700">{{ $completedCount }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex flex-wrap gap-3 mb-6">
            @foreach ($statuses as $statusKey)
                <a href="{{ route('staff.orders.index', $statusKey) }}"
                   class="px-4 py-2 rounded font-medium {{ $status === $statusKey ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ ucfirst($statusKey) }}
                </a>
            @endforeach
        </div>

        @forelse ($orders as $order)
            <div class="border border-gray-200 rounded-lg p-5 mb-4 shadow-sm">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-4">
                    <div>
                        <h2 class="text-xl font-bold">{{ $order->order_number }}</h2>
                        <p class="text-gray-600">{{ $order->customer_name }} · {{ $order->customer_phone }}</p>
                        @if ($order->customer_email)
                            <p class="text-gray-500 text-sm">{{ $order->customer_email }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-green-600">${{ number_format($order->final_price, 2) }}</p>
                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <div class="grid gap-4 lg:grid-cols-[1.5fr_1fr] mb-4">
                    <div>
                        <div class="mb-3 text-sm font-semibold text-gray-700">Items</div>
                        <ul class="space-y-2 text-sm text-gray-700">
                            @foreach ($order->items as $item)
                                <li class="flex justify-between border-b border-gray-100 pb-2">
                                    <span>{{ $item->quantity }} × {{ $item->foodItem->name }}</span>
                                    <span>${{ number_format($item->subtotal, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-4">
                        <div class="text-sm text-gray-500 mb-2">Current Status</div>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $order->status === 'pending' ? 'bg-red-100 text-red-700' : ($order->status === 'preparing' ? 'bg-yellow-100 text-yellow-700' : ($order->status === 'ready' ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-800')) }}">
                            {{ ucfirst($order->status) }}
                        </span>

                        @if ($order->customer_notes)
                            <div class="mt-4 text-sm text-gray-600">
                                <div class="font-semibold mb-1">Notes</div>
                                <p>{{ $order->customer_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <form method="POST" action="{{ route('staff.orders.status', $order) }}" class="flex flex-wrap gap-2 items-center">
                        @csrf
                        <label class="sr-only" for="status-{{ $order->id }}">Status</label>
                        <select id="status-{{ $order->id }}" name="status" class="px-3 py-2 border rounded bg-white text-sm">
                            @foreach ($statuses as $statusKey)
                                <option value="{{ $statusKey }}" {{ $order->status === $statusKey ? 'selected' : '' }}>{{ ucfirst($statusKey) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update Status</button>
                    </form>
                    <div class="text-right text-sm text-gray-600">
                        <div><strong>Paid:</strong> {{ $order->paid ? 'Yes' : 'No' }}</div>
                        @if ($order->paid)
                            <div>Paid at {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : '—' }}</div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-gray-500">No orders found for this status.</div>
        @endforelse
    </div>
</div>
@endsection
