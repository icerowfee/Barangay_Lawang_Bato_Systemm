<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Report</title>

</head>

<body class="flex h-screen bg-gray-100" x-data="{
    date_filter: '{{ request('date_filter') }}',
    from_date: '{{ request('from_date') }}',
    to_date: '{{ request('to_date') }}',

    clearCustomFilter: function() {
        if (this.date_filter !== 'custom') {
            this.from_date = '';
            this.to_date = '';
        }
    }
}">

    @include('admin/admin-side-panel')

    <!-- Main Content (Placeholder) -->


    @if (Auth::guard('admin')->check())
        {{-- Report tab for Document Issuance Admin --}}
        @if (Auth::guard('admin')->user()->role == '1')
            <div class="relative h-screen flex-1 p-8 overflow-y-scroll" x-data="{
                date_filter: '{{ request('date_filter') }}',
                from_date: '{{ request('from_date') }}',
                to_date: '{{ request('to_date') }}',
                clearCustomFilter: function() {
                    if (this.date_filter !== 'custom') {
                        this.from_date = '';
                        this.to_date = '';
                    }
                }
            }">

                <h1 class="text-4xl font-bold mb-8">Document Issuance Reports</h1>
                <!-- Filter Section -->
                <div class="bg-white p-4 rounded-lg shadow mb-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Filter Reports</h2>
                    <!-- Filters -->
                    <div class="flex flex-wrap justify-between gap-4 items-end">
                        <form id="filterForm" method="GET" action=""
                            class="flex flex-wrap justify-between gap-4 items-end">
                            <div class="flex gap-4">
                                <!-- Filter by Date Range -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Filter</label>
                                    <select name="date_filter" x-model="date_filter" onchange="this.form.submit()"
                                        @click="clearCustomFilter()" class="border p-2 rounded w-52 ">
                                        <option value="all" {{ request('date_filter') == 'all' ? 'selected' : '' }}>
                                            All</option>
                                        <option value="today"
                                            {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                        <option value="last_3_days"
                                            {{ request('date_filter') == 'last_3_days' ? 'selected' : '' }}>Last 3 days
                                        </option>
                                        <option value="last_7_days"
                                            {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 days
                                        </option>
                                        <option value="custom"
                                            {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom</option>
                                    </select>
                                </div>

                                <div x-cloak x-show="date_filter === 'custom'" class="flex gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                                        <input type="date" name="from_date" x-model="from_date"
                                            onchange="this.form.submit()" class="border p-2 rounded w-52 h-[41px]"
                                            value="{{ request('from') }}">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                                        <input type="date" name="to_date" x-model="to_date"
                                            onchange="this.form.submit()" class="border p-2 rounded w-52 h-[41px]"
                                            value="{{ request('to') }}">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.generate.report') }}">
                            @csrf
                            <input type="hidden" name="report_type" value="Document Issuance Admin Report">
                            <input type="hidden" name="filters[date_filter]" :value="date_filter">
                            <input type="hidden" name="filters[from_date]" :value="from_date">
                            <input type="hidden" name="filters[to_date]" :value="to_date">

                            <button type="submit" class="bg-green-600 text-white px-4 py-2 mr-4 rounded">Generate
                                Report</button>
                        </form>
                    </div>
                </div>

                <!-- Document Issuance Report Cards -->
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Document Issuance Reports</h2>
                <div class="mb-6 flex flex-col gap-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Cedulas Issued</h3>
                            <p class="text-2xl font-bold text-blue-600 mt-2">
                                {{ $cedulaRequests->where('status', 'Completed')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Cedula Requests Pending</h3>
                            <p class="text-2xl font-bold text-yellow-600 mt-2">
                                {{ $cedulaRequests->where('status', 'Pending')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Cedula Requests Accepted</h3>
                            <p class="text-2xl font-bold text-green-600 mt-2">
                                {{ $cedulaRequests->where('status', 'Approved')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Cedula Requests Rejected</h3>
                            <p class="text-2xl font-bold text-red-600 mt-2">
                                {{ $cedulaRequests->where('status', 'Rejected')->count() }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Indigency Issued</h3>
                            <p class="text-2xl font-bold text-blue-600 mt-2">
                                {{ $indigencyRequests->where('status', 'Completed')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Indigency Requests Pending</h3>
                            <p class="text-2xl font-bold text-yellow-600 mt-2">
                                {{ $indigencyRequests->where('status', 'Pending')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Indigency Requests Accepted</h3>
                            <p class="text-2xl font-bold text-green-600 mt-2">
                                {{ $indigencyRequests->where('status', 'Approved')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Indigency Requests Rejected</h3>
                            <p class="text-2xl font-bold text-red-600 mt-2">
                                {{ $indigencyRequests->where('status', 'Rejected')->count() }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Clearance Issued</h3>
                            <p class="text-2xl font-bold text-blue-600 mt-2">
                                {{ $clearanceRequests->where('status', 'Completed')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Clearance Requests Pending</h3>
                            <p class="text-2xl font-bold text-yellow-600 mt-2">
                                {{ $clearanceRequests->where('status', 'Pending')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Clearance Requests Accepted</h3>
                            <p class="text-2xl font-bold text-green-600 mt-2">
                                {{ $clearanceRequests->where('status', 'Approved')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Clearance Requests Rejected</h3>
                            <p class="text-2xl font-bold text-red-600 mt-2">
                                {{ $clearanceRequests->where('status', 'Rejected')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Chart Placeholder -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500 mt-6  col-span-1">
                        <h3 class="text-lg font-semibold mb-4">Request Status Distribution</h3>
                        <canvas id="statusPieChart"></canvas>
                    </div>
                    <div class=" bg-white p-6 rounded-lg shadow text-center text-gray-500 mt-6 col-span-2">
                        <h3 class="text-lg font-semibold mb-4">Total Documents Issued</h3>
                        <canvas id="issuedDocumentsBarChart"></canvas>
                    </div>
                </div>
            </div>

            @php
                $issuedCedula = $cedulaRequests->where('status', 'Completed')->count();
                $issuedIndigency = $indigencyRequests->where('status', 'Completed')->count();
                $issuedClearance = $clearanceRequests->where('status', 'Completed')->count();

                $pendingCedula = $cedulaRequests->where('status', 'Pending')->count();
                $pendingIndigency = $indigencyRequests->where('status', 'Pending')->count();
                $pendingClearance = $clearanceRequests->where('status', 'Pending')->count();

                $rejectedCedula = $cedulaRequests->where('status', 'Rejected')->count();
                $rejectedIndigency = $indigencyRequests->where('status', 'Rejected')->count();
                $rejectedClearance = $clearanceRequests->where('status', 'Rejected')->count();

                $approvedCedula = $cedulaRequests->where('status', 'Approved')->count();
                $approvedIndigency = $indigencyRequests->where('status', 'Approved')->count();
                $approvedClearance = $clearanceRequests->where('status', 'Approved')->count();

                $completedTotal = $issuedCedula + $issuedIndigency + $issuedClearance;

                $pendingTotal =
                    $cedulaRequests->where('status', 'Pending')->count() +
                    $indigencyRequests->where('status', 'Pending')->count() +
                    $clearanceRequests->where('status', 'Pending')->count();
                $approvedTotal =
                    $cedulaRequests->where('status', 'Approved')->count() +
                    $indigencyRequests->where('status', 'Approved')->count() +
                    $clearanceRequests->where('status', 'Approved')->count();
                $rejectedTotal =
                    $cedulaRequests->where('status', 'Rejected')->count() +
                    $indigencyRequests->where('status', 'Rejected')->count() +
                    $clearanceRequests->where('status', 'Rejected')->count();

            @endphp

            <script>
                const issuedDocuments = @json($issuedDocuments);

                const dataValues = [
                    {{ $issuedCedula }},
                    {{ $issuedClearance }},
                    {{ $issuedIndigency }},
                    {{ $pendingCedula }},
                    {{ $pendingClearance }},
                    {{ $pendingIndigency }},
                    {{ $rejectedCedula }},
                    {{ $rejectedClearance }},
                    {{ $rejectedIndigency }},
                    {{ $approvedCedula }},
                    {{ $approvedClearance }},
                    {{ $approvedIndigency }},
                ];

                // Get the maximum value from the dataset
                const maxValue = Math.max(...dataValues);

                // Calculate dynamic max (round up to nearest 10 + add buffer)
                const dynamicMax = Math.ceil((maxValue + 10) / 10) * 10;

                document.addEventListener('DOMContentLoaded', function() {
                    const statusPieCtx = document.getElementById('statusPieChart').getContext('2d');

                    new Chart(statusPieCtx, {
                        type: 'pie',
                        data: {
                            labels: [
                                'Completed ({{ $completedTotal }})',
                                'Pending ({{ $pendingTotal }})',
                                'Approved ({{ $approvedTotal }})',
                                'Rejected ({{ $rejectedTotal }})'
                            ],
                            datasets: [{
                                data: [
                                    {{ $completedTotal }},
                                    {{ $pendingTotal }},
                                    {{ $approvedTotal }},
                                    {{ $rejectedTotal }}
                                ],
                                backgroundColor: ['#1d4ed8', '#f97316', '#22c55e', '#ef4444'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            plugins: {
                                datalabels: {
                                    color: '#fff',
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    },
                                    formatter: (value) => value // show the number directly
                                }
                            }
                        },
                    });

                    // Bar Chart For Issued Documents
                    const barCtx = document.getElementById('issuedDocumentsBarChart')?.getContext('2d');

                    if (barCtx) {
                        new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: ['Cedula', 'Clearance', 'Indigency'],
                                datasets: [{
                                        label: 'Issued',
                                        data: [{{ $issuedCedula }}, {{ $issuedClearance }},
                                            {{ $issuedIndigency }}
                                        ],
                                        backgroundColor: '#1d4ed8', // red
                                    },
                                    {
                                        label: 'Pending',
                                        data: [{{ $pendingCedula }}, {{ $pendingClearance }},
                                            {{ $pendingIndigency }}
                                        ],
                                        backgroundColor: '#f97316', // blue
                                    }, 
                                    {
                                        label: 'Approved',
                                        data: [{{ $approvedCedula }}, {{ $approvedClearance }},
                                            {{ $approvedIndigency }}
                                        ],
                                        backgroundColor: '#22c55e', // green
                                    },
                                    {
                                        label: 'Rejected',
                                        data: [{{ $rejectedCedula }}, {{ $rejectedClearance }},
                                            {{ $rejectedIndigency }}
                                        ],
                                        backgroundColor: '#ef4444', // red
                                    }
                                ]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            boxWidth: 20,
                                            padding: 15
                                        }
                                    },
                                    datalabels: {
                                        color: '#fff',
                                        font: {
                                            weight: 'bold',
                                            size: 12
                                        },
                                        formatter: (value) => value // show the number directly
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true, // always start from 0
                                        min: 0, // minimum value for y-axis
                                        max: dynamicMax, // maximum value for y-axis
                                        ticks: {
                                            stepSize: 5 // interval between ticks (0, 5, 10, 15, 20)
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            </script>



            {{-- Report tab for Job Center Admin --}}
        @elseif (Auth::guard('admin')->user()->role == '2')
            <div class="relative h-screen flex-1 p-8 overflow-y-scroll" x-data="{
                date_filter: '{{ request('date_filter') }}',
                from_date: '{{ request('from_date') }}',
                to_date: '{{ request('to_date') }}',
                clearCustomFilter: function() {
                    if (this.date_filter !== 'custom') {
                        this.from_date = '';
                        this.to_date = '';
                    }
                }
            }">

                <h1 class="text-4xl font-bold mb-8">Job Referral Report</h1>
                <!-- Filter Section -->
                <div class="bg-white p-4 rounded-lg shadow mb-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Filter Reports</h2>
                    <!-- Filters -->
                    <div class="flex flex-wrap justify-between gap-4 items-end">
                        <form id="filterForm" method="GET" action=""
                            class="flex flex-wrap justify-between gap-4 items-end">
                            <div class="flex gap-4">
                                <!-- Filter by Date Range -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Filter</label>
                                    <select name="date_filter" x-model="date_filter" onchange="this.form.submit()"
                                        @click="clearCustomFilter()" class="border p-2 rounded w-52 ">
                                        <option value="all"
                                            {{ request('date_filter') == 'all' ? 'selected' : '' }}>All</option>
                                        <option value="today"
                                            {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                        <option value="last_3_days"
                                            {{ request('date_filter') == 'last_3_days' ? 'selected' : '' }}>Last 3 days
                                        </option>
                                        <option value="last_7_days"
                                            {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 days
                                        </option>
                                        <option value="custom"
                                            {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom</option>
                                    </select>
                                </div>

                                <div x-cloak x-show="date_filter === 'custom'" class="flex gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                                        <input type="date" name="from_date" x-model="from_date"
                                            onchange="this.form.submit()" class="border p-2 rounded w-52 h-[41px]"
                                            value="{{ request('from') }}">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                                        <input type="date" name="to_date" x-model="to_date"
                                            onchange="this.form.submit()" class="border p-2 rounded w-52 h-[41px]"
                                            value="{{ request('to') }}">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('admin.generate.report') }}">
                            @csrf
                            <input type="hidden" name="report_type" value="Job Center Admin Report">
                            <input type="hidden" name="filters[date_filter]" :value="date_filter">
                            <input type="hidden" name="filters[from_date]" :value="from_date">
                            <input type="hidden" name="filters[to_date]" :value="to_date">

                            <button type="submit" class="bg-green-600 text-white px-4 py-2 mr-4 rounded">Generate
                                Report</button>
                        </form>
                    </div>
                </div>

                <!-- Job Referral Report Cards -->
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Job Referral Reports</h2>
                <div class="mb-6 flex flex-col gap-4">
                    <div class="grid grid-cols-5 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Applicants Accepted by Company</h3>
                            <p class="text-2xl font-bold text-green-600 mt-2">
                                {{ $jobReferralRequests->where('status', 'Accepted by Company')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Referred Applicants</h3>
                            <p class="text-2xl font-bold text-blue-600 mt-2">
                                {{ $jobReferralRequests->where('status', 'Shortlisted')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Pending Applicant Requests</h3>
                            <p class="text-2xl font-bold text-orange-600 mt-2">
                                {{ $jobReferralRequests->where('status', 'Applied')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Rejected Applicant Requests</h3>
                            <p class="text-2xl font-bold text-red-600 mt-2">
                                {{ $jobReferralRequests->where('status', 'Rejected')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Applicants Rejected by Company</h3>
                            <p class="text-2xl font-bold text-yellow-600 mt-2">
                                {{ $jobReferralRequests->where('status', 'Rejected by Company')->count() }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Active User Accounts</h3>
                            <p class="text-2xl font-bold text-blue-600 mt-2">
                                {{ $jobAccounts->where('status', 'Active')->count() }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Pending User Accounts</h3>
                            <p class="text-2xl font-bold text-yellow-600 mt-2">
                                {{ $jobAccounts->where('status', 'Pending')->count() }}</p>
                        </div>
                        {{-- <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Accepted Job Accounts</h3>
                            <p class="text-2xl font-bold text-green-600 mt-2">
                                {{ $jobAccounts->where('status', 'Approved')->count() }}</p>
                        </div> --}}
                        <div class="bg-white p-4 rounded-lg shadow">
                            <h3 class="text-lg font-medium text-gray-700">Rejected User Accounts</h3>
                            <p class="text-2xl font-bold text-red-600 mt-2">
                                {{ $jobAccounts->where('status', 'Rejected')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                    <!-- Admin Roles Pie Chart -->
                    <div class="bg-white p-6 rounded-lg shadow h-[350px] flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold mb-4">User Accounts Status</h3>
                        <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                            <canvas id="jobAccountStatusPieChart"></canvas>
                        </div>

                    </div>

                    <!-- Account Creation Trend -->
                    <div class="bg-white p-6 rounded-lg shadow h-[350px] flex flex-col items-center justify-center">
                        <h3 class="text-lg font-semibold mb-4">Referred Job Seeker</h3>
                        <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                            <canvas id="jobReferralStatusPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Pie Chart
                    const pijobAccountStatusPieCharteCtx = document.getElementById('jobAccountStatusPieChart').getContext(
                        '2d');
                    new Chart(jobAccountStatusPieChart, {
                        type: 'pie',
                        data: {
                            labels: ['Active', 'Pending', 'Rejected'],
                            datasets: [{
                                label: 'Job Accounts',
                                data: [
                                    {{ $jobAccounts->where('status', 'Active')->count() }},
                                    {{ $jobAccounts->where('status', 'Pending')->count() }},
                                    // {{ $jobAccounts->where('status', 'Approved')->count() }},
                                    {{ $jobAccounts->where('status', 'Rejected')->count() }}
                                ],
                                backgroundColor: ['#1d4ed8', '#ea580c', '#16a34a', '#dc2626'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                datalabels: {
                                    color: '#ffff',
                                    font: {
                                        weight: 'bold',
                                        size: 13
                                    },
                                    formatter: (value) => value // show the number directly
                                }
                            }
                        }
                    });

                    // Pie Chart
                    const jobReferralPieChart = document.getElementById('jobReferralStatusPieChart').getContext('2d');
                    new Chart(jobReferralPieChart, {
                        type: 'pie',
                        data: {
                            labels: ['Accepted by Company', 'Referred', 'Pending', 'Rejected by Admim', 'Rejected by Company'],
                            datasets: [{
                                label: 'Job Accounts',
                                data: [
                                    {{ $jobReferralRequests->where('status', 'Accepted by Company')->count() }},
                                    {{ $jobReferralRequests->where('status', 'Shortlisted')->count() }},
                                    {{ $jobReferralRequests->where('status', 'Applied')->count() }},
                                    {{ $jobReferralRequests->where('status', 'Rejected')->count() }},
                                    {{ $jobReferralRequests->where('status', 'Rejected by Company')->count() }}
                                ],
                                backgroundColor: ['#16a34a', '#1d4ed8', '#ea580c', '#dc2626', '#ca8a04'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                datalabels: {
                                    color: '#ffff',
                                    font: {
                                        weight: 'bold',
                                        size: 13
                                    },
                                    formatter: (value) => value // show the number directly
                                }
                            }
                        }
                    });


                });
            </script>
        @endif
    @else
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold">You are not logged in...</h1>
        </div>
    @endIf

    @livewireScripts

</body>

</html>
