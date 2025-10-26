<!-- Popup Table for New Clearance Requests -->
<div wire:poll x-cloak x-show="openClearance || activePopup === 'new-clearance-request-tab'"
    class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
    <div class="relative bg-white rounded-lg shadow-md w-3/4 min-h-[77%] overflow-hidden">
        <div class="relative bg-[#0F5192] text-white px-4 py-4 flex-1 items-center">
            <h2 class="text-3xl font-bold text-center self-center">New Clearance Requests</h2>
        </div>
        @if ($newClearanceRequests->isEmpty()) {{-- AYUSIN MO TO --}}
            <div class="w-full flex items-center justify-center h-[637px]">
                <div class=" text-center mb-10">
                    <!-- Icon / Illustration -->
                    <div class="mb-4 flex justify-center h-32">
                        <!-- You can replace this with an actual SVG or image if needed -->
                        <img src="{{ asset('images/new-document-icon.png') }}" alt="No Admin">
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">You're All Caught Up!
                    </h2>

                    <!-- Subtitle -->
                    <p class="text-gray-500">New clearance applications will appear here as
                        they come in.</p>
                </div>
            </div>
            <div class="absolute bottom-0 flex w-full items-center p-8 pt-6 space-x-6">
                <div class="flex-1">

                </div>

                <!-- Close Button -->
                <button @click="openClearance = false; activePopup = ''"
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
                            <th class="p-4 px-3">Purpose</th>
                            <th class="p-4 px-3">Date</th>
                            <th class="p-4 px-3">Time</th>
                            <th class="p-4 px-3 w-1/12">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newClearanceRequests as $newRequest)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedRequest = JSON.parse(atob('{{ base64_encode(json_encode($newRequest)) }}')); showNewClearanceRequests = true;">
                                <td class="border-b p-3 truncate">
                                    {{ ($newClearanceRequests->currentPage() - 1) * $newClearanceRequests->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-b p-3 truncate">{{ $newRequest->lastname }},
                                    {{ $newRequest->firstname }} {{ $newRequest->middlename }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[250px]">{{ $newRequest->house_number }},
                                    {{ $newRequest->barangay }}, {{ $newRequest->city }}, {{ $newRequest->province }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[180px]">{{ $newRequest->user_purpose }}</td>
                                <td class="border-b p-3 truncate max-w-[130px]">{{ $newRequest->formatted_date }}</td>
                                <td class="border-b p-3 truncate max-w-[100px]">{{ $newRequest->formatted_time }}</td>
                                <td class="border-b p-3 truncate">
                                    <span class="px-2 py-1 text-white rounded"
                                        :class="selectedRequest?.status === 'Approved' ?
                                            'bg-green-500' :
                                            (selectedRequest?.status === 'Rejected' ?
                                                'bg-red-500' : 'bg-yellow-500')">
                                        {{ $newRequest->status ?? 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Popup Modal for New Clearance Requests -->
                <div x-cloak x-show="showNewClearanceRequests"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-2/5 h-fit overflow-y-hidden">
                        <!-- Modal Header -->
                        <div class="relative bg-[#0F5192] text-white px-4 py-3 flex-1 items-center">
                            <h2 class="text-2xl font-bold p-2 text-center">REVIEW NEW CLEARANCE REQUEST</h2>
                            <button
                                class="absolute top-6 right-6 text-[18px] font-semibold text-white hover:text-red-600 w-[27px]"
                                @click="selectedRequest = null; showNewClearanceRequests = false"
                                wire:click="resetModal">
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
                                        ', ' + selectedRequest.city + ', ' + selectedRequest
                                        .province"
                                    readonly>
                            </div>

                            <!-- Civil Status & Sex -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col w-full">
                                    <label class="block text-base font-semibold">Civil Status</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        x-model="selectedRequest.civil_status" readonly>
                                </div>

                                <div class="flex flex-col w-full">
                                    <label class="block text-base font-semibold">Sex</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        x-model="selectedRequest.sex" readonly>
                                </div>
                            </div>

                            <!-- Birthplace, Birthdate, & Age -->
                            <div class="grid grid-cols-3 gap-4">
                                <div class="flex flex-col w-full">
                                    <label class="block text-base font-semibold">Birthplace</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        x-model="selectedRequest.birthplace" readonly>
                                </div>
                                <div class="flex flex-col w-full">
                                    <label class="block text-base font-semibold">Birthdate</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        x-model="selectedRequest.formatted_birthdate" readonly>
                                </div>
                                <div class="flex flex-col w-full">
                                    <label class="block text-base font-semibold">Age</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        x-model="selectedRequest.age" readonly>
                                </div>
                            </div>

                            <!-- Years of Stay, Tin, Gross Income -->
                            <div class="grid grid-cols-1 gap-4">
                                <div class="flex flex-col w-full">
                                    <label class="block text-base font-semibold">Years of Stay</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        x-model="selectedRequest.years_stay ?? 'Not Provided'" readonly>
                                </div>
                            </div>

                            <!-- Purpose -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col w-full">
                                    <label class="block text-base font-semibold">Purpose</label>
                                    <input type="text"
                                        class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                        x-model="selectedRequest.user_purpose" readonly>
                                </div>
                                <div class="flex flex-col w-full">
                                    <label class="block text-base font-semibold">Actual Purpose</label>
                                    <div wire:ignore>
                                        <select x-model="selectedRequest.actual_purpose" required
                                            class="normal-dropdown tom-select">
                                            <option value="">Choose Purpose</option>
                                            <option value="Local">Local</option>
                                            <option value="Residency">Residency</option>
                                            <option value="Loan Purpose">Loan Purpose</option>
                                            <option value="Meralco Installation">Meralco Installation
                                            </option>
                                            <option value="Maynilad Installation">Maynilad Installation
                                            </option>
                                            <option value="PWD">PWD</option>
                                            <option value="Solo Parent">Solo Parent</option>
                                            <option value="Senior ID">Senior ID</option>
                                            <option value="Senior Requirements">Senior Requirements
                                            </option>
                                            <option value="4Ps">4Ps</option>
                                            <option value="Tricycle Registration">Tricycle Registration
                                            </option>
                                            <option value="E-trike Registration">E-trike Registration
                                            </option>
                                            <option value="Bank Requirements">Bank Requirements
                                            </option>
                                            <option value="Bail Purpose">Bail Purpose</option>
                                            <option value="Marriage">Marriage</option>
                                            <option value="Work Immersion">Work Immersion</option>
                                            <option value="School Purpose">School Purpose</option>
                                        </select>
                                    </div>
                                    @error('actual_purpose')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Valid ID -->
                            <div class="flex flex-col">
                                <label class="block text-base font-semibold">Valid ID</label>
                                <button
                                    class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                    @click="viewUploadedID = true">
                                    View ID</button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center align-middle gap-6 py-6">

                            <!-- Reject -->
                            <button @click="showRejectionModal = true"
                                class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold"
                                @click="showRejectionModal = true;">
                                Reject
                            </button>

                            <!-- Accept -->
                            <form wire:submit.prevent="approveClearanceRequest"
                                x-on:submit.prevent="$wire.id = selectedRequest.id; $wire.actual_purpose = selectedRequest.actual_purpose;">
                                @csrf
                                @method('PUT')
                                {{-- <input type="hidden" name="id" :value="selectedRequest.id">
                                <input type="hidden" name="actual_purpose" :value="selectedRequest.actual_purpose"> --}}
                                <input type="hidden" name="status" value="Approved">
                                {{-- <input type="hidden" name="activeTab" value="clearanceTab">
                                <input type="hidden" name="activePopup" value="new-clearance-request-tab"> --}}
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
                    {{ $newClearanceRequests->links() }}
                </div>

                <!-- Close Button -->
                <button @click="openClearance = false; activePopup = ''"
                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                    Close
                </button>
            </div>
        @endif
    </div>
</div>
