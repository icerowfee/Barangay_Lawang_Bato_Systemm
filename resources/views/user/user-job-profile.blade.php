<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>

<body class="h-full flex flex-col" x-data="{
    isEditing: false,
    isChangingAccountCredentials: false,
    viewUplaodedResume: false,
    viewUploadedID: false,
    viewUploadedSecondaryID: false,
    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},
}">

    <!-- Navbar -->
    @include('user/user-header')

    <main class="relative flex-grow flex justify-center items-start py-32">
        <a href="/user-job-seeking" class="absolute top-12 left-12 mb-6 w-fit text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>

        <div x-show="isEditing === false" class="w-2/5 h-fit mx-auto bg-white rounded-lg shadow border border-gray-300 p-8">
            <!-- User Info -->
            <div class="text-center">
                <h2 class="text-2xl font-bold text-left text-gray-900 mb-2">{{ $user->firstname }}
                    {{ $user->middlename }} {{ $user->lastname }}</h2>
                <div class="space-y-2 text-gray-700 text-sm">
                    <div class="flex items-center">
                        <img class="h-5 mx-2" src="{{ asset('images/black-gmail-icon.png') }}" alt="">
                        <span class="text-base">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center">
                        <img class="h-5 mx-2" src="{{ asset('images/black-phone-icon.png') }}" alt="">
                        <span class="text-base">{{ $user->contact_number }}</span>
                    </div>
                    <div class="flex items-center">
                        <img class="h-5 mx-2" src="{{ asset('images/location-icon.png') }}" alt="">
                        <span class="text-base">{{ $user->house_number }}, {{ $user->barangay }}, {{ $user->city }},
                            {{ $user->province }} </span>
                    </div>
                </div>
                <button @click="isEditing = true"
                    class="text-blue-600 text-sm font-medium mt-3 flex-1 text-center">Edit</button>
            </div>



            <!-- Resume -->
            <div class="mt-6">
                <h3 class="font-semibold text-gray-900 mb-2">Resume</h3>
                <div class="flex items-center justify-between border rounded-lg px-4 py-3 bg-gray-50">
                    @if ($user->resume != null)
                        <div class="flex items-center justify-between flex-1">
                            <div class="flex items-center">
                                <span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-bold mr-3">PDF</span>
                                <p class="text-sm text-gray-800">{{ basename($user->resume) }}</p>
                            </div>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="p-1 rounded hover:bg-gray-200">
                                    ⋮
                                </button>
                                <div x-cloak x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-40 bg-white border rounded-md shadow-lg text-sm">
                                    <a href="#" @click="viewUplaodedResume = true" class="block px-4 py-2 hover:bg-gray-100">👁 View file</a>
                                    <form action="{{ route('upload.resume') }}" method="POST" enctype="multipart/form-data" id="replaceResumeForm" class="hidden">
                                        @csrf
                                        @method('PUT')
                                        <input type="file" name="resume" accept=".pdf" id="replaceResumeInput" onchange="document.getElementById('replaceResumeForm').submit()">
                                    </form>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100"
                                       onclick="event.preventDefault(); document.getElementById('replaceResumeInput').click();">
                                        ⤴ Replace file
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('upload.resume') }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-between flex-1" x-data="{ fileSelected: false }">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center justify-between flex-1">
                                <input type="file" name="resume" accept=".pdf" required class="w-full p-2 rounded-md"
                                    @change="fileSelected = $event.target.files.length > 0">
                                <button type="submit" x-cloak x-show="fileSelected" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Save</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Valid ID (Main) -->
            <div class="mt-6">
                <h3 class="font-semibold text-gray-900 mb-2">Valid ID (Main ID)</h3>
                <div class="flex items-center justify-between border rounded-lg px-4 py-3 bg-gray-50">
                    @if ($user->valid_id != null)
                        <div class="flex items-center justify-between flex-1">
                            <div class="flex items-center">
                                <span class="bg-gray-700 text-white px-2 py-1 rounded text-xs font-bold mr-3">ID</span>
                                <p class="text-sm text-gray-800">{{ basename($user->valid_id) }}</p>
                            </div>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="p-1 rounded hover:bg-gray-200">
                                    ⋮
                                </button>
                                <div x-cloak x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-40 bg-white border rounded-md shadow-lg text-sm">
                                    <a href="#" @click="viewUploadedID = true" class="block px-4 py-2 hover:bg-gray-100">👁 View file</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('upload.valid.id') }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-between flex-1" x-data="{ fileSelected: false }">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center justify-between flex-1">
                                <input type="file" name="valid_id" accept="image/*" required class="w-full p-2 rounded-md" 
                                    @change="fileSelected = $event.target.files.length > 0">
                                <button type="submit" x-cloak x-show="fileSelected" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Save</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Valid ID (Secondary) -->
            <div class="mt-6">
                <h3 class="font-semibold text-gray-900 mb-2">Valid ID (Secondary ID)</h3>
                <div class="flex items-center justify-between border rounded-lg px-4 py-3 bg-gray-50">
                    @if ($user->secondary_valid_id != null)
                        <div class="flex items-center justify-between flex-1">
                            <div class="flex items-center">
                                <span class="bg-gray-700 text-white px-2 py-1 rounded text-xs font-bold mr-3">ID</span>
                                <p class="text-sm text-gray-800">{{ basename($user->secondary_valid_id) }}</p>
                            </div>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="p-1 rounded hover:bg-gray-200">
                                    ⋮
                                </button>
                                <div x-cloak x-show="open" @click.away="open = false"
                                    class="absolute right-0 mt-2 w-40 bg-white border rounded-md shadow-lg text-sm">
                                    <a href="#" @click="viewUploadedSecondaryID = true" class="block px-4 py-2 hover:bg-gray-100">👁 View file</a>
                                    <form action="{{ route('upload.secondary.valid.id') }}" method="POST" enctype="multipart/form-data" id="replaceSecondaryValidIdForm" class="hidden">
                                        @csrf
                                        @method('PUT')
                                        <input type="file" name="secondary_valid_id" accept="image/*,.pdf" id="replaceSecondaryValidIdInput" onchange="document.getElementById('replaceSecondaryValidIdForm').submit()">
                                    </form>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100"
                                       onclick="event.preventDefault(); document.getElementById('replaceSecondaryValidIdInput').click();">
                                        ⤴ Replace file
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <form action="{{ route('upload.secondary.valid.id') }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-between flex-1" x-data="{ fileSelected: false }">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center justify-between flex-1">
                                <input type="file" name="secondary_valid_id" accept="image/*" required class="w-full p-2 rounded-md" 
                                    @change="fileSelected = $event.target.files.length > 0">
                                <button type="submit" x-cloak x-show="fileSelected" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Save</button>
                            </div>
                        </form>
                    @endif
                    
                </div>
            </div>

            <!-- Sign out -->
            <form method="POST" action="{{ route('user.logout') }}" class="mt-8 border-t pt-4 text-center">
                @csrf
                <button type="submit" class="text-blue-700 font-semibold hover:underline">
                    Sign out
                </button>
            </form>
        </div>

        <div x-cloak x-show="isEditing === true && isChangingAccountCredentials === false"
            class="w-2/5 mx-auto bg-white rounded-lg shadow border border-gray-300 p-8">
            <!-- Back Arrow -->
            <div class="mb-4">
                <button @click="isEditing = false" class="flex items-center text-gray-700 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </button>
            </div>

            <!-- Title -->
            <h2 class="text-lg font-semibold mb-6">Contact Information</h2>

            <!-- Form -->
            <form class="space-y-5" action="{{ route('update.account.information') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-3 gap-4">
                    <!-- First Name -->
                    <div>
                        <label class="block text-sm font-medium mb-1">First name</label>
                        <input type="text" name="firstname" placeholder="Firstname" value="{{ $user->firstname }}"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"/>
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Middle name</label>
                        <input type="text" name="middlename" placeholder="Middlename" value="{{ $user->middlename ?? 'N/A' }}"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"/>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Last name</label>
                        <input type="text" name="lastname" placeholder="Lastname" value="{{ $user->lastname }}"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"/>
                    </div>
                </div>


                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="text" name="contact_number" placeholder="Contact Number"
                        value="{{ $user->contact_number }}"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" placeholder="Email" value="{{ $user->email }}"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    <p x-cloak x-show="isChangingAccountCredentials === false" @click="isChangingAccountCredentials = true;"
                        class="mt-2 text-sm text-blue-600 cursor-pointer hover:underline w-fit">Change account password</p>
                </div>

                <!-- Location Section -->
                <div>
                    <h3 class="text-sm font-semibold mb-3">Location</h3>
                    <!-- Country + City -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- House Address -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Street address</label>
                            <input type="text" name="house_number" placeholder= "House No., Street, Subdivision"
                                value="{{ $user->house_number }}"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"/>
                        </div>

                        <!-- Barangay -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Barangay</label>
                            <input type="text" name="barangay" placeholder="Barangay"
                                value="{{ $user->barangay }}"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>

                    </div>

                    <!-- Barangay + City -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">City</label>
                            <input type="text" name="city" placeholder="City" value="{{ $user->city }}"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Province</label>
                            <input type="text" name="province" placeholder="Province"
                                value="{{ $user->province }}"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full rounded-md bg-blue-600 px-4 py-2 text-white font-medium hover:bg-blue-700 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>

        <div x-cloak x-show="isChangingAccountCredentials === true"
            class="w-2/5 mx-auto bg-white rounded-lg shadow border border-gray-300 p-8">
            <!-- Back Arrow -->
            <div class="mb-4">
                <button @click="isChangingAccountCredentials = false"
                    class="flex items-center text-gray-700 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </button>
            </div>

            <!-- Title -->
            <h2 class="text-lg font-semibold mb-6">Change Password</h2>

            <form action="{{ route('update.account.password') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')
                <!-- Current Password -->
                <x-password-toggle>
                    <label class="block text-sm font-medium mb-1">Current Password</label>
                    <input :type="show ? 'text' : 'password'" name="current_password" placeholder="Password"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                </x-password-toggle>

                <!-- New Password -->
                <x-password-toggle>
                    <label class="block text-sm font-medium mb-1">New Password</label>
                    <input :type="show ? 'text' : 'password'" name="password" placeholder="New Password"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                </x-password-toggle>

                <!-- Confirm New Password -->
                <x-password-toggle>
                    <label class="block text-sm font-medium mb-1">Confirm New Password</label>
                    <input :type="show ? 'text' : 'password'" name="password_confirmation" placeholder="Confirm New Password"
                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                </x-password-toggle>

                <!-- Save Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full rounded-md bg-blue-600 px-4 py-2 text-white font-medium hover:bg-blue-700 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- Modal for Uploaded Resume --}}
    <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" 
        x-cloak x-show="viewUplaodedResume"
        @click.away="viewUplaodedResume = false">

        <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden">
            <!-- Close Button -->
            <button 
                class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                @click="viewUplaodedResume = false">
                ✕
            </button>

            <!-- Modal Title -->
            <p class="text-center text-xl font-semibold mb-4">Uploaded Resume</p>

            <!-- PDF Display -->
            <iframe 
                src="{{ asset('storage/' . $user->resume) }}" 
                class="flex-1 w-full rounded-lg border"
                frameborder="0">
            </iframe>
        </div>
    </div>


    {{-- Modal for Uploaded Valid Id --}}
    <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50"
        x-cloak x-show="viewUploadedID" @click.away="viewUploadedID = false">
        <div class="relative bg-white p-4 rounded-lg shadow-lg w-[80%] max-w-[1000px]">
            <!-- Close Button -->
            <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                @click="viewUploadedID = false">
                ✕
            </button>

            <!-- Image Display -->
            <div class="mt-6">
                <p class="text-center text-lg font-semibold mb-4">Uploaded ID</p>
                <img src="{{ asset('storage/' . $user->valid_id) }}" alt="Uploaded ID"
                    class="w-full max-h-[400px] object-contain rounded-lg border" />
            </div>
        </div>
    </div>

    {{-- Modal for Uploaded Secondary Valid Id --}}
    <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50"
        x-cloak x-show="viewUploadedSecondaryID" @click.away="viewUploadedSecondaryID = false">
        <div class="relative bg-white p-4 rounded-lg shadow-lg w-[80%] max-w-[1000px]">
            <!-- Close Button -->
            <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                @click="viewUploadedSecondaryID = false">
                ✕
            </button>

            <!-- Image Display -->
                <div class="mt-6">
                    <p class="text-center text-lg font-semibold mb-4">Uploaded ID</p>
                    <img src="{{ asset('storage/' . $user->secondary_valid_id) }}" alt="Uploaded Secondary ID"
                        class="w-full max-h-[400px] object-contain rounded-lg border" />
                </div>
        </div>
    </div>

    {{-- Action Successful Toast --}}
    <div 
        x-cloak x-show="showSuccessNotificationToast"
        x-transition
        x-init="setTimeout(() => showSuccessNotificationToast = false, 3000)"
        class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        
        {{ session('success') }}
    </div>
    

    @include('user/user-footer')

    @livewireScripts

</body>

</html>
