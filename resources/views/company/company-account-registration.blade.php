<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>

<body class="min-h-screen flex flex-col bg-white"> <!-- full light blue background -->

    <header class="bg-[#0F3860] text-white shadow-lg h-24 w-full flex items-center z-50">
        <nav class="container mx-auto flex justify-between items-center py-4 px-6">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-2 mr-4">
                    <img class="w-14" src="{{ asset('images/valenzuela-logo.png') }}" alt="Valenzuela Logo">
                    <img class="w-14" src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo">
                </div>
                <a class="text-2xl font-bold">Barangay Lawang Bato</a>
            </div>
        </nav>
    </header>

    <!-- Company Registration Multi-Step -->
    <div x-data="{ step: 1 }" class="flex justify-center items-center min-h-[90vh] px-4">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-4xl grid md:grid-cols-3 gap-4 h-4/6">

            <!-- Left Panel: Steps -->
            <div class="col-span-1 border-r pr-6 flex flex-col justify-between">
                <div>
                    <h4 class="text-2xl font-semibold mb-2">Company Registration</h4>
                    <p class="text-sm text-gray-500">Register your company to Access the Dashboard</p>
                </div>

                <div class="mb-12">
                    <!-- Step 1 -->
                    <div
                        :class="step === 1 ? 'flex items-center font-semibold text-blue-600' : 'flex items-center text-gray-600'">
                        <div class="flex flex-col items-center w-12">
                            <span :class="step === 1 ? 'bg-blue-600 text-white w-12 h-12' : 'bg-gray-300'"
                                class="w-10 h-10 rounded-full text-center flex items-center justify-center relative">
                                1
                            </span>

                            <!-- Vertical line for Step 1 -->
                            <div class="border-l-4 border-gray-300 h-12"
                                :class="step === 1 ? 'border-blue-600' : 'border-gray-300'"></div>
                        </div>

                        <span class="h-10 rounded-full text-center flex items-center self-start flex-1 ml-3">Company
                            Information</span>
                    </div>



                    <!-- Step 2 -->
                    <div
                        :class="step === 2 ? 'flex items-center font-semibold text-blue-600' : 'flex items-center text-gray-600'">
                        <div class="flex flex-col items-center w-12">
                            <span :class="step === 2 ? 'bg-blue-600 text-white w-12 h-12' : 'bg-gray-300'"
                                class="w-10 h-10 rounded-full text-center flex items-center justify-center relative">
                                2
                            </span>

                            <!-- Vertical line for Step 1 -->
                            <div class="border-l-4 border-gray-300 h-12"
                                :class="step === 2 ? 'border-blue-600' : 'border-gray-300'"></div>
                        </div>

                        <span class="h-10 rounded-full text-center flex items-center self-start flex-1 ml-3">Contact
                            Person</span>
                    </div>


                    <!-- Step 3 -->
                    <div
                        :class="step === 3 ? 'flex items-center font-semibold text-blue-600' : 'flex items-center text-gray-600'">
                        <div class="flex flex-col items-center w-12">
                            <span :class="step === 3 ? 'bg-blue-600 text-white w-12 h-12' : 'bg-gray-300'"
                                class="w-10 h-10 rounded-full text-center flex items-center justify-center relative">
                                3
                            </span>

                            <!-- Vertical line for Step 1 -->
                            <div class="border-l-4 border-gray-300 h-12"
                                :class="step === 3 ? 'border-blue-600' : 'border-gray-300'"></div>
                        </div>

                        <span class="h-10 rounded-full text-center flex items-center self-start flex-1 ml-3">Verification Documents</span>
                    </div>



                    <!-- Step 4 -->
                    <div
                        :class="step === 4 ? 'flex items-center font-semibold text-blue-600' : 'flex items-center text-gray-600'">
                        <div class="flex flex-col items-center w-12">
                            <span :class="step === 4 ? 'bg-blue-600 text-white w-12 h-12' : 'bg-gray-300'"
                                class="w-10 h-10 rounded-full text-center flex items-center justify-center relative">
                                4
                            </span>
                        </div>

                        <span
                            class="h-10 rounded-full text-center flex items-center self-start flex-1 ml-3">Account Credentials</span>
                    </div>
                </div>


                <div class="">
                    <p class="text-sm">Already have an Account? <a href="/company-login" class="text-blue-600">Login Here</a></p>
                </div>

            </div>


            <!-- Right Panel: Form -->
            <div class="relative col-span-2">
                <form action="{{ route('company.register') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- STEP 1: Company Information -->
                    <div x-cloak x-show="step === 1">
                        <h5 class="text-lg font-semibold mb-4">🏢 Company Information</h5>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm mb-1">Company Name <span class="text-red-500">*</span></label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}"
                                    placeholder="Company Name"
                                    class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400"
                                    required>
                                @error('company_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Business Type <span class="text-red-500">*</span></label>
                                <select name="business_type"
                                    required class="h-12 w-full rounded-lg border px-4 focus:ring-2 focus:ring-blue-400">
                                    <option value="Corporation"
                                        {{ old('business_type') == 'Corporation' ? 'selected' : '' }}>Corporation
                                    </option>
                                    <option value="Partnership"
                                        {{ old('business_type') == 'Partnership' ? 'selected' : '' }}>Partnership
                                    </option>
                                    <option value="Sole Proprietorship"
                                        {{ old('business_type') == 'Sole Proprietorship' ? 'selected' : '' }}>Sole
                                        Proprietorship</option>
                                    <option value="Government"
                                        {{ old('business_type') == 'Government' ? 'selected' : '' }}>Government</option>
                                    <option value="NGO" {{ old('business_type') == 'NGO' ? 'selected' : '' }}>NGO
                                    </option>
                                </select>
                                @error('business_type')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Company Address <span class="text-red-500">*</span></label>
                                <div class="grid gap-4">
                                    <input type="text" name="street_address" value="{{ old('street_address') }}"
                                        placeholder="Street Address"
                                        class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400"
                                        required>
                                    @error('street_address')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                    <input type="text" name="barangay" value="{{ old('barangay') }}"
                                        placeholder="Barangay"
                                        class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400"
                                        required>
                                    @error('barangay')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                    <input type="text" name="city" value="{{ old('city') }}" placeholder="City"
                                        class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400"
                                        required>
                                    @error('city')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <div class="absolute bottom-0 right-0 flex justify-end mt-6">
                            <button type="button" @click="step = 2"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg">Next</button>
                        </div>
                    </div>

                    <!-- STEP 2: Contact Person -->
                    <div x-cloak x-show="step === 2">
                        <h5 class="text-lg font-semibold mb-4">👤 Contact Person</h5>

                        <div class="space-y-4">

                            <div>
                                <label class="block text-sm mb-1">Contact Person Name <span class="text-red-500">*</span></label>
                                <input type="text" name="contact_person_name"
                                    value="{{ old('contact_person_name') }}" placeholder="Full Name"
                                    class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400"
                                    required>
                                @error('contact_person_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>


                            <div>
                                <label class="block text-sm mb-1">Position / Role <span class="text-red-500">*</span></label>
                                <input type="text" name="contact_person_position"
                                    value="{{ old('contact_person_position') }}" placeholder="Position / Role"
                                    required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
                                @error('contact_person_position')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="contact_person_email"
                                    value="{{ old('contact_person_email') }}" placeholder="Email"
                                    class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400"
                                    required>
                                @error('contact_person_email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Contact Number <span class="text-red-500">*</span></label>
                                <input type="text" name="contact_person_contact_number"
                                    value="{{ old('contact_person_contact_number') }}" placeholder="Phone Number"
                                    required class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
                                @error('contact_person_contact_number')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="absolute bottom-0 right-0 space-x-6 mt-6">
                            <button type="button" @click="step = 1"
                                class="bg-gray-400 text-white px-6 py-2 rounded-lg">Back</button>
                            <button type="button" @click="step = 3"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg">Next</button>
                        </div>
                    </div>

                    <!-- STEP 3: Account Credentials -->
                    <div x-cloak x-show="step === 3">
                        <h5 class="text-lg font-semibold mb-4">📄 Verification Documents</h5>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm mb-1">Business Permit / SEC / DTI <span class="text-red-500">*</span></label>
                                <input type="file" name="registration_document"
                                    required class="w-full border px-3 py-2 rounded-lg file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                @error('registration_document')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm mb-1">Valid ID of Contact Person <span class="text-red-500">*</span></label>
                                <input type="file" name="contact_person_valid_id"
                                    required class="w-full border px-3 py-2 rounded-lg file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                @error('contact_person_valid_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="absolute bottom-0 right-0 space-x-6 mt-6">
                            <button type="button" @click="step = 2"
                                class="bg-gray-400 text-white px-6 py-2 rounded-lg">Back</button>
                            <button type="button" @click="step = 4"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg">Next</button>
                        </div>
                    </div>

                    <!-- STEP 4: Verification Documents -->

                    <div x-cloak x-show="step === 4">
                        <h5 class="text-lg font-semibold mb-4">🔑 Account Credentials</h5>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm mb-1">Account Email <span class="text-red-500">*</span></label>
                                <input type="text" name="account_email" value="{{ old('account_email') }}"
                                    placeholder="Email"
                                    class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400"
                                    required>
                                @error('account_email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password" placeholder="Password"
                                    class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400"
                                    required>
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm mb-1">Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                    class="w-full border px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-400"
                                    required>
                            </div>
                        </div>

                        
                        <div class="absolute bottom-0 right-0 space-x-6 mt-6">
                            <button type="button" @click="step = 3"
                                class="bg-gray-400 text-white px-6 py-2 rounded-lg">Back</button>
                            <button type="submit"
                                class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @livewireScripts

</body>

</html>
