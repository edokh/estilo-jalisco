@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'px-2 border-gray-700 focus:border-indigo-200 focus:ring-indigo-200 rounded-md shadow-sm py-2']) }}>
