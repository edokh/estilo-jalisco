@extends('layouts.app')

@section('title', 'Create Food Item - Admin')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Create Food Item</h1>

    <form method="POST" action="{{ route('admin.food-items.store') }}" enctype="multipart/form-data"
          class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-2">Category *</label>
            <select name="category_id" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Item Name *</label>
            <input type="text" name="name" required value="{{ old('name') }}"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
            @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full px-4 py-2 border rounded">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Price (USD) *</label>
            <input type="number" name="price" step="0.01" required value="{{ old('price') }}"
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-orange-600">
            @error('price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full">
            @error('image') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Order (Display Position)</label>
            <input type="number" name="order" value="{{ old('order', 0) }}" class="w-full px-4 py-2 border rounded">
            @error('order') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="flex items-center">
                <input type="checkbox" name="available" value="1" {{ old('available', true) ? 'checked' : '' }} class="mr-2">
                <span class="text-sm font-medium">Available</span>
            </label>
            @error('available') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 font-bold">
                Create Item
            </button>
            <a href="{{ route('admin.food-items.index') }}" class="flex-1 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 font-bold text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
