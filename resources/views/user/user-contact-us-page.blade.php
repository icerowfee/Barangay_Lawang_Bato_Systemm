<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>
<body class="bg-[#DBEFFF]" x-data="{ showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }} }">
    @include('user/user-header')
    <!-- Contact Section -->
    <section class="w-3/5 mx-auto py-10 grid grid-cols-2 gap-10 items-start">
        <!-- Form Card -->
        <div class="bg-white p-6 rounded shadow-lg">
            <h2 class="text-3xl font-bold mb-6 text-center">Get in Touch with Barangay Lawang Bato</h2>
            <form action="{{ route('send.email') }}" method="POST" class="space-y-4">
                @csrf
                <div class="flex gap-4 mb-4">
                    <input type="text" name="firstname" placeholder="First Name" class="w-1/2 border border-gray-400 p-2 rounded">
                    <input type="text" name="lastname" placeholder="Last Name" class="w-1/2 border border-gray-400 p-2 rounded">
                </div>
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Your email address" class="w-full border border-gray-400 p-2 rounded">
                </div>
                <div class="mb-4">
                    <textarea rows="6" name="user_message" placeholder="Your message" class="w-full border border-gray-400 p-2 rounded resize-none"></textarea>
                </div>
                <div class="mb-4 flex items-start gap-2 text-sm text-gray-700">
                    <input type="checkbox" required class="mt-1 border border-gray-400">
                    <p>
                        In compliance with RA 10173 (Data Privacy Act of 2012), I hereby agree to provide information that Barangay Lawang Bato, Valenzuela City commits to safeguard with utmost confidentiality and to use it only for purposes of providing community updates.
                    </p>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-[#0f2d52] text-white px-6 py-2 rounded hover:bg-[#0d2544] transition">Submit</button>
                </div>
            </form>
        </div>

        <!-- Contact Info -->
        <div class="text-gray-800">
            <h3 class="text-xl font-bold mb-4">For more information, you can also contact us through our official Facebook page or landline.</h3>
            <div class="space-y-4 mt-8">
                <div class="bg-white px-6 py-4 rounded shadow text-center font-semibold text-lg">
                    Barangay Lawang Bato
                </div>
                <div class="bg-white px-6 py-4 rounded shadow text-center font-semibold text-lg">
                    270 000 083
                </div>
            </div>
        </div>
    </section>

    @php
      use Carbon\Carbon;   
    @endphp

    <section class="relative bg-[#8B2C1D] text-white mt-[100px] pb-10">
        <!-- SVG Curve Top -->
        <div class="absolute -top-[100px] left-0 w-full overflow-hidden leading-[0]">
            <svg class="relative block w-full h-[100px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
                <path d="M0,80 Q720,0 1440,80 L1440,100 L0,100 Z" fill="#8B2C1D"></path>
            </svg>
        </div>
        

        <!-- Section Content -->
        <div class="relative z-10 pb-12 text-center">
            <h2 class="text-3xl font-bold">Baranggay Lawang Bato Map</h2>
            <p class="mt-2">Charting Progress, Connecting Community: Navigating the Barangay Lawang Bato Master Action Plan (MAP)</p>
            
            <div class="mt-6">
                <iframe class="w-full max-w-4xl mx-auto h-80" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30870.048229391443!2d120.98156836207276!3d14.726380780413402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b17f2311be67%3A0xdbd338a857bac941!2sLawang%20Bato%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1746981805357!5m2!1sen!2sph" allowfullscreen></iframe>
            </div>
        </div>

        <div class="flex flex-col items-center">
            <div class="flex gap-4">
                <a href="/user-contact-us-page"><img class="h-[40px]" src="{{asset('images/gmail-logo.png')}}" alt=""></a>
                <a href="https://www.facebook.com/BarangayLawangBato/" target="_blank"><img class="h-[40px]" src="{{asset('images/facebook-logo.png')}}" alt=""></a>
                <a href="/user-contact-us-page"><img class="h-[40px]" src="{{asset('images/telephone-logo.png')}}" alt=""></a>
            </div>
            <p>{{Carbon::now()->format('Y')}} Barangay Lawang Bato</p>
        </div>
    </section>

    {{-- Action Successful Toast --}}
    <div 
        x-cloak x-show="showSuccessNotificationToast"
        x-transition
        x-cloak
        x-init="setTimeout(() => showSuccessNotificationToast = false, 7000)"
        class="fixed top-20 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        
        {{ session('success') }}
    </div>

    @include('user/user-footer')

    <x-privacy-policy-modal />

    @livewireScripts
    
</body>
</html>