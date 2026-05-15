@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#f7c600] text-start text-base font-medium text-[#13401a] bg-[#f7c600]/20 focus:outline-none focus:text-[#13401a] focus:bg-[#f7c600]/30 focus:border-[#f7c600] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-700 hover:text-[#13401a] hover:bg-[#f7c600]/10 hover:border-[#f7c600] focus:outline-none focus:text-[#13401a] focus:bg-[#f7c600]/20 focus:border-[#f7c600] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
