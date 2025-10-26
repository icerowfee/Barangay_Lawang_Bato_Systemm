@if (Auth::guard('admin')->check())
    @php
        $currentRoute = Request::path();
    @endphp

    @if (Auth::guard('admin')->user()->role == '1')
        <!-- Sidebar for Document Issuance Admin -->
        <div class="flex flex-col min-h-fit w-[18%] bg-[#003097] text-white shadow-lg">
            <!-- Profile Section -->
            <div class="flex flex-col items-center p-6 bg-[#003097]">
                <div class="h-24 w-24 rounded-full overflow-hidden border-4 border-white">
                    <img src="{{ asset('images/profile-picture.png') }}" alt="Profile Picture"
                        class="h-full w-full object-cover">
                </div>
                <p class="mt-4 text-2xl font-semibold">Welcome, <span
                        class="font-bold">{{ auth('admin')->user()->firstname }}</span>!</p>
            </div>

            <!-- Navigation Menu -->
            <div class="flex flex-col justify-between flex-1">
                <nav class="mt-6">
                    <h2 class="text-xl font-bold pl-6 mb-4">Admin Panel</h2>
                    <ul class="space-y-1">
                        <li>
                            <a href="/admin-dashboard"
                                class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-dashboard' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                <x-icons.dashboard-icon />
                                <span class="ml-2">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin-document-request"
                                class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-document-request' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">

                                <x-icons.documents-icon />
                                <span class="ml-2">Document Requests</span>
                            </a>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <h2 class="text-xl font-bold pl-6 mb-4">Reports</h2>
                        <ul class="space-y-1">
                            <li>
                                <a href="/admin-report"
                                    class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-report' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                    
                                    <x-icons.report-icon /> 
                                    <span class="ml-2">Reports</span>
                                </a>
                            </li>
                            <li>
                                <a href="/admin-generated-report"
                                    class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-generated-report' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                    
                                    <x-icons.generated-report-icon />
                                    <span class="ml-2">Generated Reports</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="mb-6">
                    <form action="{{ route('admin.logout') }}" method="POST" class="text-center">
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
    @elseif (Auth::guard('admin')->user()->role == '2')
        <!-- Sidebar for Job Referral Admin -->
        <div class="flex flex-col min-h-fit w-[18%] bg-[#003097] text-white shadow-lg">
            <!-- Profile Section -->
            <div class="flex flex-col items-center p-6 bg-[#003097]">
                <div class="h-24 w-24 rounded-full overflow-hidden border-4 border-white">
                    <img src="{{ asset('images/profile-picture.png') }}" alt="Profile Picture"
                        class="h-full w-full object-cover">
                </div>
                <p class="mt-4 text-2xl font-semibold">Welcome, <span
                        class="font-bold">{{ auth('admin')->user()->firstname }}</span>!</p>
            </div>

            <!-- Navigation Menu -->
            <div class="flex flex-col justify-between flex-1">
                <nav class="mt-6">
                    <h2 class="text-xl font-bold pl-6 mb-4">Admin Panel</h2>
                    <ul class="space-y-1">
                        <li>
                            <a href="/admin-dashboard"
                                class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-dashboard' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                
                                <x-icons.dashboard-icon />
                                <span class="ml-2">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin-user-account-management"
                                class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-user-account-management' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                <x-icons.user-icon />
                                <span class="ml-2">User Accounts</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin-company-account-management"
                                class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-company-account-management' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                <x-icons.company-icon />
                                <span class="ml-2">Company Accounts</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin-job-referral"
                                class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-job-referral' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                <x-icons.applicant-icon />
                                <span class="ml-2">Applicants</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin-job-listing-management"
                                class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-job-listing-management' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                <x-icons.job-icon />
                                <span class="ml-2">Job Listings</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin-announcement-section"
                                class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-announcement-section' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                <x-icons.announcement-icon />
                                <span class="ml-2">Announcement Section</span>
                            </a>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <h2 class="text-xl font-bold pl-6 mb-4">Reports</h2>
                        <ul class="space-y-1">
                            <li>
                                <a href="/admin-report"
                                    class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-report' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                    <x-icons.report-icon /> 
                                    <span class="ml-2">Reports</span>
                                </a>
                            </li>
                            <li>
                                <a href="/admin-generated-report"
                                    class="flex items-center px-6 py-3 mx-4 rounded-lg transition-all duration-200 {{ $currentRoute === 'admin-generated-report' ? 'bg-blue-700 font-semibold' : 'hover:bg-blue-800 font-medium' }}">
                                    <x-icons.generated-report-icon /> 
                                    <span class="ml-2">Generated Reports</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="mb-6">
                    <form action="{{ route('admin.logout') }}" method="POST" class="text-center">
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
    @endif
@else
    <div class="flex-1 p-8">
        <h1 class="text-3xl font-bold">You are not logged in...</h1>
    </div>
@endauth
