@extends('layouts.app')

@section('title', 'Create Category - Admin')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Create Category</h1>

    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data"
          class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-2">Category Name *</label>
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
                <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }} class="mr-2">
                <span class="text-sm font-medium">Active</span>
            </label>
            @error('active') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 font-bold">
                Create Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="flex-1 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 font-bold text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
