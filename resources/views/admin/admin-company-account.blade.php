<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Company Accounts</title>
</head>

<body class="flex h-screen bg-gray-100" x-data="{
    openNewAccountRequestModal: false,
    selectedRequest: null,

    viewUploadedID: false,
    viewUpleadedRegistrationDocument: false,

    showApprovedAccountRequestData: false,
    showNewAccountRequestData: false,
    showArchivedCompanyAccountsData: false,

    showRejectionModal: false,

    successMessage: '',
    errorMessage: '',

    openArchive: false,

    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},
    activeTab: '{{ session('activeTab') ?? '' }}',
    showNewUserAccountRequestIndication: {{ $newCompanyAccountRequests->isNotEmpty() ? 'true' : 'false' }},
}"
    x-on:show-success-toast.window="
        showSuccessNotificationToast = true;
        successMessage = $event.detail.message;
        setTimeout(() => showSuccessNotificationToast = false, 3000);

        selectedRequest = null;

        showApprovedAccountRequestData: false,
        showNewAccountRequestData: false,
        showArchivedCompanyAccountsData: false,

        showRejectionModal: false,

        successMessage: '',
        errorMessage: '',
        
        showRejectionModal = false;
        "
    x-on:show-error-toast.window="
        showErrorNotificationToast = true;
        errorMessage = $event.detail.message;
        setTimeout(() => showErrorNotificationToast = false, 3000);
        
        selectedRequest = null;

        showApprovedAccountRequestData: false,
        showNewAccountRequestData: false,
        showArchivedCompanyAccountsData: false,

        showRejectionModal: false,

        successMessage: '',
        errorMessage: '',
        
        showRejectionModal = false;     
">

    <!-- Sidebar -->
    @include('admin/admin-side-panel')

    <!-- Main Content (Placeholder) -->
    <div class="relative h-screen flex-1 overflow-hidden">

        <!-- Background image -->
        <div class="absolute w-full left-1/3 inset-0 opacity-5 flex justify-center items-center pointer-events-none">
            <img src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo"
                class="h-[135vh] w-[135vh] select-none">
        </div>

        <!-- Foreground Content -->
        <div class="relative h-screen flex-1 p-8 flex flex-col overflow-hidden z-10">
            <h1 class="text-4xl font-bold mb-8">Manage Company Accounts</h1>

            <!-- Tab Content -->
            <div class="mx-auto h-[86.5%] w-full bg-white shadow-lg rounded-lg p-6">

                <livewire:show-approved-company-accounts />


            </div>

            <livewire:show-pending-company-accounts />

        </div>

        <!-- Archived Requests Button -->
        <div>
            <div class="flex flex-row-reverse w-full">
                <button
                    class="mt-6 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md"
                    @click="openArchive = true">
                    Archived Accounts
                </button>
            </div>

            <livewire:show-archived-company-accounts />

        </div>


        <!-- Rejection Modal -->
        <livewire:show-job-referral-admin-rejection-modal
            activeTab="{{ session('activeTab', 'new-company-request-tab') }}" />



        {{-- Show Uploaded NBI Clearance --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUpleadedRegistrationDocument" @click.away="viewUpleadedRegistrationDocument = false">

            <div
                class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                    @click="viewUpleadedRegistrationDocument = false">
                    ✕
                </button>

                <!-- Modal Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Business Registration</p>

                <!-- PDF Display -->
                <template x-if="selectedRequest.registration_document">
                    <iframe :src="'/storage/' + selectedRequest.registration_document"
                        class="flex-1 w-full rounded-lg border" frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>

        {{-- Show Valid ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedID" @click.away="viewUploadedID = false">
            <div class="relative bg-white p-4 rounded-lg shadow-lg w-[80%] max-w-[1000px]">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedID = false">
                    ✕
                </button>

                <!-- Image Display -->
                <template x-if="selectedRequest.contact_person_valid_id">
                    <div class="mt-6">
                        <p class="text-center text-lg font-semibold mb-4">Uploaded ID</p>
                        <img :src="'/storage/' + selectedRequest.contact_person_valid_id" alt="Uploaded ID"
                            class="w-full max-h-[400px] object-contain rounded-lg border" />
                    </div>
                </template>
            </div>
        </div>

        {{-- Action Successful Toast --}}
        <div x-cloak x-show="showSuccessNotificationToast" x-transition x-init="setTimeout(() => showSuccessNotificationToast = false, 3000)"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
            <span x-text="successMessage"></span>
        </div>

        {{-- Action Error Toast --}}
        <div x-cloak x-show="showErrorNotificationToast" x-transition
            class="fixed top-20 right-5 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <span x-text="errorMessage"></span>
        </div>

    </div>

    @livewireScripts

</body>

</html>
