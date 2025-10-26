<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AdminUser;
use App\Models\SkOfficial;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\CedulaRequest;
use App\Models\SuperAdminUser;
use App\Models\GeneratedReport;
use App\Models\BarangayOfficial;
use App\Models\ClearanceRequest;
use App\Models\IndigencyRequest;
use App\Models\JobReferralRequest;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class SuperAdminNavigationController extends Controller
{
    public function goToLoginPage(){
        return view('super-admin/super-admin-login');
    }

    public function goToDashboard(){
        if (Auth::guard('super_admin')->check() === false) {
            return redirect('/super-admin-login')->with('error', 'You are not logged in.');
        }

        $adminUsers = AdminUser::all();
        $activityLogs = Activity::latest()->paginate(6); // You can adjust the number per page

        $months = collect(range(0, 3))->map(function ($i) {
            return now()->subMonths($i)->format('F Y');
        })->reverse()->values(); // Get the last 4 months

        // Get the count of total admin accounts for each month
        $adminAccounts = [];

        foreach ($months as $i => $month) {
            $targetDate = now()->subMonths(3 - $i); // Aligns with the months you previously generated
            $adminAccounts[$month] = AdminUser::whereBetween('created_at', [
                $targetDate->copy()->startOfMonth(),
                $targetDate->copy()->endOfMonth()
            ])->count();
        }

        return view('super-admin/super-admin-dashboard', ['adminUsers' => $adminUsers, 'activityLogs' => $activityLogs, 'months' => $months, 'adminAccounts' => $adminAccounts]);
    }

    public function goToAccountManagement(Request $request)
    {
        if (Auth::guard('super_admin')->check() === false) {
            return redirect('/super-admin-login')->with('error', 'You are not logged in.');
        }
        
        $sortBy = $request->input('sort_by', 'lastname'); // default to lastname
        $sortDir = $request->input('sort_dir', 'asc');    // default to ascending
        $search = $request->input('search');
    
        $query = AdminUser::query();
    
        // Optional search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('middlename', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
    
        // Sorting
        switch ($sortBy) {
            case 'name':
                $query->orderBy('lastname', $sortDir)->orderBy('firstname', $sortDir);
                break;
            case 'sex':
            case 'email':
            case 'role':
                $query->orderBy($sortBy, $sortDir);
                break;
            default:
                $query->orderBy('lastname', 'asc');
                break;
        }
    
        $adminAccounts = $query->oldest()->paginate(15);
    
        return view('super-admin/super-admin-account-management', [
            'adminAccounts' => $adminAccounts,
            'sort_by' => $sortBy,
            'sort_dir' => $sortDir,
            'search' => $search,
        ]);
    }

    public function goToAnnouncementManagement(){
        if (Auth::guard('super_admin')->check() === false) {
            return redirect('/super-admin-login')->with('error', 'You are not logged in.');
        }

        $announcements = Announcement::all();
        return view('super-admin/super-admin-announcement-management', ['announcements' => $announcements]);
    }

    public function goToBarangayOfficialManagement(BarangayOfficial $barangayOfficials){
        if (Auth::guard('super_admin')->check() === false) {
            return redirect('/super-admin-login')->with('error', 'You are not logged in.');
        }

        $barangayOfficials = BarangayOfficial::all();
        return view('super-admin/super-admin-barangay-official-management', ['barangayOfficials' => $barangayOfficials]);
    }

    public function goToSkOfficialManagement(SkOfficial $skOfficials){
        if (Auth::guard('super_admin')->check() === false) {
            return redirect('/super-admin-login')->with('error', 'You are not logged in.');
        }

        $skOfficials = SkOfficial::all();
        return view('super-admin/super-admin-sk-official-management', ['skOfficials' => $skOfficials]);
    }

    public function goToReport(Request $request){
        if (Auth::guard('super_admin')->check() === false) {
            return redirect('/super-admin-login')->with('error', 'You are not logged in.');
        }

        $currentDate = Carbon::now();
        $adminAccounts = AdminUser::all();

        $queries = [
            'cedulaQuery' => CedulaRequest::query(),
            'indigencyQuery' => IndigencyRequest::query(),
            'clearanceQuery' => ClearanceRequest::query(),
            'jobAccountQuery' => User::query(),
            'jobReferralQuery' => JobReferralRequest::query(),
            
        ];

        foreach ($queries as $key => $query) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereBetween('updated_at', [
                        $currentDate->copy()->startOfDay(),
                        $currentDate->copy()->endOfDay()
                    ]);
                    break;

                case 'last_3_days':
                    $query->whereBetween('updated_at', [
                        $currentDate->copy()->subDays(2)->startOfDay(),
                        $currentDate->copy()->endOfDay()
                    ]);
                    break;

                case 'last_7_days':
                    $query->whereBetween('updated_at', [
                        $currentDate->copy()->subDays(6)->startOfDay(),
                        $currentDate->copy()->endOfDay()
                    ]);
                    break;

                case 'custom':
                    if ($request->filled('from_date') && $request->filled('to_date')) {
                        $from = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                        $to = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                        $query->whereBetween('updated_at', [$from, $to]);
                    }
                    break;

                default:
                    break;
            }

            // Execute the query and replace the original builder with results
            $queries[$key] = $query->latest()->get();
        }


        return view('super-admin/super-admin-report', [
            'cedulaRequests' => $queries['cedulaQuery'],
            'indigencyRequests' => $queries['indigencyQuery'],
            'clearanceRequests' => $queries['clearanceQuery'],
            'jobAccounts' => $queries['jobAccountQuery'],
            'jobReferralRequests' => $queries['jobReferralQuery'],
            'adminAccounts' => $adminAccounts,
            'currentDate' => $currentDate
        ]);
    }

    public function goToGeneratedReport(Request $request){
        if (Auth::guard('super_admin')->check() === false) {
            return redirect('/super-admin-login')->with('error', 'You are not logged in.');
        }

        $currentDate = Carbon::now();

        $generatedReports = GeneratedReport::latest()->get();
        $superAdminUser = SuperAdminUser::all();

        $query = GeneratedReport::query()
        ->join('super_admin_users', function ($join) {
            $join->on('generated_reports.reporter_id', '=', 'super_admin_users.id')
                ->where('generated_reports.reporter_type', '=', '0');
        })
        ->select('generated_reports.*');

        $sortBy = $request->input('sort_by', 'lastname'); // default to lastname
        $sortDir = $request->input('sort_dir', 'asc');    // default to ascending
        $search = $request->input('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                ->orWhere('lastname', 'like', "%{$search}%")
                ->orWhere('middlename', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sorting
        switch ($request->date_filter) {
            case 'today':
                $query->whereBetween('generated_reports.created_at', [
                    $currentDate->copy()->startOfDay(),
                    $currentDate->copy()->endOfDay()
                ]);
                break;

            case 'last_3_days':
                $query->whereBetween('generated_reports.created_at', [
                    $currentDate->copy()->subDays(2)->startOfDay(),
                    $currentDate->copy()->endOfDay()
                ]);
                break;

            case 'last_7_days':
                $query->whereBetween('generated_reports.created_at', [
                    $currentDate->copy()->subDays(6)->startOfDay(),
                    $currentDate->copy()->endOfDay()
                ]);
                break;

            case 'custom':
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    $from = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                    $to = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                    $query->whereBetween('generated_reports.created_at', [$from, $to]);
                }
                break;

            default:
                break;
        }
        
        $generatedReports = $query->latest()->get();
        
        return view('super-admin/super-admin-generated-report', ['generatedReports' => $generatedReports, 'superAdminUser' => $superAdminUser, 'sortBy' => $sortBy, 'sortDir' => $sortDir, 'currentDate' => $currentDate]);
    }

    public function goToLog(Request $request){
        if (Auth::guard('super_admin')->check() === false) {
            return redirect('/super-admin-login')->with('error', 'You are not logged in.');
        }
        
        $query = Activity::query();
        $currentDate = Carbon::now();
        $search = $request->input('search');
        $adminType = $request->input('admin_type');

        if ($search) {
            $query->whereHas('causer', function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('middlename', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        
        switch ($request->date_filter) {
            case 'today':
                $query->whereBetween('created_at', [
                    $currentDate->copy()->startOfDay(), // 2 days ago + today = 3
                    $currentDate->endOfDay()
                ]);
                break;

            case 'last_3_days':
                $query->whereBetween('created_at', [
                    $currentDate->copy()->subDays(2)->startOfDay(), // 2 days ago + today = 3
                    $currentDate->endOfDay()
                ]);
                break;

            case 'last_7_days':
                $query->whereBetween('created_at', [
                    $currentDate->copy()->subDays(6)->startOfDay(), // 6 days ago + today = 3
                    $currentDate->endOfDay()
                ]);
                break;
            
            case 'custom':
                if ($request->filled('from_date') && $request->filled('to_date')) {
                    $request->from_date = Carbon::createFromFormat('Y-m-d', $request->from_date);
                    $request->to_date = Carbon::createFromFormat('Y-m-d', $request->to_date);
                    $query->whereBetween('created_at', [$request->from_date->startOfDay(), $request->to_date->endOfDay()]);
                }
                break;
            
            default:
                
                break;
        }

        switch ($adminType) {
            case 'super_admin':
                $query->where('causer_type', 'App\Models\SuperAdminUser');
                break;

            case 'document_issuance_admin':
                $query->where('causer_type', 'App\Models\AdminUser')
                    ->whereHasMorph(
                        'causer',
                        [AdminUser::class],
                        function ($q) {
                            $q->where('role', '1');
                        }
                    );
                break;

            case 'job_center_admin':
                $query->where('causer_type', 'App\Models\AdminUser')
                    ->whereHasMorph(
                        'causer',
                        [AdminUser::class],
                        function ($q) {
                            $q->where('role', '2');
                        }
                    );
                break;

            default:
                break;
        }

        $currentDate->toDateString();


        $activityLogs = $query->latest()->paginate(15);

        return view('super-admin/super-admin-log', ['activityLogs' => $activityLogs]);
    }
}
