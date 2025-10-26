{{-- Reject Document Request Modal --}}
<div x-cloak x-show="showRejectionModal"
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div
        class="relative bg-white flex flex-col items-center w-full max-w-md m-auto max-h-fit rounded-2xl shadow-lg p-6 pt-8">
        <!-- Close Button -->
        <button
            class="absolute top-4 right-4 self-end text-[18px] font-semibold text-gray-700 hover:text-red-600 w-[27px]"
            @click="showRejectionModal = false">
            ✕
        </button>

        <!-- Header -->
        <div class="flex items-start justify-between">
            <div class="flex flex-col items-center space-x-2">
                <div class="mb-4 flex justify-center h-14">
                    <!-- You can replace this with an actual SVG or image if needed -->
                    <img src="{{ asset('images/information-icon.png') }}" alt="Information Icon">
                </div>
                <h2 class="text-xl font-bold text-gray-800">Reject Document Request</h2>
            </div>
        </div>


        @switch($activeTab)
            @case('clearanceTab')
                <!-- Reject -->
                <form wire:submit.prevent="rejectClearanceRequest" x-on:submit.prevent="$wire.id = selectedRequest.id;">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" wire:model="id" :value="selectedRequest.id"> --}}
                    {{-- <input type="hidden" wire:model="activeTab" value="clearanceTab">

                    <template x-if="showNewClearanceRequests">
                        <input type="hidden" wire:model="activePopup" value="new-clearance-request-tab">
                    </template> --}}

                    <!-- Body -->
                    <div class="flex flex-col justify-center mt-4">
                        <p class="text-sm text-center text-gray-600">
                            You are about to reject this Clearance request. <br>
                            Please select a reason before proceeding.
                        </p>

                        <!-- Select -->
                        <select wire:model="rejecting_reason" required
                            class="m-4 rounded-md normal-dropdown tom-select-for-rejection">
                            <option value="">Select Reason</option>
                            <option value="Invalid ID">Invalid ID</option>
                            <option value="Incomplete requirements">Blurry ID Upload</option>
                            <option value="Mismatched Information">Mismatched Information</option>
                            <option value="Duplicate request">Duplicate Request</option>
                            <option value="You are not from Barangay Lawang Bato">Outside Jurisdiction</option>
                            <option value="Invalid Purpose">Invalid Purpose</option>
                            <option value="Incorrect Document Type Requested">Incorrect Document Type Requested
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-center gap-3">
                        <button type="button" @click="showRejectionModal = false"
                            class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100">
                            No
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                            Yes
                        </button>
                    </div>
                </form>
            @break

            @case('indigencyTab')
                <!-- Reject -->
                <form wire:submit.prevent="rejectIndigencyRequest" x-on:submit.prevent="$wire.id = selectedRequest.id;">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" wire:model="id" :value="selectedRequest.id"> --}}
                    {{-- <input type="hidden" wire:model="activeTab" value="indigencyTab">

                    <template x-if="showNewIndigencyRequests">
                        <input type="hidden" wire:model="activePopup" value="new-indigency-request-tab">
                    </template> --}}

                    <!-- Body -->
                    <div class="flex flex-col justify-center mt-4">
                        <p class="text-sm text-center text-gray-600">
                            You are about to reject this Indigency request. <br>
                            Please select a reason before proceeding.
                        </p>

                        <!-- Select -->
                        <select wire:model="rejecting_reason" required
                            class="m-4 rounded-md normal-dropdown tom-select-for-rejection">
                            <option value="">Select Reason</option>
                            <option value="Invalid ID">Invalid ID</option>
                            <option value="Incomplete requirements">Blurry ID Upload</option>
                            <option value="Invalid information">Mismatched Information</option>
                            <option value="Duplicate request">Duplicate Request</option>
                            <option value="Outside Jurisdiction">Outside Jurisdiction</option>
                            <option value="Invalid Purpose">Invalid Purpose</option>
                            <option value="Incorrect Document Type Requested">Incorrect Document Type Requested
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-center gap-3">
                        <button type="button" @click="showRejectionModal = false"
                            class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100">
                            No
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                            Yes
                        </button>
                    </div>
                </form>
            @break

            @default
                <!--For Cedula Tab -->
                <!-- Reject -->
                <form wire:submit.prevent="rejectCedulaRequest"
                    x-on:submit.prevent="$wire.id = selectedRequest.id;">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" wire:model="id"> --}}
                    {{-- <input type="hidden" wire:model="activeTab" value="cedulaTab">

                    <template x-if="showNewCedulaRequests">
                        <input type="hidden" wire:model="activePopup" value="new-cedula-request-tab">
                    </template> --}}

                    <!-- Body -->
                    <div class="flex flex-col justify-center mt-4">
                        <p class="text-sm text-center text-gray-600">
                            You are about to reject this Cedula request. <br>
                            Please select a reason before proceeding.
                        </p>

                        <!-- Select -->
                        <select wire:model="rejecting_reason" required
                            class="m-4 rounded-md normal-dropdown tom-select-for-rejection">
                            <option value="">Select Reason</option>
                            <option value="Invalid ID">Invalid ID</option>
                            <option value="Incomplete requirements">Blurry ID Upload</option>
                            <option value="Invalid information">Mismatched Information</option>
                            <option value="Duplicate request">Duplicate Request</option>
                            <option value="Invalid Purpose">Invalid Purpose</option>
                            <option value="No Paper Available For Your City">No Available Paper For Your City</option>
                            <option value="Incorrect Document Type Requested">Incorrect Document Type Requested
                            </option>
                        </select>
                    </div>

                    <div class="flex justify-center gap-3">
                        <button type="button" @click="showRejectionModal = false"
                            class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100">
                            No
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                            Yes
                        </button>
                    </div>
                </form>
        @endswitch

    </div>
</div>
