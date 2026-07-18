@extends('layouts.app')

@section('title', 'Staff Dashboard - Estilo Jalisco')

@section('content')
    <div class="mx-auto max-w-7xl px-6 py-10">
        <h1 class="mb-10 font-serif text-5xl text-[#FAF3E0]">Staff Dashboard</h1>

        <div id="order-notification"
            class="hidden mb-6 rounded border-l-4 border-green-600 bg-green-100 px-4 py-3 text-green-800"></div>

        <!-- Order Statistics -->
        <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

            <!-- Pending -->
            <div class="rounded-xl border border-[#C0392B]/30 bg-[#1E1409] p-8 text-center shadow-lg">

                <div id="staff-pending-count" class="text-5xl font-bold text-[#C0392B]">

                    {{ $pendingCount }}

                </div>

                <div class="mt-3 uppercase tracking-widest text-[#FAF3E0]/60">
                    Pending Orders
                </div>

            </div>

            <!-- Preparing -->
            <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 text-center shadow-lg">

                <div id="staff-preparing-count" class="text-5xl font-bold text-[#D4A017]">

                    {{ $preparingCount }}

                </div>

                <div class="mt-3 uppercase tracking-widest text-[#FAF3E0]/60">
                    Preparing
                </div>

            </div>

            <!-- Ready -->
            <div class="rounded-xl border border-emerald-600/30 bg-[#1E1409] p-8 text-center shadow-lg">

                <div id="staff-ready-count" class="text-5xl font-bold text-emerald-400">

                    {{ $readyCount }}

                </div>

                <div class="mt-3 uppercase tracking-widest text-[#FAF3E0]/60">
                    Ready for Pickup
                </div>

            </div>

            <!-- Completed -->
            <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-8 text-center shadow-lg">

                <div id="staff-completed-count" class="text-5xl font-bold text-[#FAF3E0]">

                    {{ $completedCount }}

                </div>

                <div class="mt-3 uppercase tracking-widest text-[#FAF3E0]/60">
                    Completed
                </div>

            </div>

        </div>

        <!-- Active Orders -->
        <div class="space-y-4">
            @forelse ($orders as $order)
                <div
                    class="rounded-xl border-l-4 bg-white/5 p-6 shadow-xl

    {{ $order->status === 'pending'
        ? 'border-[#C0392B]'
        : ($order->status === 'preparing'
            ? 'border-[#D4A017]'
            : 'border-emerald-500') }}">
                    <div class="mb-6 flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h2 class="font-serif text-3xl text-[#D4A017]">{{ $order->order_number }}</h2>
                            <p class="mt-3 text-[#FAF3E0]/70">
                                <strong class="text-[#FAF3E0]">Customer:</strong> {{ $order->customer_name }}
                                ({{ $order->customer_phone }})
                            </p>
                            @if ($order->customer_notes)
                                <p
                                    class="mt-3 rounded-lg border border-[#D4A017]/20 bg-[#130E07] p-3 text-sm text-[#FAF3E0]/70">
                                    <strong class="text-[#FAF3E0]">Notes:</strong> {{ $order->customer_notes }}
                                </p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-4xl font-bold text-[#D4A017]">${{ number_format($order->final_price, 2) }}</p>
                            <p class="mt-2 text-sm text-[#FAF3E0]/50">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-5 rounded-xl border border-[#D4A017]/20 bg-[#130E07] p-5">
                        <h3 class="mb-4 text-lg font-semibold text-[#D4A017]">Items:</h3>
                        <ul class="space-y-3">
                            @foreach ($order->items as $item)
                                <li class="border-b border-[#D4A017]/10 pb-3 text-[#FAF3E0] last:border-b-0 last:pb-0">
                                    <strong class="mr-2 text-[#D4A017]">
                                        {{ $item->quantity }}×
                                    </strong>{{ $item->foodItem->name }}
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

                    <!-- Status Update -->
                    <div
                        class="flex flex-col gap-5 border-t border-[#D4A017]/10 pt-5 lg:flex-row lg:items-center lg:justify-between">
                        <form method="POST" action="{{ route('staff.orders.status', $order) }}"
                            class="flex flex-col gap-3 sm:flex-row"> @csrf
                            <select name="status"
                                class="rounded-lg border border-[#D4A017]/20 bg-[#130E07] px-4 py-3 text-[#FAF3E0] transition focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing
                                </option>
                                <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>
                            <button type="submit"
                                class="rounded-lg bg-[#C0392B] px-6 py-3 font-semibold text-white transition hover:bg-[#a93226]">
                                Update
                            </button>
                        </form>

                        <span
                            class="inline-flex items-center rounded-full px-5 py-2 text-sm font-bold uppercase tracking-wider

    {{ $order->status === 'pending'
        ? 'bg-[#C0392B]/15 text-[#C0392B] border border-[#C0392B]/30'
        : ($order->status === 'preparing'
            ? 'bg-[#D4A017]/15 text-[#D4A017] border border-[#D4A017]/30'
            : ($order->status === 'ready'
                ? 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30'
                : 'bg-slate-700/20 text-slate-300 border border-slate-500/30')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-[#D4A017]/20 bg-[#1E1409] p-12 text-center shadow-xl">
                    <p class="font-serif text-3xl text-[#D4A017]">🍽️ No active orders right now.</p>
                    <p class="mt-3 text-[#FAF3E0]/60">
                        New orders will appear here automatically.
                    </p>
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
        (function() {
            var state = {
                pending: {{ $pendingCount }},
                preparing: {{ $preparingCount }},
                ready: {{ $readyCount }},
                completed: {{ $completedCount }},
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
                if (!el) return;
                el.textContent = message;
                el.classList.remove('hidden');
                setTimeout(function() {
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
                        handleNewData(data, 'New order: ' + data.order_number + ' from ' + data.customer_name);
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
