<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Management</title>
</head>

<body class="flex h-screen bg-gray-100" x-data="{
    activeTab: 'active',
    jobInfo: true,
    personalInfo: false,
    requirements: false,
    openNewJobModal: false,
    selectedJob: null,

    showJobDetailsModal: false,

    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},
    showErrorNotificationToast: {{ session('error') ? 'true' : 'false'}},
}">

    @include('company/company-side-panel')

    <div class="p-6 min-h-screen flex flex-col flex-1">
        <!-- Title -->
        <h2 class="text-xl font-bold mb-4">JOB MANAGEMENT</h2>

        <!-- Tabs -->
        <div class="flex justify-between items-center mb-4">
            <div class="space-x-2">
                <button @click="activeTab = 'pending'"
                    :class="activeTab === 'pending' ? 'bg-blue-900 text-white' : 'bg-gray-300 text-gray-700'"
                    class="px-4 py-2 rounded">
                    Pending
                </button>
                <button @click="activeTab = 'active'"
                    :class="activeTab === 'active' ? 'bg-blue-900 text-white' : 'bg-gray-300 text-gray-700'"
                    class="px-4 py-2 rounded">
                    Active
                </button>
                <button @click="activeTab = 'closed'"
                    :class="activeTab === 'closed' ? 'bg-blue-900 text-white' : 'bg-gray-300 text-gray-700'"
                    class="px-4 py-2 rounded">
                    Closed
                </button>
            </div>


            <div class="ml-auto flex items-center space-x-2">
                <!-- Search -->
                <input type="text" placeholder="Search..."
                    class="border rounded px-3 py-1 text-sm focus:ring-blue-500 focus:border-blue-500">
                <!-- Add Job Button -->
                <button @click="openNewJobModal = true" class="bg-blue-900 text-white px-4 py-1 rounded">Add
                    Job</button>
            </div>
        </div>

        <!-- Pending Jobs Table -->
        <div x-cloak x-show="activeTab === 'pending'" class="overflow-hidden border rounded flex-1">
            @if ($jobListings->where('status', 'Pending')->isEmpty())
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-center mb-10">
                        <div class="mb-4 flex justify-center h-32">
                            <img src="{{ asset('images/approve-document-icon.png') }}" alt="No Admin">
                        </div>
                        <h2 class="text-xl font-semibold text-gray-600 mb-2">Pending Jobs Will Appear Here.</h2>
                        <p class="text-gray-500">No pending job listings available at the moment.</p>
                    </div>
                </div>
            @else
                <table class="min-w-full border-collapse text-lg">
                    <thead>
                        <tr class="bg-blue-900 text-white text-center">
                            <th class="px-6 py-3">Job ID</th>
                            <th class="px-6 py-3">Date Submitted</th>
                            <th class="px-6 py-3">Job Title</th>
                            <th class="px-6 py-3">Job Type</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($jobListings as $jobListing)
                            @if ($jobListing->status === 'Pending')
                                <tr class="odd:bg-blue-50 even:bg-white text-center">
                                    <td class="px-6 py-4">{{ $jobListing->job_id }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->created_at->format('M d Y') }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->job_title }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->employment_type }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->status }}</td>
                                    <td class="px-6 py-4">
                                        <button
                                            class="bg-blue-700 text-white px-4 py-2 rounded text-xs font-bold hover:bg-blue-900"
                                            @click="selectedJob = {{ $jobListing->toJson() }}; showJobDetailsModal = true">
                                            Review
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Active Jobs Table -->
        <div x-cloak x-show="activeTab === 'active'" class="overflow-hidden border rounded flex-1">
            @if ($jobListings->where('status', 'Active')->isEmpty())
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-center mb-10">
                        <div class="mb-4 flex justify-center h-32">
                            <img src="{{ asset('images/customer-service-icon.png') }}" alt="No Active Jobs">
                        </div>
                        <h2 class="text-xl font-semibold text-gray-600 mb-2">No Active Jobs Right Now</h2>
                        <p class="text-gray-500">Your active job listings will appear here once they’re approved. Post a
                            new one!</p>
                    </div>
                </div>
            @else
                <table class="min-w-full border-collapse text-lg">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="px-6 py-3">Job ID</th>
                            <th class="px-6 py-3">Date Started</th>
                            <th class="px-6 py-3">Job Title</th>
                            <th class="px-6 py-3">Job Type</th>
                            <th class="px-6 py-3">No. of Applicants</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($jobListings as $jobListing)
                            @if ($jobListing->status === 'Active')
                                <tr class="odd:bg-blue-50 even:bg-white text-center">
                                    <td class="px-6 py-4">{{ $jobListing->job_id }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->created_at->format('M d Y') }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->job_title }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->employment_type }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->applicants->where('status', 'Shortlisted')->count() }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->status }}</td>
                                    <td class="px-6 py-4">
                                        <button
                                            class="bg-blue-700 text-white px-4 py-2 rounded text-xs font-bold hover:bg-blue-900"
                                            @click="selectedJob = {{ $jobListing->toJson() }}; showJobDetailsModal = true">
                                            Review
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Closed Jobs Table -->
        <div x-cloak x-show="activeTab === 'closed'" class="overflow-hidden border rounded flex-1">
            @if ($jobListings->where('status', 'Closed')->isEmpty())
                <div class="w-full h-full flex items-center justify-center">
                    <div class="text-center mb-10">
                        <div class="mb-4 flex justify-center h-32">
                            <img src="{{ asset('images/new-document-icon.png') }}" alt="No Admin">
                        </div>
                        <h2 class="text-xl font-semibold text-gray-600 mb-2">Jobs Will Be Moved Here When Closed</h2>
                        <p class="text-gray-500">No jobs are closed yet. After completion, jobs will appear in this
                            section.</p>
                    </div>
                </div>
            @else
                <table class="min-w-full border-collapse text-lg">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="px-6 py-3">Job ID</th>
                            <th class="px-6 py-3">Date Closed</th>
                            <th class="px-6 py-3">Job Title</th>
                            <th class="px-6 py-3">Job Type</th>
                            <th class="px-6 py-3">No. of Applicants</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($jobListings as $jobListing)
                            @if ($jobListing->status === 'Closed')
                                <tr class="odd:bg-blue-50 even:bg-white text-center">
                                    <td class="px-6 py-4">{{ $jobListing->job_id }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->created_at->format('M d Y') }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->job_title }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->employment_type }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->applicants->count() }}</td>
                                    <td class="px-6 py-4">{{ $jobListing->status }}</td>
                                    <td class="px-6 py-4">
                                        <button
                                            class="bg-blue-700 text-white px-4 py-2 rounded text-xs font-bold hover:bg-blue-900"
                                            @click="selectedJob = {{ $jobListing->toJson() }}; showJobDetailsModal = true">
                                            Review
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>





        <!-- Add New Job Modal -->
        <div x-cloak>
            <!-- Overlay -->
            <div x-show="openNewJobModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <form action="{{ route('post.job.listing') }}" method="POST"
                    class="bg-white w-3/4 max-w-3xl h-5/6 rounded shadow-lg overflow-hidden flex flex-col"
                    @click.away="openNewJobModal = false">
                    @csrf
                    <!-- Header -->
                    <div class="bg-blue-900 text-white px-4 py-3 flex justify-between items-center">
                        <h2 class="text-lg font-bold">NEW JOB LISTING</h2>
                        <button type="button" @click="openNewJobModal = false"
                            class="text-white text-2xl">&times;</button>
                    </div>

                    <!-- Body -->
                    <div class="p-4 space-y-3 flex-1 overflow-y-auto">

                        <!-- Job Information -->
                        <div class="border rounded">
                            <button type="button" @click="jobInfo = !jobInfo"
                                class="w-full flex justify-between items-center px-4 py-2 bg-gray-100 font-semibold">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 6h16M2 10h16M2 14h16" />
                                    </svg>
                                    <span>JOB INFORMATION</span>
                                </span>
                                <span x-text="jobInfo ? '▲' : '▼'"></span>
                            </button>
                            <div x-show="jobInfo" class="p-4 space-y-4">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm">Job Title</label>
                                        <input type="text" name="job_title"
                                            class="w-full border rounded px-2 py-1">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold">Job Category (Collar Type)</label>
                                        <select name="job_category" class="w-full border rounded px-2 py-1" required>
                                            <option value="">-- Select Collar Category --</option>
                                            <option value="Blue Collar">Blue Collar (Manual/Skilled Labor)</option>
                                            <option value="White Collar">White Collar (Office/Professional)</option>
                                            <option value="Pink Collar">Pink Collar (Service/Care Work)</option>
                                            <option value="Green Collar">Green Collar (Environmental/Sustainability)
                                            </option>
                                            <option value="Gray Collar">Gray Collar (Tech/Specialized)</option>
                                            <option value="Gold Collar">Gold Collar (Highly Skilled/High Demand)
                                            </option>
                                            <option value="Red Collar">Red Collar (Government/Military)</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm">Job Description</label>
                                    <textarea rows="3" name="job_description" class="w-full border rounded px-2 py-1"></textarea>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm">Location</label>
                                        <input type="text" name="job_location"
                                            class="w-full border rounded px-2 py-1">
                                    </div>
                                    <div>
                                        <label class="block text-sm">Employment Type</label>
                                        <select name="employment_type" class="w-full border rounded px-2 py-1">
                                            <option value="Full-time">Full-time</option>
                                            <option value="Part-time">Part-time</option>
                                            <option value="Contractual">Contractual</option>
                                            <option value="Project-based">Project-based</option>
                                            <option value="Internship">Internship</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm">Application Deadline (Date)</label>
                                        <input type="date" name="application_deadline_date"
                                            class="w-full border rounded px-2 py-1">
                                    </div>
                                    <div>
                                        <label class="block text-sm">Application Deadline (Time)</label>
                                        <input type="time" value="23:59" name="application_deadline_time"
                                            class="w-full border rounded px-2 py-1">
                                    </div>
                                </div>

                                <div x-data="{ hasSalary: false }" class="space-y-2">
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" x-model="hasSalary" class="rounded">
                                        <span class="text-sm">Include Salary Range</span>
                                    </label>

                                    <div x-show="hasSalary" class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-sm">Minimum Salary</label>
                                            <input type="number" name="min_salary"
                                                class="w-full border rounded px-2 py-1" x-bind:disabled="!hasSalary">
                                        </div>
                                        <div>
                                            <label class="block text-sm">Maximum Salary</label>
                                            <input type="number" name="max_salary"
                                                class="w-full border rounded px-2 py-1" x-bind:disabled="!hasSalary">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Job Requirements -->
                        <div class="border rounded">
                            <button type="button" @click="requirements = !requirements"
                                class="w-full flex justify-between items-center px-4 py-2 bg-gray-100 font-semibold">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 3h12v2H4V3zm0 4h12v2H4V7zm0 4h12v2H4v-2zm0 4h12v2H4v-2z" />
                                    </svg>
                                    <span>JOB REQUIREMENTS</span>
                                </span>
                                <span x-text="requirements ? '▲' : '▼'"></span>
                            </button>
                            <div x-show="requirements" class="p-4 space-y-4">
                                <!-- Toggle + Input pairs -->
                                <template
                                    x-for="req in [
                                        { key: 'age', label: 'Age', min: 'min_age', max: 'max_age' },
                                        { key: 'height', label: 'Height (cm)', min: 'min_height', max: 'max_height' },
                                        { key: 'weight', label: 'Weight (kg)', min: 'min_weight', max: 'max_weight' },
                                        { key: 'educational_attainment', label: 'Educational Attainment', type: 'dropdown' },
                                        { key: 'special_program', label: 'Special Program', type: 'input' }
                                    ]"
                                    :key="req.key">
                                    <div class="border p-3 rounded space-y-2">
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" :id="req.key + '_toggle'" x-model="req.active">
                                            <span class="text-sm font-semibold"
                                                x-text="req.label + ' Requirement'"></span>
                                        </label>

                                        <div class="gap-3" x-show="req.active">
                                            <!-- Minimum and Maximum for other requirements -->
                                            <div class="grid grid-cols-2 gap-4"
                                                x-show="req.type !== 'dropdown' && req.type !== 'input'">
                                                <div>
                                                    <label class="block text-sm">Minimum</label>
                                                    <input type="number" :name="req.min"
                                                        class="w-full border rounded px-2 py-1">
                                                </div>
                                                <div>
                                                    <label class="block text-sm">Maximum</label>
                                                    <input type="number" :name="req.max"
                                                        class="w-full border rounded px-2 py-1">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="grid grid-cols-2 gap-3" x-show="req.active">


                                            <!-- Conditional Fields Based on Type -->
                                            <div x-show="req.type === 'dropdown'" class="w-full">
                                                <label class="block text-sm">Select Educational Attainment</label>
                                                <select name="educational_attainment"
                                                    class="w-full border rounded px-2 py-1">
                                                    <option value="" disabled selected>Select educational
                                                        attainment</option>
                                                    <option value="Basic Education">Basic Education</option>
                                                    <option value="High School Undergraduate">High School Undergraduate</option>
                                                    <option value="High School Graduate">High School Graduate</option>
                                                    <option value="College Undergraduate">College Undergraduate
                                                    </option>
                                                    <option value="College Graduate">College Graduate</option>
                                                </select>
                                            </div>

                                            <div x-show="req.type === 'input'" class="w-full space-y-4">
                                                <div>
                                                    <label class="block text-sm">Special Program</label>
                                                    <input type="text" :name="req.key"
                                                        class="w-full border rounded px-2 py-1"
                                                        placeholder="Enter special program details">
                                                </div>

                                                <!-- Is Special Program Optional? -->
                                                <div class="border p-3 rounded space-y-2">
                                                    <label class="flex items-center space-x-2">
                                                        <input type="checkbox" name="is_special_program_optional">
                                                        <span class="text-sm font-semibold">Is Special Program
                                                            Optional?</span>
                                                    </label>
                                                </div>

                                                <!-- Certificate Number Requirement -->
                                                <div class="border p-3 rounded space-y-2">
                                                    <label class="flex items-center space-x-2">
                                                        <input type="checkbox" name="certificate_number">
                                                        <span class="text-sm font-semibold">Require Certificate
                                                            Number</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>




                    <!-- Footer -->
                    <div class="flex justify-center space-x-4 px-4 py-3 bg-gray-100 border-t">
                        <button type="button" @click="openNewJobModal = false"
                            class="px-4 py-2 rounded bg-gray-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-900 text-white">Save Job</button>
                    </div>
                </form>
            </div>
        </div>





        <!-- Job Details Modal -->
        <div x-cloak>
            <!-- Overlay -->
            <div x-show="showJobDetailsModal"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white w-3/4 max-w-3xl h-fit rounded shadow-lg overflow-hidden flex flex-col p-4"
                    @click.away="showJobDetailsModal = false">

                    <!-- Header -->
                    <div class="bg-blue-900 text-white px-4 py-3 flex justify-between items-center">
                        <h2 class="text-lg font-bold">JOB DETAILS</h2>
                        <button type="button" @click="showJobDetailsModal = false"
                            class="text-white text-2xl">&times;</button>
                    </div>

                    <!-- Body -->
                    <div class="p-4 space-y-6 flex-1 overflow-y-auto mb-4">

                        <!-- Job Information -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="w-full">
                                    <label class="block text-sm font-semibold">Job Title</label>
                                    <input type="text" x-bind:value="selectedJob.job_title"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold">Job Category</label>
                                    <input type="text" x-bind:value="selectedJob.job_category"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                            </div>


                            <div class="space-y-2">
                                <label class="block text-sm font-semibold">Job Description</label>
                                <textarea x-bind:value="selectedJob.job_description" rows="6"
                                    class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly></textarea>
                            </div>
                        </div>

                        <!-- Job Location and Employment Type -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold">Location</label>
                                    <input type="text" x-bind:value="selectedJob.job_location"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold">Employment Type</label>
                                    <input type="text" x-bind:value="selectedJob.employment_type"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Application Deadline Date -->
                                <div>
                                    <label class="block text-sm font-semibold">Application Deadline</label>

                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="col-span-2">
                                            <input type="text"
                                                x-bind:value="new Date(selectedJob.application_deadline).toLocaleDateString(
                                                    'en-US', { month: 'long', day: 'numeric', year: 'numeric' })"
                                                class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700"
                                                readonly>
                                        </div>

                                        <!-- Application Deadline Time -->
                                        <div class="col-span-1">
                                            <div></div>
                                            <input type="text"
                                                x-bind:value="new Date(selectedJob.application_deadline).toLocaleTimeString(
                                                    [], { hour: '2-digit', minute: '2-digit' })"
                                                class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Salary Range -->
                                <div>
                                    <label class="block text-sm font-semibold">Salary Range</label>
                                    <input type="text"
                                        x-bind:value="selectedJob.min_salary && selectedJob.max_salary ? '₱' + selectedJob
                                            .min_salary + ' - ₱' + selectedJob.max_salary : 'Not Specified'"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Job Requirements (Age, Height, Weight, Educational Attainment, Special Program) -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold">Age Requirement</label>
                                    <input type="text"
                                        x-bind:value="selectedJob.min_age && selectedJob.max_age ? selectedJob.min_age + ' - ' +
                                            selectedJob.max_age + ' years' : 'Not Specified'"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold">Height Requirement</label>
                                    <input type="text"
                                        x-bind:value="selectedJob.min_height && selectedJob.max_height ? selectedJob.min_height +
                                            ' - ' + selectedJob.max_height + ' cm' : 'Not Specified'"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold">Weight Requirement</label>
                                    <input type="text"
                                        x-bind:value="selectedJob.min_weight && selectedJob.max_weight ? selectedJob.min_weight +
                                            ' - ' + selectedJob.max_weight + ' kg' : 'Not Specified'"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold">Educational Attainment</label>
                                    <input type="text"
                                        x-bind:value="selectedJob.educational_attainment ? selectedJob.educational_attainment :
                                            'Not Specified'"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold">Special Program</label>
                                    <input type="text"
                                        x-bind:value="selectedJob.special_program ? selectedJob.special_program : 'Not Specified'"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold">Certificate Required</label>
                                    <input type="text" x-bind:value="selectedJob.certificate_number ? 'Yes' : 'No'"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold">Special Program Optional</label>
                                    <input type="text"
                                        x-bind:value="selectedJob.is_special_program_optional ? 'Yes' : 'No'"
                                        class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-700" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-center space-x-4 px-4 py-3">
                        <!-- Active Jobs: Close and Delete Buttons -->
                        <template x-if="selectedJob.status === 'Active'">
                            <div class="space-x-4">
                                <form action="{{ route('delete.job.listing') }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="job_id" x-bind:value="selectedJob.job_id">
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                                </form>

                                <form action="{{ route('close.job.listing') }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="job_id" x-bind:value="selectedJob.job_id">
                                    <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded">Close
                                        Job</button>
                                </form>
                            </div>
                        </template>

                        <!-- Pending and Closed Jobs: Delete Button Only -->
                        <template x-if="selectedJob.status !== 'Active'">
                            <form action="{{ route('delete.job.listing') }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="job_id" x-bind:value="selectedJob.job_id">
                                <button type="submit" 
                                    class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                            </form>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Successful Toast --}}
        <div 
            x-cloak x-show="showSuccessNotificationToast"
            x-transition
            x-cloak
            x-init="setTimeout(() => showSuccessNotificationToast = false, 3000)"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            
            {{ session('success') }}
        </div>

        {{-- Action Error Toast --}}
        <div 
            x-cloak x-show="showErrorNotificationToast"
            x-transition
            x-cloak
            x-init="setTimeout(() => showErrorNotificationToast = false, 3000)"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            
            {{ session('success') }}
        </div>
        
    </div>

    @livewireScripts

</body>

</html>
