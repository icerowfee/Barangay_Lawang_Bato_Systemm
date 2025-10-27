<div class="p-4 flex-1">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold text-center self-center">Active Job Listings</h2>

        <div class="flex gap-4 items-center">
            {{-- filters --}}
            <div class="flex gap-4 items-center">
                <!-- Search Input -->
                <div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search Job Title..."
                        class="border border-gray-400 p-2 rounded w-64 h-[41px]">
                </div>

                <div class="flex gap-4 items-center mb-0">

                    <div x-data="{ open: false }" class="relative w-full">
                        <select wire:model.live="sort_by" @click="open = !open" @blur="open = false"
                            class="appearance-none border border-gray-400 cursor-pointer p-2 pl-3 pr-8 rounded">
                            <option value="job_title">Sort by Job Title</option>
                            {{-- <option value="company_name">Sort by Company</option> --}}
                            <option value="job_category">Sort by Job Category</option>
                            <option value="employment_type">Sort by Job Employment Type</option>
                            <option value="date">Sort by Date</option>
                        </select>

                        <!-- Custom arrow -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none transition-transform duration-300"
                            :class="{ 'rotate-180': open }">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div x-data="{ open: false }" class="relative w-full">
                        <select wire:model.live="sort_dir" @click="open = !open" @blur="open = false"
                            class="appearance-none border border-gray-400 cursor-pointer p-2 pl-3 pr-7 rounded">
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>

                        <!-- Custom arrow -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none transition-transform duration-300"
                            :class="{ 'rotate-180': open }">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <button wire:click="clearFilter"
                class="text-black hover:bg-slate-200 font-semibold px-4 py-2 rounded border border-gray-400">
                Clear Filter
            </button>

            <button @click="openNewJobListingModal = true"
                class="relative px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md">
                New Requests
                <span x-cloak x-show="showNewCedulaRequestIndication" x-transition:enter="transform scale-200 opacity-0"
                    x-transition:enter-start="transform scale-150 opacity-0"
                    x-transition:enter-end="transform scale-100 opacity-100"
                    x-transition:leave="transform scale-100 opacity-100"
                    x-transition:leave-end="transform scale-0 opacity-0"
                    class="absolute top-[-40px] right-[-7px] text-red-600 text-[50px] animate-pulse transition-transform duration-700 ease-out origin-center">
                    •
                </span>
            </button>
        </div>
    </div>

    <div wire:poll.5s.keep-alive class="max-h-full">
        @if ($approvedJobListings->isEmpty())
            <div class="w-full h-[70vh] flex items-center justify-center">
                <div class="text-center">
                    <!-- Icon / Illustration -->
                    <div class=" flex justify-center h-32">
                        <!-- You can replace this with an actual SVG or image if needed -->
                        <img src="{{ asset('images/approve-job-icon.png') }}" alt="No Job Listings">
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">No Active Job Listings</h2>

                    <!-- Subtitle -->
                    <p class="text-gray-500">Once job listings are approved, they’ll show up here. <br>
                        Review pending listings to get jobs posted for applicants.</p>
                </div>
            </div>
        @else
            <div>
                <table class="min-w-full table-fixed text-base bg-white rounded-lg shadow-md overflow-hidden">
                    <thead>
                        <tr class="bg-gray-400 text-white uppercase tracking-wider text-center">
                            <th class="p-4 px-3 w-12">#</th>
                            <th class="p-4 px-3">Job Title</th>
                            <th class="p-4 px-3">Company Name</th>
                            <th class="p-4 px-3">Location</th>
                            <th class="p-4 px-3">Date Posted</th>
                            <th class="p-4 px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($approvedJobListings as $approvedJob)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedJobListing = JSON.parse(atob('{{ base64_encode(json_encode($approvedJob->load('company'))) }}')); showApprovedJobListingDetails = true;">
                                <td class="border-b p-3">
                                    {{ ($approvedJobListings->currentPage() - 1) * $approvedJobListings->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[200px]">{{ $approvedJob->job_title }}</td>
                                <td class="border-b p-3">{{ $approvedJob->company->company_name }}</td>
                                <td class="border-b p-3">{{ $approvedJob->job_location }}</td>
                                <td class="border-b p-3">{{ $approvedJob->formatted_date }}</td>
                                <td class="border-b p-3">
                                    <span
                                        class="text-white text-center font-medium px-3 py-2 rounded-md 
                                        {{ $approvedJob->status === 'Active'
                                            ? 'bg-green-500'
                                            : ($approvedJob->status === 'Rejected'
                                                ? 'bg-red-500'
                                                : 'bg-gray-500') }}">
                                        {{ $approvedJob->status ?? 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Popup Modal for Approved Job Listing -->
                <div x-cloak x-show="showApprovedJobListingDetails"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-2/5 max-h-[90vh] overflow-y-auto">
                        <!-- Modal Header -->
                        <div class="relative bg-[#0F5192] text-white px-4 py-3 flex-1 items-center">
                            <h2 class="text-2xl font-bold p-2 text-center">REVIEW JOB LISTING DETAILS</h2>
                            <button
                                class="absolute top-6 right-6 text-[18px] font-semibold text-white hover:text-red-600 w-[27px]"
                                @click="selectedJobListing = null; showApprovedJobListingDetails = false">
                                ✕
                            </button>
                        </div>

                        <!-- Content Panel -->
                        <div class="space-y-4 px-12 py-4">
                            <!-- Job Info Section -->
                            <div>
                                <h5 class="text-lg mt-4 font-bold text-gray-700 mb-1">Job Information</h5>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Company
                                                Name</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.company.company_name" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Business
                                                Type</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.company.business_type" readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Job
                                                Title</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.job_title" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Job
                                                Category</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.job_category" readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col col-span-2">
                                            <label class="block text-base font-semibold">Job
                                                Description</label>
                                            <textarea class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.job_description" readonly rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Salary & Employment Details Section -->
                            <div>
                                <h5 class="text-lg mt-4 font-bold text-gray-700 mb-1">Salary & Employment
                                    Details</h5>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Location</label>
                                            <input type="text" :value="selectedJobListing.job_location"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Employment
                                                Type</label>
                                            <input type="text" :value="selectedJobListing.employment_type"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Application
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
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                        readonly>
                                                </div>

                                                <!-- Application Deadline Time -->
                                                <div class="col-span-1">
                                                    <input type="text"
                                                        :value="new Date(selectedJobListing.application_deadline)
                                                            .toLocaleTimeString(
                                                                [], { hour: '2-digit', minute: '2-digit' })"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Salary Range -->
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Salary
                                                Range</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="'₱ ' + selectedJobListing.min_salary + ' - ₱ ' +
                                                    selectedJobListing.max_salary"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Requirements Section -->
                            <div>
                                <h5 class="text-lg mt-4 font-bold text-gray-700 mb-1">Requirements</h5>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Minimum
                                                Age</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.min_age ?? 'N/A'" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Maximum
                                                Age</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.max_age ?? 'N/A'" readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Minimum Height
                                                (cm)</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.min_height ?? 'N/A'" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Maximum Height
                                                (cm)</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.max_height ?? 'N/A'" readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Minimum Weight
                                                (kg)</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.min_weight ?? 'N/A'" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Maximum Weight
                                                (kg)</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedJobListing.max_weight ?? 'N/A'" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center align-middle gap-6 py-6">

                            <!-- Delete -->
                            <form action="{{ route('delete.job.listing') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" :value="selectedJobListing.id">
                                <button class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold mb-4">
                                    Delete
                                </button>
                            </form>
                            
                            <!-- Close Job -->
                            <form action="{{ route('approve.job.listing') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" :value="selectedJobListing.id">
                                <button
                                    class="bg-green-500 text-white px-12 py-2 rounded-md hover:bg-green-600 transition text-lg h-12 font-semibold mb-4">
                                    Close Job
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">{{ $approvedJobListings->links() }}</div>
        @endif
    </div>
</div>
