<!-- filepath: /c:/xampp/htdocs/Barangay_Lawang_Bato_System/resources/views/user/user-cedula-request.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Request Form</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>
<body x-data="{ showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }} }">
    
    {{-- Alpine.js for Toast Notification --}}

    <!-- Navbar -->
    @include('user/user-header')

    <section class="relative z-[-1]">
        <img src="{{asset('images/barangay-lawang-bato-3s-hero-section.jpg')}}" alt="Clearance Request Banner" class="w-full h-80 object-cover">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center bg-black bg-opacity-50 ">
            <h2 class="text-7xl font-bold">CLEARANCE REQUEST</h2>
            <p class="text-xl mt-4">
                A barangay-issued document certifying that a resident has no pending obligations or violations within the community.
            </p>
        </div>
    </section>
    
    <!-- Main Content (Placeholder) -->
    <div class="py-16 bg-white p-8 rounded-lg shadow-lg w-full relative overflow-hidden">

        <!-- Background image -->
        <div class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
            <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo" class="h-[135vh] w-[135vh] select-none">
        </div>

        <!-- Foreground Content -->
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-8 text-center">Clearance Request Form</h2>
            
            <form action="{{ route('clearance.request') }}" method="POST" enctype="multipart/form-data" class="space-y-4 w-3/5 mx-auto">
                @csrf
                <!-- Name Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="firstname" placeholder="First Name" value="{{old ('firstname')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('firstname')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Middle Name</label>
                        <input type="text" name="middlename" placeholder="Middle Name" value="{{old ('middlename')}}" class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('middlename')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="lastname" placeholder="Last Name" value="{{old ('lastname')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('lastname')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Address Fields with Alpine.js -->
                <div>
                    <label class="block text-sm font-medium">Complete Address</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

                        <div class="flex flex-col">
                            <!-- Street Input -->
                            <label class="block text-sm font-normal">Street Address <span class="text-red-500">*</span></label>
                            <input type="text" name="house_number" value="{{old ('house_number')}}" placeholder="House No., Street, Subdivision" required class="line-clamp-1 border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400"/>
                            @error('house_number')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <!-- Barangay Input -->
                            <label class="block text-sm font-normal">Barangay <span class="text-red-500">*</span></label>
                            <input type="text" name="barangay" value="Lawang Bato" placeholder="Barangay"class="border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400 bg-gray-200 cursor-not-allowed" readonly/>
                        </div>
                            
                        <div class="flex flex-col">
                            <!-- City Input -->
                            <label class="block text-sm font-normal">City <span class="text-red-500">*</span></label>
                            <input type="text" name="city" value="Valenzuela City" placeholder="City" class="border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400 bg-gray-200 cursor-not-allowed" readonly/>
                        </div>
                        
                        <div class="flex flex-col">
                            <!-- Province Input -->
                            <label class="block text-sm font-normal">Province <span class="text-red-500">*</span></label>
                            <input type="text" name="province" value="Metro Manila" placeholder="Province" class="border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400 bg-gray-200 cursor-not-allowed" readonly/>
                        </div>
                    </div>
                </div>

                <!-- Civil Status, Birthplace, Birthdate & Auto-Calculated Age & Sex-->
                <div x-data="{ birthdate: '{{old ('birthdate')}}', age: '{{old ('age')}}' }" class="grid grid-cols-4 gap-4">
                    <div class="grid grid-cols-3 col-span-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Civil Status <span class="text-red-500">*</span></label>
                            <select name="civil_status" value="{{old ('civil_status')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Separated">Separated</option>
                            </select>
                            @error('civil_status')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col">
                            <!-- Street Input -->
                            <label class="block text-sm font-medium">Birthplace <span class="text-red-500">*</span></label>
                            <input type="text" name="birthplace" value="{{old ('birthplace')}}" placeholder="Birthplace" required class="line-clamp-1 border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400" />
                            @error('birthplace')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Birthdate <span class="text-red-500">*</span></label>
                            <input type="date" name="birthdate"  value="{{old ('birthdate')}}" x-model="birthdate" 
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
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    

                    
                    <div class="grid grid-cols-3 col-span-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Age <span class="text-red-500">*</span></label>
                            <input type="number" name="age" placeholder="Age" value="{{old ('age')}}" x-model="age" readonly required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400 bg-gray-200 cursor-not-allowed">
                            @error('age')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Sex <span class="text-red-500">*</span></label>
                            <select name="sex" value="{{old ('sex')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('sex')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        
                        <div>
                            <label class="block text-sm font-medium">Years of Residency</label>
                            <input type="number" name="years_stay" placeholder="Years of Residency" value="{{old ('years_stay')}}" class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                            @error('years_stay')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Email & Mobile -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" placeholder="Email" value="{{old ('email')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Mobile Number <span class="text-red-500">*</span></label>
                        <input type="number" name="contact_number" placeholder="Contact Number" value="{{old ('contact_number')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                        @error('contact_number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Purpose -->
                <div>
                    <label class="block text-sm font-medium">Purpose for Requesting <span class="text-red-500">*</span></label>
                    <input type="text" name="user_purpose" placeholder="Purpose for Requesting" value="{{old ('user_purpose')}}" class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                    @error('user_purpose')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium">Upload Valid ID <span class="text-red-500">*</span></label>
                    <input type="file" name="valid_id" accept="image/*" required class="w-full border border-gray-400 bg-white p-2 rounded-md">
                    @error('valid_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="text-sm text-gray-500 mt-2">*Please upload a valid ID with your name and address.</div>
                <div class="text-sm text-gray-500 mt-2">*File size should not exceed 2MB.</div>
                <div class="text-sm text-gray-500 mt-2">*File format should be JPEG, PNG.</div>
                <div class="text-sm text-gray-500 mt-2">*Please ensure the image is clear and readable.</div>

                <div class="mb-4 text-center flex items-start gap-2 text-sm text-gray-700 justify-center">
                    <input type="checkbox" name="data_privacy_agreement" required class="mt-1">
                    <p>
                        I have read and agree to the <a class="text-blue-600 hover:underline cursor-pointer" @click="$dispatch('open-privacy-policy')">Privacy Policy</a> regarding the collection and use of my personal information for processing this request.
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                        Submit Request
                    </button>
                </div>

            </form>

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