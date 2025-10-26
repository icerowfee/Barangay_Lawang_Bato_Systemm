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



        @switch($activeTab)
            @case('new-company-request-tab')
                <!-- Header -->
                <div class="flex items-start justify-between">
                    <div class="flex flex-col items-center space-x-2">
                        <div class="mb-4 flex justify-center h-14">
                            <!-- You can replace this with an actual SVG or image if needed -->
                            <img src="{{ asset('images/information-icon.png') }}" alt="Information Icon">
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Reject New Company Account Request</h2>
                    </div>
                </div>

                <!-- Reject -->
                <form wire:submit.prevent="rejectCompanyAccountRequest" x-on:submit.prevent="$wire.id = selectedRequest.id;">
                    @csrf
                    @method('PUT')

                    <!-- Body -->
                    <div class="flex flex-col justify-center mt-4">
                        <p class="text-sm text-center text-gray-600">
                            You are about to reject this new Company Account request. <br>
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

            @case('applicantsTab')
                <!-- Header -->
                <div class="flex items-start justify-between">
                    <div class="flex flex-col items-center space-x-2">
                        <div class="mb-4 flex justify-center h-14">
                            <!-- You can replace this with an actual SVG or image if needed -->
                            <img src="{{ asset('images/information-icon.png') }}" alt="Information Icon">
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Reject New Applicant Request</h2>
                    </div>
                </div>

                <!-- Reject -->
                <form wire:submit.prevent="rejectApplicationRequest" x-on:submit.prevent="$wire.id = selectedRequest.id;">
                    @csrf
                    @method('PUT')

                    <!-- Body -->
                    <div class="flex flex-col justify-center mt-4">
                        <p class="text-sm text-center text-gray-600">
                            You are about to reject this Applicant request. <br>
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

            @case('jobListingsTab')
                <!-- Header -->
                <div class="flex items-start justify-between">
                    <div class="flex flex-col items-center space-x-2">
                        <div class="mb-4 flex justify-center h-14">
                            <!-- You can replace this with an actual SVG or image if needed -->
                            <img src="{{ asset('images/information-icon.png') }}" alt="Information Icon">
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Reject New Job Listing Request</h2>
                    </div>
                </div>

                <!-- Reject -->
                <form wire:submit.prevent="rejectJobListing" x-on:submit.prevent="$wire.id = selectedRequest.id;">
                    @csrf
                    @method('PUT')

                    <!-- Body -->
                    <div class="flex flex-col justify-center mt-4">
                        <p class="text-sm text-center text-gray-600">
                            You are about to reject this new Job Listing request. <br>
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
                <!--For User Account Tab -->

                <!-- Header -->
                <div class="flex items-start justify-between">
                    <div class="flex flex-col items-center space-x-2">
                        <div class="mb-4 flex justify-center h-14">
                            <!-- You can replace this with an actual SVG or image if needed -->
                            <img src="{{ asset('images/information-icon.png') }}" alt="Information Icon">
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Reject New User Account Request</h2>
                    </div>
                </div>

                <!-- Reject -->
                <form wire:submit.prevent="rejectAccountRequest" x-on:submit.prevent="$wire.id = selectedRequest.id;">
                    @csrf
                    @method('PUT')

                    <!-- Body -->
                    <div class="flex flex-col justify-center mt-4">
                        <p class="text-sm text-center text-gray-600">
                            You are about to reject this new User Account request. <br>
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
            @break
        @endswitch
    </div>
</div>
