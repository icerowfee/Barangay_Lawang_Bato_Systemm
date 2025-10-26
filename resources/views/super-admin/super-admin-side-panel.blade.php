@php
    $currentRoute = Request::path();
@endphp

<!-- Sidebar for Super Admin -->
<div class="flex flex-col h-full w-1/5 bg-blue-900 text-white shadow-lg">
    <!-- Profile Section -->
    <div class="flex flex-col items-center p-6 bg-blue-900">
        <div class="h-24 w-24 rounded-full overflow-hidden border-4 border-white">
            <img src="{{asset('images/profile-picture.png')}}" alt="Profile Picture" class="h-full w-full object-cover">
        </div>
        <p class="mt-4 text-lg font-semibold">Welcome, <span class="font-bold">Super Admin</span>!</p>
    </div>

    <!-- Navigation Menu -->
    <div class="flex flex-col justify-between flex-1">
        <nav class="mt-6">
            <h2 class="text-xl font-bold pl-6 mb-4">Super Admin Panel</h2>
            <ul class="space-y-1">
                <li>
                    <a href="/super-admin-dashboard" class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'super-admin-dashboard' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        📊 <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/super-admin-account-management" class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'super-admin-account-management' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        🧑🏻 <span class="ml-3">Manage Accounts</span>
                    </a>
                </li>
                <li>
                    <a href="/super-admin-announcement-management" class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'super-admin-announcement-management' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        📢 <span class="ml-3">Manage Announcements</span>
                    </a>
                </li>
                <li>
                    <a href="/super-admin-barangay-official-management" class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'super-admin-barangay-official-management' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        📄 <span class="ml-3">Barangay Officials</span>
                    </a>
                </li>
                <li>
                    <a href="/super-admin-sk-official-management" class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'super-admin-sk-official-management' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                        💼 <span class="ml-3">SK Officials</span>
                    </a>
                </li>
            </ul>

            <div class="mt-10">
                <h2 class="text-xl font-bold pl-6 mb-4">Reports</h2>
                <ul class="space-y-1">
                    <li>
                        <a href="/super-admin-report" class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'super-admin-report' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                            📊 <span class="ml-3">Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="/super-admin-generated-report" class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'super-admin-generated-report' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                            📊 <span class="ml-3">Generated Reports</span>
                        </a>
                    </li>
                    <li>
                        <a href="/super-admin-log" class="flex items-center px-6 py-3 rounded-lg transition-all duration-200 {{ $currentRoute === 'super-admin-log' ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
                            📊 <span class="ml-3">Logs</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="mb-6">
            <form action="{{route('super.admin.logout')}}" method="POST" class="text-center">
                @csrf
                <button class="bg-red-500 hover:bg-red-600 transition text-white px-4 py-2 rounded-lg mt-4">Log out</button>
            </form>
            <div class="text-center mt-4 text-sm text-gray-300">
                <p>@2024 Barangay Lawang Bato</p>
            </div>
        </div>
    </div>
</div>