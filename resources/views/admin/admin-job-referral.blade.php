<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Referral Management</title>
</head>

<body class="flex h-screen bg-gray-100" x-data="{
    openNewApplicationRequestModal: false,
    selectedRequest: null,

    viewUploadedValidId: false,
    viewUploadedSecondaryValidId: false,
    viewUploadedResume: false,

    {{-- viewUploadedSssId: false,
    viewUploadedTinId: false,
    viewUploadedPagibigId: false,
    viewUploadedPoliceClearance: false,
    viewUploadedNbiClearance: false,
    viewUploadedCedula: false,
    viewUploadedBarangayClearance: false, --}}

    showProcessingApplicationData: false,
    showNewApplicationRequestData: false,
    showArchivedApplicationData: false,

    showRejectionModal: false,

    successMessage: '',
    errorMessage: '',


    openArchive: false,
    showArchivedRequests: false,


    showNewApplicationRequestIndication: {{ $newApplicationRequests->isNotEmpty() ? 'true' : 'false' }},

    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},
    activeTab: '{{ session('activeTab') ?? '' }}'

}"
    x-on:show-success-toast.window="
        showSuccessNotificationToast = true;
        successMessage = $event.detail.message;
        setTimeout(() => showSuccessNotificationToast = false, 3000);

        selectedRequest = null;

        showProcessingApplicationData = false;
        showNewApplicationRequestData = false;
        showArchivedApplicationData = false;

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

        showProcessingApplicationData = false;
        showNewApplicationRequestData = false;
        showArchivedApplicationData = false;

        showRejectionModal = false;

        successMessage = '';
        errorMessage = '';
        
        showRejectionModal = false;     
">


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
            <h1 class="text-4xl font-bold mb-8">Manage Applicants</h1>

            <!-- Tab Content -->
            <div class="mx-auto h-[86.5%] w-full bg-white shadow-lg rounded-lg p-6">

                <livewire:show-approved-applicants />

                <livewire:show-pending-applicants />

            </div>

            <!-- Archived Requests Button -->
            <div>
                <div class="flex flex-row-reverse w-full">
                    <button
                        class="mt-6 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md"
                        @click="openArchive = true">
                        Archives
                    </button>
                </div>

                <livewire:show-archived-applicants />

            </div>
        </div>



        {{-- Show Main Valid ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedValidId">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto"
                @click.away="viewUploadedValidId = false">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedValidId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Valid ID</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.user.valid_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.valid_id" alt="Uploaded ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>


        {{-- Show Second Valid ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedSecondaryValidId">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto"
                @click.away="viewUploadedSecondaryValidId = false">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedSecondaryValidId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Second Valid ID</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.secondary_valid_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.secondary_valid_id" alt="Uploaded ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>


        {{-- Show Uploaded resume --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedResume">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden"
                @click.away="viewUploadedResume = false">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                    @click="viewUploadedResume = false">
                    ✕
                </button>

                <!-- Modal Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Resume</p>

                <!-- PDF Display -->
                <template x-if="selectedRequest.resume">
                    <iframe :src="'/storage/' + selectedRequest.resume" class="flex-1 w-full rounded-lg border"
                        frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>

        {{-- Show Cedula Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedCedula" @click.away="viewUploadedCedula = false">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedCedula = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Cedula</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.cedula">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.cedula" alt="Uploaded Cedula"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Show SSS ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedSssId" @click.away="viewUploadedSssId = false">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedSssId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded SSS ID</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.sss_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.sss_id" alt="Uploaded SSS ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Show TIN ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedTinId" @click.away="viewUploadedTinId = false">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedTinId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded TIN ID</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.tin_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.tin_id" alt="Uploaded TIN ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Show Pag-ibig ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedPagibigId" @click.away="viewUploadedPagibigId = false">

            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[900px] h-auto">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedPagibigId = false">
                    ✕
                </button>

                <!-- Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Pag-ibig ID</p>

                <!-- Image Display -->
                <template x-if="selectedRequest.pagibig_id">
                    <div class="flex justify-center">
                        <div class="w-[600px] h-[380px] border rounded-lg overflow-hidden shadow">
                            <img :src="'/storage/' + selectedRequest.pagibig_id" alt="Uploaded Pag-ibig ID"
                                class="object-cover w-full h-full" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Show Uploaded Police Clearance --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedPoliceClearance" @click.away="viewUploadedPoliceClearance = false">

            <div
                class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                    @click="viewUploadedPoliceClearance = false">
                    ✕
                </button>

                <!-- Modal Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Police Clearance</p>

                <!-- PDF Display -->
                <template x-if="selectedRequest.police_clearance">
                    <iframe :src="'/storage/' + selectedRequest.police_clearance"
                        class="flex-1 w-full rounded-lg border" frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>

        {{-- Show Uploaded NBI Clearance --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedNbiClearance" @click.away="viewUploadedNbiClearance = false">

            <div
                class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                    @click="viewUploadedNbiClearance = false">
                    ✕
                </button>

                <!-- Modal Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded NBI Clearance</p>

                <!-- PDF Display -->
                <template x-if="selectedRequest.nbi_clearance">
                    <iframe :src="'/storage/' + selectedRequest.nbi_clearance" class="flex-1 w-full rounded-lg border"
                        frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>

        {{-- Show Uploaded Barangay Clearance --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedBarangayClearance" @click.away="viewUploadedBarangayClearance = false">

            <div
                class="relative bg-white p-6 rounded-lg shadow-lg w-[90%] max-w-[1200px] h-[90%] flex flex-col overflow-hidden">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg z-10"
                    @click="viewUploadedBarangayClearance = false">
                    ✕
                </button>

                <!-- Modal Title -->
                <p class="text-center text-xl font-semibold mb-4">Uploaded Barangay Clearance</p>

                <!-- PDF Display -->
                <template x-if="selectedRequest.barangay_clearance">
                    <iframe :src="'/storage/' + selectedRequest.barangay_clearance"
                        class="flex-1 w-full rounded-lg border" frameborder="0">
                    </iframe>
                </template>
            </div>
        </div>

        {{-- Action Successful Toast --}}
        <div x-cloak x-show="showSuccessNotificationToast" x-transition x-cloak x-init="setTimeout(() => showSuccessNotificationToast = false, 3000)"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">

            {{ session('success') }}
        </div>
        @livewireScripts
    </div>
</body>

</html>
