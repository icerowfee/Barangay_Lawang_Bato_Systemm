<!-- Archive Modal -->
<div wire:poll x-cloak x-show="openArchive"
    class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
    <div class="relative bg-white rounded-lg shadow-md w-3/4 min-h-[77%] overflow-hidden">
        <div class="relative bg-[#0F5192] text-white px-4 py-4 flex-1 items-center">
            <h2 class="text-3xl font-bold text-center self-center">Archives</h2>
        </div>
        @if ($mergedRequests->isEmpty())
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
                    <p class="text-gray-500">Achives are all clear. Completed documents will be
                        displayed here.</p>
                </div>
            </div>
        @else
            <div>
                <table class="min-w-full table-fixed text-base bg-white shadow-md overflow-hidden">
                    <thead>
                        <tr class="bg-gray-400 text-white uppercase tracking-wider text-center">
                            <th class="p-4 px-3 w-12">#</th>
                            <th class="p-4 px-3 w-1/6">Fullname</th>
                            <th class="p-4 px-3 w-2/6">Address</th>
                            <th class="p-4 px-3">Purpose</th>
                            <th class="p-4 px-3">Date</th>
                            <th class="p-4 px-3">Time</th>
                            <th class="p-4 px-3">Type</th>
                            <th class="p-4 px-3 w-1/12">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mergedRequests as $documentRequest)
                            <tr class="cursor-pointer odd:bg-gray-50 even:bg-white hover:bg-slate-200 transition text-center"
                                @click="selectedRequest = JSON.parse(atob('{{ base64_encode(json_encode($documentRequest)) }}')); showArchivedRequests = true;">
                                <td class="border-b p-3 truncate">
                                    {{ ($mergedRequests->currentPage() - 1) * $mergedRequests->perPage() + $loop->iteration }}
                                </td>
                                @if ($documentRequest->document_type === 'indigency')
                                    <td class="border-b p-3 truncate">
                                        {{ $documentRequest->representative_lastname }},
                                        {{ $documentRequest->representative_firstname }}
                                        {{ $documentRequest->representative_middlename }}</td>
                                @else
                                    <td class="border-b p-3 truncate">{{ $documentRequest->lastname }},
                                        {{ $documentRequest->firstname }}
                                        {{ $documentRequest->middlename }}</td>
                                @endif
                                <td class="border-b p-3 truncate max-w-[250px]">{{ $documentRequest->house_number }},
                                    {{ $documentRequest->barangay }}, {{ $documentRequest->city }},
                                    {{ $documentRequest->province }}</td>
                                <td class="border-b p-3 truncate max-w-[180px]">
                                    {{ $documentRequest->actual_purpose ?? 'None' }}</td>
                                <td class="border-b p-3 truncate max-w-[130px]">{{ $documentRequest->formatted_date }}
                                </td>
                                <td class="border-b p-3 truncate max-w-[100px]">{{ $documentRequest->formatted_time }}
                                </td>
                                @if ($documentRequest->document_type === 'cedula')
                                    <td class="border-b p-3 truncate max-w-[130px]">
                                        Cedula
                                    </td>
                                @elseif ($documentRequest->document_type === 'clearance')
                                    <td class="border-b p-3 truncate max-w-[130px]">
                                        Clearance
                                    </td>
                                @elseif ($documentRequest->document_type === 'indigency')
                                    <td class="border-b p-3 truncate max-w-[130px]">
                                        Indigency
                                    </td>
                                @endif
                                <td
                                    class="border-b p-3 text-white
                                                    {{ $documentRequest->status === 'Completed'
                                                        ? 'bg-blue-500'
                                                        : ($documentRequest->status === 'Rejected'
                                                            ? 'bg-red-500'
                                                            : 'bg-gray-500') }}">
                                    {{ $documentRequest->status }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Popup Modal for archived documents -->
                <div x-cloak x-show="showArchivedRequests"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg w-fit h-fit overflow-y-hidden">
                        <!-- Modal Header -->
                        <div class="relative bg-[#0F5192] text-white px-4 py-3 flex-1 items-center">
                            <template x-if="selectedRequest && selectedRequest.document_type === 'cedula'">
                                <h2 class="text-2xl font-bold p-2 text-center">REVIEW ARCHIVED CEDULA REQUEST</h2>
                            </template>

                            <template x-if="selectedRequest && selectedRequest.document_type === 'clearance'">
                                <h2 class="text-2xl font-bold p-2 text-center">REVIEW ARCHIVED CLEARANCE REQUEST</h2>
                            </template>

                            <template x-if="selectedRequest && selectedRequest.document_type === 'indigency'">
                                <h2 class="text-2xl font-bold p-2 text-center">REVIEW ARCHIVED INDIGENCY REQUEST</h2>
                            </template>

                            <button
                                class="absolute top-6 right-6 text-[18px] font-semibold text-white hover:text-red-600 w-[27px]"
                                @click="selectedRequest = null; showArchivedRequests = false">
                                ✕
                            </button>
                        </div>


                        <template x-if="selectedRequest && selectedRequest.document_type === 'cedula'">

                            <!-- Content Panel -->
                            <div>
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
                                            :value="selectedRequest.house_number + ', ' + selectedRequest.barangay + ', ' +
                                                selectedRequest.city + ', ' + selectedRequest.province"
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

                                    <!-- Tin, Gross Income -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="flex flex-col w-full">
                                            <label class="block text-base font-semibold">TIN Number</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                x-model="selectedRequest.tin ?? 'Not Provided'" readonly>
                                        </div>
                                        <div class="flex flex-col w-full">
                                            <label class="block text-base font-semibold">Gross Income</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                x-model="selectedRequest.gross_income ?? 'Not Provided'" readonly>
                                        </div>
                                    </div>

                                    <!-- Valid ID -->
                                    <div class="flex flex-col">
                                        <label class="block text-base font-semibold">Valid ID</label>
                                        <button
                                            class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                            @click="viewUploadedID = true">View ID</button>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-center align-middle gap-6 py-6">
                                    <!-- Reclaim -->
                                    <form action="{{ route('claim.cedula') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" :value="selectedRequest.id">
                                        <input type="hidden" name="activeTab" value="cedulaTab">
                                        <button
                                            class="bg-green-500 text-white px-12 py-2 rounded-md hover:bg-green-600 transition text-lg h-12 font-semibold">
                                            Reclaim
                                        </button>
                                    </form>
                                </div>
                            </div>


                            {{-- <!-- Action Buttons -->
                            <div class="mt-10 flex justify-center items-center gap-6">
                                <!-- Print -->
                                <form action="{{ route('print.cedula') }}" method="GET" target="popupWindow"
                                    onsubmit="return openPopup(this.action)">
                                    <input type="hidden" name="id" :value="selectedRequest.id">
                                    <button
                                        class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                        Print
                                    </button>
                                </form>
                            </div> --}}
                        </template>



                        <template x-if="selectedRequest && selectedRequest.document_type === 'clearance'">
                            <!-- Content Panel -->
                            <div>
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
                                                ', ' + selectedRequest.city + ', ' + selectedRequest.province"
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
                                        <div wire:ignore class="flex flex-col w-full">
                                            <label class="block text-base font-semibold">Actual Purpose</label>
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                x-model="selectedRequest.actual_purpose ?? 'Not Provided'" readonly>
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
                                    <!-- Print -->
                                    <form action="{{ route('print.clearance') }}" method="GET"
                                        target="popupWindow" onsubmit="return openPopup(this.action)">
                                        <input type="hidden" name="id" :value="selectedRequest.id">
                                        <input type="hidden" name="actual_purpose"
                                            :value="selectedRequest.actual_purpose">
                                        <input type="hidden" name="activeTab" value="clearanceTab">
                                        <button
                                            class="bg-green-500 text-white px-12 py-2 rounded-md hover:bg-green-600 transition text-lg h-12 font-semibold">
                                            Print
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- <!-- Action Buttons -->
                            <div class="mt-8 flex justify-center gap-6">
                                <!-- Print -->
                                <form action="{{ route('print.clearance') }}" method="GET"
                                    target="popupWindow" onsubmit="return openPopup(this.action)">
                                    <input type="hidden" name="id" :value="selectedRequest.id">
                                    <input type="hidden" name="actual_purpose"
                                        :value="selectedRequest.actual_purpose">
                                    <button
                                        class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                        Print
                                    </button>
                                </form>
                            </div> --}}
                        </template>



                        <template x-if="selectedRequest && selectedRequest.document_type === 'indigency'">
                            <!-- Content Panel -->
                            <div>
                                <!-- Content Panel -->
                                <div class="space-y-4 px-12 py-4">

                                    <!-- ID -->
                                    <div class="flex flex-col">
                                        <input type="hidden" x-model="selectedRequest.id">
                                    </div>

                                    <div class="flex flex-col">
                                        <label><strong>RECIPIENT INFORMATION</strong></label>
                                        <div class="grid grid-cols-3 gap-4">
                                            <!-- Name -->
                                            <div class="flex flex-col">
                                                <label class="block text-base font-semibold">Lastname</label>
                                                <input type="text"
                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                    :value="selectedRequest.recipient_lastname" readonly>
                                            </div>
                                            <div class="flex flex-col">
                                                <label class="block text-base font-semibold">Firstname</label>
                                                <input type="text"
                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                    :value="selectedRequest.recipient_firstname" readonly>
                                            </div>
                                            <div class="flex flex-col">
                                                <label class="block text-base font-semibold">Middlename</label>
                                                <input type="text"
                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                    :value="selectedRequest.recipient_middlename ?? 'N/A'" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col">
                                        <label><strong>REPRESENTATIVE INFORMATION</strong></label>
                                        <div class="grid grid-cols-3 gap-4">
                                            <!-- Name -->
                                            <div class="flex flex-col">
                                                <label class="block text-base font-semibold">Lastname</label>
                                                <input type="text"
                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                    :value="selectedRequest.representative_lastname" readonly>
                                            </div>
                                            <div class="flex flex-col">
                                                <label class="block text-base font-semibold">Firstname</label>
                                                <input type="text"
                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                    :value="selectedRequest.representative_firstname" readonly>
                                            </div>
                                            <div class="flex flex-col">
                                                <label class="block text-base font-semibold">Middlename</label>
                                                <input type="text"
                                                    class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                    :value="selectedRequest.representative_middlename ?? 'N/A'"
                                                    readonly>
                                            </div>
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
                                            <input type="text"
                                                class="w-full border border-gray-400 rounded px-3 py-2 bg-white text-gray-900"
                                                x-model="selectedRequest.actual_purpose ?? 'Not Provided'" readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4">
                                        <!-- Valid ID -->
                                        <div class="flex flex-col">
                                            <label class="block text-base font-semibold">Valid ID</label>
                                            <button
                                                class="bg-[#F7F8FF] w-full border border-blue-600 rounded px-3 py-2 hover:bg-[#E2E5FA] text-[#034EC5] font-semibold"
                                                @click="viewUploadedID = true">View
                                                ID</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex justify-center align-middle gap-6 py-6">

                                    <!-- Print -->
                                    <form action="{{ route('print.indigency') }}" method="GET"
                                        target="popupWindow" onsubmit="return openPopup(this.action)">
                                        <input type="hidden" name="id" :value="selectedRequest.id">
                                        <input type="hidden" name="cedula_number"
                                            :value="selectedRequest.cedula_number">
                                        <input type="hidden" name="actual_purpose"
                                            :value="selectedRequest.actual_purpose">
                                        <input type="hidden" name="activeTab" value="indigencyTab">
                                        <button
                                            class="bg-green-500 text-white px-12 py-2 rounded-md hover:bg-green-600 transition text-lg h-12 font-semibold">
                                            Print
                                        </button>
                                    </form>

                                </div>
                            </div>

                            {{-- <!-- Action Buttons -->
                            <div class="mt-8 flex justify-center gap-6">
                                <!-- Print -->
                                <form action="{{ route('print.indigency') }}" method="GET" target="popupWindow"
                                    onsubmit="return openPopup(this.action)">
                                    <input type="hidden" name="id" :value="selectedRequest.id">
                                    <input type="hidden" name="cedula_number"
                                        :value="selectedRequest.cedula_number">
                                    <input type="hidden" name="actual_purpose"
                                        :value="selectedRequest.actual_purpose">
                                    <button
                                        class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                        Print
                                    </button>
                                </form>
                            </div> --}}
                        </template>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 flex w-full items-center p-8 pt-6 space-x-6">
                <div class="flex-1">
                    {{ $mergedRequests->links() }}
                </div>

                <!-- Close Button -->
                <button @click="openArchive = false"
                    class="bg-red-500 text-white px-12 py-2 rounded-md hover:bg-red-600 transition text-lg h-12 font-semibold">
                    Close
                </button>
            </div>
        @endif
    </div>
</div>
