<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Application</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/lawang-bato-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/lawang-bato-logo.png') }}">
</head>

<body class="h-screen" x-data="{
    step: 1,
    firstname: '{{ $user->firstname }}',
    middlename: '{{ $user->middlename }}',
    lastname: '{{ $user->lastname }}',
    contact_number: '{{ $user->contact_number }}',
    email: '{{ $user->email }}',
    house_number: '{{ $user->house_number }}',
    barangay: '{{ $user->barangay }}',
    city: '{{ $user->city }}',
    province: '{{ $user->province }}',
    age: '',
    height: '',
    weight: '',
    educational_attainment: '',
    special_program: '',
    certificate_number: ''
}">

    <!-- Navbar -->
    @include('user/user-header')

    <div class="relative min-h-full max-h-full flex bg-white overflow-hidden">
        <!-- Left Section -->
        <div class="w-1/2 flex flex-col px-60 py-10 my-auto">
            <a href="/user-job-seeking" class="absolute top-12 left-12 mb-6 w-fit text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
            <!-- Progress Bar -->
            <div class="flex items-center justify-center mb-8">
                <div class="flex-1 h-1 bg-gray-200 rounded">
                    <div class="h-1 bg-blue-600 rounded"
                        :style="{
                            width: step === 1 ? '0%' : step === 2 ? '25%' : step === 3 ? '50%' : step === 4 ? '75%' :
                                '100%'
                        }">
                    </div>
                </div>
            </div>

            <!-- Step 1 -->
            <div x-cloak x-show="step === 1" class="h-[50%] flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold mb-4">Add your contact information</h2>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">First name *</label>
                            <input type="text" name="firstname" placeholder="Firstname" x-model="firstname"
                                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Middle name *</label>
                            <input type="text" name="middlename" placeholder="Middle name" x-model="middlename"
                                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Last name *</label>
                            <input type="text" name="lastname" placeholder="Last name" x-model="lastname"
                                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium">Contact Number *</label>
                                <input type="text" name="contact_number" placeholder="Contact Number"
                                    x-model="contact_number"
                                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium">Email *</label>
                                <input type="email" name="email" placeholder="Email" x-model="email"
                                    class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button
                        @click="if(firstname && middlename && lastname && contact_number && email){ step = 2 }"
                        :disabled="!(firstname && middlename && lastname && contact_number && email)"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold col-span-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Continue
                    </button>
                </div>
            </div>

            <!-- Step 2 -->
            <div x-cloak x-show="step === 2" class="h-[50%] flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold mb-4">Review your location details</h2>
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">Street Address *</label>
                            <input type="text" name="house_number" placeholder="House No., Street, Subdivision"
                                x-model="house_number"
                                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Barangay *</label>
                            <input type="text" name="barangay" placeholder="Barangay" x-model="barangay"
                                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">City *</label>
                            <input type="text" name="city" placeholder="City" x-model="city"
                                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Province *</label>
                            <input type="text" name="province" placeholder="Province" x-model="province"
                                class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </form>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button @click="step = 1"
                        class="w-full bg-transparent border-2 border-blue-600 text-blue-600 py-2 rounded-lg hover:bg-gray-100 transition hover:text-blue-600 font-semibold">
                        Back
                    </button>
                    <button
                        @click="if(house_number && barangay && city && province){ step = 3 }"
                        :disabled="!(house_number && barangay && city && province)"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Continue
                    </button>
                </div>
            </div>

            <!-- Step 3 -->
            <div x-cloak x-show="step === 3" class="h-[50%] flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-semibold mb-4">Other requirements</h2>
                    <form class="space-y-4">
                        <!-- Age, Height, Weight Group -->
                        <div class="flex gap-4">
                            @if($jobListing->min_age || $jobListing->max_age)
                                <div class="flex-1">
                                    <label class="block text-sm font-medium">Age *</label>
                                    <input type="number" name="age" placeholder="Age" x-model="age"
                                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                                </div>
                            @endif
                            @if($jobListing->min_height || $jobListing->max_height)
                                <div class="flex-1">
                                    <label class="block text-sm font-medium">Height (cm) *</label>
                                    <input type="number" name="height" placeholder="Height" x-model="height"
                                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                                </div>
                            @endif
                            @if($jobListing->min_weight || $jobListing->max_weight)
                                <div class="flex-1">
                                    <label class="block text-sm font-medium">Weight (kg) *</label>
                                    <input type="number" name="weight" placeholder="Weight" x-model="weight"
                                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                                </div>
                            @endif
                        </div>

                        <!-- Educational Attainment Solo -->
                        @if(!empty($jobListing->educational_attainment))
                            <div>
                                <label class="block text-sm font-medium">Educational Attainment</label>
                                <select name="educational_attainment" x-model="educational_attainment" class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                                    <option value="" disabled selected>Select educational attainment</option>
                                    <option value="Basic Education">Basic Education</option>
                                    <option value="High School Undergraduate">High School Undergraduate
                                    </option>
                                    <option value="High School Graduate">High School Graduate</option>
                                    <option value="College Undergraduate">College Undergraduate
                                    </option>
                                    <option value="College Graduate">College Graduate</option>
                                </select>
                            </div>
                        @endif

                        <!-- Special Program & Certificate Number Group -->
                        <div class="flex gap-4">
                            @if(!empty($jobListing->special_program))
                                <div class="flex-1">
                                    <label class="block text-sm font-medium">
                                        Special Program *
                                        @if(!empty($jobListing->is_special_program_optional))
                                            <span class="text-xs text-gray-500">(Optional)</span>
                                        @endif
                                    </label>
                                    <input type="text" name="special_program" placeholder="Special Program"
                                        x-model="special_program"
                                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                                </div>
                            @endif
                            @if(!empty($jobListing->certificate_number))
                                <div class="flex-1">
                                    <label class="block text-sm font-medium">Certificate Number *</label>
                                    <input type="text" name="certificate_number" placeholder="Certificate Number"
                                        x-model="certificate_number"
                                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-500">
                                </div>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button @click="step = 2"
                        class="w-full bg-transparent border-2 border-blue-600 text-blue-600 py-2 rounded-lg hover:bg-gray-100 transition hover:text-blue-600 font-semibold">
                        Back
                    </button>
                    <button
                        @click="
                            let valid = true;
                            @if($jobListing->min_age || $jobListing->max_age)
                                valid = valid && age;
                            @endif
                            @if($jobListing->min_height || $jobListing->max_height)
                                valid = valid && height;
                            @endif
                            @if($jobListing->min_weight || $jobListing->max_weight)
                                valid = valid && weight;
                            @endif
                            @if(!empty($jobListing->educational_attainment))
                                valid = valid && educational_attainment;
                            @endif
                            @if(!empty($jobListing->special_program))
                                @if(empty($jobListing->is_special_program_optional))
                                    valid = valid && special_program;
                                @endif
                            @endif
                            @if(!empty($jobListing->certificate_number))
                                valid = valid && certificate_number;
                            @endif
                            if(valid){ step = 4 }
                        "
                        :disabled="
                            @if($jobListing->min_age || $jobListing->max_age)
                                !age ||
                            @endif
                            @if($jobListing->min_height || $jobListing->max_height)
                                !height ||
                            @endif
                            @if($jobListing->min_weight || $jobListing->max_weight)
                                !weight ||
                            @endif
                            @if(!empty($jobListing->educational_attainment))
                                !educational_attainment ||
                            @endif
                            @if(!empty($jobListing->special_program))
                                @if(empty($jobListing->is_special_program_optional))
                                    !special_program ||
                                @endif
                            @endif
                            @if(!empty($jobListing->certificate_number))
                                !certificate_number ||
                            @endif
                            false
                        "
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed">
                        Continue
                    </button>
                </div>
            </div>

            <!-- Step 4 -->
            <div x-cloak x-show="step === 4" class="h-full flex flex-col justify-between">
                <div class="h-full flex flex-col justify-center">
                    <div class="">
                        <h2 class="text-lg font-semibold mb-4">Uploaded Resume</h2>
                        <iframe src="{{ asset('storage/' . $user->resume) }}"
                            class="flex-1 w-full h-[60vh] rounded-lg border" frameborder="0">
                        </iframe>
                    </div>
                    
                    <form action="{{ route('upload.resume') }}" method="POST" enctype="multipart/form-data" id="replaceResumeForm" class="hidden">
                        @csrf
                        @method('PUT')
                        <input type="file" name="resume" accept=".pdf" id="replaceResumeInput" onchange="document.getElementById('replaceResumeForm').submit()">
                    </form>

                    <a href="#" class="w-fit self-center text-center underline hover:text-blue-400 my-4"
                        onclick="event.preventDefault(); document.getElementById('replaceResumeInput').click();">
                        Update file
                    </a>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button @click="step = 3"
                        class="w-full bg-transparent border-2 border-blue-600 text-blue-600 py-2 rounded-lg hover:bg-gray-100 transition hover:text-blue-600 font-semibold">
                        Back
                    </button>
                    <button @click="step = 5"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">
                        Continue
                    </button>
                </div>
            </div>

            <!-- Step 5 -->
            <div x-cloak x-show="step === 5" class="h-full flex flex-col justify-between">
                <div class="h-full flex flex-col justify-center">
                    <h2 class="text-lg font-semibold mb-4">Uploaded Valid IDs</h2>
                    <div class="grid gap-8 mt-6">
                        <!-- Primary Valid ID -->
                        <div class="flex flex-col items-center">
                            <p class="text-center text-lg font-semibold mb-2">Primary Valid ID</p>
                            <img src="{{ asset('storage/' . $user->valid_id) }}"
                                alt="Uploaded Primary Valid ID"
                                class="w-fit max-h-[250px] object-contain rounded-lg border mb-2" />
                            <span class="text-xs text-gray-500">Cannot be changed</span>
                        </div>
                        <!-- Secondary Valid ID -->
                        <div class="flex flex-col items-center">
                            <p class="text-center text-lg font-semibold mb-2">Secondary Valid ID</p>
                            @if(!empty($user->secondary_valid_id))
                                <img src="{{ asset('storage/' . $user->secondary_valid_id) }}"
                                    alt="Uploaded Secondary Valid ID"
                                    class="w-fit max-h-[250px] object-contain rounded-lg border mb-2" />
                                <form action="{{ route('upload.secondary.valid.id') }}" method="POST" enctype="multipart/form-data" id="replaceSecondaryValidIdForm" class="hidden">
                                    @csrf
                                    @method('PUT')
                                    <input type="file" name="secondary_valid_id" accept="image/*" id="replaceSecondaryValidIdInput" onchange="document.getElementById('replaceSecondaryValidIdForm').submit()">
                                </form>
                                <a href="#" class="w-fit self-center text-center underline hover:text-blue-400 my-2"
                                    onclick="event.preventDefault(); document.getElementById('replaceSecondaryValidIdInput').click();">
                                    Update file
                                </a>
                            @else
                                <div class="flex flex-col items-center justify-center w-full h-[300px] border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                                    <span class="text-gray-500 mb-2">No secondary valid ID uploaded yet.</span>
                                    <form action="{{ route('upload.secondary.valid.id') }}" method="POST" enctype="multipart/form-data" id="uploadSecondaryValidIdForm" class="hidden">
                                        @csrf
                                        @method('PUT')
                                        <input type="file" name="secondary_valid_id" accept="image/*" id="uploadSecondaryValidIdInput" onchange="document.getElementById('uploadSecondaryValidIdForm').submit()">
                                    </form>
                                    <a href="#" class="w-fit self-center text-center underline hover:text-blue-400"
                                        onclick="event.preventDefault(); document.getElementById('uploadSecondaryValidIdInput').click();">
                                        Upload file
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button @click="step = 4"
                        class="w-full bg-transparent border-2 border-blue-600 text-blue-600 py-2 rounded-lg hover:bg-gray-100 transition hover:text-blue-600 font-semibold">
                        Back
                    </button>
                    <button @click="step = 6"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold">
                        Continue
                    </button>
                </div>
            </div>

            <!-- Step 6 -->
            <form x-cloak x-show="step === 6" method="POST" action="{{ route('submit.job.application', ['jobListing' => $jobListing->id]) }}" enctype="multipart/form-data" class="flex flex-col justify-between align-top">
                @csrf
                <div>
                    <h2 class="text-lg font-semibold mb-6">Review Information</h2>
                        
                    <div class="h-[60vh] space-y-0 overflow-y-scroll">
                        <input type="hidden" name="job_listing_id" value="{{ $jobListing->id }}">
                        <!-- Contact Information -->
                        <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                            <h3 class="text-base font-semibold mb-3 text-blue-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0m8 0a4 4 0 00-8 0m8 0v1a4 4 0 01-8 0V7m8 0V5a4 4 0 00-8 0v2"></path>
                                </svg>
                                Contact Information
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">First name</label>
                                    <input type="text" name="firstname" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="firstname" :value="firstname" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Middle name</label>
                                    <input type="text" name="middlename" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="middlename" :value="middlename" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Last name</label>
                                    <input type="text" name="lastname" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="lastname" :value="lastname" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Contact Number</label>
                                    <input type="text" name="contact_number" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="contact_number" :value="contact_number" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Email</label>
                                    <input type="email" name="email" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="email" :value="email" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                            <h3 class="text-base font-semibold mb-3 text-blue-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22c4.418-6 6-8.418 6-12a6 6 0 00-12 0c0 3.582 1.582 6 6 12z" />
                                </svg>
                                Address Information
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Street Address</label>
                                    <input type="text" name="house_number" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="house_number" :value="house_number" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Barangay</label>
                                    <input type="text" name="barangay" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="barangay" :value="barangay" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">City</label>
                                    <input type="text" name="city" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="city" :value="city" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500">Province</label>
                                    <input type="text" name="province" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="province" :value="province" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Other Requirements (Dynamic) -->
                        <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                            <h3 class="text-base font-semibold mb-3 text-blue-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z" />
                                </svg>
                                Other Requirements
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                @if($jobListing->min_age || $jobListing->max_age)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Age</label>
                                        <input type="number" name="age" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="age" :value="age" readonly>
                                    </div>
                                @endif
                                @if($jobListing->min_height || $jobListing->max_height)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Height (cm)</label>
                                        <input type="number" name="height" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="height" :value="height" readonly>
                                    </div>
                                @endif
                                @if($jobListing->min_weight || $jobListing->max_weight)
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Weight (kg)</label>
                                        <input type="number" name="weight" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="weight" :value="weight" readonly>
                                    </div>
                                @endif
                                @if(!empty($jobListing->educational_attainment))
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Educational Attainment</label>
                                        <input type="text" name="educational_attainment" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="educational_attainment" :value="educational_attainment" readonly>
                                    </div>
                                @endif
                                @if(!empty($jobListing->special_program))
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Special Program</label>
                                        <input type="text" name="special_program" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="special_program" :value="special_program" readonly>
                                    </div>
                                @endif
                                @if(!empty($jobListing->certificate_number))
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500">Certificate Number</label>
                                        <input type="text" name="certificate_number" class="w-full border rounded px-3 py-2 mt-1 bg-white" x-model="certificate_number" :value="certificate_number" readonly>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Valid Id Section -->
                        <div class="bg-gray-50 h-fit rounded-lg p-4 shadow-sm">
                            <h3 class="text-base font-semibold mb-3 text-blue-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Valid IDs
                            </h3>
                            <div class="w-full h-full border rounded px-3 py-2 mt-1 bg-white">
                                <div class="grid gap-4">
                                    <div class="flex flex-col items-center">
                                        <p class="text-center text-lg font-semibold mb-2">Primary Valid ID</p>
                                        <img src="{{ asset('storage/' . $user->valid_id) }}"
                                            alt="Uploaded Primary Valid ID"
                                            class="w-fit max-h-[250px] object-contain rounded border mb-2" />
                                        <span class="text-xs text-gray-500">Cannot be changed</span>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <p class="text-center text-lg font-semibold mb-2">Secondary Valid ID</p>
                                        @if(!empty($user->secondary_valid_id))
                                            <img src="{{ asset('storage/' . $user->secondary_valid_id) }}"
                                                alt="Uploaded Secondary Valid ID"
                                                class="w-fit max-h-[250px] object-contain rounded border mb-2" />
                                        @else
                                            <div class="flex flex-col items-center justify-center w-full h-[250px] border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                                                <span class="text-gray-500">No secondary valid ID uploaded yet.</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Resume Section -->
                        <div class="bg-gray-50 h-fit rounded-lg p-4 shadow-sm">
                            <h3 class="text-base font-semibold mb-3 text-blue-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7v10a2 2 0 002 2h6a2 2 0 002-2V7"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10"></path>
                                </svg>
                                Resume
                            </h3>
                            <div class="w-full h-full border rounded px-3 py-2 mt-1 bg-white">
                                <iframe src="{{ asset('storage/' . $user->resume) }}" class="w-full h-[50vh] rounded border" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-4">
                    <button @click="step = 5"
                        type="button"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold transition">
                        Back
                    </button>
                    <button
                    type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 font-semibold transition">
                        Submit
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Section -->
        <div class="w-1/2 bg-gray-50 flex items-center justify-center px-28 py-10 h-[100vh]">
            <div class="relative px-6 flex-1 bg-white rounded-lg shadow-lg flex flex-col text-black h-full overflow-auto">
                <div class="absolute top-0 h-3 w-full rounded-tl-lg rounded-tr-lg self-center"
                    :class="{
                        'bg-blue-400': '{{ $jobListing->job_category }}' === 'Blue Collar',
                        'bg-gray-200': '{{ $jobListing->job_category }}' === 'White Collar',
                        'bg-pink-400': '{{ $jobListing->job_category }}' === 'Pink Collar',
                        'bg-green-400': '{{ $jobListing->job_category }}' === 'Green Collar',
                        'bg-gray-500': '{{ $jobListing->job_category }}' === 'Gray Collar',
                        'bg-yellow-400': '{{ $jobListing->job_category }}' === 'Gold Collar',
                        'bg-red-400': '{{ $jobListing->job_category }}' === 'Red Collar',
                        'bg-black': '{{ $jobListing->job_category }}' === 'Other'
                    }">
                </div>
                <div class="sticky top-3 bg-white p-4 border-b border-gray-200">
                    <h2 class="text-3xl font-bold mb-4">{{ $jobListing->job_title }}</h2>
                    <div class="flex justify-between">
                        <div>
                            <div class="flex items-center">
                                <img class="h-5" src="{{ asset('images/company-icon.png') }}" alt="Company Icon">
                                <p class="ml-2 text-lg font-semibold">{{ $jobListing->company->company_name }}</p>
                            </div>
                            <div class="flex items-center">
                                <img class="h-5" src="{{ asset('images/location-icon.png') }}"
                                    alt="Location Icon">
                                <p class="ml-2 text-lg">{{ $jobListing->job_location }}</p>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Body Sections -->
                <div class="p-6 space-y-8 text-gray-800 text-sm leading-relaxed">

                    <!-- Job Details -->
                    <section>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Job details</h3>
                        <div class="flex flex-wrap items-center gap-2">

                            <!-- Job Category -->
                            @if($jobListing->job_category)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500"
                                        viewBox="0 0 20 20"
                                        :fill="{
                                            'Blue Collar': '#60A5FA',      // blue-400
                                            'White Collar': '#FFFFFF',     // gray-200
                                            'Pink Collar': '#F472B6',      // pink-400
                                            'Green Collar': '#34D399',     // green-400
                                            'Gray Collar': '#6B7280',      // gray-500
                                            'Gold Collar': '#FBBF24',      // yellow-400
                                            'Red Collar': '#F87171',       // red-400
                                            'Other': '#000000'             // black
                                        }['{{ $jobListing->job_category }}'] || '#000000'">
                                        <circle cx="10" cy="10" r="8" />
                                    </svg>
                                    <span>
                                        {{
                                            [
                                                'Blue Collar' => 'Manual/Skilled Labor',
                                                'White Collar' => 'Office/Professional',
                                                'Pink Collar' => 'Service/Care Work',
                                                'Green Collar' => 'Environmental/Sustainability',
                                                'Gray Collar' => 'Tech/Specialized',
                                                'Gold Collar' => 'Highly Skilled/High Demand',
                                                'Red Collar' => 'Government/Military',
                                                'Other' => 'Other'
                                            ][$jobListing->job_category] ?? $jobListing->job_category
                                        }}
                                    </span>
                                </span>
                            @endif
                            
                            <!-- Employment Type -->
                            @if($jobListing->employment_type)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 2a1 1 0 00-1 1v14l7-7-7-7z" />
                                    </svg>
                                    <span>{{ $jobListing->employment_type }}</span>
                                </span>
                            @endif

                            <!-- Salary Range -->
                            @if($jobListing->min_salary || $jobListing->max_salary)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 12H9v-2h2v2zm0-4H9V6h2v4z" />
                                    </svg>
                                    @if($jobListing->min_salary)
                                        <span>₱{{ number_format($jobListing->min_salary) }}</span>
                                    @endif
                                    @if($jobListing->min_salary && $jobListing->max_salary)
                                        <span>-</span>
                                    @endif
                                    @if($jobListing->max_salary)
                                        <span>₱{{ number_format($jobListing->max_salary) }}</span>
                                    @endif
                                </span>
                            @endif

                            <!-- Age Requirement -->
                            @if($jobListing->min_age || $jobListing->max_age)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 12H9v-2h2v2zm0-4H9V6h2v4z" />
                                    </svg>
                                    @if($jobListing->min_age)
                                        <span>{{ $jobListing->min_age }}</span>
                                    @endif
                                    @if($jobListing->min_age && $jobListing->max_age)
                                        <span>-</span>
                                    @endif
                                    @if($jobListing->max_age)
                                        <span>{{ $jobListing->max_age }}</span>
                                    @endif
                                    <span>years old</span>
                                </span>
                            @endif

                            <!-- Height Requirement -->
                            @if($jobListing->min_height || $jobListing->max_height)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <rect x="4" y="8" width="12" height="4" />
                                    </svg>
                                    @if($jobListing->min_height)
                                        <span>{{ $jobListing->min_height }}cm</span>
                                    @endif
                                    @if($jobListing->min_height && $jobListing->max_height)
                                        <span>-</span>
                                    @endif
                                    @if($jobListing->max_height)
                                        <span>{{ $jobListing->max_height }}cm</span>
                                    @endif
                                </span>
                            @endif

                            <!-- Weight Requirement -->
                            @if($jobListing->min_weight || $jobListing->max_weight)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <ellipse cx="10" cy="10" rx="8" ry="5" />
                                    </svg>
                                    @if($jobListing->min_weight)
                                        <span>{{ $jobListing->min_weight }}kg</span>
                                    @endif
                                    @if($jobListing->min_weight && $jobListing->max_weight)
                                        <span>-</span>
                                    @endif
                                    @if($jobListing->max_weight)
                                        <span>{{ $jobListing->max_weight }}kg</span>
                                    @endif
                                </span>
                            @endif

                            <!-- Educational Attainment -->
                            @if($jobListing->educational_attainment)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2L2 7l8 5 8-5-8-5zm0 13a7 7 0 01-7-7h2a5 5 0 0010 0h2a7 7 0 01-7 7z" />
                                    </svg>
                                    <span>{{ $jobListing->educational_attainment }}</span>
                                </span>
                            @endif

                            <!-- Special Program -->
                            @if($jobListing->special_program)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M4 4h12v12H4z" />
                                    </svg>
                                    <span>{{ $jobListing->special_program }}</span>
                                    @if(!empty($jobListing->is_special_program_optional))
                                        <span class="ml-1 text-xs text-gray-500">(Optional)</span>
                                    @endif
                                </span>
                            @endif

                            <!-- Certificate Number -->
                            @if($jobListing->certificate_number)
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 6.293a1 1 0 00-1.414 0L9 12.586 6.707 10.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l7-7a1 1 0 000-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Certificate</span>
                                </span>
                            @endif

                        </div>
                    </section>



                    <!-- Location -->
                    <section>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Location</h3>
                        <div class="flex items-center text-gray-700">
                            <img class="h-4 m-1" src="{{ asset('images/location-icon.png') }}">
                            <p class="text-base">{{ $jobListing->job_location }}</p>
                        </div>
                    </section>

                    <!-- Full Job Description -->
                    <section>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Full job description
                        </h3>
                        <p class="whitespace-pre-line text-base">{{ $jobListing->job_description }}</p>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    @include('user/user-footer')

    <x-privacy-policy-modal />

    @livewireScripts
    
</body>

</html>
