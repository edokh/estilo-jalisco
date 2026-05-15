@extends('layouts.app')

@section('title', 'Orders - Admin')

@section('content') <div class="max-w-7xl mx-auto px-4 py-8">
        @if (!$isOpen)
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 text-center">
                <h2 class="text-2xl font-bold">🔒 Restaurant Closed</h2>
                <p class="mt-2">We're open from {{ $openTime }} to {{ $closeTime }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Categories Sidebar -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-20">
                    <h3 class="text-xl font-bold mb-4">Categories</h3>
                    <div class="space-y-2">
                        @foreach ($categories as $category)
                            <button class="w-full text-left px-4 py-2 rounded hover:bg-green-100 category-btn"
                                data-category="{{ $category->id }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="md:col-span-3">
                @foreach ($categories as $category)
                    <div class="category-section mb-12" data-category="{{ $category->id }}">
                        <h2 class="text-3xl font-bold mb-6 text-green-600">{{ $category->name }}</h2>
                        @if ($category->foodItems->isEmpty())
                            <p class="text-gray-500">No items available in this category</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($category->foodItems as $item)
                                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                                        @if ($item->image)
                                            <img src="{{ asset('storage/food-items/' . $item->image) }}"
                                                alt="{{ $item->name }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <span class="text-4xl">🍽️</span>
                                            </div>
                                        @endif

                                        <div class="p-4">
                                            <h3 class="text-lg font-semibold mb-2">{{ $item->name }}</h3>
                                            <div class="min-h-[60px]">
                                                @if ($item->description)
                                                    <p class="text-gray-600 text-sm mb-3">{{ $item->description }}</p>
                                                @endif
                                            </div>
                                            <div class="flex items-center justify-between mb-4">
                                                @php
                                                    $discount = $item->getActiveDiscount();
                                                    $discountedPrice = $item->getPriceWithDiscount();
                                                @endphp

                                                <div class="flex items-center gap-2">
                                                    <span
                                                        class="text-2xl font-bold text-green-600">${{ number_format($discountedPrice, 2) }}</span>
                                                    @if ($discount)
                                                        <div class="flex flex-col items-start">
                                                            <span
                                                                class="text-sm line-through text-gray-500">${{ number_format($item->price, 2) }}</span>
                                                            <span class="text-xs font-bold text-red-600">
                                                                @if ($discount->type === 'percentage')
                                                                    {{ $discount->value }}% OFF
                                                                @else
                                                                    -${{ number_format($discount->value, 2) }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <input type="number" value="1" min="1" hidden
                                                    class="item-quantity w-16 px-2 py-1 border rounded"
                                                    data-item="{{ $item->id }}">
                                                <button type="button" data-item="{{ $item->id }}"
                                                    class="flex-1 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition add-to-cart"
                                                    {{ !$isOpen ? 'disabled' : '' }}>
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        window.whenJQueryReady(function($) {
            $(function() {
                const cartAddBaseUrl = '{{ url('/cart/add') }}';

                $('.add-to-cart').on('click', function() {
                    const foodItemId = $(this).data('item');
                    const $input = $(`input[data-item="${foodItemId}"]`);
                    const quantity = parseInt($input.val(), 10) || 1;

                    $.ajax({
                            url: `${cartAddBaseUrl}/${foodItemId}`,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            contentType: 'application/json',
                            dataType: 'json',
                            data: JSON.stringify({
                                quantity
                            })
                        })
                        .done(function(data) {
                            if (data.success) {
                                $(document).trigger('cart-updated');
                            }
                        })
                        .fail(function(xhr, status, error) {
                            console.error('Error adding item to cart', error || status);
                        });
                });

                $('.category-btn').on('click', function() {
                    const categoryId = $(this).data('category');

                    $('.category-btn').removeClass('bg-orange-600 text-white').addClass(
                        'hover:bg-orange-100');
                    $(this).addClass('bg-orange-600 text-white').removeClass('hover:bg-orange-100');

                    const $target = $(`.category-section[data-category="${categoryId}"]`).first();
                    if ($target.length) {
                        const offset = $target.offset().top - 100;
                        $('html, body').animate({
                            scrollTop: offset
                        }, 300);

                        const $heading = $target.find('h2').first();
                        if ($heading.length) {
                            $heading.attr('tabindex', '-1').focus();
                        }
                    }
                });
            });
        });
    </script>
    </div>
@endsection
