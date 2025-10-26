<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Super Admin Dashboard</title>

</head>
<body class="flex h-screen bg-gray-100">

    @if (Auth::guard('super_admin')->check())
        <!-- Sidebar -->
        @include('super-admin/super-admin-side-panel')

        <!-- Main Content (Placeholder) -->
        <div class="relative h-screen flex-1 p-8 overflow-y-scroll">
            <h1 class="text-3xl font-bold mb-10 ">Super Admin Dashboard</h1>
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500 text-sm">Total Admin Accounts</p>
                    <h2 class="text-2xl font-bold mt-2">{{$adminUsers->count();}}</h2>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500 text-sm">Job Referral Admins</p>
                    <h2 class="text-2xl font-bold mt-2">{{ $adminUsers->where('role', '2')->count() }}</h2>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-500 text-sm">Document Issuance Admins</p>
                    <h2 class="text-2xl font-bold mt-2">{{ $adminUsers->where('role', '1')->count() }}</h2>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                <!-- Admin Roles Pie Chart -->
                <div class="bg-white p-6 rounded-lg shadow h-[350px] flex flex-col items-center justify-center">
                    <h3 class="text-lg font-semibold mb-4">Admin Role Distribution</h3>
                    <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>

                <!-- Account Creation Trend -->
                <div class="bg-white p-6 rounded-lg shadow h-[350px] flex flex-col items-center justify-center">
                    <h3 class="text-lg font-semibold mb-4">Created Admin Accounts</h3>
                    <div class="w-full h-[250px] rounded-lg flex items-center justify-center text-gray-400">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Admin Activities -->
            <div class="relative bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Recent Admin Activities</h3>
                <table class="w-full text-left table-auto">
                    <thead class="bg-gray-100 text-gray-600 text-sm">
                        <tr>
                            <th class="p-3">Admin Name</th>
                            <th class="p-3">Role</th>
                            <th class="p-3">Activity</th>
                            <th class="p-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @forelse($activityLogs as $activityLog)
                            <tr class="border-t">
                                <td class="p-3">
                                    @if($activityLog->causer)
                                        {{ $activityLog->causer->firstname . " " . $activityLog->causer->lastname ?? 'N/A' }}
                                    @else
                                        System
                                    @endif
                                </td>
                                <td class="p-3">
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
                                <td class="p-3">
                                    {{$activityLog->description}}
                                </td>
                                <td class="p-3">
                                    {{ $activityLog->updated_at->format('F j, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-3 text-center" colspan="6">No activity logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="absolute bottom-3 right-5 w-full flex justify-end pt-2">
                    <a href="{{ route('go.to.super.admin.log') }}">View all logs</a>
                </div>
            </div>
        </div>
    @else
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold">You are not logged in...</h1>
        </div>
    @endif
    

    <script>
        const monthLabels = @json($months);
        const adminAccounts = @json($adminAccounts);



        document.addEventListener('DOMContentLoaded', function () {
            // Pie Chart
            const pieCtx = document.getElementById('myPieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Document Issuance Admin', 'Job Referral Admin'],
                    datasets: [{
                        label: 'Active Admins',
                        data: [{{ $adminUsers->where('role', '1')->count() }}, {{ $adminUsers->where('role', '2')->count() }}],
                        backgroundColor: ['#4CAF50', '#2196F3'],
                        borderWidth: 1
                    }]
                }
            });
    
            // Bar Chart
            const barCtx = document.getElementById('myBarChart')?.getContext('2d');
            if (barCtx) {
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: monthLabels,
                        datasets: [{
                            label: 'Total Admin Accounts',
                            data: adminAccounts,
                            fill: false,
                            borderColor: '#42A5F5',
                            tension: 0.3
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true, // always start from 0
                                min: 0,            // minimum value for y-axis
                                max: 15,           // maximum value for y-axis
                                ticks: {
                                    stepSize: 3    // interval between ticks (0, 5, 10, 15, 20)
                                }
                            }
                        }
                    }                                                                                               
                });
            }
        });
    </script>

    @livewireScripts
    
</body>
</html>