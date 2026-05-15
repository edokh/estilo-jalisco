@extends('layouts.app')

@section('title', 'Orders - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Order Management</h1>
    <div id="admin-order-notification" class="hidden mb-6 rounded border-l-4 border-blue-600 bg-blue-50 px-4 py-3 text-blue-800"></div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-8">
        <h3 class="font-bold mb-4">Quick Stats</h3>
        <div class="grid grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded">
                <div id="admin-total-orders-count" class="text-2xl font-bold text-blue-600">{{ $orders->count() }}</div>
                <div class="text-sm text-gray-600">Total Orders</div>
            </div>
            <div class="text-center p-4 bg-red-50 rounded">
                <div id="admin-pending-orders-count" class="text-2xl font-bold text-red-600">{{ $orders->where('status', 'pending')->count() }}</div>
                <div class="text-sm text-gray-600">Pending</div>
            </div>
            <div class="text-center p-4 bg-yellow-50 rounded">
                <div class="text-2xl font-bold text-yellow-600">{{ $orders->where('paid', false)->count() }}</div>
                <div class="text-sm text-gray-600">Unpaid</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded">
                <div class="text-2xl font-bold text-green-600">${{ number_format($orders->sum('final_price'), 2) }}</div>
                <div class="text-sm text-gray-600">Total Revenue</div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse ($orders as $order)
            <div class="bg-white rounded-lg shadow p-6 border-l-4 {{ $order->status === 'pending' ? 'border-red-500' : ($order->status === 'completed' ? 'border-green-500' : 'border-yellow-500') }}">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-bold">{{ $order->order_number }}</h2>
                        <p class="text-gray-600">
                            <strong>Customer:</strong> {{ $order->customer_name }} ({{ $order->customer_phone }})
                        </p>
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-green-600">${{ number_format($order->final_price, 2) }}</p>
                        <p class="text-sm {{ $order->paid ? 'text-green-600' : 'text-red-600' }}">
                            {{ $order->paid ? '✓ Paid' : '✗ Unpaid' }}
                        </p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded p-4 mb-4">
                    <h3 class="font-bold mb-2">Items:</h3>
                    <ul class="space-y-1 text-sm">
                        @foreach ($order->items as $item)
                            <li>
                                <strong>{{ $item->quantity }}x</strong> {{ $item->foodItem->name }} - ${{ number_format($item->subtotal, 2) }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Actions -->
                <div class="flex justify-between items-center gap-4">
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex gap-2">
                        @csrf
                        <select name="status" class="px-3 py-2 border rounded">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Update Status
                        </button>
                    </form>

                    @if (!$order->paid)
                        <form method="POST" action="{{ route('admin.orders.mark-paid', $order) }}">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Mark as Paid
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.orders.show', $order) }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-xl text-gray-500">No orders found</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</div>

<script>
    (function () {
        var state = {
            total: {{ $orders->count() }},
            pending: {{ $orders->where('status', 'pending')->count() }},
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
                oscillator.type = 'sine';
                oscillator.frequency.value = 880;
                gain.gain.value = 0.05;
                oscillator.start();
                oscillator.stop(context.currentTime + 0.18);
            } catch (error) {
                console.warn('Audio notification blocked or unavailable:', error);
            }
        }

        function showNotification(message) {
            var el = document.getElementById('admin-order-notification');
            if (! el) return;
            el.textContent = message;
            el.classList.remove('hidden');
            setTimeout(function () {
                el.classList.add('hidden');
            }, 7000);
        }

        function updateCounts(data) {
            document.getElementById('admin-total-orders-count').textContent = data.total;
            document.getElementById('admin-pending-orders-count').textContent = data.pending;
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
                    handleNewData(data, 'New order received: ' + data.order_number + ' from ' + data.customer_name);
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
    })();
</script>
@endsection
