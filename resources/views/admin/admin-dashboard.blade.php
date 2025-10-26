<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>

</head>

<body class="flex h-screen bg-gray-100">

    @include('admin/admin-side-panel')

    <!-- Main Content (Placeholder) -->

    {{-- Document Issuance Admin Dashboard --}}
    @if (Auth::guard('admin')->check())
        @if (Auth::guard('admin')->user()->role == '1')
            <div class="relative h-screen flex-1 p-8 overflow-y-scroll">
                <h1 class="text-4xl font-bold mb-8">Document Issuance Admin Dashboard</h1>

                {{-- Metrics Section --}}
                <div class="grid grid-cols-5 gap-6 mb-10">
                    <div class="bg-white p-4 shadow-lg rounded-lg flex flex-col justify-center items-center">
                        <div class="flex items-center justify-center h-full">
                            <div class="grid grid-cols-2 items-center justify-items-center h-full">
                                <h2 class=" text-lg text-black text-center mb-2"><strong>Total Issued Documents</strong>
                                </h2>
                                <div
                                    class="flex items-center justify-center bg-blue-600 text-white rounded-md h-20 w-20 ">
                                    <p class="text-2xl font-semibold text-center">
                                        {{ $documentRequests['cedula']->where('status', 'Completed')->count() +
                                            $documentRequests['clearance']->where('status', 'Completed')->count() +
                                            $documentRequests['indigency']->where('status', 'Completed')->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-4 grid grid-cols-3 gap-6">
                        <div class="bg-blue-300 p-4 shadow-lg rounded-lg flex flex-col justify-between">
                            <h2 class=" text-lg text-black text-center mb-2"><strong>Cedula Requests</strong></h2>
                            <div class="grid grid-cols-4 items-center justify-between">
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><strong>Issued</strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-blue-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['cedula']->where('status', 'Completed')->count() }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><Strong>Pending</Strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-orange-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['cedula']->where('status', 'Pending')->count() }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><strong>Accepted</strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-green-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['cedula']->where('status', 'Approved')->count() }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><strong>Rejected</strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-red-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['cedula']->where('status', 'Rejected')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-300 p-4 shadow-lg rounded-lg flex flex-col justify-between">
                            <h2 class=" text-lg text-black text-center mb-2"><strong>Clearance Requests</strong></h2>
                            <div class="grid grid-cols-4 items-center justify-between">
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><strong>Issued</strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-blue-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['clearance']->where('status', 'Completed')->count() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><Strong>Pending</Strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-orange-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['clearance']->where('status', 'Pending')->count() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><strong>Accepted</strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-green-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['clearance']->where('status', 'Approved')->count() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><strong>Rejected</strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-red-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['clearance']->where('status', 'Rejected')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-300 p-4 shadow-lg rounded-lg flex flex-col justify-between">
                            <h2 class=" text-lg text-black text-center mb-2"><strong>Indigency Requests</strong></h2>
                            <div class="grid grid-cols-4 items-center justify-between">
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><strong>Issued</strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-blue-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['indigency']->where('status', 'Completed')->count() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><Strong>Pending</Strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-orange-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['indigency']->where('status', 'Pending')->count() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><strong>Accepted</strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-green-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['indigency']->where('status', 'Approved')->count() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-center">
                                    <h2 class="text-sm text-gray-700 pb-2"><strong>Rejected</strong></h2>
                                    <div
                                        class="flex items-center justify-center bg-red-600 text-white rounded-md w-10 h-10">
                                        <p class="text-2xl font-semibold">
                                            {{ $documentRequests['indigency']->where('status', 'Rejected')->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                    <!-- Admin Roles Pie Chart -->
                    <div class="bg-white p-6 rounded-lg shadow-lg h-[350px] flex flex-col items-center justify-center">
                        <h3 class="text-2xl font-bold mb-4">Overall Document Issued Status</h3>
                        <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                            <canvas id="myPieChart"></canvas>
                        </div>

                    </div>

                    <!-- Issued Document Over Time -->
                    <div class="bg-white p-6 rounded-lg shadow-lg h-[350px] flex flex-col items-center justify-center">
                        <h3 class="text-2xl font-bold mb-4">Issued Documents Over Time</h3>
                        <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                            <canvas id="stackedBarChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Empty State if No Requests --}}
                <div class="relative w-full pb-12 flex flex-col bg-white rounded-lg shadow-lg p-4">
                    <div class="flex justify-center pb-4">
                        <h2 class="text-2xl font-bold">New Document Requests</h2>
                    </div>
                    @if ($mergedNewRequests->isEmpty())
                        <div class="w-full h-full flex flex-1 items-center justify-center rounded-lg shadow">
                            <div class="text-center">
                                <div class="mb-4 flex justify-center h-32">
                                    <img src="{{ asset('images/new-document-icon.png') }}" alt="No Requests">
                                </div>
                                <h2 class="text-xl font-semibold text-gray-600 mb-2">Nothing to process right now</h2>
                                <p class="text-gray-500">You’re all caught up! New document requests will show up here.
                                </p>
                            </div>
                        </div>
                    @else
                        <div>
                            <table class="min-w-full border border-gray-300 text-base">
                                <thead>
                                    <tr class="bg-gray-200 uppercase tracking-wider">
                                        <th class="border p-3">#</th>
                                        <th class="border p-3">Fullname</th>
                                        <th class="border p-3">Address</th>
                                        <th class="border p-3">Date</th>
                                        <th class="border p-3">Time</th>
                                        <th class="border p-3">Document Type</th>
                                        <th class="border p-3">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($mergedNewRequests as $newRequest)
                                        <tr class="cursor-pointer hover:bg-gray-100 transition text-center"
                                            @click="selectedRequest = {{ $newRequest->toJson() }}; showAcceptedCedulaModal = true;">
                                            <td class="border p-2">{{ $loop->iteration }}</td>
                                            @if ($newRequest->document_type === 'indigency')
                                                <td class="border p-2">{{ $newRequest->representative_lastname }},
                                                    {{ $newRequest->representative_firstname }}
                                                    {{ $newRequest->representative_middlename }}</td>
                                            @else
                                                <td class="border p-2">{{ $newRequest->lastname }},
                                                    {{ $newRequest->firstname }} {{ $newRequest->middlename }}</td>
                                            @endif
                                            <td class="border p-2">{{ $newRequest->house_number }},
                                                {{ $newRequest->barangay }}, {{ $newRequest->city }},
                                                {{ $newRequest->province }}</td>
                                            <td class="border p-2">{{ $newRequest->formatted_date }}</td>
                                            <td class="border p-2">{{ $newRequest->formatted_time }}</td>
                                            <td class="border p-2 capitalize">{{ $newRequest->document_type }}</td>
                                            <td class="border p-2">
                                                <span
                                                    class="px-2 py-1 text-white rounded 
                                                        {{ $newRequest->status === 'Approved'
                                                            ? 'bg-green-500'
                                                            : ($newRequest->status === 'Rejected'
                                                                ? 'bg-red-500'
                                                                : ($newRequest->status === 'Pending'
                                                                    ? 'bg-yellow-500'
                                                                    : ($newRequest->status === 'Completed'
                                                                        ? 'bg-blue-500'
                                                                        : 'bg-gray-500'))) }}">
                                                    {{ $newRequest->status ?? 'Pending' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="absolute bottom-3 right-5 w-full flex justify-end pt-2">
                                <a class="hover:underline text-blue-700" href="/admin-document-request">View all
                                    requests</a>
                            </div>
                        </div>

                    @endif

                </div>
            </div>



            <script>
                const monthLabels = @json($months);
                const issuedCedula = @json($issuedCedulaCounts);
                const issuedIndigency = @json($issuedIndigencyCounts);
                const issuedClearance = @json($issuedClearanceCounts);


                document.addEventListener('DOMContentLoaded', function() {
                    // Pie Chart
                    const pieCtx = document.getElementById('myPieChart').getContext('2d');
                    new Chart(pieCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Successfully Issued', 'Pending Requests', 'Accepted Requests',
                                'Rejected Requests'
                            ],
                            datasets: [{
                                label: '',
                                data: [
                                    {{ $documentRequests['cedula']->where('status', 'Completed')->count() +
                                        $documentRequests['clearance']->where('status', 'Completed')->count() +
                                        $documentRequests['indigency']->where('status', 'Completed')->count() }},
                                    {{ $documentRequests['cedula']->where('status', 'Pending')->count() +
                                        $documentRequests['clearance']->where('status', 'Pending')->count() +
                                        $documentRequests['indigency']->where('status', 'Pending')->count() }},
                                    {{ $documentRequests['cedula']->where('status', 'Approved')->count() +
                                        $documentRequests['clearance']->where('status', 'Approved')->count() +
                                        $documentRequests['indigency']->where('status', 'Approved')->count() }},
                                    {{ $documentRequests['cedula']->where('status', 'Rejected')->count() +
                                        $documentRequests['clearance']->where('status', 'Rejected')->count() +
                                        $documentRequests['indigency']->where('status', 'Rejected')->count() }}
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
                                    position: 'right'
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
                        },
                    });

                    // Bar Chart
                    const stackedBarCtx = document.getElementById('stackedBarChart')?.getContext('2d');

                    if (stackedBarCtx) {
                        new Chart(stackedBarCtx, {
                            type: 'bar',
                            data: {
                                labels: monthLabels,
                                datasets: [{
                                        label: 'Cedula Issued',
                                        data: issuedCedula,
                                        backgroundColor: '#93c5fd ',
                                    },
                                    {
                                        label: 'Clearance Issued',
                                        data: issuedClearance,
                                        backgroundColor: '#86efac',
                                    },
                                    {
                                        label: 'Indigency Issued',
                                        data: issuedIndigency,
                                        backgroundColor: '#fde047',
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            boxWidth: 20,
                                            padding: 15
                                        }
                                    },
                                    datalabels: {
                                        color: '#ffff',
                                        font: {
                                            weight: 'bold',
                                            size: 13
                                        },
                                        formatter: (value) => value // show the number directly
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: true
                                    },
                                    y: {
                                        stacked: true,
                                        beginAtZero: true, // always start from 0
                                        min: 0, // minimum value for y-axis
                                        max: 50, // maximum value for y-axis
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






            {{-- Job Center Dashboard --}}
        @elseif (Auth::guard('admin')->user()->role == '2')
            <div class="relative h-screen flex-1 p-8 overflow-y-scroll">
                <h1 class="text-4xl font-bold mb-8">Job Referral Admin Dashboard</h1>
                <!-- Stats Section -->
                <div class="grid grid-cols-4 gap-6 mb-10">
                    <div class="bg-white p-4 shadow-lg rounded-lg flex flex-col justify-between">
                        <h2 class=" text-lg text-black text-center mb-2"><strong>User Accounts</strong></h2>
                        <div class="grid grid-cols-3 items-center justify-between">
                            <div class="flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Active</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-blue-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobAccounts->where('status', 'Active')->count() }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Pending</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-orange-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobAccounts->where('status', 'Pending')->count() }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Rejected</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-red-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobAccounts->where('status', 'Rejected')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white col-span-2 p-4 shadow-lg rounded-lg flex flex-col justify-between">
                        <h2 class=" text-lg text-black text-center mb-2"><strong>Job Referral Requests</strong></h2>
                        <div class="grid grid-cols-7 items-center justify-between">
                            <div class="col-span-2 flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Accepted by Company</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-green-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobReferralRequests->where('status', 'Accepted by Company')->count() }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Referred</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-blue-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobReferralRequests->where('status', 'Shortlisted')->count() }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Pending</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-orange-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobReferralRequests->where('status', 'Applied')->count() }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Rejected</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-red-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobReferralRequests->where('status', 'Rejected')->count() }}</p>
                                </div>
                            </div>
                            <div class="col-span-2 flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Rejected by Company</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-yellow-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobReferralRequests->where('status', 'Rejected by Company')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 shadow-lg rounded-lg flex flex-col justify-between">
                        <h2 class=" text-lg text-black text-center mb-2"><strong>Company Accounts</strong></h2>
                        <div class="grid grid-cols-3 items-center justify-between">
                            <div class="flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Active</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-blue-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobAccounts->where('status', 'Active')->count() }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Pending</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-orange-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobAccounts->where('status', 'Pending')->count() }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-center">
                                <h2 class="text-sm text-gray-700 pb-2"><strong>Rejected</strong></h2>
                                <div
                                    class="flex items-center justify-center bg-red-600 text-white rounded-md px-2 min-w-16 w-fit h-10">
                                    <p class="text-2xl font-semibold">
                                        {{ $jobAccounts->where('status', 'Rejected')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Charts -->
                <div class="grid grid-cols-4 gap-6 mb-10">
                    <!-- Admin Roles Pie Chart -->
                    <div
                        class="bg-white p-6 col-span-1 rounded-lg shadow h-[350px] flex flex-col items-center justify-center">
                        <h3 class="text-2xl font-bold mb-4">User Accounts Status</h3>
                        <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                            <canvas id="jobAccountsStatusChart"></canvas>
                        </div>
                    </div>

                    <!-- Account Creation Trend -->
                    <div
                        class="bg-white p-6 col-span-2 rounded-lg shadow h-[350px] flex flex-col items-center justify-center">
                        <h3 class="text-2xl font-bold mb-4">Job Referral Status Distribution Over Time</h3>
                        <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                            <canvas id="stackedBarChart"></canvas>
                        </div>
                    </div>

                    <!-- Admin Roles Pie Chart -->
                    <div
                        class="bg-white p-6 col-span-1 rounded-lg shadow h-[350px] flex flex-col items-center justify-center">
                        <h3 class="text-2xl font-bold mb-4">Company Accounts Status</h3>
                        <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                            <canvas id="companyAccountsStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- New Job Referral Request Table -->
                <div class="relative w-full pb-12 flex flex-col bg-white rounded-lg shadow-lg p-4 mb-10">
                    <div class="flex justify-center pb-4">
                        <h2 class="text-2xl font-bold">New Job Referral Requests</h2>
                    </div>
                    @if ($jobReferralRequests->where('status', 'Applied')->take(6)->isEmpty())
                        <div class="w-full h-full flex flex-1 items-center justify-center rounded-lg">
                            <div class="text-center">
                                <img src="{{ asset('images/new-job-referral-request-icon.png') }}" alt="No Referrals"
                                    class="mx-auto h-24 mb-4">
                                <h2 class="text-xl font-semibold text-gray-600 mb-2">This Space is Empty</h2>
                                <p class="text-gray-500">Start processing job referral requests to help job seekers get
                                    matched.</p>
                            </div>
                        </div>
                    @else
                        <div>
                            <table class="min-w-full bg-white border border-gray-300">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="border p-2">#</th>
                                        <th class="border p-2">Fullname</th>
                                        <th class="border p-2">Address</th>
                                        <th class="border p-2">Sex</th>
                                        <th class="border p-2">Date</th>
                                        <th class="border p-2">Time</th>
                                        <th class="border p-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jobReferralRequests->where('status', 'Applied')->take(6) as $newRequest)
                                        <tr class="cursor-pointer hover:bg-gray-200 transition text-center"
                                            @click="selectedRequest = {{ $newRequest->load('user')->toJson() }}; showNewJobReferralRequestData = true;">
                                            <td class="border p-2">{{ $loop->iteration }}</td>
                                            <td class="border p-2">{{ $newRequest->user->lastname }},
                                                {{ $newRequest->user->firstname }} {{ $newRequest->user->middlename }}
                                            </td>
                                            <td class="border p-2">{{ $newRequest->user->house_number }},
                                                {{ $newRequest->user->barangay }}, {{ $newRequest->user->city }},
                                                {{ $newRequest->user->province }}</td>
                                            <td class="border p-2">{{ $newRequest->user->sex }}</td>
                                            <td class="border p-2">{{ $newRequest->formatted_date }}</td>
                                            <td class="border p-2">{{ $newRequest->formatted_time }}</td>
                                            <td class="border p-2">
                                                <span class="px-2 py-1 text-white rounded bg-yellow-500">
                                                    {{ $newRequest->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="absolute bottom-3 right-5 w-full flex justify-end pt-2">
                                <a class="hover:underline text-blue-700" href="/admin-job-referral">View all
                                    requests</a>
                            </div>
                        </div>
                    @endIf
                </div>



                <div class="grid grid-cols-2 gap-6">
                    <!-- New User Account Request Table -->
                    <div class="relative w-full pb-12 flex flex-col bg-white rounded-lg shadow-lg p-4">
                        <div class="flex justify-center pb-4">
                            <h2 class="text-2xl font-bold">New User Account Requests</h2>
                        </div>
                        @if ($jobAccounts->where('status', 'Pending')->take(6)->isEmpty())
                            <div class="w-full h-full flex flex-1 items-center justify-center rounded-lg">
                                <div class="text-center">
                                    <img src="{{ asset('images/new-job-referral-request-icon.png') }}"
                                        alt="No Referrals" class="mx-auto h-24 mb-4">
                                    <h2 class="text-xl font-semibold text-gray-600 mb-2">This Space is Empty</h2>
                                    <p class="text-gray-500">Start processing job referral requests to help job seekers
                                        get
                                        matched.</p>
                                </div>
                            </div>
                        @else
                            <div>
                                <table class="min-w-full bg-white border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th class="border p-2">#</th>
                                            <th class="border p-2">Fullname</th>
                                            <th class="border p-2">Address</th>
                                            <th class="border p-2">Date</th>
                                            <th class="border p-2">Time</th>
                                            <th class="border p-2">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobAccounts->where('status', 'Pending')->take(6) as $newRequest)
                                            <tr class="cursor-pointer hover:bg-gray-200 transition text-center"
                                                @click="selectedRequest = {{ $newRequest->toJson() }}; showNewJobReferralRequestData = true;">
                                                <td class="border p-2">{{ $loop->iteration }}</td>
                                                <td class="border p-2 truncate max-w-[155px]">{{ $newRequest->lastname }},
                                                    {{ $newRequest->firstname }}
                                                    {{ $newRequest->middlename }}
                                                </td>
                                                <td class="border p-2 truncate max-w-[250px]">{{ $newRequest->house_number }},
                                                    {{ $newRequest->barangay }}, {{ $newRequest->city }},
                                                    {{ $newRequest->province }}</td>
                                                <td class="border p-2">{{ $newRequest->formatted_date }}</td>
                                                <td class="border p-2">{{ $newRequest->formatted_time }}</td>
                                                <td class="border p-2">
                                                    <span class="px-2 py-1 text-white rounded bg-yellow-500">
                                                        {{ $newRequest->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="absolute bottom-3 right-5 w-full flex justify-end pt-2">
                                    <a class="hover:underline text-blue-700" href="/admin-user-account-management">View all
                                        requests</a>
                                </div>
                            </div>
                        @endIf
                    </div>


                    <!-- New Company Account Request Table -->
                    <div class="relative w-full pb-12 flex flex-col bg-white rounded-lg shadow-lg p-4">
                        <div class="flex justify-center pb-4">
                            <h2 class="text-2xl font-bold">New Company Account Requests</h2>
                        </div>
                        @if ($companyAccounts->where('status', 'Pending')->take(6)->isEmpty())
                            <div class="w-full h-full flex flex-1 items-center justify-center rounded-lg">
                                <div class="text-center">
                                    <img src="{{ asset('images/new-job-referral-request-icon.png') }}"
                                        alt="No Referrals" class="mx-auto h-24 mb-4">
                                    <h2 class="text-xl font-semibold text-gray-600 mb-2">This Space is Empty</h2>
                                    <p class="text-gray-500">Start processing job referral requests to help job seekers
                                        get
                                        matched.</p>
                                </div>
                            </div>
                        @else
                            <div>
                                <table class="min-w-full bg-white border border-gray-300">
                                    <thead>
                                        <tr class="bg-gray-200">
                                            <th class="border p-2">#</th>
                                            <th class="border p-2">Company Name</th>
                                            <th class="border p-2">Bussiness Type</th>
                                            <th class="border p-2">Location</th>
                                            <th class="border p-2">Date</th>
                                            <th class="border p-2">Time</th>
                                            <th class="border p-2">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($companyAccounts->where('status', 'Pending')->take(6) as $newRequest)
                                            <tr class="cursor-pointer hover:bg-gray-200 transition text-center"
                                                @click="selectedRequest = {{ $newRequest->toJson() }}; showNewJobReferralRequestData = true;">
                                                <td class="border p-2">{{ $loop->iteration }}</td>
                                                <td class="border p-2 truncate max-w-[155px]">{{ $newRequest->company_name }}</td>
                                                <td class="border p-2 truncate w-[135px]">{{ $newRequest->business_type }}</td>
                                                <td class="border p-2 truncate max-w-[125px]">{{ $newRequest->barangay }}</td>
                                                <td class="border p-2">{{ $newRequest->formatted_date }}</td>
                                                <td class="border p-2">{{ $newRequest->formatted_time }}</td>
                                                <td class="border p-2">
                                                    <span class="px-2 py-1 text-white rounded bg-yellow-500">
                                                        {{ $newRequest->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="absolute bottom-3 right-5 w-full flex justify-end pt-2">
                                    <a class="hover:underline text-blue-700" href="/admin-company-account-management">View all
                                        requests</a>
                                </div>
                            </div>
                        @endIf
                    </div>
                </div>
            </div>

            <script>
                const monthLabels = @json($months);
                const referredJobSeekers = @json($referredJobSeekers);
                const rejectedJobSeekers = @json($rejectedJobSeekers);
                const rejectedByCompanyJobSeekers = @json($rejectedByCompanyJobSeekers);
                const acceptedByCompanyJobSeekers = @json($acceptedByCompanyJobSeekers);


                document.addEventListener('DOMContentLoaded', function() {
                    // Pie Chart
                    const jobAccountPieCtx = document.getElementById('jobAccountsStatusChart').getContext('2d');
                    new Chart(jobAccountPieCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Active', 'Pending', 'Rejected'],
                            datasets: [{
                                label: 'Job Accounts',
                                data: [
                                    {{ $jobAccounts->where('status', 'Active')->count() }},
                                    {{ $jobAccounts->where('status', 'Pending')->count() }},
                                    {{ $jobAccounts->where('status', 'Rejected')->count() }}
                                ],
                                backgroundColor: ['#1d4ed8', '#ea580c', '#dc2626'],
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
                        },
                    });

                    // Bar Chart
                    const barCtx = document.getElementById('myBarChart')?.getContext('2d');

                    if (barCtx) {
                        new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: monthLabels,
                                datasets: [{
                                    label: 'Referred Job Seekers',
                                    data: referredJobSeekers,
                                    fill: false,
                                    borderColor: '#42A5F5',
                                    tension: 0.3
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true, // always start from 0
                                        min: 0, // minimum value for y-axis
                                        max: 50, // maximum value for y-axis
                                        ticks: {
                                            stepSize: 5 // interval between ticks (0, 5, 10, 15, 20)
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Bar Stacked Chart
                    const stackedBarCtx = document.getElementById('stackedBarChart')?.getContext('2d');

                    if (stackedBarCtx) {

                        // const dataValues = [].concat(
                        //     @json($acceptedByCompanyJobSeekers),
                        //     @json($rejectedJobSeekers),
                        //     @json($referredJobSeekers),
                        //     @json($rejectedByCompanyJobSeekers)
                        // );

                        // // Get the maximum value from the dataset
                        // const maxValue = Math.max(...dataValues);

                        // // Calculate dynamic max (round up to nearest 10 + add buffer)
                        // const dynamicMax = Math.ceil((maxValue + 10) / 10) * 10;

                        new Chart(stackedBarCtx, {
                            type: 'bar',
                            data: {
                                labels: monthLabels,
                                datasets: [{
                                        label: 'Accepted by Conpany',
                                        data: acceptedByCompanyJobSeekers,
                                        backgroundColor: '#16a34a ',
                                    },
                                    {
                                        label: 'Rejected by Admin',
                                        data: rejectedJobSeekers,
                                        backgroundColor: '#dc2626',
                                    },
                                    {
                                        label: 'Referred',
                                        data: referredJobSeekers,
                                        backgroundColor: '#1d4ed8',
                                    },
                                    {
                                        label: 'Rejected by Conpany',
                                        data: rejectedByCompanyJobSeekers,
                                        backgroundColor: '#ca8a04',
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            boxWidth: 20,
                                            padding: 15
                                        }
                                    },
                                    datalabels: {
                                        color: '#ffff',
                                        font: {
                                            weight: 'bold',
                                            size: 13
                                        },
                                        formatter: (value) => value // show the number directly
                                    }
                                },
                                scales: {
                                    x: {
                                        stacked: true
                                    },
                                    y: {
                                        stacked: true,
                                        beginAtZero: true, // always start from 0
                                        min: 0, // minimum value for y-axis
                                        max: 500, // maximum value for y-axis
                                        ticks: {
                                            stepSize: 10 // interval between ticks (0, 5, 10, 15, 20)
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Pie Chart for Company Account Status
                    const jobReferralStatusCtx = document.getElementById('companyAccountsStatusChart').getContext('2d');
                    new Chart(jobReferralStatusCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Verified', 'Pending', 'Rejected'],
                            datasets: [{
                                label: 'Job Referrals',
                                data: [
                                    {{ $companyAccounts->where('status', 'Verified')->count() }},
                                    {{ $companyAccounts->where('status', 'Pending')->count() }},
                                    {{ $companyAccounts->where('status', 'Rejected')->count() }},
                                ],
                                backgroundColor: ['#1d4ed8', '#ea580c', '#dc2626'],
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
                        },
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
