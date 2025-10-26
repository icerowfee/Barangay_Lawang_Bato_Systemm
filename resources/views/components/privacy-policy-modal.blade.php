<div 
    x-data="{ open: false }" 
    x-show="open" 
    @open-privacy-policy.window="open = true"
    @keydown.escape.window="open = false"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    x-cloak
>
    <div 
        class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 relative"
        @click.away="open = false"
    >
        <!-- Close button -->
        <button 
            @click="open = false" 
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-800"
        >
            ✕
        </button>

        <!-- Modal Title -->
        <h2 class="text-xl font-bold text-blue-900 mb-4">Privacy Policy</h2>

        <!-- Modal Content -->
        <div class="space-y-3 text-gray-700 text-sm overflow-y-auto max-h-[60vh]">
            <p>We value your privacy. This system collects only the information necessary to process your requests and maintain service quality.</p>
            <p>Your personal data (such as name, address, and contact number) will be used solely for verification and record purposes within the Barangay Lawang Bato Digital Services System (LBDSS).</p>
            <p>We will not share your data with third parties without your consent, except as required by law or for legitimate government use.</p>
            <p>By continuing to use this system, you agree to our data privacy policy as stated here.</p>
        </div>

        <!-- Footer / Buttons -->
        <div class="mt-6 flex justify-end">
            <button 
                @click="open = false" 
                class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
            >
                Close
            </button>
        </div>
    </div>
</div>
