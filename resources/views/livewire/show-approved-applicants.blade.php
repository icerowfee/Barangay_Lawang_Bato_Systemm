<div class="p-4 flex-1">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold text-center self-center">Shortlisted Applicants</h2>

        <div class="flex gap-4 items-center">
            {{-- filters --}}
            <div class="flex gap-4 items-center">
                <!-- Search Input -->
                <div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search name or email..."
                        class="border border-gray-400 p-2 rounded w-64 h-[41px]">
                </div>

                <div class="flex gap-4 items-center mb-0">

                    <div x-data="{ open: false }" class="relative w-full">
                        <select wire:model.live="sort_by" @click="open = !open" @blur="open = false"
                            class="appearance-none border border-gray-400 cursor-pointer p-2 pl-3 pr-8 rounded">
                            <option value="name">Sort by Applicant Name</option>
                            <option value="email">Sort by Email</option>
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

            <button @click="openNewApplicationRequestModal = true"
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
        @if ($approvedApplicationRequests->isEmpty())
            <div class="w-full h-[70vh] flex items-center justify-center">
                <div class="text-center">
                    <!-- Icon / Illustration -->
                    <div class=" flex justify-center h-32">
                        <!-- You can replace this with an actual SVG or image if needed -->
                        <img src="{{ asset('images/approve-job-referral-request-icon.png') }}" alt="No Admin">
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">All Clear on Approved Requests</h2>

                    <!-- Subtitle -->
                    <p class="text-gray-500">You're up to date. Keep an eye on incoming applications and
                        approve
                        them when ready.</p>
                </div>
            </div>
        @else
            <div>
                <table class="min-w-full table-fixed text-base bg-white rounded-lg shadow-md overflow-hidden">
                    <thead>
                        <tr class="bg-gray-400 text-white uppercase tracking-wider text-center">
                            <th class="p-4 px-3 w-12">#</th>
                            <th class="p-4 px-3">Fullname</th>
                            <th class="p-4 px-3">Company Name</th>
                            <th class="p-4 px-3">Job Title</th>
                            <th class="p-4 px-3">Age</th>
                            <th class="p-4 px-3">Date</th>
                            <th class="p-4 px-3">Time</th>
                            <th class="p-4 px-3 w-1/12">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($approvedApplicationRequests as $approvedRequest)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedRequest = JSON.parse(atob('{{ base64_encode($approvedRequest->load('user')->load('jobListing')->toJson()) }}')); showProcessingApplicationData = true;">
                                <td class="border-b p-3">
                                    {{ ($approvedApplicationRequests->currentPage() - 1) * $approvedApplicationRequests->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[150px]">{{ $approvedRequest->user->lastname }},
                                    {{ $approvedRequest->user->firstname }}
                                    {{ $approvedRequest->user->middlename }}</td>
                                <td class="border-b p-3 truncate max-w-[150px]">
                                    {{ $approvedRequest->jobListing->company->company_name }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[150px]">
                                    {{ $approvedRequest->jobListing->job_title }}
                                </td>
                                <td class="border-b p-3 truncate">{{ $approvedRequest->user->age }}</td>
                                <td class="border-b p-3 truncate">{{ $approvedRequest->formatted_date }}</td>
                                <td class="border-b p-3 truncate">{{ $approvedRequest->formatted_time }}</td>
                                <td class="border-b p-3 ">
                                    <span
                                        class="text-white text-center font-medium px-3 py-2 rounded-md 
                                                {{ $approvedRequest->status === 'Shortlisted'
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

                <!-- Popup Modal for Approved Applicant Accounts -->
                <div x-cloak x-show="showProcessingApplicationData"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-2/5  min-h-fit overflow-y-auto">
                        <!-- Modal Header -->
                        <div class="relative bg-[#0F5192] text-white px-4 py-3 flex-1 items-center">
                            <h2 class="text-2xl font-bold p-2 text-center">VERIFIED APPLICANT DETAILS</h2>
                            <button
                                class="absolute top-6 right-6 text-[18px] font-semibold text-white hover:text-red-600 w-[27px]"
                                @click="selectedRequest = null; showProcessingApplicationData = false">
                                ✕
                            </button>
                        </div>

                        <!-- Content Panel -->
                        <div class="space-y-4 px-12 py-4">

                            <!-- Name -->
                            <div class="grid grid-cols-3 gap-4">
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Lastname</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.user.lastname" readonly>
                                </div>
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Firstname</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.user.firstname" readonly>
                                </div>
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Middlename</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.user.middlename ?? 'N/A'" readonly>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex flex-col">
                                <label class="block text-base font-semibold">Address</label>
                                <input type="text"
                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                    :value="selectedRequest.user.house_number + ', ' + selectedRequest.user
                                        .barangay + ', ' + selectedRequest.user.city + ', ' +
                                        selectedRequest.user.province"
                                    readonly>
                            </div>

                            <div class="grid grid-cols-4 gap-4">
                                <!-- Civil Status -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Civil Status</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.user.civil_status" readonly>
                                </div>

                                <!-- Sex -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Sex</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.user.sex" readonly>
                                </div>

                                <div class="grid grid-cols-3 gap-4 col-span-2">
                                    <!-- Birthdate -->
                                    <div class="col-span-2 flex flex-col">
                                        <label class="block text-base font-semibold">Birthdate</label>
                                        <input type="text"
                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                            :value="selectedRequest.formatted_birthdate" readonly>
                                    </div>

                                    <!-- Age -->
                                    <div class="col-span-1 flex flex-col">
                                        <label class="block text-base font-semibold">Age</label>
                                        <input type="text"
                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                            :value="selectedRequest.user.age" readonly>
                                    </div>
                                </div>

                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Email -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Email</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.user.email" readonly>
                                </div>

                                <!-- Mobile Number -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Mobile
                                        Number</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.user.contact_number" readonly>
                                </div>
                            </div>

                            <!-- Added User Information Fields -->
                            <div class="grid grid-cols-3 gap-4 mt-4">
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Height</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.height ? selectedRequest.height + ' cm' :
                                            'Not Specified'"
                                        readonly>
                                </div>
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Weight</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.weight ? selectedRequest.weight + ' kg' :
                                            'Not Specified'"
                                        readonly>
                                </div>
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Educational
                                        Attainment</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.educational_attainment ? selectedRequest
                                            .educational_attainment : 'Not Specified'"
                                        readonly>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Special
                                        Program</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.special_program ? selectedRequest
                                            .special_program : 'Not Specified'"
                                        readonly>
                                </div>
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Certificate
                                        Number</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.certificate_number ? selectedRequest
                                            .certificate_number : 'Not Specified'"
                                        readonly>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-4">
                                <div class="flex space-x-4">
                                    <!-- Valid ID -->
                                    <div class="flex flex-col w-1/2 flex-1">
                                        <label class="block text-base font-semibold">Valid ID</label>
                                        <button
                                            class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                            @click="viewUploadedValidId = true">View ID</button>
                                    </div>

                                    <!-- Second Valid ID (Dynamic) -->
                                    <template x-if="selectedRequest.secondary_valid_id">
                                        <div class="flex flex-col w-1/2">
                                            <label class="block text-base font-semibold">Second Valid
                                                ID</label>
                                            <button
                                                class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                                @click="viewUploadedSecondaryValidId = true">View
                                                Second ID</button>
                                        </div>
                                    </template>
                                </div>

                                <!-- resume -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Resume</label>
                                    <button
                                        class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                        @click="viewUploadedResume = true">View resume</button>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center align-middle gap-6 py-6">

                            <!-- Delete -->
                            <form action="{{ route('delete.application.request') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" :value="selectedRequest.id">
                                <button class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                                    Delete
                                </button>
                            </form>

                            {{-- <form x-show="selectedRequest.status != 'Scheduled'"
                                action="{{ route('schedule.job.referral.request') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" :value="selectedRequest.id">
                                <button
                                    class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                    Schedule Appointment
                                </button>
                            </form> --}}

                            {{-- <form x-show="selectedRequest.status === 'Scheduled'"
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
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">{{ $approvedApplicationRequests->links() }}</div>
        @endif
    </div>
</div>
