<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#1d7d32] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#13401a] focus:bg-[#13401a] active:bg-[#0f3016] focus:outline-none focus:ring-2 focus:ring-[#f7c600] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
