<!-- Popup Table for New User Accounts -->
<div wire:poll x-cloak x-show="openNewAccountRequestModal || activeTab == 'new-account-request-tab'"
    class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
    <div class="relative bg-white rounded-lg shadow-md w-3/4 min-h-[77%] overflow-hidden">
        <div class="relative bg-[#0F5192] text-white px-4 py-4 flex-1 items-center">
            <h2 class="text-3xl font-bold text-center self-center">New User Account Requests</h2>
        </div>
        @if ($newUserAccountRequests->isEmpty())
            <div class="w-full flex items-center justify-center h-[637px]">
                <div class="text-center mb-10">
                    <!-- Icon / Illustration -->
                    <div class="mb-4 flex justify-center h-32">
                        <!-- You can replace this with an actual SVG or image if needed -->
                        <img src="{{ asset('images/new-account-icon.png') }}" alt="No Admin">
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">Waiting for Job Seekers</h2>

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
                            <th class="p-4 px-3 w-1/6">Fullname</th>
                            <th class="p-4 px-3 w-2/5">Address</th>
                            <th class="p-4 px-3">Age</th>
                            <th class="p-4 px-3">Sex</th>
                            <th class="p-4 px-3">Date</th>
                            <th class="p-4 px-3">Time</th>
                            <th class="p-4 px-3 w-1/12">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newUserAccountRequests as $newRequest)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedRequest = JSON.parse(atob('{{ base64_encode(json_encode($newRequest)) }}')); showNewAccountRequestData = true;">
                                <td class="border-b p-3">
                                    {{ ($newUserAccountRequests->currentPage() - 1) * $newUserAccountRequests->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-b p-3">{{ $newRequest->lastname }},
                                    {{ $newRequest->firstname }} {{ $newRequest->middlename }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[250px]">{{ $newRequest->house_number }},
                                    {{ $newRequest->barangay }}, {{ $newRequest->city }},
                                    {{ $newRequest->province }}</td>
                                <td class="border-b p-3">{{ $newRequest->age }}</td>
                                <td class="border-b p-3">{{ $newRequest->sex }}</td>
                                <td class="border-b p-3 truncate max-w-[130px]">{{ $newRequest->formatted_date }}</td>
                                <td class="border-b p-3 truncate max-w-[100px]">{{ $newRequest->formatted_time }}</td>
                                <td class="border-b p-3">
                                    <span class="text-white text-center font-medium px-3 py-2 rounded-md"
                                        :class="selectedRequest?.status === 'Active' ? 'bg-green-500' :
                                            (selectedRequest?.status === 'Rejected' ?
                                                'bg-red-500' :
                                                'bg-yellow-500')">
                                        {{ $newRequest->status ?? 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Popup Modal for New User Account Requests -->
                <div x-cloak x-show="showNewAccountRequestData"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-2/5 max-h-[80vh] overflow-y-auto">
                        <!-- Modal Header -->
                        <div class="relative bg-[#0F5192] text-white px-4 py-3 flex-1 items-center">
                            <h2 class="text-2xl font-bold p-2 text-center">REVIEW USER ACCOUNT REQUEST</h2>
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

                            <div class="grid grid-cols-3 gap-4">
                                <!-- Name -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Lastname</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.lastname" readonly>
                                </div>
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Firstname</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.firstname" readonly>
                                </div>
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Middlename</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.middlename ?? 'N/A'" readonly>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex flex-col">
                                <label class="block text-base font-semibold">Address</label>
                                <input type="text"
                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                    :value="selectedRequest.house_number + ', ' + selectedRequest.barangay +
                                        ', ' +
                                        selectedRequest.city + ', ' + selectedRequest.province"
                                    readonly>
                            </div>

                            <div class="grid grid-cols-4 gap-4">
                                <!-- Civil Status -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Civil Status</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.civil_status" readonly>
                                </div>

                                <!-- Sex -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Sex</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.sex" readonly>
                                </div>

                                <!-- Birthdate -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Birthdate</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.formatted_birthdate" readonly>
                                </div>

                                <!-- Age -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Age</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.age" readonly>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Email -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Email</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.email" readonly>
                                </div>

                                <!-- Mobile Number -->
                                <div class="flex flex-col">
                                    <label class="block text-base font-semibold">Mobile Number</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        :value="selectedRequest.contact_number" readonly>
                                </div>
                            </div>

                            <!-- Valid ID -->
                            <div class="flex flex-col">
                                <label class="block text-base font-semibold">Valid ID</label>
                                <button
                                    class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                    @click="viewUploadedID = true">View
                                    ID</button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center align-middle gap-6 py-6">

                            {{-- <!-- Reject -->
                            <form action="{{ route('reject.user.account.request') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" :value="selectedRequest.id">
                                <button class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                                    Reject
                                </button>
                            </form> --}}

                            <button @click="showRejectionModal = true;  $wire.activeTab = 'new-account-request-tab'"
                                class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                                Reject
                            </button>

                            <!-- Accept -->
                            <form action="{{ route('approve.user.account.request') }}" method="POST">
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
                    {{ $newUserAccountRequests->links() }}
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
