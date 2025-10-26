<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Management</title>
</head>
<body class="flex h-screen bg-gray-100" 
        x-data="{
        showAddAccountModal: false,
        selectedAdminUser: null, // Holds the selected admin user for viewing/editing
        showAccountModal: false,
        editUserAdmin: false,
        editMode: false,
        showConfirmAddAccount: false,
        showSuccessNotificationToast: {{ session('success') ? 'true' : 'false' }},
        
        tempAccount: null, // Holds a temporary copy for editing   

        startEditing() {
            this.tempAccount = JSON.parse(JSON.stringify(this.selectedAdminUser)); // Create a deep copy
            this.editMode = true;
        },
        cancelEditing() {
            this.selectedAdminUser = JSON.parse(JSON.stringify(this.tempAccount)); // Restore values
            this.editMode = false;
        }
    }">

    @include('super-admin/super-admin-side-panel')

    <!-- Main Content  value="{{old('')}}"(Placeholder) -->
    <div class="w-4/5 h-full flex justify-center">
        <div class="w-full flex flex-col justify-center p-8">
            <h1 class="text-3xl font-bold mb-10 ">Super Admin Account Management</h1>

            <div class="p-6 h-[770px] bg-white shadow-lg rounded-lg">
                <div class="flex justify-between mb-4">
                    <h2 class="text-xl font-bold">Admin Accounts</h2>

                    {{-- Filters --}}
                    <div class="flex gap-4 items-center">
                        <!-- Search Input -->
                        <form method="GET" action="super-admin-account-management" class="flex gap-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..."
                                class="border p-2 rounded w-64">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
                        </form>
                    
                        <!-- Sort Dropdown -->
                        <form method="GET" action="super-admin-account-management" class="flex gap-2 items-center">
                            <!-- Keep search term if it exists -->
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            
                            <select name="sort_by" onchange="this.form.submit()" class="border p-2 rounded">
                                <option value="">Sort By</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="sex" {{ request('sort_by') == 'sex' ? 'selected' : '' }}>Sex</option>
                                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                                <option value="role" {{ request('sort_by') == 'role' ? 'selected' : '' }}>Role</option>
                            </select>
                            
                            <select name="sort_dir" onchange="this.form.submit()" class="border p-2 rounded">
                                <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </form>
                    </div>
                </div>

                @if($adminAccounts->isEmpty())
                    <div class="w-full h-[70vh] flex items-center justify-center">
                        <div class=" text-center">
                            <!-- Icon / Illustration -->
                            <div class="mb-4 flex justify-center h-32">
                                <!-- You can replace this with an actual SVG or image if needed -->
                                <img src="{{asset('images/admin-icon.png')}}" alt="No Admin">
                            </div>
                            
                            <!-- Title -->
                            <h2 class="text-xl font-semibold text-gray-600 mb-2">No Admin Users</h2>
                    
                            <!-- Subtitle -->
                            <p class="text-gray-500">Looks like no admin account has been created yet.</p>
                    
                            
                        </div>
                    </div>
                @else
                    <div class="px-4">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="border p-2">#</th>
                                    <th class="border p-2">Fullname</th>
                                    <th class="border p-2">Sex</th>
                                    <th class="border p-2">Email</th>
                                    <th class="border p-2">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($adminAccounts as $adminAccount)
                                    <tr class="cursor-pointer hover:bg-gray-200 transition text-center" 
                                        @click="selectedAdminUser = {{ $adminAccount->toJson() }}; showAccountModal = true;">
                                        <input type="hidden" name="id" value="{{ $adminAccount->id }}">
                                        <td class="border p-2">{{ $loop->iteration }}</td>
                                        <td class="border p-2">{{ $adminAccount->lastname }}, {{ $adminAccount->firstname }} {{ $adminAccount->middlename}}</td>
                                        {{-- <td class="border p-2">{{ $approvedRequest->house_number }}, {{ $approvedRequest->barangay }}, {{ $approvedRequest->city }}, {{ $approvedRequest->province }}</td> --}}
                                        <td class="border p-2">{{ $adminAccount->sex }}</td>
                                        <td class="border p-2">{{ $adminAccount->email }}</td>
                                        <td class="border p-2">
                                            @if ($adminAccount->role == 1)
                                                Document Issuance Admin
                                            @elseif ($adminAccount->role == 2)
                                                Job Center Admin
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Popup Modal EDIT THIS FORMAT AND ADD ACCPEXT REJEXT AND CLOSE BTN-->
                        <div x-cloak x-show="showAccountModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="relative bg-white p-6 rounded-lg shadow-lg w-[750px] max-h-[90vh] overflow-y-auto">
                                <!-- Modal Header -->
                                <div class="flex justify-between mb-8 items-center">
                                    <h2 class="text-center text-[24px] font-bold w-full ml-[27px]">Review Admin Account</h2>
                                    <button class="text-[18px] font-semibold text-gray-700 hover:text-red-600 w-[27px]" @click="showAccountModal = false; cancelEditing()">
                                        ✕
                                    </button>
                                </div>
                
                                <div class="mx-5 text-[17px]">
                                    <div class="grid grid-cols-3 gap-4">
                                        <div class="w-full mb-4">
                                            <p><strong>Firstname</strong></p>
                                            <input type="text" class="w-full border p-2 rounded-lg mb-4" x-model="selectedAdminUser.firstname" :readonly= !editMode>
                                        </div>
                    
                                        <div class="w-full mb-4">
                                            <p><strong>Middle Name</strong></p>
                                            <input type="text" class="w-full border p-2 rounded-lg mb-4" x-model="selectedAdminUser.middlename" :readonly= !editMode>
                                        </div>
            
                                        <div class="w-full mb-4">
                                            <p><strong>Last Name</strong></p>
                                            <input type="text" class="w-full border p-2 rounded-lg mb-4" x-model="selectedAdminUser.lastname" :readonly= !editMode>
                                        </div>
                                    </div>
                                    
                
                                    
                                    
                                    <div class="grid grid-cols-3 gap-4">

                                        <div class="w-full mb-4">
                                            <label><strong>Email</strong></label>
                                            <input type="email" x-model="selectedAdminUser.email" class="border p-2 rounded w-full" :readonly= !editMode>
                                        </div>

                                        <div class="w-full mb-4">
                                            <label><strong>Sex</strong></label>
                                            <select x-model="selectedAdminUser.sex" required class="w-full border p-2 rounded-md border-gray-300 h-[42px] " :disabled= !editMode>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>

                                        

                                        <div class="grid grid-cols-3 gap-4 mb-4">
                                            <div class="col-span-2 mb-4">
                                                <label><strong>Birthdate</strong></label>
                                                <input type="date" x-model="selectedAdminUser.birthdate" 
                                                    @change="let today = new Date(); 
                                                                let bday = new Date(selectedAdminUser.birthdate); 
                                                                let ageDiff = today.getFullYear() - bday.getFullYear();
                                                                let monthDiff = today.getMonth() - bday.getMonth();
                                                                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < bday.getDate())) {
                                                                    ageDiff--;
                                                                }
                                                                selectedAdminUser.age = ageDiff;"
                                                    required class="w-full border p-2 rounded-md h-[42px]  border-gray-300" :readonly= !editMode>
                                            </div>

                                            <div class="col-span-1 mb-4">
                                                <label><strong>Age</strong></label>
                                                <input type="number" x-model="selectedAdminUser.age" class="border p-2 rounded w-full  h-[42px]" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    
                
                                    <div class="flex flex-col w-full">
                                        <label><strong>Role</strong></label>
                                        <select x-model="selectedAdminUser.role" class="w-full p-2 border border-gray-300 rounded" :disabled= !editMode>
                                            <option value="1">Document Issuance Admin</option>
                                            <option value="2">Job Center Admin</option>
                                        </select>
                                    </div>
                                </div>
                
                                
                                <div class="mt-8 flex justify-center gap-6">
                                    <div class="flex justify-between w-[225px] h-[40px]" x-cloak x-show="!editMode">
                                        <button class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition h-[40px]" @click="startEditing()">
                                            Edit
                                        </button>
                
                
                                        <form action="{{route('delete.admin.account')}}" method="POST"> {{-- EDIT THIS Need pa ng confirmation if want to cancel --}}
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" :value="selectedAdminUser.id">
                                            <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                
                                    </div>
                
                                    <div class="flex justify-between w-[225px] h-[40px]" x-cloak x-show="editMode">
                                        <form action="{{route('edit.admin.account')}}" method="POST"> {{-- Need ayusin yung sa file upload, hindi na uupload yung image sa storage--}}
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" :value="selectedAdminUser.id">
                                            <input type="hidden" name="firstname" :value="selectedAdminUser.firstname">
                                            <input type="hidden" name="middlename" :value="selectedAdminUser.middlename">
                                            <input type="hidden" name="lastname" :value="selectedAdminUser.lastname">
                                            <input type="hidden" name="email" :value="selectedAdminUser.email">
                                            <input type="hidden" name="sex" :value="selectedAdminUser.sex"> 
                                            <input type="hidden" name="birthdate" :value="selectedAdminUser.birthdate">
                                            <input type="hidden" name="password" :value="selectedAdminUser.password">
                                            <input type="hidden" name="age" :value="selectedAdminUser.age">

                                            <input type="hidden" name="role" :value="selectedAdminUser.role">
                                            <button class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition " @click="editMode = false">
                                                Save
                                            </button>
                                        </form>
                
                                        
                                            <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-600 transition h-[40px]" @click="cancelEditing()">
                                                Cancel
                                            </button>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $adminAccounts->links() }}
                    </div>
                @endif

            </div>

            <div class="right-10 flex justify-end w-full p-4 z-0 ">
                <div class="space-x-4">
                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition" @click="showAddAccountModal = true">
                        Add Account
                    </button>
                </div>
            </div>
        </div>



    <!-- Account Creation Modal -->
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50" x-cloak x-show="showAddAccountModal">
            <div class="flex justify-center bg-white p-6 rounded-lg w-2/5 shadow-lg">
                
                <form action="{{route('create.admin.account')}}" method="POST" class="w-full">
                    <h2 class=" w-full text-center text-[30px] font-bold mb-8">Create New Account</h2>
                    @csrf
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Firstname <span class="text-red-500">*</span></label>
                            <input type="text" name="firstname" value="{{old('firstname')}}" placeholder="Firstname" required class="w-full p-2 border border-gray-300 rounded">
                            @error('firstname')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Middlename</label>
                            <input type="text" name="middlename" value="{{old('middlename')}}" placeholder="Middlename" class="w-full p-2 border border-gray-300 rounded">
                            @error('middlename')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Lastname <span class="text-red-500">*</span></label>
                            <input type="text" name="lastname" value="{{old('lastname')}}" placeholder="Lastname" required class="w-full p-2 border border-gray-300 rounded">
                            @error('lastname')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 mb-4" x-data="{ birthdate: '', age: '' }">
                        <div class="w-full mb-4">
                            <label class="block text-sm font-medium">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{old('email')}}" placeholder="Email" required class="w-full p-2 border border-gray-300 rounded">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        

                        <div class="w-full mb-4">
                            <label class="block text-sm font-medium">Sex <span class="text-red-500">*</span></label>
                            <select name="sex" required class="w-full border p-2 rounded-md border-gray-300 h-[42px]">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            @error('sex')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-3 gap-4 gap-y-0">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium">Birthdate <span class="text-red-500">*</span></label>
                                <input type="date" name="birthdate" value="{{old('birthdate')}}" x-model="birthdate" 
                                    @change="let today = new Date(); 
                                                let bday = new Date(birthdate); 
                                                let ageDiff = today.getFullYear() - bday.getFullYear();
                                                let monthDiff = today.getMonth() - bday.getMonth();
                                                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < bday.getDate())) {
                                                    ageDiff--;
                                                }
                                                age = ageDiff;"
                                    required class="w-full border p-2 rounded-md h-[42px]  border-gray-300">
                                @error('age')
                                    <p class="text-red-500 text-sm col-span-3 mt-1">Age must be 18 and above</p>
                                @enderror
                            </div>
                                
                            <div class="col-span-1">
                                <label class="block text-sm font-medium">Age <span class="text-red-500">*</span></label>
                                <input type="number" name="age" x-model="age" value="{{old('age')}}" readonly required class="w-full border p-2 rounded-md h-[42px] bg-gray-300">
                            </div>
                            
                        </div>
                    </div>

                    
                    
                    <input type="hidden" value="default" name="password">

                    <div class="mb-6 ">
                        <label class="block text-sm font-medium mb-1">Role <span class="text-red-500">*</span></label>
                        <select name="role" class="w-full p-2 border border-gray-300 rounded">
                            <option value="1">Document Issuance Admin</option>
                            <option value="2">Job Center Admin</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 ">
                        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded ">Create Account</button>
                        <button class="w-full bg-red-500 text-white p-2 rounded" @click="selectedAdminUser = showAddAccountModal = false;">Cancel</button>

                    </div>
                    
                </form>
            </div>
        </div>

        {{-- Action Successful Toast --}}
        <div 
            x-show="showSuccessNotificationToast"
            x-transition
            x-cloak
            x-init="setTimeout(() => showSuccessNotificationToast = false, 3000)"
            class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            
            {{ session('success') }}
        </div>
    </div>

    @livewireScripts
    
</body>
</html>