@extends('layouts.app')

@section('title', 'Categories - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700">
            + Add Category
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Description</th>
                    <th class="px-6 py-3 text-left">Order</th>
                    <th class="px-6 py-3 text-left">Active</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 font-semibold">{{ $category->name }}</td>
                        <td class="px-6 py-3 text-sm text-gray-600">{{ Str::limit($category->description, 50) }}</td>
                        <td class="px-6 py-3">{{ $category->order }}</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded {{ $category->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->active ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="px-6 py-3 space-x-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                                  style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            No categories found. <a href="{{ route('admin.categories.create') }}" class="text-orange-600">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
