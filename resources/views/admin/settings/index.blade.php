@extends('layouts.app')

@section('title', 'Settings - Admin')

@section('content')
    <div class="min-h-screen bg-[#0A0805] py-10">
        <div class="mx-auto max-w-5xl px-6">

            <div class="mb-10">
                <h1 class="text-4xl font-bold text-[#D4A017]">
                    Restaurant Settings
                </h1>
                <p class="mt-2 text-[#B8A97E]">
                    Configure restaurant hours, tax, WhatsApp notifications and holidays.
                </p>
            </div>

            <!-- ========================= -->
            <!-- Operating Hours -->
            <!-- ========================= -->
            <div class="mb-8 rounded-2xl border border-[#D4A017]/20 bg-[#130E07] p-8 shadow-xl">
                <h2 class="mb-6 text-2xl font-bold text-[#D4A017]">
                    Operating Hours
                </h2>

                <form method="POST" action="{{ route('admin.settings.timings') }}" class="space-y-6">
                    @csrf

                    <div class="grid gap-6 md:grid-cols-2">

                        <div>
                            <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                                Opening Time *
                            </label>

                            <input type="time" name="open_time" required value="{{ $openTime }}"
                                class="w-full rounded-xl border border-[#D4A017]/30 bg-[#0A0805] px-4 py-3 text-[#F5E6B3] focus:border-[#D4A017] focus:outline-none">

                            @error('open_time')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                                Closing Time *
                            </label>

                            <input type="time" name="close_time" required value="{{ $closeTime }}"
                                class="w-full rounded-xl border border-[#D4A017]/30 bg-[#0A0805] px-4 py-3 text-[#F5E6B3] focus:border-[#D4A017] focus:outline-none">

                            @error('close_time')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <button type="submit"
                        class="rounded-xl bg-[#D4A017] px-8 py-3 font-semibold text-[#130E07] transition hover:bg-[#E6B325]">
                        Update Operating Hours
                    </button>
                </form>
            </div>

            <!-- ========================= -->
            <!-- Tax Settings -->
            <!-- ========================= -->
            <div class="mb-8 rounded-2xl border border-[#D4A017]/20 bg-[#130E07] p-8 shadow-xl">
                <h2 class="mb-6 text-2xl font-bold text-[#D4A017]">
                    Tax Settings
                </h2>

                <form method="POST" action="{{ route('admin.settings.tax') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                            Tax Percentage *
                        </label>

                        <div class="flex items-center gap-3">
                            <input type="number" name="tax_percentage" min="0" max="100" step="0.01"
                                required value="{{ old('tax_percentage', $taxPercentage) }}"
                                class="w-full rounded-xl border border-[#D4A017]/30 bg-[#0A0805] px-4 py-3 text-[#F5E6B3] focus:border-[#D4A017] focus:outline-none">

                            <span class="font-bold text-[#D4A017]">%</span>
                        </div>

                        @error('tax_percentage')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="rounded-xl bg-[#D4A017] px-8 py-3 font-semibold text-[#130E07] transition hover:bg-[#E6B325]">
                        Save Tax Settings
                    </button>
                </form>
            </div>

            <!-- ========================= -->
            <!-- WhatsApp Settings -->
            <!-- ========================= -->
            @php
                $defaultRestaurantTemplate = "Nueva orden recibida!\nOrder: @{{ order_number }}\nName: @{{ customer_name }}\nPhone: @{{ customer_phone }}\nTotal: $@{{ final_price }}\nItems: @{{ items }}";

                $defaultCustomerTemplate = "Gracias @{{ customer_name }}! Tu orden @{{ order_number }} ha sido recibida. Total: $@{{ final_price }}. Nos comunicaremos pronto.";
            @endphp

            <div class="mb-8 rounded-2xl border border-[#D4A017]/20 bg-[#130E07] p-8 shadow-xl">
                <h2 class="mb-6 text-2xl font-bold text-[#D4A017]">
                    WhatsApp Settings
                </h2>

                <form method="POST" action="{{ route('admin.settings.whatsapp') }}" class="space-y-6">
                    @csrf
                    <!-- WhatsApp Settings -->
                    <div class="rounded-3xl border border-[#D4A017]/20 bg-[#1A1208] p-8 shadow-2xl shadow-black/40 mb-8">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-[#F5E6C4]">WhatsApp Settings</h2>
                            <p class="mt-2 text-sm text-[#B8A082]">
                                Configure the WhatsApp number and customize automatic notification messages.
                            </p>
                        </div>

                        @php
                            $defaultRestaurantTemplate = "Nueva orden recibida!\nOrder: @{{ order_number }}\nName: @{{ customer_name }}\nPhone: @{{ customer_phone }}\nTotal: $@{{ final_price }}\nItems: @{{ items }}";
                            $defaultCustomerTemplate = "Gracias @{{ customer_name }}! Tu orden @{{ order_number }} ha sido recibida. Total: $@{{ final_price }}. Nos comunicaremos pronto.";
                        @endphp

                        <form method="POST" action="{{ route('admin.settings.whatsapp') }}" class="space-y-6">
                            @csrf

                            <div>
                                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                                    Restaurant WhatsApp Phone *
                                </label>

                                <input type="text" name="whatsapp_restaurant_number" required
                                    value="{{ old('whatsapp_restaurant_number', $whatsappRestaurantNumber) }}"
                                    placeholder="+1234567890"
                                    class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] placeholder:text-[#7A6A58] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                                @error('whatsapp_restaurant_number')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                                    Restaurant Notification Template *
                                </label>

                                <textarea name="whatsapp_restaurant_template" rows="5" placeholder="Nueva orden para @{{ order_number }}..."
                                    class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] placeholder:text-[#7A6A58] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">{{ old('whatsapp_restaurant_template', $whatsappRestaurantTemplate ?? $defaultRestaurantTemplate) }}</textarea>

                                @error('whatsapp_restaurant_template')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                                    Customer Confirmation Template *
                                </label>

                                <textarea name="whatsapp_customer_template" rows="5" placeholder="Gracias @{{ customer_name }}..."
                                    class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] placeholder:text-[#7A6A58] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">{{ old('whatsapp_customer_template', $whatsappCustomerTemplate ?? $defaultCustomerTemplate) }}</textarea>

                                @error('whatsapp_customer_template')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="rounded-2xl border border-[#D4A017]/20 bg-[#130E07] p-5">
                                <p class="mb-3 font-semibold text-[#D4A017]">
                                    Available Placeholders
                                </p>

                                <div class="flex flex-wrap gap-3 text-sm">
                                    @foreach (['@{{ order_number }}', '@{{ customer_name }}', '@{{ customer_phone }}', '@{{ final_price }}', '@{{ items }}'] as $placeholder)
                                        <code
                                            class="rounded-lg border border-[#D4A017]/20 bg-[#1A1208] px-3 py-2 text-[#F5E6C4]">
                                            {{ $placeholder }}
                                        </code>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit"
                                class="rounded-xl bg-[#D4A017] px-8 py-3 font-bold text-[#130E07] transition hover:bg-[#E5B82E]">
                                Save WhatsApp Settings
                            </button>
                        </form>
                    </div>

                    <!-- Holidays -->
                    <div class="rounded-3xl border border-[#D4A017]/20 bg-[#1A1208] p-8 shadow-2xl shadow-black/40">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-[#F5E6C4]">Holidays (Closed Days)</h2>
                            <p class="mt-2 text-sm text-[#B8A082]">
                                Add holidays when the restaurant will be closed.
                            </p>
                        </div>

                        <!-- Add Holiday Form -->
                        <form method="POST" action="{{ route('admin.settings.holiday') }}"
                            class="mb-8 space-y-6 border-b border-[#D4A017]/20 pb-8">
                            @csrf

                            <div class="grid gap-6 md:grid-cols-3">

                                <div>
                                    <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                                        Holiday Name *
                                    </label>

                                    <input type="text" name="name" required value="{{ old('name') }}"
                                        placeholder="Christmas"
                                        class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] placeholder:text-[#7A6A58] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                                    @error('name')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                                        Date *
                                    </label>

                                    <input type="date" name="date" required value="{{ old('date') }}"
                                        class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">

                                    @error('date')
                                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-end">
                                    <button type="submit"
                                        class="w-full rounded-xl bg-green-600 px-6 py-3 font-bold text-white transition hover:bg-green-500">
                                        Add Holiday
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="mb-2 block text-sm font-semibold uppercase tracking-wide text-[#D4A017]">
                                    Note
                                </label>

                                <input type="text" name="note" value="{{ old('note') }}"
                                    placeholder="Optional note"
                                    class="w-full rounded-xl border border-[#D4A017]/30 bg-[#130E07] px-4 py-3 text-[#F5E6C4] placeholder:text-[#7A6A58] focus:border-[#D4A017] focus:outline-none focus:ring-2 focus:ring-[#D4A017]/30">
                            </div>
                        </form>

                        @if ($holidays->count() > 0)
                            <div>
                                <h3 class="mb-6 text-xl font-bold text-[#F5E6C4]">
                                    Registered Holidays
                                </h3>

                                <div class="space-y-4">
                                    @foreach ($holidays as $holiday)
                                        <div
                                            class="flex flex-col gap-4 rounded-2xl border border-[#D4A017]/15 bg-[#130E07] p-5 transition hover:border-[#D4A017]/40 md:flex-row md:items-center md:justify-between">

                                            <div>
                                                <h4 class="font-bold text-[#F5E6C4]">
                                                    {{ $holiday->name }}
                                                </h4>

                                                <p class="mt-1 text-sm text-[#B8A082]">
                                                    {{ $holiday->date->format('F d, Y (l)') }}
                                                </p>

                                                @if ($holiday->note)
                                                    <p class="mt-2 text-sm text-[#8E7A66]">
                                                        {{ $holiday->note }}
                                                    </p>
                                                @endif
                                            </div>

                                            <form method="POST"
                                                action="{{ route('admin.settings.holiday.remove', $holiday) }}"
                                                onsubmit="return confirm('Remove this holiday?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="rounded-xl bg-red-600 px-5 py-2.5 font-semibold text-white transition hover:bg-red-500">
                                                    Remove
                                                </button>
                                            </form>

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div
                                class="rounded-2xl border border-dashed border-[#D4A017]/20 bg-[#130E07] py-12 text-center">
                                <p class="text-lg text-[#8E7A66]">
                                    No holidays set. Add one above.
                                </p>
                            </div>
                        @endif
                    </div>
            </div>
        </div>
    </div>
@endsection
