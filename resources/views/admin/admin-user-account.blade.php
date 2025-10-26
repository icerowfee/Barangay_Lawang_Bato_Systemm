<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Accounts</title>
</head>

<body class="flex h-screen bg-gray-100" x-data="{
    openNewAccountRequestModal: false,
    selectedRequest: null,

    viewUploadedID: false,
    
    showActiveAccountsData: false,
    showNewAccountRequestData: false,

    showRejectionModal: false,

    successMessage: '',
    errorMessage: '',

    showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},
    activeTab: '{{ session('activeTab') ?? '' }}',
    showNewUserAccountRequestIndication: {{ $newUserAccountRequests->isNotEmpty() ? 'true' : 'false' }},
}"
    x-on:show-success-toast.window="
        showSuccessNotificationToast = true;
        successMessage = $event.detail.message;
        setTimeout(() => showSuccessNotificationToast = false, 3000);

        selectedRequest = null;

        showActiveAccountsData = false;
        showNewAccountRequestData = false;

        successMessage = '';
        errorMessage = '';
        
        showRejectionModal = false;
        "
    x-on:show-error-toast.window="
        showErrorNotificationToast = true;
        errorMessage = $event.detail.message;
        setTimeout(() => showErrorNotificationToast = false, 3000);
        
        selectedRequest = null;

        showActiveAccountsData = false;
        showNewAccountRequestData = false;

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
            <h1 class="text-4xl font-bold mb-8">Manage User Accounts</h1>

            <!-- Tab Content -->
            <div class="mx-auto h-[88%] w-full bg-white shadow-lg rounded-lg p-6">

                <livewire:show-approved-user-accounts>

            </div>

            <livewire:show-pending-user-accounts>

                {{-- <div class="right-10 flex justify-end w-full p-4 z-0" x-data="{openArchive: false, showArchivedRequests: false}">
            <div class="space-x-4">
                <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition" @click="openArchive = true">
                    Archives
                </button>
            </div>

            <!-- Archive Modal -->
            <div x-cloak x-show="openArchive" class="fixed inset-0 bg-gray-300 bg-opacity-50 flex justify-center items-center">
                <div class="relative bg-white p-6 rounded-lg shadow-md w-3/4 h-3/4 overflow-hidden">
                    <h2 class="text-xl font-bold mb-4">Archives</h2>
                    @if ($archivedUserAccounts->isEmpty())
                        <div class="w-full flex items-center justify-center h-[637px]">
                            <div class=" text-center mb-10">
                                <!-- Icon / Illustration -->
                                <div class="mb-4 flex justify-center h-32">
                                    <!-- You can replace this with an actual SVG or image if needed -->
                                    <img src="{{asset('images/new-document-icon.png')}}" alt="No Admin">
                                </div>
                        
                                <!-- Title -->
                                <h2 class="text-xl font-semibold text-gray-600 mb-2">You're All Caught Up!</h2>
                        
                                <!-- Subtitle -->
                                <p class="text-gray-500">Achives are all clear. Rejected and deactivated accounts will be displayed here.</p>
                            </div>
                        </div>
                    @else
                        <div>
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border p-2">#</th>
                                        <th class="border p-2">Fullname</th>
                                        <th class="border p-2">Address</th>
                                        <th class="border p-2">Age</th>
                                        <th class="border p-2">Sex</th>
                                        <th class="border p-2">Date</th>
                                        <th class="border p-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach ($archivedUserAccounts as $userAccount)
                                        <tr class="cursor-pointer hover:bg-gray-200 transition text-center"
                                            @click="selectedRequest = {{ $userAccount->toJson() }}; showArchivedRequests = true;">
                                            <td class="border p-2">{{ $counter++ }}</td>
                                            <td class="border p-2">{{ $userAccount->lastname }}, {{ $userAccount->firstname }} {{ $userAccount->middlename }}</td>
                                            <td class="border p-2">{{ $userAccount->house_number }}, {{ $userAccount->barangay }}, {{ $userAccount->city }}, {{ $userAccount->province }}</td>
                                            <td class="border p-2">{{ $userAccount->age }}</td>
                                            <td class="border p-2">{{ $userAccount->sex }}</td>
                                            <td class="border p-2">{{ $userAccount->created_at }}</td>
                                            <td class="border p-2">
                                                <span class="px-2 py-1 text-white rounded"
                                                    :class="selectedRequest?.status === 'Approved' ? 'bg-green-500' : 
                                                            (selectedRequest?.status === 'Rejected' ? 'bg-red-500' : 'bg-yellow-500')">
                                                    {{ $userAccount->status ?? 'Pending' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                            <!-- Popup Modal -->
                            <div x-cloak x-show="showArchivedRequests" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div class="relative bg-white p-6 rounded-lg shadow-lg w-[700px] max-h-[90vh] overflow-y-auto">
                                    <!-- Modal Header -->
                                    <div class="flex justify-between mb-4 items-center">
                                        <h2 class="text-center text-[24px] font-bold w-full ml-[27px]">Review Request</h2>
                                        <button class="text-[18px] font-semibold text-gray-700 hover:text-red-600 w-[27px]" @click="selectedRequest = null; showArchivedRequests = false">
                                            ✕
                                        </button>
                                    </div>

                                    <!-- Form Content -->
                                    <div class="text-[17px] space-y-4">
                                        <!-- ID -->
                                        <div class="flex flex-col">
                                            <input type="hidden" x-model="selectedRequest.id">
                                        </div>

                                        <!-- Name -->
                                        <div class="flex flex-col">
                                            <label><strong>Name</strong></label>
                                            <input type="text" class="border p-2 rounded-lg" 
                                                :value="selectedRequest.lastname + ', ' + selectedRequest.firstname + ' ' + selectedRequest.middlename" 
                                                readonly>
                                        </div>

                                        <!-- Address -->
                                        <div class="flex flex-col">
                                            <label><strong>Address</strong></label>
                                            <input type="text" class="border p-2 rounded-lg" 
                                                :value="selectedRequest.house_number + ', ' + selectedRequest.barangay + ', ' + selectedRequest.city + ', ' + selectedRequest.province" 
                                                readonly>
                                        </div>

                                        <div class="grid grid-cols-4 gap-4">
                                            <!-- Civil Status -->
                                            <div class="flex flex-col">
                                                <label><strong>Civil Status</strong></label>
                                                <input type="text" class="border p-2 rounded-lg" :value="selectedRequest.civil_status" readonly>
                                            </div>

                                            <!-- Sex -->
                                            <div class="flex flex-col">
                                                <label><strong>Sex</strong></label>
                                                <input type="text" class="border p-2 rounded-lg" :value="selectedRequest.sex" readonly>
                                            </div>

                                            <!-- Birthdate -->
                                            <div class="flex flex-col">
                                                <label><strong>Birthdate</strong></label>
                                                <input type="text" class="border p-2 rounded-lg" :value="selectedRequest.birthdate" readonly>
                                            </div>

                                            <!-- Age -->
                                            <div class="flex flex-col">
                                                <label><strong>Age</strong></label>
                                                <input type="text" class="border p-2 rounded-lg" :value="selectedRequest.age" readonly>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- Email -->
                                            <div class="flex flex-col">
                                                <label><strong>Email</strong></label>
                                                <input type="text" class="border p-2 rounded-lg" :value="selectedRequest.email" readonly>
                                            </div>

                                            <!-- Mobile Number -->
                                            <div class="flex flex-col">
                                                <label><strong>Mobile Number</strong></label>
                                                <input type="text" class="border p-2 rounded-lg" :value="selectedRequest.contact_number" readonly>
                                            </div>
                                        </div>

                                        <!-- Valid ID -->
                                        <div class="flex flex-col">
                                            <label><strong>Valid ID</strong></label>
                                            <button class="w-full border p-2 rounded-lg" @click="viewUploadedID = true">View ID</button>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-8 flex justify-center gap-6">
                                        <!-- Delete -->
                                        <form action="{{route('delete.user.account')}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" :value="selectedRequest.id">
                                            <button class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                        <!-- Deactivate -->
                                        <form action="{{route('reactivate.user.account')}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" :value="selectedRequest.id">
                                            <button class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition">
                                                Reactivate
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">{{ $archivedUserAccounts->links() }}</div>
                    @endif
                

                    <!-- Close Button -->
                    <div class="absolute bottom-4 w-[1385px] flex justify-end self-center">
                        <button @click="openArchive = false" class=" px-4 py-2 bg-red-600 text-white rounded-md">
                            Close
                        </button>
                    </div>
                </div>
            </div> --}}
        </div>


        <!-- Rejection Modal OKAY ITO-->
        <livewire:show-job-referral-admin-rejection-modal
            activeTab="{{ session('activeTab', 'new-account-request-tab') }}" />


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
                <template x-if="selectedRequest.valid_id">
                    <div class="mt-6">
                        <p class="text-center text-lg font-semibold mb-4">Uploaded ID</p>
                        <img :src="'/storage/' + selectedRequest.valid_id" alt="Uploaded ID"
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
