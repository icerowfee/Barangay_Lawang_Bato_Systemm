<!-- filepath: /c:/xampp/htdocs/Barangay_Lawang_Bato_System/resources/views/user/user-cedula-request.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cedula Request Form</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>

<body x-data="{ showSuccessNotificationToast: false, successMessage: '' }"
    x-on:show-success-toast.window="
        showSuccessNotificationToast = true;
        successMessage = $event.detail.message;
        setTimeout(() => showSuccessNotificationToast = false, 7000);
    ">

    {{-- Alpine.js for Toast Notification --}}

    <!-- Navbar -->
    @include('user/user-header')

    <section class="relative z-[-1]">
        <img src="{{ asset('images/barangay-lawang-bato-3s-hero-section.jpg') }}" alt="Cedula Request Banner"
            class="w-full h-80 object-cover">
        <div
            class="absolute inset-0 flex flex-col items-center justify-center text-white text-center bg-black bg-opacity-50 ">
            <h2 class="text-6xl font-bold">CERTIFICATION TAX CERTIFICATE – <br> CEDULA REQUEST</h2>
            <p class="text-xl mt-4">
                A community tax certificate issued to residents as proof of identity and residency for legal and
                administrative transactions.
            </p>
        </div>
    </section>

    <!-- Main Content (Placeholder) -->
    <div class="py-16 bg-white p-8 rounded-lg shadow-lg w-full relative overflow-hidden">

        <!-- Background image -->
        <div class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
            <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo"
                class="h-[135vh] w-[135vh] select-none">
        </div>

        <!-- Foreground Content -->
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-8 text-center">Cedula Request Form</h2>

            <livewire:cedula-request-form />
            
            <div x-cloak x-show="showSuccessNotificationToast" x-transition
                class="fixed top-20 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
                <span x-text="successMessage"></span>
            </div>
        </div>
    </div>



    <!-- Footer Section -->
    @include('user/user-footer')

    <x-privacy-policy-modal />

    @livewireScripts

</body>

</html>
