<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-[#1d7d32] rounded-md font-semibold text-xs text-[#1d7d32] uppercase tracking-widest shadow-sm hover:bg-[#f8f2de] focus:outline-none focus:ring-2 focus:ring-[#f7c600] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
