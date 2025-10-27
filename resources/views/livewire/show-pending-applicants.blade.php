<!-- Popup Table for New Applicant -->
<div wire:poll x-cloak x-show="openNewApplicationRequestModal || activeTab === 'new-job-referral-request-tab'"
    class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
    <div class="relative bg-white rounded-lg shadow-md w-3/4 min-h-[77%] overflow-hidden">
        <div class="relative bg-[#0F5192] text-white px-4 py-4 flex-1 items-center">
            <h2 class="text-3xl font-bold text-center self-center">New Job Application Requests</h2>
        </div>
        @if ($newApplicationRequests->isEmpty())
            <div class="w-full flex items-center justify-center h-[637px]">
                <div class=" text-center mb-10">
                    <!-- Icon / Illustration -->
                    <div class="mb-4 flex justify-center h-32">
                        <!-- You can replace this with an actual SVG or image if needed -->
                        <img src="{{ asset('images/new-job-referral-request-icon.png') }}" alt="No Admin">
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">No Pending Job Referral
                        Requests
                    </h2>

                    <!-- Subtitle -->
                    <p class="text-gray-500">Looks like there are no new job referral requests.
                        <br>Check
                        back regularly to process new applications quickly.
                    </p>
                </div>
            </div>
            <div class="absolute bottom-0 flex w-full items-center p-8 pt-6 space-x-6">
                <div class="flex-1">

                </div>

                <!-- Close Button -->
                <button @click="openNewApplicationRequestModal = false; activePopup = ''"
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
                        @foreach ($newApplicationRequests as $newRequest)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedRequest = JSON.parse(atob('{{ base64_encode($newRequest->load('user')->load('jobListing')->toJson()) }}')); showNewApplicationRequestData = true;">
                                <td class="border-b p-3">
                                    {{ ($newApplicationRequests->currentPage() - 1) * $newApplicationRequests->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[150px]">{{ $newRequest->user->lastname }},
                                    {{ $newRequest->user->firstname }}
                                    {{ $newRequest->user->middlename }}</td>
                                <td class="border-b p-3 truncate max-w-[150px]">
                                    {{ $newRequest->jobListing->company->company_name }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[150px]">
                                    {{ $newRequest->jobListing->job_title }}
                                </td>
                                <td class="border-b p-3 truncate">{{ $newRequest->user->age }}</td>
                                <td class="border-b p-3 truncate">{{ $newRequest->formatted_date }}</td>
                                <td class="border-b p-3 truncate">{{ $newRequest->formatted_time }}</td>
                                <td class="border-b p-3 ">
                                    <span class="text-white text-center font-medium px-3 py-2 rounded-md"
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
                                            <label class="block text-sm font-semibold">Job
                                                Title</label>
                                            <input type="text" :value="selectedRequest.job_listing?.job_title"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold">Job
                                                Category</label>
                                            <input type="text" :value="selectedRequest.job_listing?.job_category"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold">Job
                                            Description</label>
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
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold">Employment
                                                Type</label>
                                            <input type="text" :value="selectedRequest.job_listing?.employment_type"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <!-- Application Deadline Date -->
                                        <div>
                                            <label class="block text-sm font-semibold">Application
                                                Deadline</label>
                                            <div class="grid grid-cols-3 gap-4">
                                                <div class="col-span-2">
                                                    <input type="text"
                                                        :value="selectedRequest.job_listing
                                                            ?.application_deadline ?
                                                            new Date(selectedRequest.job_listing
                                                                .application_deadline)
                                                            .toLocaleDateString(
                                                                'en-US', {
                                                                    month: 'long',
                                                                    day: 'numeric',
                                                                    year: 'numeric'
                                                                }) : ''"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        readonly>
                                                </div>
                                                <!-- Application Deadline Time -->
                                                <div class="col-span-1">
                                                    <div></div>
                                                    <input type="text"
                                                        :value="selectedRequest.job_listing
                                                            ?.application_deadline ?
                                                            new Date(selectedRequest.job_listing
                                                                .application_deadline)
                                                            .toLocaleTimeString(
                                                                [], {
                                                                    hour: '2-digit',
                                                                    minute: '2-digit'
                                                                }
                                                            ) : ''"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Salary Range -->
                                        <div>
                                            <label class="block text-sm font-semibold">Salary
                                                Range</label>
                                            <input type="text"
                                                :value="selectedRequest.job_listing?.min_salary &&
                                                    selectedRequest
                                                    .job_listing?.max_salary ? '₱' + selectedRequest
                                                    .job_listing.min_salary + ' - ₱' + selectedRequest
                                                    .job_listing.max_salary : 'Not Specified'"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Job Requirements (Age, Height, Weight, Educational Attainment, Special Program) -->
                                <div class="space-y-4">
                                    <div class="grid grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold">Age
                                                Requirement</label>
                                            <input type="text"
                                                :value="selectedRequest.job_listing?.min_age && selectedRequest
                                                    .job_listing?.max_age ? selectedRequest.job_listing
                                                    .min_age + ' - ' + selectedRequest.job_listing
                                                    .max_age +
                                                    ' years' : 'Not Specified'"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold">Height
                                                Requirement</label>
                                            <input type="text"
                                                :value="selectedRequest.job_listing?.min_height &&
                                                    selectedRequest
                                                    .job_listing?.max_height ? selectedRequest
                                                    .job_listing
                                                    .min_height + ' - ' + selectedRequest.job_listing
                                                    .max_height + ' cm' : 'Not Specified'"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold">Weight
                                                Requirement</label>
                                            <input type="text"
                                                :value="selectedRequest.job_listing?.min_weight &&
                                                    selectedRequest
                                                    .job_listing?.max_weight ? selectedRequest
                                                    .job_listing
                                                    .min_weight + ' - ' + selectedRequest.job_listing
                                                    .max_weight + ' kg' : 'Not Specified'"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold">Educational
                                                Attainment</label>
                                            <input type="text"
                                                :value="selectedRequest.educational_attainment ? selectedRequest
                                                    .educational_attainment : 'Not Specified'"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold">Special
                                                Program</label>
                                            <input type="text"
                                                :value="selectedRequest.job_listing?.special_program ?
                                                    selectedRequest.job_listing.special_program :
                                                    'Not Specified'"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold">Certificate
                                                Required</label>
                                            <input type="text"
                                                :value="selectedRequest.certificate_number ? 'Yes' : 'No'"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold">Special Program
                                                Optional</label>
                                            <input type="text"
                                                :value="selectedRequest.job_listing
                                                    ?.is_special_program_optional ?
                                                    'Yes' : 'No'"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Applicant Details --}}
                        <div class="bg-[#FFF8F8] overflow-y-auto">
                            <!-- Header -->
                            <div class="relative bg-[#0367C9] text-white px-4 py-3 flex justify-between items-center">
                                <h2 class="text-2xl font-bold p-2">APPLICANT DETAILS</h2>
                                <button
                                    class="absolute top-6 right-6 text-[18px] font-semibold text-white hover:text-red-600 w-[27px]"
                                    @click="selectedRequest = null; showNewApplicationRequestData = false">✕</button>
                            </div>

                            <!-- Body -->
                            <div class="py-4 px-12 space-y-4 flex-1 overflow-y-auto mb-4">

                                <!-- Name -->
                                <div class="flex flex-col">
                                    <label class="block text-sm font-semibold">Name</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                        :value="selectedRequest.user.lastname + ', ' + selectedRequest.user
                                            .firstname +
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
                                        <label class="block text-sm font-semibold">Mobile
                                            Number</label>
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
                                            :value="selectedRequest.height ? selectedRequest.height + ' cm' :
                                                'Not Specified'"
                                            readonly>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="block text-sm font-semibold">Weight</label>
                                        <input type="text"
                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                            :value="selectedRequest.weight ? selectedRequest.weight + ' kg' :
                                                'Not Specified'"
                                            readonly>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="block text-sm font-semibold">Educational
                                            Attainment</label>
                                        <input type="text"
                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                            :value="selectedRequest.educational_attainment ? selectedRequest
                                                .educational_attainment : 'Not Specified'"
                                            readonly>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div class="flex flex-col">
                                        <label class="block text-sm font-semibold">Special
                                            Program</label>
                                        <input type="text"
                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                            :value="selectedRequest.special_program ? selectedRequest
                                                .special_program : 'Not Specified'"
                                            readonly>
                                    </div>
                                    <div class="flex flex-col">
                                        <label class="block text-sm font-semibold">Certificate
                                            Number</label>
                                        <input type="text"
                                            class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-700"
                                            :value="selectedRequest.certificate_number ? selectedRequest
                                                .certificate_number : 'Not Specified'"
                                            readonly>
                                    </div>
                                </div>

                                <div class="flex flex-col space-y-4">
                                    <div class="flex space-x-4 ">
                                        <!-- Valid ID -->
                                        <div class="flex flex-col w-1/2 flex-1">
                                            <label class="block text-sm font-semibold">Valid ID</label>
                                            <button
                                                class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                                @click="viewUploadedValidId = true">View ID</button>
                                        </div>

                                        <!-- Second Valid ID (Dynamic) -->
                                        <template x-if="selectedRequest.secondary_valid_id">
                                            <div class="flex flex-col w-1/2">
                                                <label class="block text-sm font-semibold">Second Valid
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
                                        <label class="block text-sm font-semibold">Resume</label>
                                        <button
                                            class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                            @click="viewUploadedResume = true">View resume</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="bg-white flex justify-center align-middle col-span-2 gap-6 py-6">

                            <!-- Decline -->
                            <form action="{{ route('reject.application.request') }}" method="POST" class="m-0">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" :value="selectedRequest.id">

                                <button
                                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                                    Decline Application
                                </button>
                            </form>

                            <!-- Approve -->
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

            <div class="absolute bottom-0 flex w-full items-center p-8 pt-6 space-x-6">
                <div class="flex-1">
                    {{ $newApplicationRequests->links() }}
                </div>

                <!-- Close Button -->
                <button @click="openNewApplicationRequestModal = false; activeTab = ''"
                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                    Close
                </button>
            </div>
        @endif
    </div>
</div>
