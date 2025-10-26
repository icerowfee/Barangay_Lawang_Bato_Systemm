<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Applicant Management</title>
</head>

<body class="flex h-screen" x-data="{
    isViewingApplicantDetails: false,
    selectedApplicant: null,

    viewUploadedValidId: false,
    viewUploadedSecondaryValidId: false,
    viewUploadedResume: false,
}">

    @include('company/company-side-panel')

    <div x-cloak x-show="isViewingApplicantDetails == false" class="p-6 min-h-screen flex flex-col flex-1" x-data="{ openJob: null }">
        <h2 class="text-xl font-bold mb-4">Applicants</h2>

        <!-- Job Block -->
        @foreach ($activeJobs as $index => $job)
            <div class="border rounded-lg mb-4">
                <!-- Job Header -->
                <button 
                    @click="openJob === {{ $index }} ? openJob = null : openJob = {{ $index }}"
                    class="w-full flex justify-between items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 rounded-t-lg"
                >
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-900" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        <span class="font-semibold text-blue-900 uppercase">{{ $job->job_title }}</span>
                    </div>
                    <span class="text-sm text-blue-700">{{ $job->applicants->where('status', 'Shortlisted')->count() }} people have applied for this job</span>
                </button>

                <!-- Applicants Table -->
                <div x-show="openJob === {{ $index }}" x-collapse>
                    <div class="p-4">
                        <table class="min-w-full border-collapse rounded">
                            <thead>
                                <tr class="bg-blue-900 text-white text-sm">
                                    <th class="px-4 py-2 text-left">#</th>
                                    <th class="px-4 py-2 text-left">Full Name</th>
                                    <th class="px-4 py-2 text-left">Email</th>
                                    <th class="px-4 py-2 text-left">Contact Number</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Date Applied</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse ($job->applicants->where('status', 'Shortlisted') as $i => $applicant)
                                    <tr class="{{ $i % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td> {{-- 1,2,3... --}}
                                        <td class="px-4 py-2">{{ $applicant->user->lastname}}, {{ $applicant->user->firstname}} {{ $applicant->user->middlename}}</td>
                                        <td class="px-4 py-2">{{ $applicant->user->email}}</td>
                                        <td class="px-4 py-2">{{ $applicant->user->contact_number}}</td>
                                        <td class="px-4 py-2">{{ $applicant->status}}</td>
                                        <td class="px-4 py-2">{{ $applicant->created_at->format('M d Y') }}</td>
                                        <td class="px-4 py-2">
                                            <button 
                                                class="bg-blue-900 text-white px-3 py-1 rounded text-xs"
                                                @click="selectedApplicant = {{ $applicant->toJson() }}; isViewingApplicantDetails = true;"
                                            >
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">No applicants yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div x-cloak x-show="isViewingApplicantDetails" class="p-6 min-h-screen flex flex-col flex-1 relative overflow-hidden">

        <!-- Background image -->
        <div class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
            <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo" class="h-[135vh] w-[135vh] select-none">
        </div>

        <!-- Foreground Content -->
        <div class="relative z-10 h-full flex flex-col">
            <!-- Back Button / Header -->
            <div class="flex items-center justify-between mb-8">
                <button
                    class="flex items-center space-x-2 px-3 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300"
                    @click="isViewingApplicantDetails = false; selectedApplicant = null"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back</span>
                </button>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-3 gap-6 my-auto">
                <!-- Personal Information -->
                <div class="flex flex-col col-span-2 max- rounded-md">
                    <div class="flex-1 border border-gray-400 p-8 shadow-lg rounded-md bg-white">
                        <div class="flex items-center gap-3 my-4">
                            <h3 class="text-xl font-bold text-blue-900 whitespace-nowrap">Personal Information</h3>
                            <hr class="flex-1 border-gray-500 border-t">
                        </div>

                        <!-- Name & Basic Info (Grouped in one row) -->
                        <div class="grid grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-lg font-semibold">First Name</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.user?.firstname || '—'"></span>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold">Middle Name</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.user?.middlename || '—'"></span>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold">Last Name</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.user?.lastname || '—'"></span>
                            </div>
                        </div>

                        <!-- Birthday, Age, Sex, Civil Status (Grouped in one row) -->
                        <div class="grid grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-lg font-semibold">Civil Status</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.user?.civil_status || '—'"></span>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold">Sex</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.user?.sex || '—'"></span>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold">Birthdate</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.user?.birthdate || '—'"></span>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold">Age</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.user?.age || '—'"></span>
                            </div>
                            <div class="col-span-4">
                                <label class="block text-lg font-semibold">Address</label>
                                <template x-if="!selectedApplicant?.user?.house_number && !selectedApplicant?.user?.barangay && !selectedApplicant?.user?.city && !selectedApplicant?.user?.province">
                                    <span class="text-gray-800 text font-normal">—</span>
                                </template>
                                <template x-if="selectedApplicant?.user?.house_number || selectedApplicant?.user?.barangay || selectedApplicant?.user?.city || selectedApplicant?.user?.province">
                                    <span class="text-gray-800 text font-normal"
                                        x-text="(selectedApplicant?.user?.house_number || '') + ', ' + (selectedApplicant?.user?.barangay || '') + ', ' + (selectedApplicant?.user?.city || '') + ', ' + (selectedApplicant?.user?.province || '')"></span>
                                </template>
                            </div>
                        </div>


                        <!-- Contact Info (Grouped in one row) -->
                        <div class="flex items-center gap-3 my-4">
                            <h3 class="text-xl font-bold text-blue-900 whitespace-nowrap">Contact Information</h3>
                            <hr class="flex-1 border-gray-500 border-t">
                        </div>

                        <div class="grid grid-cols-4 gap-4 mb-4">
                            <div>
                                <label class="block text-lg font-semibold">Phone Number</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.user?.contact_number || '—'"></span>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold">Email</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.user?.email || '—'"></span>
                            </div>
                        </div>


                        <!-- Physical & Educational Info (Grouped in one row) -->
                        <div class="flex items-center gap-3 my-4">
                            <h3 class="text-xl font-bold text-blue-900 whitespace-nowrap">Additional Information</h3>
                            <hr class="flex-1 border-gray-500 border-t">
                        </div>

                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-lg font-semibold">Height</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.height ? selectedApplicant.height + ' cm' : 'Not Specified'"></span>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold">Weight</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.weight ? selectedApplicant.weight + ' kg' : 'Not Specified'"></span>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold">Educational Attainment</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.educational_attainment || 'Not Specified'"></span>
                            </div>
                        </div>


                        <!-- Program & Certificate Info (Grouped in one row) -->
                        <div class="flex items-center gap-3 my-4">
                            <h3 class="text-xl font-bold text-blue-900 whitespace-nowrap">Program Details</h3>
                            <hr class="flex-1 border-gray-500 border-t">
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-lg font-semibold">Special Program</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.special_program || 'Not Specified'"></span>
                            </div>
                            <div>
                                <label class="block text-lg font-semibold">Certificate Number</label>
                                <span class="text-gray-800 text font-normal" x-text="selectedApplicant?.certificate_number || 'Not Specified'"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center p-8 space-x-4 mt-8 border border-gray-400 shadow-lg rounded-md bg-white">
                        <form action="{{ route('reject.applicant') }}" method="POST" @submit.prevent="if(confirm('Are you sure you want to reject this applicant?')) $el.submit();">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="applicant_id" :value="selectedApplicant?.id">
                            <button
                                class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                                Reject
                            </button>
                        </form>
                        

                        <form action="{{ route('approve.applicant') }}" method="POST" @submit.prevent="if(confirm('Are you sure you want to accept this applicant?')) $el.submit();">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="applicant_id" :value="selectedApplicant?.id">
                            <button
                                class="bg-green-500 text-white px-12 py-2 rounded-md hover:bg-green-600 transition text-lg h-12 font-semibold">
                                Accept
                            </button>
                        </form>
                        
                    </div>
                </div>

                <!-- Work Requirements -->
                <div class="border border-gray-400 p-8 shadow-lg rounded-md bg-white">
                    <div class="flex items-center gap-3 my-4">
                        <h3 class="text-xl font-bold text-blue-900 whitespace-nowrap">Work Requirements</h3>
                        <hr class="flex-1 border-gray-500 border-t">
                    </div>

                    <div class="flex flex-col space-y-4">
                        <!-- Valid ID -->
                        <div class="flex flex-col space-y-2">
                            <label class="block font-bold text-lg">Valid ID</label>
                            <button class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-6 hover:bg-[#E2E5FA] text-[#034EC5] text-normal font-semibold"
                                @click="viewUploadedValidId = true">View ID</button>
                        </div>

                        <!-- Second Valid ID (Dynamic) -->
                        <template x-if="selectedApplicant.secondary_valid_id">
                            <div class="flex flex-col space-y-2">
                                <label class="block font-bold text-lg">Second Valid ID</label>
                                <button class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-6 hover:bg-[#E2E5FA] text-[#034EC5] text-normal font-semibold"
                                    @click="viewUploadedSecondaryValidId = true">View Second ID</button>
                            </div>
                        </template>
                        
                        <!-- resume -->
                        <div class="flex flex-col space-y-2"> 
                            <label class="block font-bold text-lg">Resume</label>
                            <button class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-6 hover:bg-[#E2E5FA] text-[#034EC5] text-normal font-semibold"
                                @click="viewUploadedResume = true">View resume</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Show Main Valid ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedValidId">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto"
                @click.away="viewUploadedValidId = false">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedValidId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Valid ID</p>

                <!-- Image Display -->
                <template x-if="selectedApplicant.user.valid_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedApplicant.valid_id" alt="Uploaded ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>


        {{-- Show Second Valid ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedSecondaryValidId">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto"
                @click.away="viewUploadedSecondaryValidId = false">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedSecondaryValidId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Second Valid ID</p>

                <!-- Image Display -->
                <template x-if="selectedApplicant.secondary_valid_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedApplicant.secondary_valid_id" alt="Uploaded ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>


        {{-- Show Uploaded resume --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedResume">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden"
                @click.away="viewUploadedResume = false">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                    @click="viewUploadedResume = false">
                    ✕
                </button>

                <!-- Modal Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Resume</p>

                <!-- PDF Display -->
                <template x-if="selectedApplicant.resume">
                    <iframe :src="'/storage/' + selectedApplicant.resume" class="flex-1 w-full rounded-lg border"
                        frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>
    </div>

    @livewireScripts

</body>
</html>