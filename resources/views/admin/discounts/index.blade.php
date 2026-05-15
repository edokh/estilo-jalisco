@extends('layouts.app')

@section('title', 'Discounts - Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Discounts</h1>
        <a href="{{ route('admin.discounts.create') }}" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700">
            + Add Discount
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Item</th>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Value</th>
                    <th class="px-6 py-3 text-left">Valid Until</th>
                    <th class="px-6 py-3 text-left">Active</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($discounts as $discount)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3 font-semibold">{{ $discount->name }}</td>
                        <td class="px-6 py-3">{{ $discount->foodItem?->name ?? 'All Items' }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded {{ $discount->type === 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($discount->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 font-semibold">
                            @if ($discount->type === 'percentage')
                                {{ $discount->value }}%
                            @else
                                ${{ number_format($discount->value, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-3 text-sm">{{ $discount->end_date->format('M d, Y') }}</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded {{ $discount->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $discount->active ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="px-6 py-3 space-x-2">
                            <a href="{{ route('admin.discounts.edit', $discount) }}" 
                               class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form method="POST" action="{{ route('admin.discounts.destroy', $discount) }}" 
                                  style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No discounts found. <a href="{{ route('admin.discounts.create') }}" class="text-orange-600">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
