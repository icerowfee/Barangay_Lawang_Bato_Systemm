<div x-data="{ show: false }" class="relative">
    {{ $slot }}

    <button
        type="button"
        @click="show = !show"
        class="absolute top-1/2 right-0 pr-3 flex items-center text-gray-500"
        tabindex="-1"
    >
        <!-- Eye icon (hidden) -->
        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>

        <!-- Eye-off icon (visible) -->
        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.96 9.96 0 012.6-4.362m2.77-1.93A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.253 5.04M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3l18 18" />
        </svg>
    </button>
</div>
