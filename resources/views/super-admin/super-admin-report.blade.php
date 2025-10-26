<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Super Admin Reports</title>

</head>
<body class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    @include('super-admin/super-admin-side-panel')

    <!-- Main Content (Placeholder) -->
    <div class="relative h-screen flex-1 p-8 overflow-y-scroll" x-data="{
            date_filter: '{{ request('date_filter') }}',
            module_filter: '{{ request('module_filter', 'all') }}',
            from_date: '{{ request('from_date') }}',
            to_date: '{{ request('to_date') }}',
            clearCustomFilter: function() {
                if (this.date_filter !== 'custom') {
                    this.from_date = '';
                    this.to_date = '';
                }
            }
        }">

        <h1 class="text-3xl font-bold mb-10 ">Super Admin Report Management</h1>
        <!-- Filter Section -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Filter Reports</h2>
            <!-- Filters -->
            <div class="flex flex-wrap justify-between gap-4 items-end">
                <form id="filterForm" method="GET" action="" class="flex flex-wrap justify-between gap-4 items-end">
                    <div class="flex gap-4">
                        <!-- Filter by Date Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Module Filter</label>
                            <select name="module_filter" x-model="module_filter" onchange="this.form.submit()" class="border p-2 rounded w-56 ">
                                <option value="all" {{ request('module_filter') == 'all' ? 'selected' : '' }}>All</option>
                                <option value="super_admin_module" {{ request('module_filter') == 'super_admin_module' ? 'selected' : '' }}>Super Admin Module</option>
                                <option value="document_issuance_module" {{ request('module_filter') == 'document_issuance_module' ? 'selected' : '' }}>Document Issuance Module</option>
                                <option value="job_center_module" {{ request('module_filter') == 'job_center_module' ? 'selected' : '' }}>Job Center Module</option>
                            </select>
                        </div>
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
                </form>

                <form method="POST" action="{{ route('super.admin.generate.report') }}">
                    @csrf
                    <input type="hidden" name="report_type" value="Super Admin Report">
                    <input type="hidden" name="module_filter" :value="module_filter">
                    <input type="hidden" name="filters[date_filter]" :value="date_filter">
                    <input type="hidden" name="filters[from_date]" :value="from_date">
                    <input type="hidden" name="filters[to_date]" :value="to_date">
                    
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 mr-4 rounded">Generate Report</button>
                </form>
            </div>
        </div>

        <!-- Account Management Report Cards -->
        <div x-cloak x-show="module_filter === 'super_admin_module' || module_filter === 'all'" class="mb-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Admin Account Management</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-700">Total Admin Accounts</h3>
                    <p class="text-2xl font-bold text-blue-600 mt-2">{{$adminAccounts->count()}}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-700">Total Document Issuace Admin</h3>
                    <p class="text-2xl font-bold text-yellow-600 mt-2">{{$adminAccounts->where('role', '1')->count()}}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-medium text-gray-700">Total Job Center Admin</h3>
                    <p class="text-2xl font-bold text-red-600 mt-2">{{$adminAccounts->where('role', '2')->count()}}</p>
                </div>
            </div>
        </div>

        <div x-cloak x-show="module_filter === 'job_center_module' || module_filter === 'all'">
            <!-- Job Referral Report Cards -->
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Job Referral Reports</h2>
            <div class="mb-6 flex flex-col gap-4">
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Total Job Referred</h3>
                        <p class="text-2xl font-bold text-blue-600 mt-2">{{$jobReferralRequests->where('status', 'Referred')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Pending Job Referral Requests</h3>
                        <p class="text-2xl font-bold text-yellow-600 mt-2">{{$jobReferralRequests->where('status', 'Pending')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Processing Job Referral Requests</h3>
                        <p class="text-2xl font-bold text-green-600 mt-2">{{$jobReferralRequests->where('status', 'Processing')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Rejected/Cancelled Job Referral Requests</h3>
                        <p class="text-2xl font-bold text-red-600 mt-2">{{$jobReferralRequests->where('status', 'Rejected')->count() + $jobReferralRequests->where('status', 'Cancelled')->count()}}</p>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Active Job Accounts</h3>
                        <p class="text-2xl font-bold text-blue-600 mt-2">{{$jobAccounts->where('status', 'Active')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Pending Job Accounts</h3>
                        <p class="text-2xl font-bold text-yellow-600 mt-2">{{$jobAccounts->where('status', 'Pending')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Accepted Job Accounts</h3>
                        <p class="text-2xl font-bold text-green-600 mt-2">{{$jobAccounts->where('status', 'Approved')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Rejected Job Accounts</h3>
                        <p class="text-2xl font-bold text-red-600 mt-2">{{$jobAccounts->where('status', 'Rejected')->count()}}</p>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Document Issuance Report Cards -->
        <div x-cloak x-show="module_filter === 'document_issuance_module' || module_filter === 'all'">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Document Issuance Reports</h2>
            <div class="mb-6 flex flex-col gap-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Cedulas Issued</h3>
                        <p class="text-2xl font-bold text-blue-600 mt-2">{{$cedulaRequests->where('status', 'Completed')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Cedula Requests Pending</h3>
                        <p class="text-2xl font-bold text-yellow-600 mt-2">{{$cedulaRequests->where('status', 'Pending')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Cedula Requests Accepted</h3>
                        <p class="text-2xl font-bold text-green-600 mt-2">{{$cedulaRequests->where('status', 'Approved')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Cedula Requests Rejected/Cancelled</h3>
                        <p class="text-2xl font-bold text-red-600 mt-2">{{$cedulaRequests->where('status', 'Rejected')->count()}}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Indigency Issued</h3>
                        <p class="text-2xl font-bold text-blue-600 mt-2">{{$indigencyRequests->where('status', 'Completed')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Indigency Requests Pending</h3>
                        <p class="text-2xl font-bold text-yellow-600 mt-2">{{$indigencyRequests->where('status', 'Pending')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Indigency Requests Accepted</h3>
                        <p class="text-2xl font-bold text-green-600 mt-2">{{$indigencyRequests->where('status', 'Approved')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Indigency Requests Rejected/Cancelled</h3>
                        <p class="text-2xl font-bold text-red-600 mt-2">{{$indigencyRequests->where('status', 'Rejected')->count()}}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Clearance Issued</h3>
                        <p class="text-2xl font-bold text-blue-600 mt-2">{{$clearanceRequests->where('status', 'Completed')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Clearance Requests Pending</h3>
                        <p class="text-2xl font-bold text-yellow-600 mt-2">{{$clearanceRequests->where('status', 'Pending')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Clearance Requests Accepted</h3>
                        <p class="text-2xl font-bold text-green-600 mt-2">{{$clearanceRequests->where('status', 'Approved')->count()}}</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-medium text-gray-700">Clearance Requests Rejected/Cancelled</h3>
                        <p class="text-2xl font-bold text-red-600 mt-2">{{$clearanceRequests->where('status', 'Rejected')->count()}}</p>
                    </div>
                </div>
            </div>
        </div>
        

        
        {{-- <!-- Placeholder Chart Section -->
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            <p>[Charts & Visual Analytics Placeholder]</p>
            <p class="text-sm mt-1">Integrate later with Chart.js or Recharts</p>
        </div> --}}
    </div>

    @livewireScripts
    
</body>
</html>