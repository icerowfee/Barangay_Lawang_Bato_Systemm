<!-- filepath: c:\xampp\htdocs\Barangay_Lawang_Bato_System\resources\views\user/user-barangay-official-section.blade.php -->
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Our Barangay Officials</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>
<body>

    <!-- Navbar -->
    @include('user/user-header')

    <!-- Main Content (Placeholder) -->
    <div class="text-center relative overflow-hidden">

        <!-- Background image -->
        <div class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
            <img src="{{ asset('images/ph-map-bg.png') }}" alt="Lawang Bato Logo" class="h-[150vh] w-[150vh] select-none">
        </div>

        <!-- Foreground Content -->
        <div class="relative z-10 my-20">
            <h2 class="text-4xl font-bold mb-8">OUR BARANGAY OFFICIALS</h2>
            <div class="flex justify-center w-4/5 mx-auto">
                <div class="w-1/3 sm:w-1/2 md:w-1/3 p-4">
                    <div class="p-6">
                        <img src="{{ asset('storage/' . $punongBarangay['barangay_official_image']) }}" class="rounded-full border-2 mx-auto h-[150px] w-[150px]" alt="Barangay Official Picture">
                        <h5 class="mt-4 text-xl font-semibold">{{ $punongBarangay->name }}</h5>
                        <p class="text-gray-600">{{ $punongBarangay->position }}</p>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-wrap justify-center w-4/5 mx-auto">
                
                @foreach ($kagawadOfficials as $kagawadOfficial)
                    <div class="w-1/3 sm:w-1/2 md:w-1/3 p-4">
                        <div class="p-6">
                            <img src="{{ asset('storage/' . $kagawadOfficial['barangay_official_image']) }}" class="rounded-full border-2 mx-auto h-[150px] w-[150px]" alt="Barangay Official Picture">
                            <h5 class="mt-4 text-xl font-semibold">{{ $kagawadOfficial->name }}</h5>
                            <p class="text-gray-600">
                            @if ($kagawadOfficial->position === 'Barangay Secretary' || $kagawadOfficial->position === 'Barangay Treasurer')
                                {{$kagawadOfficial->position}}
                            @else 
                                Barangay Kagawad
                            @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    @include('user/user-footer')

    @livewireScripts
    
</body>
</html>