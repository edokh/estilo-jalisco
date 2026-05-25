@extends('layouts.app')

@section('title', 'Staff Dashboard - Estilo Jalisco')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Staff Dashboard</h1>

    <div id="order-notification" class="hidden mb-6 rounded border-l-4 border-green-600 bg-green-100 px-4 py-3 text-green-800"></div>

    <!-- Order Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-100 rounded-lg p-6 text-center">
            <div id="staff-pending-count" class="text-4xl font-bold text-blue-600">{{ $pendingCount }}</div>
            <div class="text-gray-600 mt-2">Pending Orders</div>
        </div>
        <div class="bg-yellow-100 rounded-lg p-6 text-center">
            <div id="staff-preparing-count" class="text-4xl font-bold text-yellow-600">{{ $preparingCount }}</div>
            <div class="text-gray-600 mt-2">Preparing</div>
        </div>
        <div class="bg-green-100 rounded-lg p-6 text-center">
            <div id="staff-ready-count" class="text-4xl font-bold text-green-600">{{ $readyCount }}</div>
            <div class="text-gray-600 mt-2">Ready for Pickup</div>
        </div>
        <div class="bg-slate-100 rounded-lg p-6 text-center">
            <div id="staff-completed-count" class="text-4xl font-bold text-slate-700">{{ $completedCount }}</div>
            <div class="text-gray-600 mt-2">Completed</div>
        </div>
    </div>

    <!-- Active Orders -->
    <div class="space-y-4">
        @forelse ($orders as $order)
            <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 {{ $order->status === 'pending' ? 'border-red-500' : ($order->status === 'preparing' ? 'border-yellow-500' : 'border-green-500') }}">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $order->order_number }}</h2>
                        <p class="text-gray-600">
                            <strong>Customer:</strong> {{ $order->customer_name }} ({{ $order->customer_phone }})
                        </p>
                        @if ($order->customer_notes)
                            <p class="text-sm text-gray-600 mt-2">
                                <strong>Notes:</strong> {{ $order->customer_notes }}
                            </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-green-600">${{ number_format($order->final_price, 2) }}</p>
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-gray-50 rounded p-4 mb-4">
                    <h3 class="font-bold mb-2">Items:</h3>
                    <ul class="space-y-1">
                        @foreach ($order->items as $item)
                            <li class="text-sm">
                                <strong>{{ $item->quantity }}x</strong> {{ $item->foodItem->name }}
                                @if ($item->special_instructions)
                                    <div class="ml-5 text-xs text-gray-500">
                                        <span class="font-semibold">Instructions:</span> {{ $item->special_instructions }}
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Status Update -->
                <div class="flex justify-between items-center">
                    <form method="POST" action="{{ route('staff.orders.status', $order) }}" class="flex gap-2">
                        @csrf
                        <select name="status" class="px-3 py-2 border rounded">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update
                        </button>
                    </form>

                    <span class="px-4 py-2 rounded font-bold {{ $order->status === 'pending' ? 'bg-red-100 text-red-800' : ($order->status === 'preparing' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-2xl text-gray-500">😎 No active orders! Take a break.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .grid-cols-3 {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    (function () {
        var state = {
            pending: {{ $pendingCount }},
            preparing: {{ $preparingCount }},
            ready: {{ $readyCount }},
            completed: {{ $completedCount }},
        };
        var audioContext;
        var pollingInterval;

        function ensureAudioContext() {
            if (! audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
            return audioContext;
        }

        function playSound() {
            try {
                var context = ensureAudioContext();
                var oscillator = context.createOscillator();
                var gain = context.createGain();
                oscillator.connect(gain);
                gain.connect(context.destination);
                oscillator.type = 'triangle';
                oscillator.frequency.value = 660;
                gain.gain.value = 0.05;
                oscillator.start();
                oscillator.stop(context.currentTime + 0.18);
            } catch (error) {
                console.warn('Audio notification blocked or unavailable:', error);
            }
        }

        function showNotification(message) {
            var el = document.getElementById('order-notification');
            if (! el) return;
            el.textContent = message;
            el.classList.remove('hidden');
            setTimeout(function () {
                el.classList.add('hidden');
            }, 7000);
        }

        function updateCounts(data) {
            document.getElementById('staff-pending-count').textContent = data.pending;
            document.getElementById('staff-preparing-count').textContent = data.preparing;
            document.getElementById('staff-ready-count').textContent = data.ready;
            document.getElementById('staff-completed-count').textContent = data.completed;
        }

        function handleNewData(data, message) {
            state = data;
            updateCounts(data);
            if (message) {
                showNotification(message);
                playSound();
            }
        }

        function pollOrders() {
            fetch('{{ route('orders.summary') }}', { credentials: 'same-origin' })
                .then(function (response) {
                    if (! response.ok) throw new Error('Failed to fetch order summary');
                    return response.json();
                })
                .then(function (data) {
                    if (data.pending > state.pending) {
                        handleNewData(data, 'New order received! Pending orders: ' + data.pending);
                    } else if (data.pending !== state.pending) {
                        handleNewData(data, 'Order counts updated. Pending: ' + data.pending);
                    } else {
                        state = data;
                    }
                })
                .catch(function (error) {
                    console.warn('Order summary polling failed:', error);
                });
        }

        function startPolling() {
            if (pollingInterval) {
                return;
            }
            pollOrders();
            pollingInterval = setInterval(pollOrders, 5000);
        }

        function bindStream() {
            if (! window.EventSource) {
                startPolling();
                return;
            }

            var source = new EventSource('{{ route('orders.stream') }}');
            var streamOpen = false;

            source.onopen = function () {
                streamOpen = true;
                if (pollingInterval) {
                    clearInterval(pollingInterval);
                    pollingInterval = null;
                }
            };

            source.addEventListener('order-created', function (event) {
                try {
                    var data = JSON.parse(event.data);
                    handleNewData(data, 'New order: ' + data.order_number + ' from ' + data.customer_name);
                } catch (error) {
                    console.warn('Failed to parse order event:', error);
                }
            });

            source.onerror = function () {
                console.warn('Order stream error. Falling back to polling and retrying in 5s.');
                source.close();
                startPolling();
                setTimeout(bindStream, 5000);
            };
        }

        bindStream();
