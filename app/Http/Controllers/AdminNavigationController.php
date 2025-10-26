<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\AdminUser;
use App\Models\Applicant;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\CedulaRequest;
use App\Models\GeneratedReport;
use App\Models\ClearanceRequest;
use App\Models\IndigencyRequest;
use App\Models\JobReferralRequest;
use Illuminate\Support\Facades\Auth;

class AdminNavigationController extends Controller
{

    public function goToAdminReportTemplate()
    {

        return view('admin/admin-report-template');
    }

    public function goToDashboard()
    {
        if (Auth::guard('admin')->check() === false) {
            return redirect('/admin-login')->with('error', 'You are not logged in.');
        }

        $adminRole = Auth()->guard('admin')->user()->role;

        $months = collect(range(0, 3))->map(function ($i) {
            return now()->subMonths($i)->format('F Y');
        })->reverse()->values(); // Get the last 4 months



        switch ($adminRole) {
            case '1':

                $documentRequests = [
                    'cedula' => CedulaRequest::all()->map(function ($item) {
                        $item->document_type = 'cedula';
                        $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                        $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                        return $item;
                    }),
                    'indigency' => IndigencyRequest::all()->map(function ($item) {
                        $item->document_type = 'indigency';
                        $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                        $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                        return $item;
                    }),
                    'clearance' => ClearanceRequest::all()->map(function ($item) {
                        $item->document_type = 'clearance';
                        $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                        $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                        return $item;
                    }),
                ];

                // $mergedIssuedDocuments = collect()
                //     ->merge($documentRequests['cedula'])
                //     ->merge($documentRequests['indigency'])
                //     ->merge($documentRequests['clearance'])
                //     ->where('status', 'Completed')
                //     ->sortByDesc('created_at')
                //     ->values(); // reset keys

                $issuedCedula = collect($documentRequests['cedula'])
                    ->where('status', 'Completed')
                    ->sortByDesc('created_at')
                    ->values();

                $issuedIndigency = collect($documentRequests['indigency'])
                    ->where('status', 'Completed')
                    ->sortByDesc('created_at')
                    ->values();

                $issuedClearance = collect($documentRequests['clearance'])
                    ->where('status', 'Completed')
                    ->sortByDesc('created_at')
                    ->values();

                $mergedNewRequests = collect()
                    ->merge($documentRequests['cedula'])
                    ->merge($documentRequests['indigency'])
                    ->merge($documentRequests['clearance'])
                    ->where('status', 'Pending')
                    ->sortByDesc('created_at')
                    ->values()
                    ->take(6); // reset keys


                $issuedCedulaCounts = [];
                $issuedIndigencyCounts = [];
                $issuedClearanceCounts = [];


                foreach ($months as $i => $month) {
                    $targetDate = now()->subMonths(3 - $i); // Aligns with the months previously generated
                    $issuedCedulaCounts[$month] = $issuedCedula->whereBetween('created_at', [
                        $targetDate->copy()->startOfMonth(),
                        $targetDate->copy()->endOfMonth()
                    ])->count();
                    $issuedIndigencyCounts[$month] = $issuedIndigency->whereBetween('created_at', [
                        $targetDate->copy()->startOfMonth(),
                        $targetDate->copy()->endOfMonth()
                    ])->count();
                    $issuedClearanceCounts[$month] = $issuedClearance->whereBetween('created_at', [
                        $targetDate->copy()->startOfMonth(),
                        $targetDate->copy()->endOfMonth()
                    ])->count();
                }


                return view('admin/admin-dashboard', [
                    'documentRequests' => $documentRequests,
                    'mergedNewRequests' => $mergedNewRequests,
                    'months' => $months,
                    'issuedCedulaCounts' => $issuedCedulaCounts,
                    'issuedIndigencyCounts' => $issuedIndigencyCounts,
                    'issuedClearanceCounts' => $issuedClearanceCounts
                ]);

                break;

            case '2':
                $jobReferralRequests = Applicant::all()->map(function ($item) {
                    $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                    $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                    return $item;
                });

                $jobAccounts = User::all()->map(function ($item) {
                    $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                    $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                    return $item;
                });

                $companyAccounts = Company::all()->map(function ($item) {
                    $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                    $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                    return $item;
                });

                $rejectedJobSeekers = [];
                $referredJobSeekers = [];
                $rejectedByCompanyJobSeekers = [];
                $acceptedByCompanyJobSeekers = [];

                foreach ($months as $i => $month) {
                    $targetDate = now()->subMonths(3 - $i); // Aligns with the months you previously generated
                    $referredJobSeekers[$month] = $jobReferralRequests->where('status', 'Shortlisted')->whereBetween('created_at', [
                        $targetDate->copy()->startOfMonth(),
                        $targetDate->copy()->endOfMonth()
                    ])->count();
                    $rejectedJobSeekers[$month] = $jobReferralRequests->where('status', 'Rejected')->whereBetween('created_at', [
                        $targetDate->copy()->startOfMonth(),
                        $targetDate->copy()->endOfMonth()
                    ])->count();
                    $rejectedByCompanyJobSeekers[$month] = $jobReferralRequests->where('status', 'Rejected by Company')->whereBetween('created_at', [
                        $targetDate->copy()->startOfMonth(),
                        $targetDate->copy()->endOfMonth()
                    ])->count();
                    $acceptedByCompanyJobSeekers[$month] = $jobReferralRequests->where('status', 'Accepted by Company')->whereBetween('created_at', [
                        $targetDate->copy()->startOfMonth(),
                        $targetDate->copy()->endOfMonth()
                    ])->count();
                }

                return view('admin/admin-dashboard', [
                    'jobReferralRequests' => $jobReferralRequests, 
                    'jobAccounts' => $jobAccounts, 
                    'companyAccounts' => $companyAccounts,
                    'months' => $months, 
                    'referredJobSeekers' => $referredJobSeekers,
                    'rejectedJobSeekers' => $rejectedJobSeekers,
                    'rejectedByCompanyJobSeekers' => $rejectedByCompanyJobSeekers,
                    'acceptedByCompanyJobSeekers' => $acceptedByCompanyJobSeekers
                ]);

                break;

            default:
                # code...
                break;
        }
    }

    public function goToDocumentRequests()
    {
        return view('admin/admin-document-request');
    }

    public function goToJobReferrals()
    {
        return view('admin/admin-job-referral');
    }

    public function goToJobListings()
    {
        return view('admin/admin-job-listing');
    }

    public function goToReport(Request $request)
    {
        $admin_role = Auth()->guard('admin')->user()->role;
        $currentDate = Carbon::now();

        switch ($admin_role) {
            case '1':

                $issuedDocuments = [];

                // Define your queries as named keys
                $queries = [
                    'cedulaQuery' => CedulaRequest::query(),
                    'indigencyQuery' => IndigencyRequest::query(),
                    'clearanceQuery' => ClearanceRequest::query()
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

                return view('admin.admin-report', [
                    'cedulaRequests' => $queries['cedulaQuery'],
                    'indigencyRequests' => $queries['indigencyQuery'],
                    'clearanceRequests' => $queries['clearanceQuery'],
                    'currentDate' => $currentDate,
                    'issuedDocuments' => $issuedDocuments,
                ]);
                break;

            case '2':
                // Define your queries as named keys
                $queries = [
                    'jobAccountQuery' => User::query(),
                    'jobReferralQuery' => JobReferralRequest::query()
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


                return view('admin.admin-report', [
                    'jobAccounts' => $queries['jobAccountQuery'],
                    'jobReferralRequests' => $queries['jobReferralQuery'],
                    'currentDate' => $currentDate,
                ]);
                break;

            default:
                break;
        }
    }

    public function goToAnnouncementSection()
    {
        $announcements = Announcement::where('announcement_type', 'Job Announcement')->get();
        return view('admin/admin-announcement-section', ['announcements' => $announcements]);
    }

    public function goToLoginPage()
    {
        return view('admin/admin-login');
    }

    public function goToCompanyAccount()
    {
        return view('admin/admin-company-account');
    }

    public function goToUserAccount()
    {
        return view('admin/admin-user-account');
    }

    public function goToGeneratedReport(Request $request)
    {


        $adminRole = Auth()->guard('admin')->user()->role;
        $currentDate = Carbon::now();

        $generatedReports = GeneratedReport::latest()->get();
        $adminUser = AdminUser::all();

        // $query = GeneratedReport::query()
        // ->join('admin_users', 'generated_reports.reporter_id', '=', 'admin_users.id')
        // ->select('generated_reports.*'); ;

        $query = GeneratedReport::query()
            ->join('admin_users', function ($join) use ($adminRole) {
                $join->on('generated_reports.reporter_id', '=', 'admin_users.id')
                    ->where('generated_reports.reporter_type', '=', $adminRole);
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

        $generatedReports = $query->where('reporter_type', $adminRole)->latest()->get();

        return view('admin/admin-generated-report', ['generatedReports' => $generatedReports, 'adminUser' => $adminUser, 'sortBy' => $sortBy, 'sortDir' => $sortDir, 'currentDate' => $currentDate]);
    }
}
