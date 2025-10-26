<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Super Admin Logs</title>

</head>
<body class="flex h-screen bg-gray-100" x-data="{
    date_filter: '{{ request('date_filter') }}',
    from_date: '{{ request('from_date') }}',
    to_date: '{{ request('to_date') }}',
    search: '{{ request('search') }}',
    admin_type: '{{ request('admin_type') }}',
    clearCustomFilter: function() {
        if (this.date_filter !== 'custom') {
            this.from_date = '';
            this.to_date = '';
        }
    },
    
    clearFilter: function() {
        this.date_filter = 'all';
        this.from_date = '';
        this.to_date = '';
        this.admin_type = 'all';
        this.search = '';

        // Now instead of submitting the form...
        $nextTick(() => {
            // Remove all query parameters without reloading the page
            const url = window.location.origin + window.location.pathname;
            window.history.pushState({}, '', url);

            // THEN submit the form if you want to refresh results
            document.getElementById('filterForm').submit();
        });
    }
}">
    <!-- Sidebar -->
    @include('super-admin/super-admin-side-panel')

    <!-- Main Content (Placeholder) -->
    <div class="relative h-screen flex-1 p-8 overflow-y-scroll">
        <h1 class="text-3xl font-bold mb-10 ">Super Admin Log Reports</h1>
        
        <!-- Filters -->
        <form id="filterForm" method="GET" action="{{ route('go.to.super.admin.log') }}" class="bg-white shadow rounded-lg p-4 mb-6 flex flex-wrap gap-4 items-end">
            <div class="flex gap-4">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <!-- Filter by Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Filter</label>
                    <select name="date_filter" x-model="date_filter" onchange="this.form.submit()" @click="clearCustomFilter()" class="border p-2 rounded w-52 ">
                        <option value="all" {{ request('date_filter') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="last_3_days" {{ request('date_filter') == 'last_3_days' ? 'selected' : '' }}>Last 3 days</option>
                        <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 days</option>
                        <option value="custom" {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>
                
                <div x-cloak x-show="date_filter === 'custom'" class="flex gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                        <input type="date" name="from_date" x-model="from_date" onchange="this.form.submit()" class="border p-2 rounded w-52 h-[41px]" value="{{ request('from') }}">
                    </div>
        
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="to_date" x-model="to_date" onchange="this.form.submit()" class="border p-2 rounded w-52 h-[41px]" value="{{ request('to') }}">
                    </div>
                </div>
            </div>
            

            <!-- Admin Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Admin Type</label>
                <select name="admin_type" x-model="admin_type" onchange="this.form.submit()" class="border p-2 rounded w-56">
                    <option value="all">All Types</option>
                    <option value="super_admin" {{ request('admin_type') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="document_issuance_admin" {{ request('admin_type') == 'document_issuance_admin' ? 'selected' : '' }}>Document Issuance Admin</option>
                    <option value="job_center_admin" {{ request('admin_type') == 'job_center_admin' ? 'selected' : '' }}>Job Center Admin</option>
                </select>
            </div>


            <!-- Search Input -->
            <div x-init="$nextTick(() => { if (search) $refs.searchInput.focus(); })">
                <label class="block text-sm font-medium text-gray-700 mb-1">Performed By</label>
                <input x-ref="searchInput" type="text" name="search"  x-model.debounce.500ms="search" class="border p-2 rounded w-64" placeholder="Search name or email..."
                    @input.debounce.500ms="
                        $refs.searchInput.blur(); 
                        window.location.href = `?search=${encodeURIComponent(search)}&date_filter=${date_filter}&from_date=${from_date}&to_date=${to_date}&admin_type=${admin_type}`
                    "
                >
            </div>
            

            <button type="button" class=" text-blue px-4 py-2 rounded" @click="clearFilter()" >Clear Filter</button>
            {{-- <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Apply Filters</button> --}}
        </form>

        <!-- Logs Table -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="w-full table-auto text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3 border-b">#</th>
                        <th class="p-3 border-b">Activity</th>
                        <th class="p-3 border-b">Performed By</th>
                        <th class="p-3 border-b">Role</th>
                        <th class="p-3 border-b">Date</th>
                        <th class="p-3 border-b">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activityLogs as $activityLog)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border-b">{{ $loop->iteration }}</td>
                            <td class="p-3 border-b">{{ $activityLog->description }}</td>
                            <td class="p-3 border-b">
                                @if($activityLog->causer)
                                    {{ $activityLog->causer->firstname . " " . $activityLog->causer->lastname ?? 'N/A' }}
                                @else
                                    System
                                @endif
                            </td>
                            <td class="p-3 border-b">
                                @if($activityLog->causer_type == 'App\Models\SuperAdminUser')
                                    Super Admin
                                @elseif($activityLog->causer_type == 'App\Models\AdminUser')
                                    @if($activityLog->causer->role == '1')
                                        Document Issuance Admin
                                    @elseif($activityLog->causer->role == '2')
                                        Job Referral Admin
                                    @endif
                                @endif
                            </td>
                            <td class="p-3 border-b">{{ $activityLog->created_at->format('F j, Y') }}</td>
                            <td class="p-3 border-b">{{ $activityLog->created_at->format('h:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">No logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4">
                {{ $activityLogs->appends(request()->query())->links() }}
            </div>
        </div>
        
    </div>

    @livewireScripts
    
</body>
</html>