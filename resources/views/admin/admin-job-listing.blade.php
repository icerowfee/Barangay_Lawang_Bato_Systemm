<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Listings</title>
</head>

<body class="flex h-screen bg-gray-100" x-data="{
    openNewJobListingModal: false,
    selectedJobListing: null,

    showApprovedJobListingDetails: false,
    showNewJobListingDetails: false,

    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},
    activeTab: '{{ session('activeTab') ?? '' }}',
    showNewJobListingIndication: {{ $newJobListings->isNotEmpty() ? 'true' : 'false' }},
}">

    <!-- Sidebar -->
    @include('admin/admin-side-panel')

    <!-- Main Content (Placeholder) -->
    <div class="relative h-screen flex-1 p-8 overflow-y-hidden">
        <h1 class="text-3xl font-bold mb-10 ">Manage Job Listings</h1>

        <!-- Tab Content -->
        <div class="p-6 h-[730px] bg-white shadow-lg rounded-lg">
            <div class="flex justify-between mb-4">
                <h2 class="text-xl font-bold">Active Job Listings</h2>
                {{-- Filters --}}
                <div class="flex gap-4 items-center">
                    <!-- Search Input -->
                    <form method="GET" action="admin-job-listing-management" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search job title or company..." class="border p-2 rounded w-64">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
                    </form>

                    <!-- Sort Dropdown -->
                    <form method="GET" action="admin-job-listing-management" class="flex gap-2 items-center">
                        <!-- Keep search term if it exists -->
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <select name="sort_by" onchange="this.form.submit()" class="border p-2 rounded">
                            <option value="">Sort By</option>
                            <option value="job_title" {{ request('sort_by') == 'job_title' ? 'selected' : '' }}>Job
                                Title</option>
                            <option value="company_name" {{ request('sort_by') == 'company_name' ? 'selected' : '' }}>
                                Company</option>
                        </select>

                        <select name="sort_dir" onchange="this.form.submit()" class="border p-2 rounded">
                            <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending
                            </option>
                            <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending
                            </option>
                        </select>
                    </form>
                </div>
                <button @click="openNewJobListingModal = true"
                    class="relative px-4 py-2 bg-blue-600 text-white rounded-md shadow-md">New Listings<span x-cloak
                        x-show="showNewJobListingIndication"
                        class=" absolute top-[-40px] right-[-7px] text-red-600 text-[50px]">•</span></button>
            </div>
            <div class="h-full">
                @if ($approvedJobListings->isEmpty())
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-center mb-32">
                            <div class="flex justify-center h-32">
                                <img src="{{ asset('images/approve-job-icon.png') }}" alt="No Job Listings">
                            </div>
                            <h2 class="text-xl font-semibold text-gray-600 mb-2">No Active Job Listings</h2>
                            <p class="text-gray-500">Once job listings are approved, they’ll show up here. <br> Review
                                pending listings to get jobs posted for applicants.</p>
                        </div>
                    </div>
                @else
                    <div>
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border p-2">#</th>
                                    <th class="border p-2">Job Title</th>
                                    <th class="border p-2">Company Name</th>
                                    <th class="border p-2">Location</th>
                                    <th class="border p-2">Date Posted</th>
                                    <th class="border p-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvedJobListings as $approvedJob)
                                    <tr class="cursor-pointer hover:bg-gray-200 transition text-center"
                                        @click="selectedJobListing = {{ $approvedJob->toJson() }}; showApprovedJobListingDetails = true;">
                                        <input type="hidden" name="id" value="{{ $approvedJob->id }}">
                                        <td class="border p-2">{{ $loop->iteration }}</td>
                                        <td class="border p-2">{{ $approvedJob->job_title }}</td>
                                        <td class="border p-2">{{ $approvedJob->company->company_name }}</td>
                                        <td class="border p-2">{{ $approvedJob->job_location }}</td>
                                        <td class="border p-2">{{ $approvedJob->formatted_date }}</td>
                                        <td class="border p-2">
                                            <span class="px-2 py-1 text-white rounded"
                                                :class="selectedJobListing?.status === 'Active' ? 'bg-green-500' :
                                                    (selectedJobListing?.status === 'Rejected' ? 'bg-red-500' :
                                                        'bg-yellow-500')">
                                                {{ $approvedJob->status ?? 'Pending' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Popup Modal -->
                        <div x-cloak x-show="showApprovedJobListingDetails"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div
                                class="relative bg-white p-8 rounded-lg shadow-lg w-[750px] max-h-[90vh] overflow-y-auto">
                                <!-- Modal Header -->
                                <div class="flex justify-between mb-4 items-center">
                                    <h2 class="text-center text-2xl font-semibold w-full ml-[27px]">Review Job
                                        Listing</h2>
                                    <button class="text-lg font-semibold text-gray-700 hover:text-red-600 w-7 h-7"
                                        @click="selectedJobListing = null; showApprovedJobListingDetails = false">✕</button>
                                </div>

                                <!-- Form Content -->
                                <div class="space-y-6">
                                    <!-- Job Info Section -->
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-700 mb-2">💼 Job Information
                                        </h5>
                                        <div class="space-y-4">
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Company
                                                        Name</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.company.company_name" readonly>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Business
                                                        Type</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.company.business_type" readonly>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Job
                                                        Title</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.job_title" readonly>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Job
                                                        Category</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.job_category" readonly>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="flex flex-col col-span-2">
                                                    <label class="text-sm font-medium text-gray-700">Job
                                                        Description</label>
                                                    <textarea class="border p-3 rounded-lg shadow-sm" :value="selectedJobListing.job_description" readonly rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Salary & Employment Details Section -->
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-700 mb-2">💰 Salary & Employment
                                            Details</h5>
                                        <div class="space-y-4">
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Location</label>
                                                    <input type="text" :value="selectedJobListing.job_location"
                                                        class="border p-3 rounded-lg shadow-sm" readonly>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Employment
                                                        Type</label>
                                                    <input type="text" :value="selectedJobListing.employment_type"
                                                        class="border p-3 rounded-lg shadow-sm" readonly>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Application
                                                        Deadline</label>

                                                    <div class="grid grid-cols-3 gap-6">
                                                        <div class="col-span-2">
                                                            <input type="text"
                                                                :value="new Date(selectedJobListing.application_deadline)
                                                                    .toLocaleDateString(
                                                                        'en-US', {
                                                                            month: 'long',
                                                                            day: 'numeric',
                                                                            year: 'numeric'
                                                                        })"
                                                                class="w-full border p-3 rounded-lg shadow-sm"
                                                                readonly>
                                                        </div>

                                                        <!-- Application Deadline Time -->
                                                        <div class="col-span-1">
                                                            <input type="text"
                                                                :value="new Date(selectedJobListing.application_deadline)
                                                                    .toLocaleTimeString(
                                                                        [], { hour: '2-digit', minute: '2-digit' })"
                                                                class="w-full border p-3 rounded-lg shadow-sm"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Salary Range -->
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Salary
                                                        Range</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="'₱ ' + selectedJobListing.min_salary + ' - ₱ ' +
                                                            selectedJobListing.max_salary"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Requirements Section -->
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-700 mb-2">🎓 Requirements</h5>
                                        <div class="space-y-4">
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Minimum
                                                        Age</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.min_age ?? 'N/A'" readonly>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Maximum
                                                        Age</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.max_age ?? 'N/A'" readonly>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Minimum Height
                                                        (cm)</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.min_height ?? 'N/A'" readonly>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Maximum Height
                                                        (cm)</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.max_height ?? 'N/A'" readonly>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Minimum Weight
                                                        (kg)</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.min_weight ?? 'N/A'" readonly>
                                                </div>
                                                <div class="flex flex-col">
                                                    <label class="text-sm font-medium text-gray-700">Maximum Weight
                                                        (kg)</label>
                                                    <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                        :value="selectedJobListing.max_weight ?? 'N/A'" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-8 flex justify-center gap-6">
                                        <form action="{{ route('approve.job.listing') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" :value="selectedJobListing.id">
                                            <button
                                                class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                                Close Job
                                            </button>
                                        </form>

                                        <form action="{{ route('reject.job.listing') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" :value="selectedJobListing.id">
                                            <button
                                                class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Modal for New Job Listings -->
            <div x-cloak x-show="openNewJobListingModal"
                class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
                <div class="relative bg-white p-6 rounded-lg shadow-md w-3/4 h-3/4 overflow-hidden">
                    <h2 class="text-xl font-bold mb-4">New Job Listings</h2>
                    @if ($newJobListings->isEmpty())
                        <div class="w-full flex items-center justify-center h-[637px]">
                            <div class=" text-center mb-10">
                                <div class="mb-4 flex justify-center h-32">
                                    <img src="{{ asset('images/new-job-icon.png') }}" alt="No Job Listings">
                                </div>
                                <h2 class="text-xl font-semibold text-gray-600 mb-2">No New Job Listings</h2>
                                <p class="text-gray-500">Once new listings are submitted, they’ll show up here. <br>
                                    Review
                                    pending listings to approve new job posts.</p>
                            </div>
                        </div>
                    @else
                        <div>
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border p-2">#</th>
                                        <th class="border p-2">Job Title</th>
                                        <th class="border p-2">Company Name</th>
                                        <th class="border p-2">Location</th>
                                        <th class="border p-2">Date Posted</th>
                                        <th class="border p-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($newJobListings as $newJob)
                                        <tr class="cursor-pointer hover:bg-gray-200 transition text-center"
                                            @click="selectedJobListing = {{ $newJob->toJson() }}; showNewJobListingDetails = true;">
                                            <input type="hidden" name="id" value="{{ $newJob->id }}">
                                            <td class="border p-2">{{ $loop->iteration }}</td>
                                            <td class="border p-2">{{ $newJob->job_title }}</td>
                                            <td class="border p-2">{{ $newJob->company->company_name }}</td>
                                            <td class="border p-2">{{ $newJob->job_location }}</td>
                                            <td class="border p-2">{{ $newJob->formatted_date }}</td>
                                            <td class="border p-2">
                                                <span class="px-2 py-1 text-white rounded"
                                                    :class="selectedJobListing?.status === 'Active' ? 'bg-green-500' :
                                                        (selectedJobListing?.status === 'Rejected' ? 'bg-red-500' :
                                                            'bg-yellow-500')">
                                                    {{ $newJob->status ?? 'Pending' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Popup Modal -->
                            <div x-cloak x-show="showNewJobListingDetails"
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div
                                    class="relative bg-white p-8 rounded-lg shadow-lg w-[750px] max-h-[90vh] overflow-y-auto">
                                    <!-- Modal Header -->
                                    <div class="flex justify-between mb-4 items-center">
                                        <h2 class="text-center text-2xl font-semibold w-full ml-[27px]">Review Job
                                            Listing</h2>
                                        <button class="text-lg font-semibold text-gray-700 hover:text-red-600 w-7 h-7"
                                            @click="selectedJobListing = null; showNewJobListingDetails = false">✕</button>
                                    </div>

                                    <!-- Form Content -->
                                    <div class="space-y-6">
                                        <!-- Job Info Section -->
                                        <div>
                                            <h5 class="text-lg font-semibold text-gray-700 mb-2">💼 Job Information
                                            </h5>
                                            <div class="space-y-4">
                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Company
                                                            Name</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.company.company_name" readonly>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Business
                                                            Type</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.company.business_type" readonly>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Job
                                                            Title</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.job_title" readonly>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Job
                                                            Category</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.job_category" readonly>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="flex flex-col col-span-2">
                                                        <label class="text-sm font-medium text-gray-700">Job
                                                            Description</label>
                                                        <textarea class="border p-3 rounded-lg shadow-sm" :value="selectedJobListing.job_description" readonly
                                                            rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Salary & Employment Details Section -->
                                        <div>
                                            <h5 class="text-lg font-semibold text-gray-700 mb-2">💰 Salary & Employment
                                                Details</h5>
                                            <div class="space-y-4">
                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="flex flex-col">
                                                        <label
                                                            class="text-sm font-medium text-gray-700">Location</label>
                                                        <input type="text" :value="selectedJobListing.job_location"
                                                            class="border p-3 rounded-lg shadow-sm" readonly>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Employment
                                                            Type</label>
                                                        <input type="text"
                                                            :value="selectedJobListing.employment_type"
                                                            class="border p-3 rounded-lg shadow-sm" readonly>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Application
                                                            Deadline</label>

                                                        <div class="grid grid-cols-3 gap-6">
                                                            <div class="col-span-2">
                                                                <input type="text"
                                                                    :value="new Date(selectedJobListing.application_deadline)
                                                                        .toLocaleDateString(
                                                                            'en-US', {
                                                                                month: 'long',
                                                                                day: 'numeric',
                                                                                year: 'numeric'
                                                                            })"
                                                                    class="w-full border p-3 rounded-lg shadow-sm"
                                                                    readonly>
                                                            </div>

                                                            <!-- Application Deadline Time -->
                                                            <div class="col-span-1">
                                                                <input type="text"
                                                                    :value="new Date(selectedJobListing.application_deadline)
                                                                        .toLocaleTimeString(
                                                                            [], { hour: '2-digit', minute: '2-digit' })"
                                                                    class="w-full border p-3 rounded-lg shadow-sm"
                                                                    readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Salary Range -->
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Salary
                                                            Range</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="'₱ ' + selectedJobListing.min_salary + ' - ₱ ' +
                                                                selectedJobListing.max_salary"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Requirements Section -->
                                        <div>
                                            <h5 class="text-lg font-semibold text-gray-700 mb-2">🎓 Requirements</h5>
                                            <div class="space-y-4">
                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Minimum
                                                            Age</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.min_age ?? 'N/A'" readonly>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Maximum
                                                            Age</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.max_age ?? 'N/A'" readonly>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Minimum Height
                                                            (cm)</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.min_height ?? 'N/A'" readonly>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Maximum Height
                                                            (cm)</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.max_height ?? 'N/A'" readonly>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-6">
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Minimum Weight
                                                            (kg)</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.min_weight ?? 'N/A'" readonly>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <label class="text-sm font-medium text-gray-700">Maximum Weight
                                                            (kg)</label>
                                                        <input type="text" class="border p-3 rounded-lg shadow-sm"
                                                            :value="selectedJobListing.max_weight ?? 'N/A'" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="mt-8 flex justify-center gap-6">
                                            <form action="{{ route('approve.job.listing') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id" :value="selectedJobListing.id">
                                                <button
                                                    class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                                    Approve
                                                </button>
                                            </form>

                                            <form action="{{ route('reject.job.listing') }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id" :value="selectedJobListing.id">
                                                <button
                                                    class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Close Button -->
                    <div class="absolute bottom-4 w-[1385px] flex justify-end self-center">
                        <button @click="openNewJobListingModal = false; activeTab = ''"
                            class=" px-4 py-2 bg-red-600 text-white rounded-md">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @livewireScripts
    
    </div>
</body>

</html>
