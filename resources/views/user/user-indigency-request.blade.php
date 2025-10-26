<!-- filepath: /c:/xampp/htdocs/Barangay_Lawang_Bato_System/resources/views/user/user-cedula-request.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indigency Request Form</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>
<body x-data="{ showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }} }">
    
    {{-- Alpine.js for Toast Notification --}}
    
    <!-- Navbar -->
    @include('user/user-header')

    <section class="relative z-[-1]">
        <img src="{{asset('images/barangay-lawang-bato-3s-hero-section.jpg')}}" alt="Indigency Request Banner" class="w-full h-80 object-cover">
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center bg-black bg-opacity-50 ">
            <h2 class="text-7xl font-bold">INDIGENCY REQUEST</h2>
            <p class="text-xl mt-4">
                A certification provided to residents who are identified as financially incapable, for use in availing government or charitable assistance.
            </p>
        </div>
    </section>
    
    <div class="py-16 bg-white p-8 rounded-lg shadow-lg w-full relative overflow-hidden">

        <!-- Background image -->
        <div class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
            <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo" class="h-[135vh] w-[135vh] select-none">
        </div>

        <!-- Foreground Content -->
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-8 text-center">Indigency Request Form</h2>
            
            <form action="{{ route('indigency.request') }}" method="POST" enctype="multipart/form-data" class="space-y-4 w-3/5 mx-auto">
                @csrf
                <!-- Name Fields -->
                <div class=""> 
                    <label class="block text-lg font-medium">Patient/Recipient</label>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="recipient_firstname" placeholder="Recipient's First Name" value="{{old ('recipient_firstname')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                            @error('recipient_firstname')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Middle Name</label>
                            <input type="text" name="recipient_middlename" placeholder="Recipient's Middle Name" value="{{old ('recipient_middlename')}}" class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                            @error('recipient_middlename')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="recipient_lastname" placeholder="Recipient's Last Name" value="{{old ('recipient_lastname')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                            @error('recipient_lastname')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div> 
                    <label class="block text-lg font-medium">Representative/Maglalakad</label>
                    <div class="grid grid-cols-3 gap-4 mb-2">
                        <div>
                            <label class="block text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="representative_firstname" placeholder="Representative's First Name" value="{{old ('representative_firstname')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                            @error('representative_firstname')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Middle Name</label>
                            <input type="text" name="representative_middlename" placeholder="Representative's Middle Name" value="{{old ('representative_middlename')}}" class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                            @error('representative_middlename')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror    
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="representative_lastname" placeholder="Representative's Last Name" value="{{old ('representative_lastname')}}" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                            @error('representative_lastname')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Address Fields -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium">Complete Address</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

                            <div class="flex flex-col">
                                <!-- Street Input -->
                                <label class="block text-sm font-normal">Street Address <span class="text-red-500">*</span></label>
                                <input type="text" name="house_number" value="{{old ('house_number')}}" placeholder="House No., Street, Subdivision" required class="line-clamp-1 border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400" />
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

                    <!-- Email & Mobile -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                </div>
                

                <!-- Purpose -->
                <div>
                    <label class="block text-sm font-medium">Purpose for Requesting <span class="text-red-500">*</span></label>
                    <textarea name="user_purpose" placeholder="Purpose for Requesting" value="{{old ('user_purpose')}}" rows="1" required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400"></textarea>
                    @error('user_purpose')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- File Upload -->
                <div class="grid grid-cols-1 gap-4">
                    <div >
                        <label class="block text-sm font-medium">Upload Valid ID of Representative <span class="text-red-500">*</span></label>
                        <input type="file" name="valid_id" accept="image/*" required class="w-full bg-white border border-gray-400 p-2 rounded-md">
                    </div>
                    {{-- <div >
                        <label class="block text-sm font-medium">Upload Cedula</label>
                        <input type="file" name="cedula_photo" x-model="cedulaPhoto" accept="image/*" class="w-full border border-gray-400 p-2 rounded-md">
                    </div>

                    <div>
                        <label class="  block text-sm font-medium">Cedula Number</label>
                        <input type="number" name="cedula_number" :disabled="!cedulaPhoto" class="w-full h-[48px] border border-gray-400 p-2 rounded-md">
                    </div> --}}
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