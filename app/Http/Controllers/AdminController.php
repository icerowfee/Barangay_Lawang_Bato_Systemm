<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\AdminUser;
use App\Models\Applicant;
use App\Models\JobListing;
use Illuminate\Http\Request;
use App\Models\CedulaRequest;
use App\Models\GeneratedReport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ClearanceRequest;
use App\Models\IndigencyRequest;
use App\Models\JobReferralRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function generateReport(Request $request)
    {

        $reportType = $request->input('report_type');
        $filters = $request->input('filters', []);
        $reporterType = Auth::guard('admin')->user()->role; // Assuming the admin's role is the reporter type
        $reporterId = Auth::guard('admin')->user()->id; // Assuming the admin's ID is the reporter ID
        $adminUser = AdminUser::find($reporterId);

        $currentDate = Carbon::now();


        switch ($reporterType) {
            case '1':

                $queries = [
                    'cedulaQuery' => CedulaRequest::query(),
                    'indigencyQuery' => IndigencyRequest::query(),
                    'clearanceQuery' => ClearanceRequest::query()
                ];

                foreach ($queries as $key => $query) {
                    switch ($filters['date_filter']) {
                        case 'today':
                            $query->whereBetween('updated_at', [
                                $currentDate->copy()->startOfDay(),
                                $currentDate->copy()->endOfDay()
                            ]);

                            $filters['from_date'] = $currentDate->copy()->startOfDay()->format('F j, Y');
                            $filters['to_date'] = $currentDate->copy()->endOfDay()->format('F j, Y');

                            break;

                        case 'last_3_days':
                            $query->whereBetween('updated_at', [
                                $currentDate->copy()->subDays(2)->startOfDay(),
                                $currentDate->copy()->endOfDay()
                            ]);

                            $filters['from_date'] = $currentDate->copy()->subDays(2)->startOfDay()->format('F j, Y');
                            $filters['to_date'] = $currentDate->copy()->endOfDay()->format('F j, Y');

                            break;

                        case 'last_7_days':
                            $query->whereBetween('updated_at', [
                                $currentDate->copy()->subDays(6)->startOfDay(),
                                $currentDate->copy()->endOfDay()
                            ]);

                            $filters['from_date'] = $currentDate->copy()->subDays(6)->startOfDay()->format('F j, Y');
                            $filters['to_date'] = $currentDate->copy()->endOfDay()->format('F j, Y');

                            break;

                        case 'custom':
                            if ($request->filled('from_date') && $request->filled('to_date')) {
                                $from = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                                $to = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                                $query->whereBetween('updated_at', [$from, $to]);

                                $filters['from_date'] = $from->format('F j, Y');
                                $filters['to_date'] = $to->format('F j, Y');
                            }

                            break;

                        default:

                            break;
                    }

                    // Execute the query and replace the original builder with results
                    $queries[$key] = $query->latest()->get();
                }



                $pdf = Pdf::loadView(
                    'admin/admin-report-template',
                    [
                        'dateStart' => $filters['from_date'],
                        'dateEnd' => $filters['to_date'],
                        'reporterType' => $reporterType,
                        'adminUserFirstname' => $adminUser->firstname,
                        'adminUserLastname' => $adminUser->lastname,

                        'totalIssuedCedula' => $queries['cedulaQuery']->where('status', 'Completed')->count(),
                        'totalPendingCedulaRequests' => $queries['cedulaQuery']->where('status', 'Pending')->count(),
                        'totalApprovedCedulaRequests' => $queries['cedulaQuery']->where('status', 'Approved')->count(),
                        'totalRejectedCedulaRequests' => $queries['cedulaQuery']->where('status', 'Rejected')->count(),

                        'totalIssuedCearances' => $queries['clearanceQuery']->where('status', 'Completed')->count(),
                        'totalPendingClearanceRequests' => $queries['clearanceQuery']->where('status', 'Pending')->count(),
                        'totalApprovedClearanceRequests' => $queries['clearanceQuery']->where('status', 'Approved')->count(),
                        'totalRejectedClearanceRequests' => $queries['clearanceQuery']->where('status', 'Rejected')->count(),

                        'totalIssuedIndigency' => $queries['indigencyQuery']->where('status', 'Completed')->count(),
                        'totalPendingIndigencyRequests' => $queries['indigencyQuery']->where('status', 'Pending')->count(),
                        'totalApprovedIndigencyRequests' => $queries['indigencyQuery']->where('status', 'Approved')->count(),
                        'totalRejectedIndigencyRequests' => $queries['indigencyQuery']->where('status', 'Rejected')->count(),


                        'currentDate' => $currentDate
                    ]
                );



                $fileName = 'Document_Issuance_Report_' . now()->format('Ymd_His') . '.pdf';
                Storage::disk('public')->makeDirectory('generated-reports');
                $path = ('generated-reports/' . $fileName);
                Storage::disk('public')->put($path, $pdf->output());


                // Optionally, save metadata to the database
                GeneratedReport::create([
                    'filename' => $fileName,
                    'path' => $path,
                    'filters' => json_encode($filters),
                    'report_type' => $reportType,
                    'reporter_type' => $reporterType,
                    'reporter_id' => $reporterId
                ]);

                return response()->download(storage_path('app/public/' . $path));

                break;




            // Generate Report for Job Center Admin
            case '2':

                $queries = [
                    'jobAccountQuery' => User::query(),
                    'jobReferralQuery' => JobReferralRequest::query()
                ];

                foreach ($queries as $key => $query) {
                    switch ($filters['date_filter']) {
                        case 'today':
                            $query->whereBetween('updated_at', [
                                $currentDate->copy()->startOfDay(),
                                $currentDate->copy()->endOfDay()
                            ]);

                            $filters['from_date'] = $currentDate->copy()->startOfDay()->format('F j, Y');
                            $filters['to_date'] = $currentDate->copy()->endOfDay()->format('F j, Y');

                            break;

                        case 'last_3_days':
                            $query->whereBetween('updated_at', [
                                $currentDate->copy()->subDays(2)->startOfDay(),
                                $currentDate->copy()->endOfDay()
                            ]);

                            $filters['from_date'] = $currentDate->copy()->subDays(2)->startOfDay()->format('F j, Y');
                            $filters['to_date'] = $currentDate->copy()->endOfDay()->format('F j, Y');

                            break;

                        case 'last_7_days':
                            $query->whereBetween('updated_at', [
                                $currentDate->copy()->subDays(6)->startOfDay(),
                                $currentDate->copy()->endOfDay()
                            ]);

                            $filters['from_date'] = $currentDate->copy()->subDays(6)->startOfDay()->format('F j, Y');
                            $filters['to_date'] = $currentDate->copy()->endOfDay()->format('F j, Y');

                            break;

                        case 'custom':
                            if ($request->filled('from_date') && $request->filled('to_date')) {
                                $from = Carbon::createFromFormat('Y-m-d', $request->from_date)->startOfDay();
                                $to = Carbon::createFromFormat('Y-m-d', $request->to_date)->endOfDay();
                                $query->whereBetween('updated_at', [$from, $to]);

                                $filters['from_date'] = $from->format('F j, Y');
                                $filters['to_date'] = $to->format('F j, Y');
                            }

                            break;

                        default:

                            break;
                    }

                    // Execute the query and replace the original builder with results
                    $queries[$key] = $query->latest()->get();
                }



                $pdf = Pdf::loadView(
                    'admin/admin-report-template',
                    [
                        'dateStart' => $filters['from_date'],
                        'dateEnd' => $filters['to_date'],
                        'reporterType' => $reporterType,
                        'adminUserFirstname' => $adminUser->firstname,
                        'adminUserLastname' => $adminUser->lastname,

                        'totalJobReferred' => $queries['jobReferralQuery']->where('status', 'Referred')->count(),
                        'totalPendingJobReferralRequests' => $queries['jobReferralQuery']->where('status', 'Pending')->count(),
                        'totalProcessingJobReferralRequests' => $queries['jobReferralQuery']->where('status', 'Processing')->count(),
                        'totalRejectedAndCancelledJobReferralRequests' => $queries['jobReferralQuery']->where('status', 'Rejected')->count() + $queries['jobReferralQuery']->where('status', 'Cancelled')->count(),

                        'totalActiveJobAccounts' => $queries['jobAccountQuery']->where('status', 'Active')->count(),
                        'totalPendingJobAccounts' => $queries['jobAccountQuery']->where('status', 'Pending')->count(),
                        'totalDeactivatedJobAccounts' => $queries['jobAccountQuery']->where('status', 'Deactivated')->count(),
                        'totalRejectedJobAccounts' => $queries['jobAccountQuery']->where('status', 'Rejected')->count(),

                        'currentDate' => $currentDate
                    ]
                );



                $fileName = 'Job_Center_Report_' . now()->format('Ymd_His') . '.pdf';
                Storage::disk('public')->makeDirectory('generated-reports');
                $path = ('generated-reports/' . $fileName);
                Storage::disk('public')->put($path, $pdf->output());


                // Optionally, save metadata to the database
                GeneratedReport::create([
                    'filename' => $fileName,
                    'path' => $path,
                    'filters' => json_encode($filters),
                    'report_type' => $reportType,
                    'reporter_type' => $reporterType,
                    'reporter_id' => $reporterId
                ]);

                return response()->download(storage_path('app/public/' . $path));
                break;

            default:
                break;
        }






        // Generate the report based on the type and save it
        // This is a placeholder for your report generation logic
        // You can use libraries like Laravel Excel, PDF, etc.

        return response()->json([
            'reporter_type' => $reporterType,
            'reporter_id' => $reporterId,
            'report_type' => $reportType,
            'filters' => $filters
        ]);
    }

    public function showApplicationRequests(Request $request)
    {
        $newApplicationRequests = Applicant::with('user', 'jobListing')->where('status', 'Applied')->oldest()->paginate(10);

        // $approvedApplicationRequests = Applicant::with('user')->where('status', 'Shortlisted')->oldest()->paginate(10);

        $archivedApplicationRequests = Applicant::with('user')->whereIn('status', ['Rejected', 'Rejected by Company', 'Accepted by Company'])->oldest()->paginate(10);



        $sortBy = $request->input('sort_by', 'lastname'); // default to lastname
        $sortDir = $request->input('sort_dir', 'asc');    // default to ascending
        $search = $request->input('search');

        $query = Applicant::query()
            ->join('users', 'applicants.user_id', '=', 'users.id')
            ->select('applicants.*'); // ensure we get only the main table's fields;

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
                $query->orderBy($sortBy, $sortDir);
                break;
            case 'email':
                $query->orderBy($sortBy, $sortDir);
                break;
            default:
                $query->orderBy('lastname', 'asc');
                break;
        }

        $approvedApplicationRequests = $query->where('applicants.status', 'Shortlisted')->oldest()->paginate(10);

        return view('admin/admin-job-referral', compact('newApplicationRequests', 'archivedApplicationRequests', 'sortBy', 'sortDir', 'search'));
    }

    public function showAccountRequests(Request $request)
    {
        $newUserAccountRequests = User::where('status', 'Pending')->oldest()->paginate(10);

        // $approvedUserAccountRequests = User::where('status', 'Active')->oldest()->paginate(10);

        $archivedUserAccounts = User::whereIn('status', ['Deactivated', 'Rejected'])->oldest()->paginate(10);


        // $sortBy = $request->input('sort_by', 'lastname'); // default to lastname
        // $sortDir = $request->input('sort_dir', 'asc');    // default to ascending
        // $search = $request->input('search');

        // $query = User::query();

        // // Optional search
        // if ($search) {
        //     $query->where(function ($q) use ($search) {
        //         $q->where('firstname', 'like', "%{$search}%")
        //           ->orWhere('lastname', 'like', "%{$search}%")
        //           ->orWhere('middlename', 'like', "%{$search}%")
        //           ->orWhere('email', 'like', "%{$search}%");
        //     });
        // }

        // // Sorting
        // switch ($sortBy) {
        //     case 'name':
        //         $query->orderBy('lastname', $sortDir)->orderBy('firstname', $sortDir);
        //         break;
        //     case 'sex':
        //         $query->orderBy($sortBy, $sortDir);
        //         break;
        //     case 'email':
        //         $query->orderBy($sortBy, $sortDir);
        //         break;
        //     default:
        //         $query->orderBy('lastname', 'asc');
        //         break;
        // }

        // $approvedUserAccountRequests = $query->where('status', 'Active')->oldest()->paginate(10);


        return view('admin/admin-user-account', compact('newUserAccountRequests', 'archivedUserAccounts'));
    }

    public function showCompanyAccountRequests(Request $request)
    {
        $sortBy = $request->input('sort_by', 'lastname'); // default to lastname
        $sortDir = $request->input('sort_dir', 'asc');    // default to ascending
        $search = $request->input('search');

        $newCompanyAccountRequests = Company::where('status', 'Pending')->oldest()->paginate(10)
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                return $item;
            });

        // $approvedCompanyAccountRequests = Company::where('status', 'Verified')->oldest()->paginate(10)
        // ->through(function ($item) {
        //     $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
        //     $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
        //     return $item;
        // });

        // $archivedCompanyAccounts = Company::whereIn('status', ['Deactivated', 'Rejected'])->oldest()->paginate(10)
        //     ->through(function ($item) {
        //         $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
        //         $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
        //         return $item;
        //     });


        // Initialize the main query builder
        $query = Company::query(); // Start with the base query

        // Optional search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('middlename', 'like', "%{$search}%")
                    ->orWhere('account_email', 'like', "%{$search}%");
            });
        }

        // Sorting by the specified column and direction
        switch ($sortBy) {
            case 'name':
                $query->orderBy('lastname', $sortDir)->orderBy('firstname', $sortDir);
                break;
            case 'email':
                $query->orderBy('account_email', $sortDir);
                break;
            default:
                $query->orderBy('lastname', 'asc'); // Default sort by lastname
                break;
        }



        // Return the view with the necessary data
        return view('admin/admin-company-account', compact('newCompanyAccountRequests'));
    }

    public function showJobListings(Request $request)
    {
        $sortBy = $request->input('sort_by', 'lastname'); // default to lastname
        $sortDir = $request->input('sort_dir', 'asc');    // default to ascending
        $search = $request->input('search');

        $newJobListings = JobListing::with('company')->where('status', 'Pending')->oldest()->paginate(10)
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                return $item;
            });

        $approvedJobListings = JobListing::with('company')->where('status', 'Active')->oldest()->paginate(10)
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                return $item;
            });

        $archivedJobListings = JobListing::with('company')->where('status', 'Closed')->oldest()->paginate(10)
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                return $item;
            });


        // Initialize the main query builder
        $query = JobListing::query(); // Start with the base query

        // Optional search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('middlename', 'like', "%{$search}%")
                    ->orWhere('account_email', 'like', "%{$search}%");
            });
        }

        // Sorting by the specified column and direction
        switch ($sortBy) {
            case 'name':
                $query->orderBy('lastname', $sortDir)->orderBy('firstname', $sortDir);
                break;
            case 'email':
                $query->orderBy('account_email', $sortDir);
                break;
            default:
                $query->orderBy('lastname', 'asc'); // Default sort by lastname
                break;
        }



        // Return the view with the necessary data
        return view('admin/admin-job-listing', compact('newJobListings', 'approvedJobListings', 'archivedJobListings', 'sortBy', 'sortDir', 'search'));
    }


    public function approveJobListing(Request $request)
    {
        $jobListing = JobListing::find($request->id);
        $jobListing->status = 'Active';
        $jobListing->save();

        return redirect()->back()->with('success', 'Job Listing Approved Successfully.')->with('activeTab', $request?->activeTab);
    }

    public function rejectJobListing(Request $request)
    {
        $jobListing = JobListing::find($request->id);
        $jobListing->status = 'Rejected';
        $jobListing->save();

        return redirect()->back()->with('success', 'Job Listing Rejected Successfully.')->with('activeTab', $request?->activeTab);
    }

    public function closeJobListing(Request $request)
    {
        $jobListing = JobListing::find($request->id);
        $jobListing->status = 'Closed';
        $jobListing->save();

        return redirect()->back()->with('success', 'Job Listing Closed Successfully.')->with('activeTab', $request?->activeTab);
    }

    public function deleteJobListing(Request $request)
    {
        $jobListing = JobListing::find($request->id);
        $jobListing->delete();

        return redirect()->back()->with('success', 'Job Listing Deleted Successfully.')->with('activeTab', $request?->activeTab);
    }

    public function archiveCompanyAccount(Request $request)
    {
        $companyAccountRequest = Company::find($request->id);
        $companyAccountRequest->status = 'Archived';
        $companyAccountRequest->save();

        return redirect()->back()->with('success', 'Company Account Archived Successfully.')->with('activeTab', $request?->activeTab);
    }


    public function deactivateCompanyAccount(Request $request)
    {
        $companyAccountRequest = Company::find($request->id);
        $companyAccountRequest->status = 'Deactivated';
        $companyAccountRequest->save();

        return redirect()->back()->with('success', 'Company Account Deactivated Successfully.')->with('activeTab', $request?->activeTab);
    }

    public function reactivateCompanyAccount(Request $request)
    {
        $companyAccountRequest = Company::find($request->id);
        $companyAccountRequest->status = 'Active';
        $companyAccountRequest->save();

        return redirect()->back()->with('success', 'Company Account Reactivated Successfully.')->with('activeTab', $request?->activeTab);
    }

    public function deleteCompanyAccount(Request $request)
    {
        $companyAccountRequest = Company::find($request->id);
        $companyAccountRequest->delete();

        return redirect()->back()->with('success', 'Company Account Deleted Successfully.')->with('activeTab', $request?->activeTab);
    }

    public function rejectCompanyAccountRequest(Request $request)
    {
        $companyAccountRequest = Company::find($request->id);
        $companyAccountRequest->status = 'Rejected';
        $companyAccountRequest->save();

        return redirect()->back()->with('success', 'Company Account Request Rejected Successfully.')->with('activeTab', 'new-company-account-request-tab');
    }

    public function approveCompanyAccountRequest(Request $request)
    {
        $companyAccountRequest = Company::find($request->id);
        $companyAccountRequest->verified_by = Auth::guard('admin')->user()->id;
        $companyAccountRequest->verified_at = now();
        $companyAccountRequest->status = 'Verified';
        $companyAccountRequest->save();

        return redirect()->back()->with('success', 'Company Account Request Accepted Successfully.')->with('activeTab', 'new-company-account-request-tab');
    }

    public function referredJobReferralRequest(Request $request)
    {
        $jobReferralRequest = JobReferralRequest::find($request->id);
        $jobReferralRequest->status = 'Referred';
        $jobReferralRequest->save();

        return redirect()->back()->with('success', 'A Job-seeker has been Referred Successfully.');
    }

    public function scheduleJobReferralRequest(Request $request)
    {
        $jobReferralRequest = JobReferralRequest::find($request->id);
        $jobReferralRequest->status = 'Scheduled';
        $jobReferralRequest->save();

        return redirect()->back()->with('success', 'Job Referral Request Scheduled Successfully.');
    }

    public function deleteApplicationRequest(Request $request)
    {
        $applicationRequest = Applicant::find($request->id);
        $applicationRequest->delete();

        return redirect()->back()->with('success', 'Job Referral Request Deleted Successfully.')->with('activeTab', $request?->activeTab);
    }

    public function approveApplicationRequest(Request $request)
    {
        $applicationRequest = Applicant::find($request->id);
        $applicationRequest->status = 'Shortlisted';
        $applicationRequest->save();

        return redirect()->back()->with('success', 'Job Referral Request Accepted Successfully.')->with('activeTab', 'new-job-referral-request-tab');
    }

    public function rejectApplicationRequest(Request $request)
    {
        $applicationRequest = Applicant::find($request->id);
        $applicationRequest->status = 'Rejected';
        $applicationRequest->save();

        return redirect()->back()->with('success', 'Job Referral Request Rejected Successfully.')->with('activeTab', 'new-job-referral-request-tab');
    }

    public function reactivateUserAccount(Request $request)
    {
        $userAccountRequest = User::find($request->id);
        $userAccountRequest->status = 'Active';
        $userAccountRequest->save();

        return redirect()->back()->with('success', 'Account Reactivated Successfully.');
    }

    public function deactivateUserAccount(Request $request)
    {
        $userAccountRequest = User::find($request->id);
        $userAccountRequest->status = 'Deactivated';
        $userAccountRequest->save();

        return redirect()->back()->with('success', 'Account Deactivated Successfully.');
    }


    public function deleteUserAccount(Request $request)
    {
        $userAccountRequest = User::find($request->id);
        $userAccountRequest->delete();

        return redirect()->back()->with('success', 'Account Deleted Successfully.');
    }

    // public function rejectAccountRequest(Request $request)
    // {
    //     $userAccountRequest = User::find($request->id);
    //     $userAccountRequest->status = 'Rejected';
    //     $userAccountRequest->save();

    //     return redirect()->back()->with('success', 'Account Request Rejected Successfully.')->with('activeTab', 'new-account-request-tab');
    // }

    public function approveAccountRequest(Request $request)
    {
        $userAccountRequest = User::find($request->id);
        $userAccountRequest->status = 'Active';
        $userAccountRequest->save();

        return redirect()->back()->with('success', 'Account Request Accepted Successfully.')->with('activeTab', 'new-account-request-tab');
    }

    public function adminLogout()
    {
        if (Auth::guard('admin')) {
            Auth::guard('admin')->logout();
        }

        return redirect('admin-login');
    }

    public function adminLogin(Request $request)
    {
        $userAdminInput = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $userAdminInput['email'], 'password' => $userAdminInput['password']])) {
            $request->session()->regenerate();
            return redirect('admin-dashboard');
        }

        return redirect('admin-login');
    }
}
