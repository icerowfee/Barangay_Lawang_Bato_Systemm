<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Registration Form</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>
<body class="relative overflow-x-hidden" x-data="{ showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }} }">
    
    {{-- Alpine.js for Toast Notification --}}

    <!-- Navbar -->
    @include('user/user-header')

    
    
    <!-- Main Content (Placeholder) class="absolute top-0 left-1/2 w-[130vh] opacity-10 bg-clip-content z-10"> -->
    <div class="bg-white px-8 py-20 rounded-lg shadow-lg w-full relative overflow-hidden">

        <!-- Background image -->
        <div class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
            <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo" class="h-[135vh] w-[135vh] select-none">
        </div>

        <!-- Foreground Content -->
        <div class="relative z-10">
            <h2 class="text-2xl font-bold mb-6 text-center">Account Registration</h2>
            
            <!-- Registration Form -->
            <form action="{{ route('user.register.account') }}" method="POST" enctype="multipart/form-data" class="space-y-4 w-3/5 mx-auto">
                @csrf
                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="firstname" value="{{ old('firstname') }}" placeholder="First Name" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('firstname')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Middle Name</label>
                        <input type="text" name="middlename" value="{{ old('middlename') }}" placeholder="Middle Name" class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('middlename')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="lastname" value="{{ old('lastname') }}" placeholder="Last Name" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('lastname')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address Fields -->
                <div>
                    <label class="block text-sm font-medium">Complete Address</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

                        <div class="flex flex-col">
                            <!-- Street Input -->
                            <label class="block text-sm font-normal">Street Address<span class="text-red-500">*</span></label>
                            <input type="text" name="house_number" value="{{ old('house_number') }}" placeholder="House No., Street, Subdivision" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400"/>
                            @error('house_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <!-- Barangay Input -->
                            <label class="block text-sm font-normal">Barangay<span class="text-red-500">*</span></label>
                            <input type="text" name="barangay" value="{{ old('barangay') }}" placeholder="Barangay" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400"/>
                            @error('barangay')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                            
                        <div class="flex flex-col">
                            <!-- City Input -->
                            <label class="block text-sm font-normal">City<span class="text-red-500">*</span></label>
                            <input type="text" name="city" value="{{ old('city') }}" placeholder="City" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400"/>
                            @error('city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex flex-col">
                            <!-- Province Input -->
                            <label class="block text-sm font-normal">Province<span class="text-red-500">*</span></label>
                            <input type="text" name="province" value="{{ old('province') }}" placeholder="Province" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400"/>
                            @error('province')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                    </div>
                </div>

                <!-- Civil Status & Birthdate & Auto-Calculated Age & Sex-->
                <div x-data="{ birthdate: '{{ old('birthdate') }}', age: '{{ old('age') }}' }" class="flex">
                    <div class=" w-1/3 pr-2">
                        <label class="block text-sm font-medium">Civil Status <span class="text-red-500">*</span></label>
                        <select name="civil_status" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                            <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                        @error('civil_status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-1/3 px-2">
                        <label class="block text-sm font-medium">Birthdate <span class="text-red-500">*</span></label>
                        <input type="date" name="birthdate" value="{{ old('birthdate') }}" x-model="birthdate" 
                            @change="let today = new Date(); 
                                    let bday = new Date(birthdate); 
                                    let ageDiff = today.getFullYear() - bday.getFullYear();
                                    let monthDiff = today.getMonth() - bday.getMonth();
                                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < bday.getDate())) {
                                        ageDiff--;
                                    }
                                    age = ageDiff;"
                            required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('birthdate')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        @error('age')
                            <p class="text-red-500 text-sm mt-1">Age must be 18 and above</p>
                        @enderror
                    </div>
                    <div class="w-1/3 pl-2 flex">
                        <div class="w-1/2 pr-2">
                            <label class="block text-sm font-medium">Age <span class="text-red-500">*</span></label>
                            <input type="number" name="age" x-model="age" value="{{ old('age') }}" readonly required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400 bg-gray-200">
                        </div>

                        <div class="w-1/2 pl-2">
                            <label class="block text-sm font-medium">Sex <span class="text-red-500">*</span></label>
                            <select name="sex" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('sex')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Email & Mobile -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Mobile Number <span class="text-red-500">*</span></label>
                        <input type="number" name="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('contact_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-password-toggle>
                        <label class="block text-sm font-medium">Password <span class="text-red-500">*</span></label>
                        <input :type="show ? 'text' : 'password'" name="password" placeholder="Password" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </x-password-toggle>
                    <x-password-toggle>
                        <label class="block text-sm font-medium">Confirm Password <span class="text-red-500">*</span></label>
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Confirm Password" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                    </x-password-toggle>
                </div>

                <!-- Upload ID -->
                <div>
                    <label class="block text-sm font-medium">Upload Valid ID<span class="text-red-500">*</span></label>
                    <input type="file" name="valid_id" accept="image/*" required class="w-full bg-white border border-gray-400 p-2 rounded-md">
                    @error('valid_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-sm text-gray-500 mt-2">*Please upload a valid ID with your name and address.</div>
                <div class="text-sm text-gray-500 mt-2">*File size should not exceed 2MB.</div>
                <div class="text-sm text-gray-500 mt-2">*File format should be JPEG, PNG.</div>
                <div class="text-sm text-gray-500 mt-2">*Please ensure the image is clear and readable.</div>
                
                <input type="hidden" name="status" value="Pending">

                <div class="mb-4 text-center flex items-start gap-2 text-sm text-gray-700 justify-center">
                    <input type="checkbox" name="data_privacy_agreement" required class="mt-1">
                    <p>
                        I have read and agree to the  <a class="text-blue-600 hover:underline cursor-pointer" @click="$dispatch('open-privacy-policy')">Privacy Policy</a> regarding the collection and use of my personal information for processing this request.
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="flex flex-col justify-center mt-4">
                <div class="flex justify-center items-center gap-2 mt-4 mb-4">
                    <p>Already have an account? </p>
                    <a href="/user-job-seeking" class="text-blue-600 hover:underline text-sm font-medium">
                        <span class="font-semibold">Login here</span>
                    </a>
                </div>
            </div>

            {{-- Action Successful Toast --}}
            <div 
                x-cloak x-show="showSuccessNotificationToast"
                x-transition
                x-cloak
                x-init="setTimeout(() => showSuccessNotificationToast = false, 7000)"
                class="fixed top-20 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
                
                {{ session('success') }}
            </div>
        </div>
    </div>    

    <!-- Footer Section -->
    @include('user/user-footer')

    <x-privacy-policy-modal />

    @livewireScripts

</body>
</html>