@extends('layouts.app')

@section('title', 'Create Discount - Admin')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Create Discount</h1>

    <form method="POST" action="{{ route('admin.discounts.store') }}"
          class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-2">Discount Name *</label>
            <input type="text" name="name" required value="{{ old('name') }}"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Apply To (Optional)</label>
            <select name="food_item_id" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
                <option value="">-- All Items --</option>
                @foreach ($foodItems as $item)
                    <option value="{{ $item->id }}" {{ old('food_item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
            @error('food_item_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Discount Type *</label>
                <select name="type" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                </select>
                @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Value *</label>
                <input type="number" name="value" step="0.01" required value="{{ old('value') }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
                @error('value') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Start Date *</label>
                <input type="datetime-local" name="start_date" required value="{{ old('start_date') }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
                @error('start_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">End Date *</label>
                <input type="datetime-local" name="end_date" required value="{{ old('end_date') }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
                @error('end_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }} class="mr-2">
                <span class="text-sm font-medium">Active</span>
            </label>
            @error('active') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 font-bold">
                Create Discount
            </button>
            <a href="{{ route('admin.discounts.index') }}" class="flex-1 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 font-bold text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
