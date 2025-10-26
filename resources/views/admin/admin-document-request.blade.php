<!-- filepath: /c:/xampp/htdocs/Barangay_Lawang_Bato_System/resources/views/admin-document-request.blade.php -->
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document Requests</title>
</head>

<body class="flex h-screen bg-gray-100" x-data="{
    openCedula: false,
    openClearance: false,
    openIndigency: false,
    selectedRequest: null,
    viewUploadedID: false,
    viewUploadedCedulaImage: false,
    showModal: false,
    editCedulaNumber: false,
    showAcceptedIndigencyModal: false,
    showAcceptedClearanceModal: false,
    showAcceptedCedulaModal: false,

    showNewIndigencyRequests: false,
    showNewClearanceRequests: false,
    showNewCedulaRequests: false,
    showArchivedRequests: false,

    showRejectionModal: false,

    activeTab: '{{ request('activeTab') ?? 'cedulaTab' }}',
    activePopup: '{{ session('activePopup') ?? '' }}',
    openArchive: false,


    showNewCedulaRequestIndication: false,
    showNewClearanceRequestIndication: false,
    showNewIndigencyRequestIndication: false,

    cedula_search: '{{ request('cedula_search') }}',
    clearance_search: '{{ request('clearance_search') }}',
    indigency_search: '{{ request('indigency_search') }}',


    tempRequest: null, // Holds a temporary copy for editing
    showSuccessNotificationToast: false,
    successMessage: '',

    showErrorNotificationToast: false,
    errorMessage: '',



    startEditing() {
        this.tempRequest = JSON.parse(JSON.stringify(this.selectedRequest)); // Create a deep copy
        this.editCedulaNumber = true;
    },
    cancelEditing() {
        this.selectedRequest = JSON.parse(JSON.stringify(this.tempRequest)); // Restore values
        this.editCedulaNumber = false;
    },

}"
    x-on:new-cedula-request-detected.window="showNewCedulaRequestIndication = true"
    x-on:no-new-cedula-request.window="showNewCedulaRequestIndication = false"
    x-on:new-clearance-request-detected.window="showNewClearanceRequestIndication = true"
    x-on:no-new-clearance-request.window="showNewClearanceRequestIndication = false"
    x-on:new-indigency-request-detected.window="showNewIndigencyRequestIndication = true"
    x-on:no-new-indigency-request.window="showNewIndigencyRequestIndication = false"
    x-on:show-success-toast.window="
        showSuccessNotificationToast = true;
        successMessage = $event.detail.message;
        setTimeout(() => showSuccessNotificationToast = false, 3000);
        selectedRequest = null;

        showAcceptedIndigencyModal = false;
        showAcceptedClearanceModal = false;
        showAcceptedCedulaModal = false;

        showNewIndigencyRequests = false;
        showNewClearanceRequests = false;
        showNewCedulaRequests = false;
        showArchivedRequests = false;
        
        showRejectionModal = false;
        "
    x-on:show-error-toast.window="
        showErrorNotificationToast = true;
        errorMessage = $event.detail.message;
        setTimeout(() => showErrorNotificationToast = false, 3000);
        
        selectedRequest = null;
        showNewCedulaRequests = false;
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
            <h1 class="text-4xl font-bold mb-8">Document Requests</h1>

            <div class="h-[86.5%]">
                <div class="mx-auto min-h-full bg-white shadow-lg rounded-lg p-6">
                    <!-- Tabs -->
                    <div class="grid grid-cols-3 w-2/6 border-b overflow-y-hidden min-h-14">
                        <button @click="activeTab = 'cedulaTab'; window.location='?activeTab=cedulaTab';"
                            :class="activeTab === 'cedulaTab' ? 'border-blue-500 text-blue-600 font-bold' :
                                'text-gray-600 hover:text-blue-400'"
                            class="py-2 px-4 text-xl font-semibold focus:outline-none border-b-4 transition-all">
                            Cedula <span x-cloak x-show="showNewCedulaRequestIndication"
                                class=" text-red-600 text-[28px]">•</span>
                        </button>
                        <button @click="activeTab = 'clearanceTab'; window.location='?activeTab=clearanceTab';"
                            :class="activeTab === 'clearanceTab' ? 'border-blue-500 text-blue-600 font-bold' :
                                'text-gray-600 hover:text-blue-400'"
                            class="py-2 px-4 text-xl font-semibold focus:outline-none border-b-4 transition-all">
                            Clearance <span x-cloak x-show="showNewClearanceRequestIndication"
                                class=" text-red-600 text-[28px]">•</span>
                        </button>
                        <button @click="activeTab = 'indigencyTab'; window.location='?activeTab=indigencyTab';"
                            :class="activeTab === 'indigencyTab' ? 'border-blue-500 text-blue-600 font-bold' :
                                'text-gray-600 hover:text-blue-400'"
                            class="py-2 px-4 text-xl font-semibold focus:outline-none border-b-4 transition-all">
                            Indigency <span x-cloak x-show="showNewIndigencyRequestIndication"
                                class=" text-red-600 text-[28px]">•</span>
                        </button>
                    </div>



                    <!-- Tab Contents -->
                    <div class="p-4 max-h-[550px]">

                        {{-- Cedula Tab --}}
                        <div x-cloak x-show="activeTab === 'cedulaTab'" class="h-full">
                            {{-- <div>
                            <div class="flex justify-between mb-4">
                                <h2 class="text-2xl font-bold text-center self-center">Approved Cedula Requests</h2>

                                <div class="flex gap-4 items-center" x-data="{
                                    clearFilter() {
                                        cedula_search = '';
                                        this.cedula_sort_by = '';
                                        this.cedula_sort_dir = '';
                                    }
                                }">
                                    <!-- Filters -->
                                    <div class="flex gap-4 items-center">
                                        <!-- Search Input -->
                                        <div x-init="$nextTick(() => { if (cedula_search) $refs.cedulaSearchInput.focus(); })">
                                            <input x-ref="cedulaSearchInput" type="text" placeholder="Search name..."
                                                class="border border-gray-400 p-2 rounded w-64 h-[41px]"
                                                x-model.debounce.500ms="cedula_search"
                                                @input.debounce.500ms="
                                                $refs.cedulaSearchInput.blur(); 
                                                window.location.href = `{{ route('admin.document.request') }}?activeTab=cedulaTab&document_type=cedula&cedula_search=${encodeURIComponent(cedula_search)}`;">
                                        </div>


                                        <!-- Sort Dropdown -->
                                        <form method="GET" action="{{ route('admin.document.request') }}"
                                            class="flex gap-4 items-center mb-0">
                                            <!-- Keep search term if it exists -->
                                            <input type="hidden" name="cedula_search"
                                                value="{{ request('cedula_search') }}">
                                            <input type="hidden" name="document_type" value="cedula">
                                            <input type="hidden" name="activeTab" value="cedulaTab">

                                            <select name="cedula_sort_by" onchange="this.form.submit()"
                                                class="border border-gray-400 cursor-pointer p-2 rounded">
                                                <option value="">Sort By</option>
                                                <option value="name"
                                                    {{ request('cedula_sort_by') == 'name' ? 'selected' : '' }}>Name
                                                </option>
                                                <option value="date"
                                                    {{ request('cedula_sort_by') == 'date' ? 'selected' : '' }}>Date
                                                </option>
                                            </select>

                                            <select name="cedula_sort_dir" onchange="this.form.submit()"
                                                class="border border-gray-400 cursor-pointer p-2 rounded">
                                                <option value="asc"
                                                    {{ request('cedula_sort_dir') == 'asc' ? 'selected' : '' }}>
                                                    Ascending
                                                </option>
                                                <option value="desc"
                                                    {{ request('cedula_sort_dir') == 'desc' ? 'selected' : '' }}>
                                                    Descending
                                                </option>
                                            </select>
                                        </form>
                                    </div>

                                    <a href="{{ route('admin.document.request', ['activeTab' => 'cedulaTab']) }}"
                                        class="text-black hover:bg-slate-200 font-semibold px-4 py-2 rounded border border-gray-400">
                                        Clear Filter
                                    </a>
                                    <button @click="openCedula = true"
                                        class="relative px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md">New
                                        Requests<span x-cloak x-show="showNewCedulaRequestIndication"
                                            class=" absolute top-[-40px] right-[-7px] text-red-600 text-[50px]">•</span></button>
                                </div>
                            </div>

                        </div> --}}

                            <livewire:show-approved-cedula-requests />

                            <livewire:show-pending-cedula-requests />

                            <livewire:monitor-new-cedula-requests />

                        </div>










                        {{-- Clearance Tab --}}
                        <div x-cloak x-show="activeTab === 'clearanceTab'" class="h-full">
                            {{-- <div class="flex justify-between mb-4">
                            <h2 class="text-2xl font-bold text-center self-center">Clearance Request</h2>

                            <div class="flex gap-4 items-center">

                                <div class="flex gap-4 items-center">
                                    <!-- Search Input -->
                                    <div x-init="$nextTick(() => { if (clearance_search) $refs.clearanceSearchInput.focus(); })">
                                        <input x-ref="clearanceSearchInput" type="text" placeholder="Search name..."
                                            class="border border-gray-400 p-2 rounded w-64 h-[41px]"
                                            x-model.debounce.500ms="clearance_search"
                                            @input.debounce.500ms="
                                                $refs.clearanceSearchInput.blur(); 
                                                window.location.href = `{{ route('admin.document.request') }}?activeTab=clearanceTab&document_type=clearance&clearance_search=${encodeURIComponent(clearance_search)}`;">
                                    </div>

                                    <!-- Sort Dropdown -->
                                    <form method="GET" action="{{ route('admin.document.request') }}"
                                        class="flex gap-4 mb-0 items-center">
                                        <!-- Keep search term if it exists -->
                                        <input type="hidden" name="clearance_search"
                                            value="{{ request('clearance_search') }}">
                                        <input type="hidden" name="document_type" value="clearance">
                                        <input type="hidden" name="activeTab" value="clearanceTab">

                                        <select name="clearance_sort_by" onchange="this.form.submit()"
                                            class="border border-gray-400 cursor-pointer p-2 rounded">
                                            <option value="">Sort By</option>
                                            <option value="name"
                                                {{ request('clearance_sort_by') == 'name' ? 'selected' : '' }}>Name
                                            </option>
                                            <option value="date"
                                                {{ request('clearance_sort_by') == 'date' ? 'selected' : '' }}>Date
                                            </option>
                                        </select>

                                        <select name="clearance_sort_dir" onchange="this.form.submit()"
                                            class="border border-gray-400 cursor-pointer p-2 rounded">
                                            <option value="asc"
                                                {{ request('clearance_sort_dir') == 'asc' ? 'selected' : '' }}>
                                                Ascending</option>
                                            <option value="desc"
                                                {{ request('clearance_sort_dir') == 'desc' ? 'selected' : '' }}>
                                                Descending</option>
                                        </select>
                                    </form>
                                </div>

                                <a href="{{ route('admin.document.request', ['activeTab' => 'clearanceTab']) }}"
                                    class="text-black font-semibold px-4 py-2 rounded hover:bg-gray-100 border border-gray-400">
                                    Clear Filter
                                </a>
                                <button @click="openClearance = true"
                                    class="relative px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md">New
                                    Requests<span x-cloak x-show="showNewClearanceRequestIndication"
                                        class=" absolute top-[-40px] right-[-7px] text-red-600 text-[50px]">•</span></button>
                            </div>

                        </div> --}}

                            <livewire:show-approved-clearance-requests />

                            <livewire:show-pending-clearance-requests />

                            <livewire:monitor-new-clearance-requests />

                        </div>










                        {{-- Indigency Tab --}}
                        <div x-cloak x-show="activeTab === 'indigencyTab'" class="h-full">
                            {{-- <div class="flex justify-between mb-4">
                            <h2 class="text-2xl font-bold text-center self-center">Indigency Request</h2>

                            <div class="flex gap-4 items-center">
                                <div class="flex gap-4 items-center">
                                    <!-- Search Input -->
                                    <div x-init="$nextTick(() => { if (indigency_search) $refs.indigencySearchInput.focus(); })">
                                        <input x-ref="indigencySearchInput" type="text" placeholder="Search name..."
                                            class="border border-gray-400 p-2 rounded w-64 h-[41px]"
                                            x-model.debounce.500ms="indigency_search"
                                            @input.debounce.500ms="
                                                $refs.indigencySearchInput.blur(); 
                                                window.location.href = `{{ route('admin.document.request') }}?activeTab=indigencyTab&document_type=indigency&indigency_search=${encodeURIComponent(indigency_search)}`;">
                                    </div>

                                    <!-- Sort Dropdown -->
                                    <form method="GET" action="{{ route('admin.document.request') }}"
                                        class="flex gap-4 mb-0 items-center">
                                        <!-- Keep search term if it exists -->
                                        <input type="hidden" name="indigency_search"
                                            value="{{ request('indigency_search') }}">
                                        <input type="hidden" name="document_type" value="indigency">
                                        <input type="hidden" name="activeTab" value="indigencyTab">

                                        <select name="indigency_sort_by" onchange="this.form.submit()"
                                            class="border border-gray-400 cursor-pointer p-2 rounded">
                                            <option value="">Sort By</option>
                                            <option value="name"
                                                {{ request('indigency_sort_by') == 'name' ? 'selected' : '' }}>Name
                                            </option>
                                            <option value="date"
                                                {{ request('indigency_sort_by') == 'date' ? 'selected' : '' }}>Date
                                            </option>
                                        </select>

                                        <select name="indigency_sort_dir" onchange="this.form.submit()"
                                            class="border border-gray-400 cursor-pointer p-2 rounded">
                                            <option value="asc"
                                                {{ request('indigency_sort_dir') == 'asc' ? 'selected' : '' }}>
                                                Ascending</option>
                                            <option value="desc"
                                                {{ request('indigency_sort_dir') == 'desc' ? 'selected' : '' }}>
                                                Descending</option>
                                        </select>
                                    </form>
                                </div>

                                <a href="{{ route('admin.document.request', ['activeTab' => 'indigencyTab']) }}"
                                    class="text-black px-4 py-2 rounded border border-gray-400 font-semibold hover:bg-gray-300">
                                    Clear Filter
                                </a>
                                <button @click="openIndigency = true"
                                    class="relative px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md">New
                                    Requests<span x-cloak x-show="showNewIndigencyRequestIndication"
                                        class=" absolute top-[-40px] right-[-7px] text-red-600 text-[50px]">•</span></button>
                            </div>
                        </div> --}}

                            <livewire:show-approved-indigency-requests />

                            <livewire:show-pending-indigency-requests />

                            <livewire:monitor-new-indigency-requests />

                        </div>
                    </div>
                </div>











                <!-- Archived Requests Button -->
                <div>
                    <div class="flex flex-row-reverse w-full">
                        <button @click="openArchive = true"
                            class="mt-6 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-md">Archived
                            Requests</button>
                    </div>

                    <livewire:show-archived-document-requests />

                </div>
            </div>
        </div>










        {{-- Show Valid ID Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedID" @click.away="viewUploadedID = false">
            <div class="relative bg-white p-4 rounded-lg shadow-lg w-[80%] max-w-[1000px]"
                @click.away="viewUploadedID = false">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedID = false">
                    ✕
                </button>

                <!-- Image Display -->
                <template x-if="selectedRequest.valid_id">
                    <div class="mt-6">
                        <p class="text-center text-lg font-semibold mb-4">Uploaded ID</p>
                        <img :src="'/storage/' + selectedRequest.valid_id" alt="Uploaded ID"
                            class="w-full max-h-[400px] object-contain rounded-lg border" />
                    </div>
                </template>
            </div>
        </div>

        {{-- Show Cedula Image --}}
        <div class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center p-4 z-50" x-cloak
            x-show="viewUploadedCedulaImage" @click.away="viewUploadedCedulaImage = false">
            <div class="relative bg-white p-4 rounded-lg shadow-lg w-[80%] max-w-[1000px]">
                <!-- Close Button -->
                <button class="absolute top-2 right-2 bg-red-500 text-white px-3 py-1 rounded-full text-lg"
                    @click="viewUploadedCedulaImage = false">
                    ✕
                </button>

                <!-- Image Display -->
                <template x-if="selectedRequest.cedula_photo">
                    <div class="mt-6">
                        <p class="text-center text-lg font-semibold mb-4">Uploaded Cedula</p>
                        <img :src="'/storage/' + selectedRequest.cedula_photo" alt="Uploaded Cedula"
                            class="w-full max-h-[400px] object-contain rounded-lg border" />
                    </div>
                </template>

                <template x-if="!selectedRequest.cedula_photo">
                    <p class="text-red-500 text-center mt-4">No Cedula photo uploaded.</p>
                </template>
            </div>
        </div>

        {{-- Action Successful Toast --}}
        <div x-cloak x-show="showSuccessNotificationToast" x-transition
            class="fixed top-20 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <span x-text="successMessage"></span>
        </div>

        {{-- Action Error Toast --}}
        <div x-cloak x-show="showErrorNotificationToast" x-transition
            class="fixed top-20 right-5 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <span x-text="errorMessage"></span>
        </div>

        {{-- <div x-cloak x-show="showSuccessNotificationToast" x-transition x-cloak x-init="setTimeout(() => showSuccessNotificationToast = false, 3000)"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">

            {{ session('success') }}
        </div> --}}


        <livewire:show-document-requests-rejection-modal :activeTab="request('activeTab', 'cedulaTab')" />

        {{-- Show Print Document View --}}
        <script>
            function openPopup(url = '') {
                const screenWidth = screen.availWidth;
                const screenHeight = screen.availHeight;

                const popupFeatures = [
                    `width=${screenWidth}`,
                    `height=${screenHeight}`,
                    `top=0`,
                    `left=0`,
                    'resizable=yes',
                    'scrollbars=yes',
                    'toolbar=no',
                    'menubar=no',
                    'location=no',
                    'status=no'
                ].join(',');

                // Open fullscreen popup with minimize and close options
                window.open(url, 'popupWindow', popupFeatures);
                return true;
            }
        </script>

        @if (session('download_file'))
            <script>
                window.onload = function() {
                    const downloadLink = document.createElement('a');
                    downloadLink.href = "{{ session('download_file') }}";
                    downloadLink.download = $filename; // Set the default filename
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                };
            </script>
        @endif

        @livewireScripts
    </div>
</body>

</html>
