@php
    $currentRoute = Request::path();
@endphp

<!-- Sidebar for Super Admin -->
<div class="flex flex-col h-full w-1/5 bg-[#0F3860] text-white shadow-lg">
    <!-- Profile Section -->
    <div class="flex flex-col items-center p-6 ">
        <div class="p-4 flex items-center justify-center">
            <!-- Placeholder for logos -->
            <div class="h-20 flex gap-2">
                <img class="w-20" src="{{ asset('images/valenzuela-logo.png') }}" alt="Valenzuela Logo">
                <img class="w-20" src="{{ asset('images/lawang-bato-logo.png') }}" alt="Lawang Bato Logo">
            </div>
        </div>
        <p class="mt-4 text-lg font-semibold">Welcome, <span class="font-bold">{{auth('company')->user()->company_name}}</span>!</p>
    </div>

    <!-- Navigation Menu -->
    <div class="flex flex-col justify-between flex-1">
        <nav class="mt-6">
            <h2 class="text-xl font-bold pl-6 mb-4">Company Admin Panel</h2>
            <ul class="space-y-1">
                <li>
                    <a href="/company-dashboard"
                        class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'company-dashboard' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        📊 <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/company-job-management"
                        class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'company-job-management' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        🧑🏻 <span class="ml-3">Job Management</span>
                    </a>
                </li>
                <li>
                    <a href="/company-applicant-management"
                        class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'company-applicant-management' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        📢 <span class="ml-3">Applicant Management</span>
                    </a>
                </li>
                <li>
                    <a href="/company-processed-applicants"
                        class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'company-processed-applicants' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        ⚙️ <span class="ml-3">Processed Applicants</span>
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'company-profile' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        ⚙️ <span class="ml-3">Profile Settings</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="mb-6">
            <form action="{{ route('company.logout') }}" method="POST" class="text-center">
                @csrf
                <button class="bg-red-500 hover:bg-red-600 transition text-white px-4 py-2 rounded-lg mt-4">Log
                    out</button>
            </form>
            <div class="text-center mt-4 text-sm text-gray-300">
                <p>@2024 Barangay Lawang Bato</p>
            </div>
        </div>
    </div>
</div>
