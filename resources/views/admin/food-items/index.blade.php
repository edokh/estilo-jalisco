@extends('layouts.app')

@section('title', 'Food Items - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Food Items</h1>
        <a href="{{ route('admin.food-items.create') }}" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700">
            + Add Food Item
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Image</th>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left">Price</th>
                    <th class="px-6 py-3 text-left">Available</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" 
                                     class="h-12 w-12 object-cover rounded">
                            @else
                                <span>No image</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 font-semibold">{{ $item->name }}</td>
                        <td class="px-6 py-3">{{ $item->category->name }}</td>
                        <td class="px-6 py-3 font-semibold text-orange-600">${{ number_format($item->price, 2) }}</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded {{ $item->available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->available ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="px-6 py-3 space-x-2">
                            <a href="{{ route('admin.food-items.edit', $item) }}" 
                               class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form method="POST" action="{{ route('admin.food-items.destroy', $item) }}" 
                                  style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No food items found. <a href="{{ route('admin.food-items.create') }}" class="text-orange-600">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
