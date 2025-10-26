<div x-data="{ open: false }" class="relative w-full mt-2">
    {{ $slot }}

    <!-- Custom arrow -->
    <svg 
        xmlns="http://www.w3.org/2000/svg"
        fill="none" 
        viewBox="0 0 24 24" 
        stroke="currentColor"
        class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none transition-transform duration-300"
        :class="{ 'rotate-180': open }"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
    </svg>
</div>