<!-- Popup Table for New Job Listing -->
<div wire:poll x-cloak x-show="openNewJobListingModal || activeTab == 'new-job-listing-tab'"
    class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
    <div class="relative bg-white rounded-lg shadow-md w-3/4 min-h-[77%] overflow-hidden">
        <div class="relative bg-[#0F5192] text-white px-4 py-4 flex-1 items-center">
            <h2 class="text-3xl font-bold text-center self-center">New Job Listings</h2>
        </div>
        @if ($newJobListings->isEmpty())
            <div class="w-full flex items-center justify-center h-[637px]">
                <div class="text-center mb-10">
                    <!-- Icon / Illustration -->
                    <div class="mb-4 flex justify-center h-32">
                        <!-- You can replace this with an actual SVG or image if needed -->
                        <img src="{{ asset('images/new-job-icon.png') }}" alt="No Job Listings">
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">No New Job Listings</h2>

                    <!-- Subtitle -->
                    <p class="text-gray-500">Once new listings are submitted, they’ll show up here.
                        <br>
                        Review
                        pending listings to approve new job posts.
                    </p>
                </div>
            </div>
            <div class="absolute bottom-0 flex w-full items-center p-8 pt-6 space-x-6">
                <div class="flex-1">

                </div>

                <!-- Close Button -->
                <button @click="openNewJobListingModal = false; activePopup = ''"
                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                    Close
                </button>
            </div>
        @else
            <div>
                <table class="min-w-full table-fixed text-base bg-white shadow-md overflow-hidden">
                    <thead>
                        <tr class="bg-gray-400 text-white uppercase tracking-wider text-center">
                            <th class="p-4 px-3 w-12">#</th>
                            <th class="p-4 px-3">Job Title</th>
                            <th class="p-4 px-3">Company Name</th>
                            <th class="p-4 px-3">Location</th>
                            <th class="p-4 px-3">Date Posted</th>
                            <th class="p-4 px-3 w-1/12">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newJobListings as $newJob)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedJobListing = JSON.parse(atob('{{ base64_encode(json_encode($newJob->load('company'))) }}')); showNewJobListingDetails = true;">
                                <td class="border-b p-3">
                                    {{ ($newJobListings->currentPage() - 1) * $newJobListings->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[200px]">
                                    {{ $newJob->job_title }}</td>
                                <td class="border-b p-3">{{ $newJob->company->company_name }}</td>
                                <td class="border-b p-3">{{ $newJob->job_location }}</td>
                                <td class="border-b p-3">{{ $newJob->formatted_date }}</td>
                                <td class="border-b p-3">
                                    <span
                                        class="text-white text-center font-medium px-3 py-2 rounded-md 
                                                        {{ $newJob->status === 'Active'
                                                            ? 'bg-green-500'
                                                            : ($newJob->status === 'Rejected'
                                                                ? 'bg-red-500'
                                                                : 'bg-yellow-500') }}">
                                        {{ $newJob->status ?? 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Popup Modal for New Job Listing -->
                <div x-cloak x-show="showNewJobListingDetails"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-2/5 max-h-[80vh] overflow-y-auto">
                        <!-- Modal Header -->
                        <div class="relative bg-[#0F5192] text-white px-4 py-3 flex-1 items-center">
                            <h2 class="text-2xl font-bold p-2 text-center">REVIEW JOB LISTING REQUEST
                            </h2>
                            <button
                                class="absolute top-6 right-6 text-[18px] font-semibold text-white hover:text-red-600 w-[27px]"
                                @click="selectedJobListing = null; showNewJobListingDetails = false">
                                ✕
                            </button>
                        </div>

                        <!-- Content Panel -->
                        <div class="space-y-4 px-12 py-4">
                            <!-- Job Info Section -->
                            <div>
                                <h5 class="text-lg mt-4 font-bold text-gray-700 mb-1">Job Information
                                </h5>
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
                                <h5 class="text-lg mt-4 font-bold text-gray-700 mb-1">Salary &
                                    Employment
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
                                                        :value="new Date(selectedJobListing
                                                                .application_deadline)
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
                                                        :value="new Date(selectedJobListing
                                                                .application_deadline)
                                                            .toLocaleTimeString(
                                                                [], {
                                                                    hour: '2-digit',
                                                                    minute: '2-digit'
                                                                })"
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

                            <!-- Reject -->
                            <form action="{{ route('reject.job.listing') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" :value="selectedJobListing.id">
                                <button
                                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold mb-4">
                                    Reject
                                </button>
                            </form>

                            <!-- Approve -->
                            <form action="{{ route('approve.job.listing') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" :value="selectedJobListing.id">
                                <button
                                    class="bg-green-500 text-white px-12 py-2 rounded-md hover:bg-green-600 transition text-lg h-12 font-semibold mb-4">
                                    Approve
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 flex w-full items-center p-8 pt-6 space-x-6">
                <div class="flex-1">
                    {{ $newJobListings->links() }}
                </div>

                <!-- Close Button -->
                <button @click="openNewJobListingModal = false; activeTab = ''"
                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                    Close
                </button>
            </div>
        @endif
    </div>
</div>
