@extends('layouts.app')

@section('title', 'Orders - Admin')

@section('content') <div class="max-w-7xl mx-auto px-4">
        @if (!$isOpen)
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 text-center">
                <h2 class="text-2xl font-bold">🔒 Restaurant Closed</h2>
                <p class="mt-2">We're open from {{ $openTime }} to {{ $closeTime }}</p>
            </div>
        @endif

        <!-- Modal -->
        <div id="cartModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h2 class="text-2xl font-bold mb-4">Special Instructions</h2>

                <textarea id="specialInstructions" class="w-full border rounded p-3 mb-4" rows="4"
                    placeholder="Add a note (e.g. no nuts, no onions)."></textarea>

                <div class="flex items-center justify-between mb-4">
                    <span class="font-bold text-lg">Quantity</span>

                    <div class="flex items-center gap-4">
                        <button type="button" id="decreaseQty" class="px-3 py-1 border rounded">-</button>
                        <span id="modalQty">1</span>
                        <button type="button" id="increaseQty" class="px-3 py-1 border rounded">+</button>
                    </div>
                </div>

                <p id="cartModalError" class="hidden text-sm text-red-600 mb-3"></p>

                <button type="button" id="confirmAddToCart" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 disabled:opacity-60">
                    Add to Cart
                </button>

                <button type="button" id="closeCartModal" class="w-full mt-2 text-gray-500">
                    Cancel
                </button>
            </div>
        </div>

        <div id="mobileCategoryNav" class="md:hidden sticky top-24 z-40 -mx-4 mb-6 bg-gray-100/95 px-4 py-3 backdrop-blur">
            <div class="flex items-center gap-2">
                <div id="mobileCategoryButtons" class="flex min-w-0 flex-1 items-center gap-2 overflow-hidden">
                    @foreach ($categories as $category)
                        <button type="button"
                            class="mobile-category-btn shrink-0 whitespace-nowrap rounded border border-gray-200 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-green-50"
                            data-category="{{ $category->id }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <div id="categoryMoreWrapper" class="relative hidden shrink-0">
                    <button type="button" id="categoryMoreButton"
                        class="rounded border border-gray-200 bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-green-50">
                        More
                    </button>
                    <div id="categoryMoreMenu"
                        class="absolute right-0 top-full mt-2 hidden max-h-72 w-52 overflow-y-auto rounded border border-gray-200 bg-white py-2 shadow-lg">
                        @foreach ($categories as $category)
                            <button type="button"
                                class="more-category-btn block w-full px-4 py-2 text-left text-sm text-gray-700 hover:bg-green-50"
                                data-category="{{ $category->id }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Categories Sidebar -->
            <div class="hidden md:col-span-1 md:block">
                <div class="bg-white rounded-lg shadow p-6 sticky top-20">
                    <h3 class="text-xl font-bold mb-4">Categories</h3>
                    <div class="space-y-2">
                        @foreach ($categories as $category)
                            <button type="button" class="w-full text-left px-4 py-2 rounded hover:bg-green-100 category-btn"
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
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                                class="w-full h-48 object-cover">
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
                const cartAddBaseUrl = '/cart/add';

                let selectedFoodItemId = null;
                let selectedQuantity = 1;
                let isAddingToCart = false;
                let activeCategoryId = null;
                let scrollSpyFrame = null;
                const activeCategoryClasses = 'bg-green-600 text-white border-green-600';
                const inactiveCategoryClasses = 'bg-white text-gray-700 border-gray-200';

                function closeCartModal() {
                    $('#cartModal').addClass('hidden').removeClass('flex');
                    $('#cartModalError').addClass('hidden').text('');
                    selectedFoodItemId = null;
                    isAddingToCart = false;
                    $('#confirmAddToCart').prop('disabled', false).text('Add to Cart');
                }

                function setActiveCategory(categoryId) {
                    activeCategoryId = categoryId;

                    $('.category-btn, .mobile-category-btn, .more-category-btn, #categoryMoreButton')
                        .removeClass(activeCategoryClasses)
                        .addClass(inactiveCategoryClasses);

                    $(`.category-btn[data-category="${categoryId}"], .mobile-category-btn[data-category="${categoryId}"], .more-category-btn[data-category="${categoryId}"]`)
                        .removeClass(inactiveCategoryClasses)
                        .addClass(activeCategoryClasses);

                    updateMoreButtonState();
                }

                function updateMoreButtonState() {
                    const $activeMobileButton = $(`.mobile-category-btn[data-category="${activeCategoryId}"]`);

                    if ($('#categoryMoreWrapper').is(':visible') && $activeMobileButton.hasClass('hidden')) {
                        $('#categoryMoreButton')
                            .removeClass(inactiveCategoryClasses)
                            .addClass(activeCategoryClasses);
                    }
                }

                function getStickyOffset() {
                    return ($('nav:visible').outerHeight() || 0) +
                        ($('#mobileCategoryNav:visible').outerHeight() || 0);
                }

                function scrollToCategory(categoryId) {
                    const $target = $(`.category-section[data-category="${categoryId}"]`).first();

                    if (!$target.length) {
                        return;
                    }

                    const offset = $target.offset().top - getStickyOffset() - 16;

                    $('html, body').animate({
                        scrollTop: Math.max(offset, 0)
                    }, 300);

                    setActiveCategory(categoryId);
                    $('#categoryMoreMenu').addClass('hidden');
                }

                function fitMobileCategories() {
                    const $nav = $('#mobileCategoryNav');

                    if (!$nav.is(':visible')) {
                        return;
                    }

                    const $buttonWrap = $('#mobileCategoryButtons');
                    const $buttons = $buttonWrap.find('.mobile-category-btn');
                    const $moreWrapper = $('#categoryMoreWrapper');
                    const $moreItems = $('#categoryMoreMenu .more-category-btn');
                    const containerWidth = $nav.find('.flex').first().innerWidth();

                    $buttons.removeClass('hidden');
                    $moreItems.addClass('hidden');
                    $moreWrapper.addClass('hidden');

                    let totalWidth = 0;
                    $buttons.each(function() {
                        totalWidth += $(this).outerWidth(true);
                    });

                    if (totalWidth <= containerWidth) {
                        $('#categoryMoreMenu').addClass('hidden');
                        return;
                    }

                    $moreWrapper.removeClass('hidden');

                    const availableWidth = containerWidth - $moreWrapper.outerWidth(true);
                    let usedWidth = 0;
                    let hiddenCount = 0;

                    $buttons.each(function(index) {
                        const $button = $(this);
                        const buttonWidth = $button.outerWidth(true);
                        const categoryId = String($button.data('category'));

                        if (index > 0 && usedWidth + buttonWidth > availableWidth) {
                            $button.addClass('hidden');
                            $moreItems.filter(`[data-category="${categoryId}"]`).removeClass('hidden');
                            hiddenCount++;
                            return;
                        }

                        usedWidth += buttonWidth;
                    });

                    if (!hiddenCount) {
                        $moreWrapper.addClass('hidden');
                        $('#categoryMoreMenu').addClass('hidden');
                    }

                    updateMoreButtonState();
                }

                function syncActiveCategoryFromScroll() {
                    scrollSpyFrame = null;

                    const probeY = $(window).scrollTop() + getStickyOffset() + 32;
                    let currentCategoryId = $('.category-section').first().data('category');

                    $('.category-section').each(function() {
                        const $section = $(this);

                        if ($section.offset().top <= probeY) {
                            currentCategoryId = $section.data('category');
                        }
                    });

                    if (currentCategoryId && String(currentCategoryId) !== String(activeCategoryId)) {
                        setActiveCategory(currentCategoryId);
                    }
                }

                function requestActiveCategorySync() {
                    if (scrollSpyFrame) {
                        return;
                    }

                    scrollSpyFrame = window.requestAnimationFrame(syncActiveCategoryFromScroll);
                }

                $('.category-btn, .mobile-category-btn, .more-category-btn').on('click', function() {
                    scrollToCategory($(this).data('category'));
                });

                $('#categoryMoreButton').on('click', function(event) {
                    event.stopPropagation();
                    $('#categoryMoreMenu').toggleClass('hidden');
                });

                $(document).on('click', function(event) {
                    if (!$(event.target).closest('#categoryMoreWrapper').length) {
                        $('#categoryMoreMenu').addClass('hidden');
                    }
                });

                $(window).on('resize', function() {
                    window.requestAnimationFrame(function() {
                        fitMobileCategories();
                        requestActiveCategorySync();
                    });
                });

                $(window).on('scroll', requestActiveCategorySync);

                fitMobileCategories();
                setActiveCategory($('.category-section').first().data('category'));
                requestActiveCategorySync();

                $('.add-to-cart').on('click', function() {
                    selectedFoodItemId = $(this).data('item');
                    selectedQuantity = 1;

                    $('#modalQty').text(selectedQuantity);
                    $('#specialInstructions').val('');
                    $('#cartModalError').addClass('hidden').text('');

                    $('#cartModal').removeClass('hidden').addClass('flex');
                    $('#specialInstructions').trigger('focus');
                });

                $('#increaseQty').on('click', function() {
                    selectedQuantity++;
                    $('#modalQty').text(selectedQuantity);
                });

                $('#decreaseQty').on('click', function() {
                    if (selectedQuantity > 1) {
                        selectedQuantity--;
                        $('#modalQty').text(selectedQuantity);
                    }
                });

                $('#closeCartModal').on('click', function() {
                    closeCartModal();
                });

                $('#cartModal').on('click', function(event) {
                    if (event.target === this) {
                        closeCartModal();
                    }
                });

                $(document).on('keydown', function(event) {
                    if (event.key === 'Escape' && !$('#cartModal').hasClass('hidden')) {
                        closeCartModal();
                    }
                });

                $('#confirmAddToCart').on('click', function() {
                    if (!selectedFoodItemId || isAddingToCart) {
                        return;
                    }

                    const specialInstructions = $('#specialInstructions').val().trim();

                    isAddingToCart = true;
                    $('#confirmAddToCart').prop('disabled', true).text('Adding...');
                    $('#cartModalError').addClass('hidden').text('');

                    $.ajax({
                            url: `${cartAddBaseUrl}/${selectedFoodItemId}`,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            contentType: 'application/json',
                            dataType: 'json',
                            data: JSON.stringify({
                                quantity: selectedQuantity,
                                instructions: specialInstructions
                            })
                        })
                        .done(function(data) {
                            if (data.success) {
                                if (typeof data.count !== 'undefined') {
                                    $('#cart-badge').text(data.count);
                                }
                                $(document).trigger('cart-updated');
                                closeCartModal();
                            }
                        })
                        .fail(function(xhr, status, error) {
                            const message = xhr.responseJSON?.message || xhr.responseText || error || status;
                            $('#cartModalError').removeClass('hidden').text('Could not add this item. Please try again.');
                            console.error('Error adding item to cart', message);
                        })
                        .always(function() {
                            isAddingToCart = false;
                            $('#confirmAddToCart').prop('disabled', false).text('Add to Cart');
                        });
                });
            });
        });
    </script>

    </div>
@endsection
