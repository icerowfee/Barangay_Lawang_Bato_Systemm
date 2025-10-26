<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
</head>

<body class="flex h-screen bg-gray-100">

    @include('company/company-side-panel')

    <div class="min-h-screen flex flex-col flex-1">
        <!-- Header -->
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-700">Company Dashboard</h1>
            <div>
                <span class="text-gray-500">Welcome, <b>{{auth('company')->user()->company_name}}</b></span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 space-y-6">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <h2 class="text-sm text-gray-500">Total Jobs</h2>
                    <p class="text-2xl font-bold text-blue-600">{{$jobListings->count()}}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <h2 class="text-sm text-gray-500">Active Jobs</h2>
                    <p class="text-2xl font-bold text-green-600">{{$jobListings->where('status', 'Active')->count()}}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <h2 class="text-sm text-gray-500">Total Applicants</h2>
                    <p class="text-2xl font-bold text-purple-600">{{$applicants->count()}}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <h2 class="text-sm text-gray-500">Pending Applicants</h2>
                    <p class="text-2xl font-bold text-yellow-600">{{$shortlistedApplicantsCount}}</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Applicants per Job (Bar) -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-lg font-bold text-gray-700 mb-4">Applicants per Job</h2>
                    <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                        <canvas id="stackedBarChart"></canvas>
                    </div>
                </div>

                <!-- Applicant Status (Doughnut) -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h2 class="text-lg font-bold text-gray-700 mb-4">Applicant Status Distribution</h2>
                    <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Job Posts Table -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold text-gray-700 mb-4">Recent Job Posts</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Job Title</th>
                                <th class="px-4 py-3">Job Category</th>
                                <th class="px-4 py-3">Applicants</th>
                                <th class="px-4 py-3">Posted Date</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentJobListings as $job)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $job->title ?? $job->job_title ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $job->category->name ?? $job->job_category ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $job->applicants_count ?? ($job->applicants->count() ?? 0) }}</td>
                                    <td class="px-4 py-3">{{ optional($job->created_at)->format('M d, Y') ?? '—' }}</td>
                                    <td class="px-4 py-3">
                                        @php $status = $job->status ?? 'Closed'; @endphp

                                        @if(strcasecmp($status, 'Active') === 0)
                                            <span class="px-2 py-1 rounded bg-green-100 text-green-600 text-xs">Active</span>
                                        @elseif(strcasecmp($status, 'Pending') === 0)
                                            <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-600 text-xs">Pending</span>
                                        @elseif(strcasecmp($status, 'Closed') === 0 || strcasecmp($status, 'Rejected') === 0)
                                            <span class="px-2 py-1 rounded bg-red-100 text-red-600 text-xs">{{ $status }}</span>
                                        @else
                                            <span class="px-2 py-1 rounded bg-gray-100 text-gray-600 text-xs">{{ $status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Bar Chart - Applicants per Job
            const stackedBarCtx = document.getElementById('stackedBarChart').getContext('2d');
            new Chart(stackedBarCtx, {
                type: 'bar',
                data: {
                    labels: @json($jobTitles),
                    datasets: [
                        {
                            label: 'Pending',
                            data: @json($pendingCounts),
                            backgroundColor: 'rgba(255, 206, 86, 0.7)', // yellow
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Accepted',
                            data: @json($acceptedCounts),
                            backgroundColor: 'rgba(75, 192, 192, 0.7)', // green
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Rejected',
                            data: @json($rejectedCounts),
                            backgroundColor: 'rgba(255, 99, 132, 0.7)', // red
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Applicants per Job (by Status)',
                            font: { size: 18 }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        x: { stacked: true },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            title: { display: true, text: 'Number of Applicants' }
                        }
                    }
                }
            });

            // Doughnut Chart - Applicant Status
            const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Approved', 'Pending', 'Rejected'],
                    datasets: [{
                        data: [
                            @json($acceptedTotal),
                            @json($pendingTotal),
                            @json($rejectedTotal)
                        ],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.7)',
                            'rgba(234, 179, 8, 0.7)',
                            'rgba(239, 68, 68, 0.7)'
                        ],
                        borderColor: ['#22c55e', '#eab308', '#ef4444'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>

    @livewireScripts
    
</body>

</html>
