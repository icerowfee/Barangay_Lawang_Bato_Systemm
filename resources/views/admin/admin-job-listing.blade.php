<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Listings</title>
</head>

<body class="flex h-screen bg-gray-100" x-data="{
    openNewJobListingModal: false,
    selectedJobListing: null,

    showApprovedJobListingDetails: false,
    showNewJobListingDetails: false,

    showRejectionModal: false,

    successMessage: '',
    errorMessage: '',


    openArchive: false,
    showArchivedRequests: false,

    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},
    activeTab: '{{ session('activeTab') ?? '' }}',
    showNewJobListingIndication: {{ $newJobListings->isNotEmpty() ? 'true' : 'false' }},
}"
    x-on:show-success-toast.window="
        showSuccessNotificationToast = true;
        successMessage = $event.detail.message;
        setTimeout(() => showSuccessNotificationToast = false, 3000);

        selectedRequest = null;

        showApprovedJobListingDetails = false;
        showNewJobListingDetails = false;

        showRejectionModal = false;

        successMessage = '';
        errorMessage = '';
        
        showRejectionModal = false;
        "
    x-on:show-error-toast.window="
        showErrorNotificationToast = true;
        errorMessage = $event.detail.message;
        setTimeout(() => showErrorNotificationToast = false, 3000);
        
        selectedRequest = null;

        showApprovedJobListingDetails = false;
        showNewJobListingDetails = false;

        showRejectionModal = false;

        successMessage = '';
        errorMessage = '';
        
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
            <h1 class="text-4xl font-bold mb-8">Manage Job Listings</h1>

            <!-- Tab Content -->
            <div class="mx-auto h-[88%] w-full bg-white shadow-lg rounded-lg p-6">

                <livewire:show-approved-job-listing />

                <livewire:show-pending-job-listing />
                
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

    </div>
</body>

</html>
