<div>
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold text-center self-center">Approved Clearance Requests</h2>

        <div class="flex gap-4 items-center">
            {{-- filters --}}
            <div class="flex gap-4 items-center">
                <!-- Search Input -->
                <div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search name..."
                        class="border border-gray-400 p-2 rounded w-64 h-[41px]">
                </div>

                <div class="flex gap-4 items-center mb-0">

                    <div x-data="{ open: false }" class="relative w-full">
                        <select wire:model.live="sort_by" @click="open = !open" @blur="open = false"
                            class="appearance-none border border-gray-400 cursor-pointer p-2 pl-3 pr-8 rounded">
                            <option value="name">Sort by Name</option>
                            <option value="date">Sort by Date</option>
                            <option value="purpose">Sort by Purpose</option>
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

            <button @click="openClearance = true"
                class="relative px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md">
                New Requests
                <span x-cloak x-show="showNewClearanceRequestIndication"
                    x-transition:enter="transform scale-200 opacity-0"
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
        @if ($approvedClearanceRequests->isEmpty())
            <div class="w-full h-full flex items-center justify-center">
                <div class="mb-40 text-center">
                    <!-- Icon / Illustration -->
                    <div class="mb-4 flex justify-center h-32">
                        <!-- You can replace this with an actual SVG or image if needed -->
                        <img src="{{ asset('images/approve-document-icon.png') }}" alt="No Admin">
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-semibold text-gray-600 mb-2">No Accepted Clearance Yet
                    </h2>

                    <!-- Subtitle -->
                    <p class="text-gray-500">Once you start approving requests, they’ll show up
                        here.</p>
                </div>
            </div>
        @else
            <div>
                <table class="min-w-full table-fixed text-base bg-white rounded-lg shadow-md overflow-hidden">
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
                        @foreach ($approvedClearanceRequests as $approvedRequest)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedRequest = JSON.parse(atob('{{ base64_encode(json_encode($approvedRequest)) }}')); showAcceptedClearanceModal = true;">
                                <td class="border-b p-3 truncate">
                                    {{ ($approvedClearanceRequests->currentPage() - 1) * $approvedClearanceRequests->perPage() + $loop->iteration }}
                                </td>
                                <td class="border-b p-3 truncate">{{ $approvedRequest->lastname }},
                                    {{ $approvedRequest->firstname }}
                                    {{ $approvedRequest->middlename }}</td>
                                <td class="border-b p-3 truncate max-w-[250px]">{{ $approvedRequest->house_number }},
                                    {{ $approvedRequest->barangay }},
                                    {{ $approvedRequest->city }}, {{ $approvedRequest->province }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[180px]">{{ $approvedRequest->actual_purpose }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[130px]">{{ $approvedRequest->formatted_date }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[100px]">{{ $approvedRequest->formatted_time }}
                                </td>
                                <td class="border-b p-3 truncate">
                                    <span
                                        class="text-white text-center font-medium px-3 py-2 rounded-md
                                                                {{ $approvedRequest->status === 'Approved'
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

                <!-- Popup Modal for Accepted Clearance Requests -->
                <div x-cloak x-show="showAcceptedClearanceModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-2/5 h-fit overflow-y-hidden">
                        <!-- Modal Header -->
                        <div class="relative bg-[#0F5192] text-white px-4 py-3 flex-1 items-center">
                            <h2 class="text-2xl font-bold p-2 text-center">APPROVED CLEARACE REQUEST</h2>
                            <button
                                class="absolute top-6 right-6 text-[18px] font-semibold text-white hover:text-red-600 w-[27px]"
                                @click="selectedRequest = null; showAcceptedClearanceModal = false">
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
                                        :value="selectedRequest.middlename" readonly>
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

                            <!-- Years of Stay -->
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
                                <div wire:ignore class="flex flex-col w-full">
                                    <label class="block text-base font-semibold">Actual Purpose</label>
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

                            <!-- Print -->
                            <form action="{{ route('print.clearance') }}" method="GET" target="popupWindow"
                                onsubmit="return openPopup(this.action)">
                                <input type="hidden" name="id" :value="selectedRequest.id">
                                <input type="hidden" name="actual_purpose" :value="selectedRequest.actual_purpose">
                                <input type="hidden" name="activeTab" value="clearanceTab">
                                <button
                                    class="bg-green-500 text-white px-12 py-2 rounded-md hover:bg-green-600 transition text-lg h-12 font-semibold">
                                    Print
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="mt-4">
            {{ $approvedClearanceRequests->links() }}
        </div>
    </div>
</div>
