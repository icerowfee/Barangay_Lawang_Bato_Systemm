<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Referral Management</title>
</head>

<body class="flex h-screen bg-gray-100" x-data="{
    openNewApplicationRequestModal: false,
    selectedRequest: null,

    viewUploadedValidId: false,
    viewUploadedSecondaryValidId: false,
    viewUploadedResume: false,

    viewUploadedSssId: false,
    viewUploadedTinId: false,
    viewUploadedPagibigId: false,
    viewUploadedPoliceClearance: false,
    viewUploadedNbiClearance: false,
    viewUploadedCedula: false,
    viewUploadedBarangayClearance: false,

    showProcessingApplicationData: false,
    showNewApplicationRequestData: false,
    showArchivedApplicationData: false,
    showNewApplicationRequestIndication: {{ $newApplicationRequests->isNotEmpty() ? 'true' : 'false' }},

    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},
    activeTab: '{{ session('activeTab') ?? '' }}'

}">


    @include('admin/admin-side-panel')

    <!-- Main Content (Placeholder) -->
    <div class="relative h-screen flex-1 p-8 overflow-y-hidden">
        <h1 class="text-3xl font-bold mb-10 ">Job Referrals</h1>

        <div class="p-6 h-[730px] bg-white shadow-lg rounded-lg">
            <div class="flex justify-between mb-4  h-[42px]">
                <h2 class="text-xl font-bold">Processing Job Referral</h2>

                {{-- Filters --}}
                <div class="flex gap-4 items-center">
                    <!-- Search Input -->
                    <form method="GET" action="admin-job-referral" class="flex gap-2 mb-0">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search name or email..." class="border p-2 rounded w-64">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
                    </form>

                    <!-- Sort Dropdown -->
                    <form method="GET" action="admin-job-referral" class="flex gap-2 items-center mb-0">
                        <!-- Keep search term if it exists -->
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <select name="sort_by" onchange="this.form.submit()" class="border p-2 rounded">
                            <option value="">Sort By</option>
                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="sex" {{ request('sort_by') == 'sex' ? 'selected' : '' }}>Sex</option>
                            <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                        </select>

                        <select name="sort_dir" onchange="this.form.submit()" class="border p-2 rounded">
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending
                            </option>
                            <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending
                            </option>
                        </select>
                    </form>
                </div>

                <button @click="openNewApplicationRequestModal = true"
                    class="relative px-4 py-2 bg-blue-600 text-white rounded-md shadow-md">New Requests<span x-cloak
                        x-show="showNewApplicationRequestIndication"
                        class=" absolute top-[-40px] right-[-7px] text-red-600 text-[50px]">•</span></button>
            </div>
            <div>
                @if ($approvedApplicationRequests->isEmpty())
                    <div class="w-full h-full flex items-center justify-center">
                        <div class=" text-center mb-32">
                            <!-- Icon / Illustration -->
                            <div class="mb-4 flex justify-center h-32">
                                <!-- You can replace this with an actual SVG or image if needed -->
                                <img src="{{ asset('images/approve-job-referral-request-icon.png') }}" alt="No Admin">
                            </div>

                            <!-- Title -->
                            <h2 class="text-xl font-semibold text-gray-600 mb-2">All Clear on Approved Requests</h2>

                            <!-- Subtitle -->
                            <p class="text-gray-500">You're up to date. Keep an eye on incoming applications and approve
                                them when ready.</p>
                        </div>
                    </div>
                @else
                    <div>
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border p-2">#</th>
                                    <th class="border p-2">Fullname</th>
                                    <th class="border p-2">Address</th>
                                    <th class="border p-2">Age</th>
                                    <th class="border p-2">Sex</th>
                                    <th class="border p-2">Date</th>
                                    <th class="border p-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvedApplicationRequests as $approvedRequest)
                                    <tr class="cursor-pointer hover:bg-gray-200 transition text-center"
                                        @click="selectedRequest = {{ $approvedRequest->load('user')->toJson() }}; showProcessingApplicationData = true;">
                                        <td class="border p-2">{{ $loop->iteration }}</td>
                                        <td class="border p-2">{{ $approvedRequest->user->lastname }},
                                            {{ $approvedRequest->user->firstname }}
                                            {{ $approvedRequest->user->middlename }}</td>
                                        <td class="border p-2">{{ $approvedRequest->user->house_number }},
                                            {{ $approvedRequest->user->barangay }},
                                            {{ $approvedRequest->user->city }}, {{ $approvedRequest->user->province }}
                                        </td>
                                        <td class="border p-2">{{ $approvedRequest->user->age }}</td>
                                        <td class="border p-2">{{ $approvedRequest->user->sex }}</td>
                                        <td class="border p-2">{{ $approvedRequest->created_at }}</td>
                                        <td class="border p-2">
                                            <span
                                                class="px-2 py-1 text-white rounded 
                                                {{ $approvedRequest->status === 'Scheduled'
                                                    ? 'bg-green-500'
                                                    : ($approvedRequest->status === 'Rejected'
                                                        ? 'bg-red-500'
                                                        : ($approvedRequest->status === 'Pending'
                                                            ? 'bg-yellow-500'
                                                            : ($approvedRequest->status === 'Completed'
                                                                ? 'bg-blue-500'
                                                                : 'bg-gray-500'))) }}">
                                                {{ $approvedRequest->status ?? 'Pending' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Popup Modal EDIT THIS FORMAT AND ADD ACCPEXT REJEXT AND CLOSE BTN-->
                        <div x-cloak x-show="showProcessingApplicationData"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div
                                class="relative bg-white p-6 rounded-lg shadow-lg w-[700px] max-h-[90vh] overflow-y-auto">
                                <!-- Modal Header -->
                                <div class="flex justify-between mb-4 items-center">
                                    <h2 class="text-center text-[24px] font-bold w-full ml-[27px]">Review Request</h2>
                                    <button class="text-[18px] font-semibold text-gray-700 hover:text-red-600 w-[27px]"
                                        @click="selectedRequest = null; showProcessingApplicationData = false">✕</button>
                                </div>

                                <!-- Form Content -->
                                <div class="text-[17px] space-y-4">
                                    <!-- ID -->
                                    <div class="flex flex-col">
                                        <input type="hidden" x-model="selectedRequest.id">
                                    </div>

                                    <!-- Name -->
                                    <div class="flex flex-col">
                                        <label><strong>Name</strong></label>
                                        <input type="text" class="border p-2 rounded-lg"
                                            :value="selectedRequest.user.lastname + ', ' + selectedRequest.user.firstname +
                                                ' ' + selectedRequest.user.middlename"
                                            readonly>
                                    </div>

                                    <!-- Address -->
                                    <div class="flex flex-col">
                                        <label><strong>Address</strong></label>
                                        <input type="text" class="border p-2 rounded-lg"
                                            :value="selectedRequest.user.house_number + ', ' + selectedRequest.user.barangay +
                                                ', ' + selectedRequest.user.city + ', ' + selectedRequest.user.province"
                                            readonly>
                                    </div>

                                    <div class="grid grid-cols-4 gap-4">
                                        <!-- Civil Status -->
                                        <div class="flex flex-col">
                                            <label><strong>Civil Status</strong></label>
                                            <input type="text" class="border p-2 rounded-lg"
                                                :value="selectedRequest.user.civil_status" readonly>
                                        </div>

                                        <!-- Sex -->
                                        <div class="flex flex-col">
                                            <label><strong>Sex</strong></label>
                                            <input type="text" class="border p-2 rounded-lg"
                                                :value="selectedRequest.user.sex" readonly>
                                        </div>

                                        <!-- Birthdate -->
                                        <div class="flex flex-col">
                                            <label><strong>Birthdate</strong></label>
                                            <input type="text" class="border p-2 rounded-lg"
                                                :value="selectedRequest.user.birthdate" readonly>
                                        </div>

                                        <!-- Age -->
                                        <div class="flex flex-col">
                                            <label><strong>Age</strong></label>
                                            <input type="text" class="border p-2 rounded-lg"
                                                :value="selectedRequest.user.age" readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <!-- Email -->
                                        <div class="flex flex-col">
                                            <label><strong>Email</strong></label>
                                            <input type="text" class="border p-2 rounded-lg"
                                                :value="selectedRequest.user.email" readonly>
                                        </div>

                                        <!-- Mobile Number -->
                                        <div class="flex flex-col">
                                            <label><strong>Mobile Number</strong></label>
                                            <input type="text" class="border p-2 rounded-lg"
                                                :value="selectedRequest.user.contact_number" readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <!-- Valid ID -->
                                        <div class="flex flex-col">
                                            <label><strong>Valid ID</strong></label>
                                            <button class="w-full border p-2 rounded-lg"
                                                @click="viewUploadedValidId = true">View ID</button>
                                        </div>

                                        <!-- resume -->
                                        <div class="flex flex-col">
                                            <label><strong>Resume</strong></label>
                                            <button class="w-full border p-2 rounded-lg"
                                                @click="viewUploadedResume = true">View resume</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-8 flex justify-center gap-6">
                                    <!-- Delete -->
                                    <form action="{{ route('delete.application.request') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" :value="selectedRequest.id">
                                        <button
                                            class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                    <form x-show="selectedRequest.status != 'Scheduled'"
                                        action="{{ route('schedule.job.referral.request') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" :value="selectedRequest.id">
                                        <button
                                            class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                            Schedule Appointment
                                        </button>
                                    </form>

                                    <form x-show="selectedRequest.status === 'Scheduled'"
                                        action="{{ route('schedule.job.referral.request') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" :value="selectedRequest.id">
                                        <button
                                            class="bg-orange-500 text-white px-6 py-2 rounded-md hover:bg-orange-600 transition">
                                            Remove Appointment
                                        </button>
                                    </form>

                                    <form x-show="selectedRequest.status === 'Scheduled'"
                                        action="{{ route('referred.job.referral.request') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" :value="selectedRequest.id">
                                        <button
                                            class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                            Referred
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Modal (Pop-up inside container, not full-screen) -->
            <div x-cloak x-show="openNewApplicationRequestModal || activeTab === 'new-job-referral-request-tab'"
                class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
                <div class="relative bg-white p-6 rounded-lg shadow-md w-3/4 h-3/4 overflow-hidden">
                    <h2 class="text-xl font-bold mb-4">New Job Referral Requests</h2>
                    @if ($newApplicationRequests->isEmpty())
                        <div class="w-full flex items-center justify-center h-[637px]">
                            <div class=" text-center mb-10">
                                <!-- Icon / Illustration -->
                                <div class="mb-4 flex justify-center h-32">
                                    <!-- You can replace this with an actual SVG or image if needed -->
                                    <img src="{{ asset('images/new-job-referral-request-icon.png') }}"
                                        alt="No Admin">
                                </div>

                                <!-- Title -->
                                <h2 class="text-xl font-semibold text-gray-600 mb-2">No Pending Job Referral Requests
                                </h2>

                                <!-- Subtitle -->
                                <p class="text-gray-500">Looks like there are no new job referral requests. <br>Check
                                    back regularly to process new applications quickly.</p>
                            </div>
                        </div>
                    @else
                        <div>
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border p-2">#</th>
                                        <th class="border p-2">Fullname</th>
                                        <th class="border p-2">Address</th>
                                        <th class="border p-2">Age</th>
                                        <th class="border p-2">Sex</th>
                                        <th class="border p-2">Date</th>
                                        <th class="border p-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($newApplicationRequests as $newRequest)
                                        <tr class="cursor-pointer hover:bg-gray-200 transition text-center"
                                            @click="selectedRequest = {{ $newRequest->load('user', 'jobListing')->toJson() }}; showNewApplicationRequestData = true;">
                                            <td class="border p-2">{{ $loop->iteration }}</td>
                                            <td class="border p-2">{{ $newRequest->user->lastname }},
                                                {{ $newRequest->user->firstname }} {{ $newRequest->user->middlename }}
                                            </td>
                                            <td class="border p-2">{{ $newRequest->user->house_number }},
                                                {{ $newRequest->user->barangay }}, {{ $newRequest->user->city }},
                                                {{ $newRequest->user->province }}</td>
                                            <td class="border p-2">{{ $newRequest->user->age }}</td>
                                            <td class="border p-2">{{ $newRequest->user->sex }}</td>
                                            <td class="border p-2">{{ $newRequest->created_at }}</td>
                                            <td class="border p-2">
                                                <span class="px-2 py-1 text-white rounded"
                                                    :class="selectedRequest?.status === 'Active' ? 'bg-green-500' :
                                                        (selectedRequest?.status === 'Rejected' ? 'bg-red-500' :
                                                            'bg-yellow-500')">
                                                    {{ $newRequest->status ?? 'Pending' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Popup Modal for Reviewing New Applicants -->
                            <div x-cloak x-show="showNewApplicationRequestData"
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center gap-4 z-50">

                                <div class="grid grid-cols-2 min-h-fit w-3/4"
                                    @click.away="!viewUploadedValidId && !viewUploadedResume && !viewUploadedSecondaryValidId && (showNewApplicationRequestData = false, selectedRequest = null)">

                                    {{-- Job Details --}}
                                    <div class="bg-[#F5F3F3] overflow-hidden flex flex-col">

                                        <!-- Header -->
                                        <div class="bg-[#0F5192] text-white px-4 py-3 flex justify-between items-center">
                                            <h2 class="text-2xl font-bold p-2">JOB DETAILS</h2>
                                        </div>

                                        <!-- Body -->
                                        <div class="py-4 px-12 space-y-4 flex-1 overflow-y-auto mb-4">
                                            <!-- Job Information -->
                                            <div class="space-y-4">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="w-full">
                                                        <label class="block text-sm font-semibold">Job Title</label>
                                                        <input type="text" :value="selectedRequest.job_listing?.job_title"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold">Job Category</label>
                                                        <input type="text" :value="selectedRequest.job_listing?.job_category"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-semibold">Job Description</label>
                                                    <textarea :value="selectedRequest.job_listing?.job_description" rows="4"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 pb-4 bg-white text-gray-700" readonly></textarea>
                                                </div>
                                            </div>

                                            <!-- Job Location and Employment Type -->
                                            <div class="space-y-4">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold">Location</label>
                                                        <input type="text" :value="selectedRequest.job_listing?.job_location"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold">Employment Type</label>
                                                        <input type="text" :value="selectedRequest.job_listing?.employment_type"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4">
                                                    <!-- Application Deadline Date -->
                                                    <div>
                                                        <label class="block text-sm font-semibold">Application Deadline</label>
                                                        <div class="grid grid-cols-3 gap-4">
                                                            <div class="col-span-2">
                                                                <input type="text"
                                                                    :value="selectedRequest.job_listing?.application_deadline ? new Date(selectedRequest.job_listing.application_deadline).toLocaleDateString(
                                                                        'en-US', { month: 'long', day: 'numeric', year: 'numeric' }) : ''"
                                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                            </div>
                                                            <!-- Application Deadline Time -->
                                                            <div class="col-span-1">
                                                                <div></div>
                                                                <input type="text"
                                                                    :value="selectedRequest.job_listing?.application_deadline ? new Date(selectedRequest.job_listing.application_deadline).toLocaleTimeString(
                                                                        [], { hour: '2-digit', minute: '2-digit' }) : ''"
                                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Salary Range -->
                                                    <div>
                                                        <label class="block text-sm font-semibold">Salary Range</label>
                                                        <input type="text"
                                                            :value="selectedRequest.job_listing?.min_salary && selectedRequest.job_listing?.max_salary ? '₱' + selectedRequest.job_listing.min_salary + ' - ₱' + selectedRequest.job_listing.max_salary : 'Not Specified'"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Job Requirements (Age, Height, Weight, Educational Attainment, Special Program) -->
                                            <div class="space-y-4">
                                                <div class="grid grid-cols-3 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold">Age Requirement</label>
                                                        <input type="text"
                                                            :value="selectedRequest.job_listing?.min_age && selectedRequest.job_listing?.max_age ? selectedRequest.job_listing.min_age + ' - ' + selectedRequest.job_listing.max_age + ' years' : 'Not Specified'"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold">Height Requirement</label>
                                                        <input type="text"
                                                            :value="selectedRequest.job_listing?.min_height && selectedRequest.job_listing?.max_height ? selectedRequest.job_listing.min_height + ' - ' + selectedRequest.job_listing.max_height + ' cm' : 'Not Specified'"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold">Weight Requirement</label>
                                                        <input type="text"
                                                            :value="selectedRequest.job_listing?.min_weight && selectedRequest.job_listing?.max_weight ? selectedRequest.job_listing.min_weight + ' - ' + selectedRequest.job_listing.max_weight + ' kg' : 'Not Specified'"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold">Educational Attainment</label>
                                                        <input type="text"
                                                            :value="selectedRequest.educational_attainment ? selectedRequest.educational_attainment : 'Not Specified'"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold">Special Program</label>
                                                        <input type="text"
                                                            :value="selectedRequest.job_listing?.special_program ? selectedRequest.job_listing.special_program : 'Not Specified'"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold">Certificate Required</label>
                                                        <input type="text"
                                                            :value="selectedRequest.certificate_number ? 'Yes' : 'No'"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold">Special Program Optional</label>
                                                        <input type="text"
                                                            :value="selectedRequest.job_listing?.is_special_program_optional ? 'Yes' : 'No'"
                                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Applicant Details --}}
                                    <div class="bg-[#FFF8F8] overflow-y-auto">
                                        <!-- Header -->
                                        <div class=" bg-[#0367C9] text-white px-4 py-3 flex justify-between items-center">
                                            <h2 class="text-2xl font-bold p-2">APPLICANT DETAILS</h2>
                                            <button
                                                class="text-[18px] font-semibold text-gray-700 hover:text-red-600 w-[27px]"
                                                @click="selectedRequest = null; showNewApplicationRequestData = false">✕</button>
                                        </div>

                                        <!-- Body -->
                                        <div class="py-4 px-12 space-y-4 flex-1 overflow-y-auto mb-4">

                                            <!-- Name -->
                                            <div class="flex flex-col">
                                                <label class="block text-sm font-semibold">Name</label>
                                                <input type="text"
                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                    :value="selectedRequest.user.lastname + ', ' + selectedRequest.user.firstname +
                                                        ' ' + selectedRequest.user.middlename"
                                                    readonly>
                                            </div>

                                            <!-- Address -->
                                            <div class="flex flex-col">
                                                <label class="block text-sm font-semibold">Address</label>
                                                <input type="text"
                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                    :value="selectedRequest.user.house_number + ', ' + selectedRequest.user
                                                        .barangay + ', ' + selectedRequest.user.city + ', ' +
                                                        selectedRequest.user.province"
                                                    readonly>
                                            </div>

                                            <div class="grid grid-cols-4 gap-4">
                                                <!-- Civil Status -->
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Civil Status</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.user.civil_status" readonly>
                                                </div>

                                                <!-- Sex -->
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Sex</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.user.sex" readonly>
                                                </div>

                                                <!-- Birthdate -->
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Birthdate</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.user.birthdate" readonly>
                                                </div>

                                                <!-- Age -->
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Age</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.user.age" readonly>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <!-- Email -->
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Email</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.user.email" readonly>
                                                </div>

                                                <!-- Mobile Number -->
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Mobile Number</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.user.contact_number" readonly>
                                                </div>
                                            </div>
                                            
                                            <!-- Added User Information Fields -->
                                            <div class="grid grid-cols-3 gap-4 mt-4">
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Height</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.height ? selectedRequest.height + ' cm' : 'Not Specified'" readonly>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Weight</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.weight ? selectedRequest.weight + ' kg' : 'Not Specified'" readonly>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Educational Attainment</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.educational_attainment ? selectedRequest.educational_attainment : 'Not Specified'" readonly>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4 mt-4">
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Special Program</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.special_program ? selectedRequest.special_program : 'Not Specified'" readonly>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Certificate Number</label>
                                                    <input type="text"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        :value="selectedRequest.certificate_number ? selectedRequest.certificate_number : 'Not Specified'" readonly>
                                                </div>
                                            </div>

                                            <div class="flex flex-col space-y-4">
                                                <div class="flex space-x-4 ">
                                                    <!-- Valid ID -->
                                                    <div class="flex flex-col w-1/2 flex-1">
                                                        <label class="block text-sm font-semibold">Valid ID</label>
                                                        <button class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                                            @click="viewUploadedValidId = true">View ID</button>
                                                    </div>

                                                    <!-- Second Valid ID (Dynamic) -->
                                                    <template x-if="selectedRequest.secondary_valid_id">
                                                        <div class="flex flex-col w-1/2">
                                                            <label class="block text-sm font-semibold">Second Valid ID</label>
                                                            <button class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                                                @click="viewUploadedSecondaryValidId = true">View Second ID</button>
                                                        </div>
                                                    </template>
                                                </div>
                                                
                                                <!-- resume -->
                                                <div class="flex flex-col">
                                                    <label class="block text-sm font-semibold">Resume</label>
                                                    <button class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                                        @click="viewUploadedResume = true">View resume</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="bg-white flex justify-center align-middle col-span-2 gap-6 py-6">
                                        <form action="{{ route('reject.application.request') }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" :value="selectedRequest.id">

                                            <button
                                                class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                                                Decline Application
                                            </button>
                                        </form>

                                        <form action="{{ route('approve.application.request') }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" :value="selectedRequest.id">

                                            <button
                                                class="bg-green-500 text-white px-12 py-2 rounded-md hover:bg-green-600 transition text-lg h-12 font-semibold">
                                                Approve and Forward to Employer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">{{ $newApplicationRequests->links() }}</div>
                    @endif


                    <!-- Close Button -->
                    <div class="absolute bottom-4 w-[1385px] flex justify-end self-center">
                        <button @click="openNewApplicationRequestModal = false; activeTab = ''"
                            class=" px-4 py-2 bg-red-600 text-white rounded-md">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="right-10 flex justify-end w-full p-4 z-0" x-data="{ openArchive: false, showArchivedRequests: false }">
            <div class="space-x-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition"
                    @click="openArchive = true">
                    Archives
                </button>
            </div>

            <!-- Archive Modal -->
            <div x-cloak x-show="openArchive || activeTab === 'job-referral-request-archive-tab'"
                class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
                <div class="relative bg-white p-6 rounded-lg shadow-md w-3/4 h-3/4 overflow-hidden">
                    <h2 class="text-xl font-bold mb-4">Archives</h2>
                    @if ($archivedApplicationRequests->isEmpty())
                        <div class="w-full flex items-center justify-center h-[637px]">
                            <div class=" text-center mb-10">
                                <!-- Icon / Illustration -->
                                <div class="mb-4 flex justify-center h-32">
                                    <!-- You can replace this with an actual SVG or image if needed -->
                                    <img src="{{ asset('images/new-document-icon.png') }}" alt="No Admin">
                                </div>

                                <!-- Title -->
                                <h2 class="text-xl font-semibold text-gray-600 mb-2">You're All Caught Up!</h2>

                                <!-- Subtitle -->
                                <p class="text-gray-500">Achives are all clear. Archived requests will be displayed
                                    here.</p>
                            </div>
                        </div>
                    @else
                        <div>
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border p-2">#</th>
                                        <th class="border p-2">Fullname</th>
                                        <th class="border p-2">Address</th>
                                        <th class="border p-2">Age</th>
                                        <th class="border p-2">Sex</th>
                                        <th class="border p-2">Date</th>
                                        <th class="border p-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($archivedApplicationRequests as $archivedRequest)
                                        <tr class="cursor-pointer hover:bg-gray-200 transition text-center"
                                            @click="selectedRequest = {{ $archivedRequest->toJson() }}; showArchivedApplicationData = true;">
                                            <td class="border p-2">{{ $loop->iteration }}</td>
                                            <td class="border p-2">{{ $archivedRequest->user->lastname }},
                                                {{ $archivedRequest->user->firstname }}
                                                {{ $archivedRequest->user->middlename }}</td>
                                            <td class="border p-2">{{ $archivedRequest->user->house_number }},
                                                {{ $archivedRequest->user->barangay }},
                                                {{ $archivedRequest->user->city }},
                                                {{ $archivedRequest->user->province }}</td>
                                            <td class="border p-2">{{ $archivedRequest->user->age }}</td>
                                            <td class="border p-2">{{ $archivedRequest->user->sex }}</td>
                                            <td class="border p-2">{{ $archivedRequest->created_at }}</td>
                                            <td class="border p-2">
                                                <span
                                                    class="px-2 py-1 text-white rounded 
                                                        {{ $archivedRequest->status === 'Active'
                                                            ? 'bg-green-500'
                                                            : ($archivedRequest->status === 'Rejected'
                                                                ? 'bg-red-500'
                                                                : ($archivedRequest->status === 'Pending'
                                                                    ? 'bg-yellow-500'
                                                                    : ($archivedRequest->status === 'Completed'
                                                                        ? 'bg-blue-500'
                                                                        : 'bg-gray-500'))) }}">
                                                    {{ $archivedRequest->status ?? 'Pending' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Popup Modal EDIT THIS FORMAT AND ADD ACCPEXT REJEXT AND CLOSE BTN-->
                            <div x-cloak x-show="showArchivedApplicationData"
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div
                                    class="relative bg-white p-6 rounded-lg shadow-lg w-[700px] max-h-[90vh] overflow-y-auto">
                                    <!-- Modal Header -->
                                    <div class="flex justify-between mb-4 items-center">
                                        <h2 class="text-center text-[24px] font-bold w-full ml-[27px]">Review Request
                                        </h2>
                                        <button
                                            class="text-[18px] font-semibold text-gray-700 hover:text-red-600 w-[27px]"
                                            @click="selectedRequest = null; showArchivedApplicationData = false">✕</button>
                                    </div>

                                    <!-- Form Content -->
                                    <div class="text-[17px] space-y-4">
                                        <!-- ID -->
                                        <div class="flex flex-col">
                                            <input type="hidden" x-model="selectedRequest.id">
                                        </div>

                                        <!-- Name -->
                                        <div class="flex flex-col">
                                            <label><strong>Name</strong></label>
                                            <input type="text" class="border p-2 rounded-lg"
                                                :value="selectedRequest.user.lastname + ', ' + selectedRequest.user.firstname +
                                                    ' ' + selectedRequest.user.middlename"
                                                readonly>
                                        </div>

                                        <!-- Address -->
                                        <div class="flex flex-col">
                                            <label><strong>Address</strong></label>
                                            <input type="text" class="border p-2 rounded-lg"
                                                :value="selectedRequest.user.house_number + ', ' + selectedRequest.user
                                                    .barangay + ', ' + selectedRequest.user.city + ', ' +
                                                    selectedRequest.user.province"
                                                readonly>
                                        </div>

                                        <div class="grid grid-cols-4 gap-4">
                                            <!-- Civil Status -->
                                            <div class="flex flex-col">
                                                <label><strong>Civil Status</strong></label>
                                                <input type="text" class="border p-2 rounded-lg"
                                                    :value="selectedRequest.user.civil_status" readonly>
                                            </div>

                                            <!-- Sex -->
                                            <div class="flex flex-col">
                                                <label><strong>Sex</strong></label>
                                                <input type="text" class="border p-2 rounded-lg"
                                                    :value="selectedRequest.user.sex" readonly>
                                            </div>

                                            <!-- Birthdate -->
                                            <div class="flex flex-col">
                                                <label><strong>Birthdate</strong></label>
                                                <input type="text" class="border p-2 rounded-lg"
                                                    :value="selectedRequest.user.birthdate" readonly>
                                            </div>

                                            <!-- Age -->
                                            <div class="flex flex-col">
                                                <label><strong>Age</strong></label>
                                                <input type="text" class="border p-2 rounded-lg"
                                                    :value="selectedRequest.user.age" readonly>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- Email -->
                                            <div class="flex flex-col">
                                                <label><strong>Email</strong></label>
                                                <input type="text" class="border p-2 rounded-lg"
                                                    :value="selectedRequest.user.email" readonly>
                                            </div>

                                            <!-- Mobile Number -->
                                            <div class="flex flex-col">
                                                <label><strong>Mobile Number</strong></label>
                                                <input type="text" class="border p-2 rounded-lg"
                                                    :value="selectedRequest.user.contact_number" readonly>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- Valid ID -->
                                            <div class="flex flex-col">
                                                <label><strong>Valid ID</strong></label>
                                                <button class="w-full border p-2 rounded-lg"
                                                    @click="viewUploadedValidId = true">View ID</button>
                                            </div>

                                            <!-- resume -->
                                            <div class="flex flex-col">
                                                <label><strong>resume</strong></label>
                                                <button class="w-full border p-2 rounded-lg"
                                                    @click="viewUploadedResume = true">View resume</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-8 flex justify-center gap-6">
                                        <!-- Delete -->
                                        <form action="{{ route('delete.application.request') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" :value="selectedRequest.id">
                                            <input type="hidden" name=activeTab
                                                value="job-referral-request-archive-tab">
                                            <button
                                                class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">{{ $archivedApplicationRequests->links() }}</div>
                    @endif


                    <!-- Close Button -->
                    <div class="absolute bottom-4 w-[1385px] flex justify-end self-center">
                        <button @click="openArchive = false; activeTab = ''"
                            class=" px-4 py-2 bg-red-600 text-white rounded-md">
                            Close
                        </button>
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
                <template x-if="selectedRequest.user.valid_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.valid_id" alt="Uploaded ID"
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
                <template x-if="selectedRequest.secondary_valid_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.secondary_valid_id" alt="Uploaded ID"
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
                <template x-if="selectedRequest.resume">
                    <iframe :src="'/storage/' + selectedRequest.resume" class="flex-1 w-full rounded-lg border"
                        frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>

        {{-- Show Cedula Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedCedula" @click.away="viewUploadedCedula = false">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedCedula = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Cedula</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.cedula">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.cedula" alt="Uploaded Cedula"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Show SSS ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedSssId" @click.away="viewUploadedSssId = false">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedSssId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded SSS ID</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.sss_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.sss_id" alt="Uploaded SSS ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Show TIN ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedTinId" @click.away="viewUploadedTinId = false">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedTinId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded TIN ID</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.tin_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.tin_id" alt="Uploaded TIN ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Show Pag-ibig ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedPagibigId" @click.away="viewUploadedPagibigId = false">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedPagibigId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Pag-ibig ID</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.pagibig_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.pagibig_id" alt="Uploaded Pag-ibig ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Show Uploaded Police Clearance --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedPoliceClearance" @click.away="viewUploadedPoliceClearance = false">

            <div
                class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                    @click="viewUploadedPoliceClearance = false">
                    ✕
                </button>

                <!-- Modal Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Police Clearance</p>

                <!-- PDF Display -->
                <template x-if="selectedRequest.police_clearance">
                    <iframe :src="'/storage/' + selectedRequest.police_clearance"
                        class="flex-1 w-full rounded-lg border" frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>

        {{-- Show Uploaded NBI Clearance --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedNbiClearance" @click.away="viewUploadedNbiClearance = false">

            <div
                class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                    @click="viewUploadedNbiClearance = false">
                    ✕
                </button>

                <!-- Modal Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded NBI Clearance</p>

                <!-- PDF Display -->
                <template x-if="selectedRequest.nbi_clearance">
                    <iframe :src="'/storage/' + selectedRequest.nbi_clearance" class="flex-1 w-full rounded-lg border"
                        frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>

        {{-- Show Uploaded Barangay Clearance --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedBarangayClearance" @click.away="viewUploadedBarangayClearance = false">

            <div
                class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                    @click="viewUploadedBarangayClearance = false">
                    ✕
                </button>

                <!-- Modal Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Barangay Clearance</p>

                <!-- PDF Display -->
                <template x-if="selectedRequest.barangay_clearance">
                    <iframe :src="'/storage/' + selectedRequest.barangay_clearance"
                        class="flex-1 w-full rounded-lg border" frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>

        {{-- Action Successful Toast --}}
        <div x-cloak x-show="showSuccessNotificationToast" x-transition x-cloak x-init="setTimeout(() => showSuccessNotificationToast = false, 3000)"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">

            {{ session('success') }}
        </div>
        @livewireScripts
    </div>
</body>

</html>
