<!-- Popup Table for New Company Accounts -->
<div wire:poll x-cloak x-show="openNewAccountRequestModal || activeTab == 'new-company-request-tab'"
    class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
    <div class="relative bg-white rounded-lg shadow-md w-3/4 min-h-[77%] overflow-hidden">
        <div class="relative bg-[#0F5192] text-white px-4 py-4 flex-1 items-center">
            <h2 class="text-3xl font-bold text-center self-center">New Company Account Requests</h2>
        </div>
        @if ($newCompanyAccountRequests->isEmpty())
            <div class="w-full flex items-center justify-center h-[637px]">
                <div class="text-center mb-10">
                    <!-- Icon / Illustration -->
                    <div class="mb-4 flex justify-center h-32">
                        <!-- You can replace this with an actual SVG or image if needed -->
                        <img src="{{ asset('images/new-account-icon.png') }}" alt="No Admin">
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">Waiting for Companies</h2>

                    <!-- Subtitle -->
                    <p class="text-gray-500">No one’s applied for an account yet. This is where new
                        requests will land when they do.</p>
                </div>
            </div>
            <div class="absolute bottom-0 flex w-full items-center p-8 pt-6 space-x-6">
                <div class="flex-1">

                </div>

                <!-- Close Button -->
                <button @click="openNewAccountRequestModal = false; activePopup = ''"
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
                            <th class="p-4 px-3 w-1/6">Company Name</th>
                            <th class="p-4 px-3">Business Type</th>
                            <th class="p-4 px-3">Address</th>
                            <th class="p-4 px-3">Contact Person Name</th>
                            <th class="p-4 px-3">Date</th>
                            <th class="p-4 px-3">Time</th>
                            <th class="p-4 px-3 w-1/12">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newCompanyAccountRequests as $newRequest)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedRequest = JSON.parse(atob('{{ base64_encode(json_encode($newRequest)) }}')); showNewAccountRequestData = true;">
                                <td class="border-b p-3">
                                    {{ ($newCompanyAccountRequests->currentPage() - 1) * $newCompanyAccountRequests->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[100px]">{{ $newRequest->company_name }}</td>
                                <td class="border-b p-3">{{ $newRequest->business_type }}</td>
                                <td class="border-b p-3">{{ $newRequest->barangay }},
                                    {{ $newRequest->city }}</td>
                                <td class="border-b p-3 truncate max-w-[150px]">
                                    {{ $newRequest->contact_person_name }}</td>
                                <td class="border-b p-3 truncate max-w-[130px]">{{ $newRequest->formatted_date }}</td>
                                <td class="border-b p-3 truncate max-w-[100px]">{{ $newRequest->formatted_time }}</td>
                                <td class="border-b p-3">
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

                <!-- Popup Modal for New Company Account Requests -->
                <div x-cloak x-show="showNewAccountRequestData"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-2/5 max-h-[80vh] overflow-y-auto">
                        <!-- Modal Header -->
                        <div class="relative bg-[#0F5192] text-white px-4 py-3 flex-1 items-center">
                            <h2 class="text-2xl font-bold p-2 text-center">REVIEW COMPANY ACCOUNT REQUEST</h2>
                            <button
                                class="absolute top-6 right-6 text-[18px] font-semibold text-white hover:text-red-600 w-[27px]"
                                @click="selectedRequest = null; showNewAccountRequestData = false">
                                ✕
                            </button>
                        </div>

                        <!-- Content Panel -->
                        <div class="space-y-4 px-12 py-4">

                            <!-- ID -->
                            <div class="flex flex-col">
                                <input type="hidden" x-model="selectedRequest.id">
                            </div>

                            <!-- Company Info Section -->
                            <div>
                                <h5 class="text-lg font-semibold text-gray-700 mb-2">🏢 Company Information</h5>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Company Name</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.company_name" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Business Type</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.business_type" readonly>
                                        </div>
                                    </div>

                                    <div class="grid gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Description</label>
                                            <textarea class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.description ?? 'NOT PROVIDED'" readonly rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col col-span-2">
                                            <label class="block text-base font-semibold">Street
                                                Address</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.street_address" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Barangay</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.barangay" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">City</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.city" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Info Section -->
                            <div>
                                <h5 class="text-lg font-semibold text-gray-700 mb-2">👤 Contact Person</h5>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Contact
                                                Person</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.contact_person_name" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Position</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.contact_person_position" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Email</label>
                                            <input type="email"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.contact_person_email" readonly>
                                        </div>
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Phone
                                                Number</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                :value="selectedRequest.contact_person_contact_number" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents Section -->
                            <div>
                                <h5 class="text-lg font-semibold text-gray-700 mb-2">📄 Verification
                                    Documents</h5>
                                <div class="space-y-4">
                                    <div class="flex flex-col">
                                        <label class="block text-base font-semibold">Uploaded Business
                                            Permit / SEC / DTI</label>
                                        <button
                                            class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                            @click="viewUpleadedRegistrationDocument = true">
                                            View ID
                                        </button>
                                    </div>

                                    <div class="flex flex-col">
                                        <label class="block text-base font-semibold">
                                            Uploaded Valid ID of Contact Person
                                        </label>

                                        <button
                                            class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                            @click="viewUploadedID = true">
                                            View ID
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center align-middle gap-6 py-6">

                            <!-- Reject -->
                            <button @click="showRejectionModal = true;  $wire.activeTab = 'companyAccountsTab'"
                                class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                                Reject
                            </button>

                            <!-- Accept -->
                            <form action="{{ route('approve.company.account.request') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" :value="selectedRequest.id">
                                <button
                                    class="bg-green-500 text-white px-12 py-2 rounded-md hover:bg-green-600 transition text-lg h-12 font-semibold">
                                    Accept
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 flex w-full items-center p-8 pt-6 space-x-6">
                <div class="flex-1">
                    {{ $newCompanyAccountRequests->links() }}
                </div>

                <!-- Close Button -->
                <button @click="openNewAccountRequestModal = false; activeTab = ''"
                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                    Close
                </button>
            </div>
        @endif
    </div>
</div>
