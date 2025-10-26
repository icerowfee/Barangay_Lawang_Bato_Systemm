<form wire:submit.prevent="documentRequest" enctype="multipart/form-data" class="space-y-4 w-3/5 mx-auto">
    @csrf
    <!-- Name Fields -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium">First Name <span class="text-red-500">*</span></label>
            <input type="text" wire:model="firstname" placeholder="First Name" value="{{ old('firstname') }}" required
                class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-sm font-medium">Middle Name</label>
            <input type="text" wire:model="middlename" placeholder="Middle Name" value="{{ old('middlename') }}"
                class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
        </div>
        <div>
            <label class="block text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
            <input type="text" wire:model="lastname" placeholder="Last Name" value="{{ old('lastname') }}" required
                class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
        </div>
    </div>

    <!-- Address Fields with Alpine.js -->
    <div>
        <label class="block text-sm font-medium">Complete Address</label>
        <div class="grid grid-cols-4 gap-4">

            <div class="flex flex-col">
                <!-- Street Input -->
                <label class="block text-sm font-normal">Street Address <span class="text-red-500">*</span></label>
                <input type="text" wire:model="house_number" value="{{ old('house_number') }}"
                    placeholder="House No., Street, Subdivision" required
                    class="line-clamp-1 border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400" />
                @error('house_number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <!-- Barangay Input -->
                <label class="block text-sm font-normal">Barangay <span class="text-red-500">*</span></label>
                <input type="text" wire:model="barangay" value="{{ old('barangay') }}" placeholder="Barangay"
                    required
                    class="line-clamp-1 border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400" />
                @error('barangay')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <!-- City Input -->
                <label class="block text-sm font-normal">City <span class="text-red-500">*</span></label>
                <input type="text" wire:model="city" value="{{ old('city') }}" placeholder="City" required
                    class="line-clamp-1 border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400" />
                @error('city')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex flex-col">
                <!-- Province Input -->
                <label class="block text-sm font-normal">Province <span class="text-red-500">*</span></label>
                <input type="text" wire:model="province" value="{{ old('province') }}" placeholder="Province"
                    required
                    class="line-clamp-1 border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400" />
                @error('province')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

        </div>
    </div>

    <!-- Civil Status, Birthplace, Birthdate & Auto-Calculated Age & Sex-->
    <div x-data="{ birthdate: '', age: '' }" class="grid grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium">Civil Status <span class="text-red-500">*</span></label>
            <select wire:model="civil_status" value="{{ old('civil_status') }}" required
                class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Widowed">Widowed</option>
                <option value="Separated">Separated</option>
            </select>
            @error('civil_status')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col">
            <!-- Street Input -->
            <label class="block text-sm font-medium">Birthplace <span class="text-red-500">*</span></label>
            <input type="text" wire:model="birthplace" value="{{ old('birthplace') }}" placeholder="Birthplace"
                required class="line-clamp-1 border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400" />
            @error('birthplace')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Birthdate <span class="text-red-500">*</span></label>
            <input type="date" wire:model="birthdate" value="{{ old('birthdate') }}" x-model="birthdate"
                @change="let today = new Date(); 
                                    let bday = new Date(birthdate); 
                                    let ageDiff = today.getFullYear() - bday.getFullYear();
                                    let monthDiff = today.getMonth() - bday.getMonth();
                                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < bday.getDate())) {
                                        ageDiff--;
                                    }
                                    $wire.age = ageDiff;"
                required class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
            @error('birthdate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Age <span class="text-red-500">*</span></label>
                <input type="number" wire:model="age" placeholder="Age" x-model="age" readonly required
                    class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400 bg-gray-200 cursor-not-allowed">
                @error('age')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Sex <span class="text-red-500">*</span></label>
                <select wire:model="sex" value="{{ old('sex') }}" required
                    class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                @error('sex')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

        </div>
    </div>

    <!-- Email & Mobile -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Email <span class="text-red-500">*</span></label>
            <input type="email" wire:model="email" placeholder="Email" value="{{ old('email') }}" required
                class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Mobile Number <span class="text-red-500">*</span></label>
            <input type="number" wire:model="contact_number" placeholder="Contact Number"
                value="{{ old('contact_number') }}" required
                class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
            @error('contact_number')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Additional Fields -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">TIN (if any)</label>
            <input type="number" wire:model="tin" placeholder="TIN Number" value="{{ old('tin') }}"
                class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
            @error('tin')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Gross Income</label>
            <input type="number" wire:model="gross_income" placeholder="Gross Income"
                value="{{ old('gross_income') }}"
                class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400">
            @error('gross_income')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- File Upload -->
    <div>
        <label class="block text-sm font-medium">Upload Valid ID <span class="text-red-500">*</span></label>
        <input type="file" wire:model="valid_id" value="{{ old('valid_id') }}" accept="image/*" required
            class="w-full border bg-white border-gray-400 p-2 rounded-md">
    </div>

    <div class="text-sm text-gray-500 mt-2">*Please upload a valid ID with your name and address.</div>
    <div class="text-sm text-gray-500 mt-2">*File size should not exceed 2MB.</div>
    <div class="text-sm text-gray-500 mt-2">*File format should be JPEG, PNG.</div>
    <div class="text-sm text-gray-500 mt-2">*Please ensure the image is clear and readable.</div>

    <div class="mb-4 text-center flex items-start gap-2 text-sm text-gray-700 justify-center">
        <input type="checkbox" wire:model="data_privacy_agreement" required class="mt-1">
        <p>
            I have read and agree to the <a class="text-blue-600 hover:underline cursor-pointer"
                @click="$dispatch('open-privacy-policy')">Privacy Policy</a> regarding the collection and use of my
            personal information for processing this request.
        </p>
    </div>

    <!-- Submit Button -->
    <div class="text-center">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
            Submit Request
        </button>
    </div>
</form>
