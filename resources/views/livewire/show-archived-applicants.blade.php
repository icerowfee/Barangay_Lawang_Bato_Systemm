<!-- Archive Modal -->
<div wire:poll x-cloak x-show="openArchive || activeTab === 'job-referral-request-archive-tab'"
    class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
    <div class="relative bg-white rounded-lg shadow-md w-3/4 min-h-[77%] overflow-hidden">
        <div class="relative bg-[#0F5192] text-white px-4 py-4 flex-1 items-center">
            <h2 class="text-3xl font-bold text-center self-center">Archives</h2>
        </div>
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
                            <th class="p-4 px-3 w-2/12">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($archivedApplicationRequests as $archivedRequest)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedRequest = JSON.parse(atob('{{ base64_encode($archivedRequest->load('user')->load('jobListing')->toJson()) }}')); showArchivedApplicationData = true;">
                                <td class="border-b p-3">
                                    {{ ($archivedApplicationRequests->currentPage() - 1) * $archivedApplicationRequests->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[150px]">{{ $archivedRequest->user->lastname }},
                                    {{ $archivedRequest->user->firstname }}
                                    {{ $archivedRequest->user->middlename }}</td>
                                <td class="border-b p-3 truncate max-w-[150px]">
                                    {{ $archivedRequest->jobListing->company->company_name }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[150px]">
                                    {{ $archivedRequest->jobListing->job_title }}
                                </td>
                                <td class="border-b p-3 truncate">{{ $archivedRequest->user->age }}</td>
                                <td class="border-b p-3 truncate">{{ $archivedRequest->formatted_date }}</td>
                                <td class="border-b p-3 truncate">{{ $archivedRequest->formatted_time }}</td>
                                <td
                                    class="border-b p-3 text-white
                                    {{ $archivedRequest->status === 'Accepted by Company'
                                        ? 'bg-green-500'
                                        : ($archivedRequest->status === 'Rejected'
                                            ? 'bg-red-500'
                                            : ($archivedRequest->status === 'Rejected by Company'
                                                ? 'bg-yellow-500'
                                                : 'bg-gray-500')) }}">
                                    @if ($archivedRequest->status === 'Rejected')
                                        Rejected by Admin
                                    @else
                                        {{ $archivedRequest->status ?? 'Pending' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Popup Modal for archived applicants status -->
                <div x-cloak x-show="showArchivedApplicationData"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-2/5 max-h-[80vh] overflow-y-auto">
                        <!-- Modal Header -->
                        <div class="relative bg-[#0F5192] text-white px-4 py-3 flex-1 items-center">
                            <h2 class="text-2xl font-bold p-2 text-center">REVIEW ARCHIVED APPLICANT STATUS</h2>
                            <button
                                class="absolute top-6 right-6 text-[18px] font-semibold text-white hover:text-red-600 w-[27px]"
                                @click="selectedRequest = null; showArchivedApplicationData = false">
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
                                <button
                                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 flex w-full items-center p-8 pt-6 space-x-6">
                <div class="flex-1">
                    {{ $archivedApplicationRequests->links() }}
                </div>

                <!-- Close Button -->
                <button @click="openArchive = false; activeTab = ''"
                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                    Close
                </button>
            </div>
        @endif
    </div>
</div>
