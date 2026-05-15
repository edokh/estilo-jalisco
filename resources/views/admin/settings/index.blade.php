@extends('layouts.app')

@section('title', 'Settings - Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Restaurant Settings</h1>

    <!-- Operating Times -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-2xl font-bold mb-6">Operating Hours</h2>

        <form method="POST" action="{{ route('admin.settings.timings') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Opening Time *</label>
                    <input type="time" name="open_time" required value="{{ $openTime }}"
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
                    @error('open_time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Closing Time *</label>
                    <input type="time" name="close_time" required value="{{ $closeTime }}"
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
                    @error('close_time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 font-bold">
                Update Operating Hours
            </button>
        </form>
    </div>

    <!-- WhatsApp Settings -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-2xl font-bold mb-6">WhatsApp Settings</h2>

        @php
            $defaultRestaurantTemplate = "Nueva orden recibida!\nOrder: @{{order_number}}\nName: @{{customer_name}}\nPhone: @{{customer_phone}}\nTotal: $@{{final_price}}\nItems: @{{items}}";
            $defaultCustomerTemplate = "Gracias @{{customer_name}}! Tu orden @{{order_number}} ha sido recibida. Total: $@{{final_price}}. Nos comunicaremos pronto.";
        @endphp

        <form method="POST" action="{{ route('admin.settings.whatsapp') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-2">Restaurant WhatsApp Phone *</label>
                <input type="text" name="whatsapp_restaurant_number" required
                       value="{{ old('whatsapp_restaurant_number', $whatsappRestaurantNumber) }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600"
                       placeholder="+1234567890">
                @error('whatsapp_restaurant_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Restaurant Notification Template *</label>
                <textarea name="whatsapp_restaurant_template" rows="4"
                          class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600"
                          placeholder="Nueva orden para @{{order_number}}...">{{ old('whatsapp_restaurant_template', $whatsappRestaurantTemplate ?? $defaultRestaurantTemplate) }}</textarea>
                @error('whatsapp_restaurant_template') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Customer Confirmation Template *</label>
                <textarea name="whatsapp_customer_template" rows="4"
                          class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600"
                          placeholder="Gracias @{{customer_name}}...">{{ old('whatsapp_customer_template', $whatsappCustomerTemplate ?? $defaultCustomerTemplate) }}</textarea>
                @error('whatsapp_customer_template') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="text-sm text-gray-600 bg-gray-50 border border-gray-200 rounded p-4">
                <p class="font-semibold mb-2">Available placeholders:</p>
                <p><code>@{{order_number}}</code>, <code>@{{customer_name}}</code>, <code>@{{customer_phone}}</code>, <code>@{{final_price}}</code>, <code>@{{items}}</code></p>
            </div>

            <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 font-bold">
                Save WhatsApp Settings
            </button>
        </form>
    </div>

    <!-- Holidays -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-6">Holidays (Closed Days)</h2>

        <!-- Add Holiday Form -->
        <form method="POST" action="{{ route('admin.settings.holiday') }}" class="space-y-4 mb-8 pb-8 border-b">
            @csrf

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Holiday Name *</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600"
                           placeholder="e.g., Christmas">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Date *</label>
                    <input type="date" name="date" required value="{{ old('date') }}"
                           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
                    @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">&nbsp;</label>
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 font-bold">
                        Add Holiday
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Note</label>
                <input type="text" name="note" value="{{ old('note') }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600"
                       placeholder="Optional note">
            </div>
        </form>

        <!-- Holidays List -->
        @if ($holidays->count() > 0)
            <div>
                <h3 class="text-lg font-semibold mb-4">Registered Holidays</h3>
                <div class="space-y-2">
                    @foreach ($holidays as $holiday)
                        <div class="flex justify-between items-center p-4 bg-gray-50 rounded">
                            <div>
                                <p class="font-semibold">{{ $holiday->name }}</p>
                                <p class="text-sm text-gray-600">{{ $holiday->date->format('F d, Y (l)') }}</p>
                                @if ($holiday->note)
                                    <p class="text-sm text-gray-500">{{ $holiday->note }}</p>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('admin.settings.holiday.remove', $holiday) }}"
                                  style="display: inline;" onsubmit="return confirm('Remove this holiday?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <p>No holidays set. Add one above.</p>
            </div>
        @endif
    </div>
</div>
@endsection
