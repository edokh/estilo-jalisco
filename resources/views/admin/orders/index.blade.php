@extends('layouts.app')

@section('title', 'Orders - Admin')

@section('content')
    <div class="mx-auto max-w-7xl px-6 py-10">
        <h1 class="mb-10 font-serif text-5xl text-[#FAF3E0]">Order Management</h1>
        <div id="admin-order-notification"
            class="hidden mb-8 rounded-xl border border-[#D4A017]/20 bg-gradient-to-r from-[#2A1A0D] to-[#C0392B] px-6 py-4 text-white shadow-xl">
        </div>

        <!-- Filters -->
        <div class="mb-10 rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-6 shadow-xl">
            <h3 class="mb-6 text-xl font-semibold text-[#D4A017]">Quick Stats</h3>
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
                <div
                    class="rounded-xl border border-[#D4A017]/20 bg-[#130E07] p-8 text-center shadow-lg transition hover:-translate-y-1 hover:shadow-2xl">
                    <div id="admin-total-orders-count" class="text-5xl font-bold text-[#FAF3E0]">{{ $orders->count() }}</div>
                    <div class="mt-3 uppercase tracking-widest text-[#FAF3E0]/60">Total Orders</div>
                </div>
                <div
                    class="rounded-xl border border-[#C0392B]/30 bg-[#130E07] p-8 text-center shadow-lg transition hover:-translate-y-1 hover:shadow-2xl">
                    <div id="admin-pending-orders-count" class="text-2xl font-bold text-[#C0392B]">
                        {{ $orders->where('status', 'pending')->count() }}</div>
                    <div class="mt-3 uppercase tracking-widest text-[#FAF3E0]/60">Pending</div>
                </div>
                <div
                    class="rounded-xl border border-[#D4A017]/20 bg-[#130E07] p-8 text-center shadow-lg transition hover:-translate-y-1 hover:shadow-2xl">
                    <div class="text-2xl font-bold text-[#D4A017]">{{ $orders->where('paid', false)->count() }}</div>
                    <div class="mt-3 uppercase tracking-widest text-[#FAF3E0]/60">Unpaid</div>
                </div>
                <div
                    class="rounded-xl border border-emerald-600/30 bg-[#130E07] p-8 text-center shadow-lg transition hover:-translate-y-1 hover:shadow-2xl">
                    <div class="text-2xl font-bold text-emerald-400">${{ number_format($orders->sum('final_price'), 2) }}
                    </div>
                    <div class="mt-3 uppercase tracking-widest text-[#FAF3E0]/60">Total Revenue</div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="space-y-4">
            @forelse ($orders as $order)
                <div
                    class="rounded-xl border-l-4 bg-[#1E1409] p-6 shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl

    {{ $order->status === 'pending'
        ? 'border-[#C0392B]'
        : ($order->status === 'completed'
            ? 'border-emerald-500'
            : 'border-[#D4A017]') }}">
                    <div class="mb-6 flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h2 class="font-serif text-3xl text-[#D4A017]">{{ $order->order_number }}</h2>
                            <p class="mt-3 text-[#FAF3E0]/70">
                                <strong class="mr-2 text-[#D4A017]">Customer:</strong> {{ $order->customer_name }}
                                ({{ $order->customer_phone }})
                            </p>
                            <p class="mt-3 uppercase tracking-widest text-[#FAF3E0]/60">
                                {{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold tracking-tight text-[#D4A017]">
                                ${{ number_format($order->final_price, 2) }}</p>
                            <p
                                class="mt-2 text-sm font-semibold {{ $order->paid ? 'text-emerald-400' : 'text-[#C0392B]' }}">
                                {{ $order->paid ? '✓ Paid' : '✗ Unpaid' }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-5 rounded-xl border border-[#D4A017]/20 bg-[#130E07] p-5">
                        <h3 class="mb-4 text-lg font-semibold text-[#D4A017]">Items:</h3>
                        <ul class="space-y-3">
                            @foreach ($order->items as $item)
                                <li class="border-b border-[#D4A017]/10 pb-3 text-[#FAF3E0] last:border-b-0 last:pb-0">
                                    <strong class="mr-2 text-[#D4A017]">{{ $item->quantity }}x</strong>
                                    {{ $item->foodItem->name }} -
                                    ${{ number_format($item->subtotal, 2) }}
                                    @if ($item->special_instructions)
                                        <div class="ml-7 mt-2 rounded-lg bg-[#1E1409] px-3 py-2 text-xs text-[#FAF3E0]/60">
                                            <span class="font-semibold text-[#D4A017]">Instructions:</span>
                                            {{ $item->special_instructions }}
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Actions -->
                    <div
                        class="flex flex-col gap-5 border-t border-[#D4A017]/10 pt-5 lg:flex-row lg:items-center lg:justify-between">
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}"
                            class="flex flex-col gap-3 sm:flex-row">
                            @csrf
                            <select name="status"
                                class="appearance-none rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] transition focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing
                                </option>
                                <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                            <button type="submit"
                                class="rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-[#a93226]">
                                Update Status
                            </button>
                        </form>

                        @if (!$order->paid)
                            <form method="POST" action="{{ route('admin.orders.mark-paid', $order) }}">
                                @csrf
                                <button type="submit"
                                    class="rounded-lg bg-emerald-600 px-6 py-3 font-semibold text-white transition duration-200 hover:-translate-y-0.5 hover:bg-emerald-700">
                                    Mark as Paid
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.orders.show', $order) }}"
                            class="inline-flex items-center justify-center rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-6 py-3 font-semibold text-[#FAF3E0] transition duration-200 hover:border-[#D4A017] hover:bg-[#D4A017]/10 hover:text-[#D4A017]">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-12 text-center shadow-xl">
                    <div class="flex flex-col items-center">

                        <div class="mb-5 text-6xl">
                            🍽️
                        </div>

                        <h2 class="font-serif text-3xl text-[#D4A017]">
                            No Orders Found
                        </h2>

                        <p class="mt-3 text-[#FAF3E0]/60">No orders found</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-6 shadow-lg">
            {{ $orders->links() }}
        </div>
    </div>

    <script>
        (function() {
            var state = {
                total: {{ $orders->count() }},
                pending: {{ $orders->where('status', 'pending')->count() }},
            };
            var audioContext;
            var pollingInterval;

            function ensureAudioContext() {
                if (!audioContext) {
                    audioContext = new(window.AudioContext || window.webkitAudioContext)();
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
                if (!el) return;
                el.textContent = message;
                el.classList.remove('hidden');
                el.classList.add('animate-pulse');
                setTimeout(function() {
                    el.classList.remove('animate-pulse');
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
                fetch('{{ route('orders.summary') }}', {
                        credentials: 'same-origin'
                    })
                    .then(function(response) {
                        if (!response.ok) throw new Error('Failed to fetch order summary');
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.pending > state.pending) {
                            handleNewData(data, 'New order received! Pending orders: ' + data.pending);
                        } else if (data.pending !== state.pending) {
                            handleNewData(data, 'Order counts updated. Pending: ' + data.pending);
                        } else {
                            state = data;
                        }
                    })
                    .catch(function(error) {
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
                if (!window.EventSource) {
                    startPolling();
                    return;
                }

                var source = new EventSource('{{ route('orders.stream') }}');
                var streamOpen = false;

                source.onopen = function() {
                    streamOpen = true;
                    if (pollingInterval) {
                        clearInterval(pollingInterval);
                        pollingInterval = null;
                    }
                };

                source.addEventListener('order-created', function(event) {
                    try {
                        var data = JSON.parse(event.data);
                        handleNewData(data, 'New order received: ' + data.order_number + ' from ' + data
                            .customer_name);
                    } catch (error) {
                        console.warn('Failed to parse order event:', error);
                    }
                });

                source.onerror = function() {
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
