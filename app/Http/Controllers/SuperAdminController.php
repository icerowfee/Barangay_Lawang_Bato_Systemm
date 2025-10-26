<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AdminUser;
use App\Models\SkOfficial;
use Illuminate\Support\Str;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\CedulaRequest;
use App\Models\SuperAdminUser;
use App\Models\GeneratedReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use App\Models\BarangayOfficial;
use App\Models\ClearanceRequest;
use App\Models\IndigencyRequest;
use App\Models\JobReferralRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    
    

    

    public function updateBarangayOfficialList(Request $request)
    {
        // Decode JSON from the hidden input
        $officialsData = json_decode($request->input('barangayOfficials_data'), true);

        // Validate the decoded data
        if (!$officialsData) {
            return back()->withErrors(['error' => 'Invalid input data.']);
        }

        foreach ($officialsData as $index => $officialData) {
            // Find the existing official by position
            $official = BarangayOfficial::where('position', $officialData['position'])->first();

            if ($official) {
                // Default to existing image
                $imagePath = $official->barangay_official_image;

                // Check if an image was uploaded for this official
                if ($request->hasFile("barangayOfficials.$index.barangay_official_image")) {
                    // Store the new image in public storage and get the path
                    $imagePath = $request->file("barangayOfficials.$index.barangay_official_image")->store('images', 'public');
                }

                // Update the official's information
                $official->update([
                    'name' => ucwords(strtolower($officialData['name'])),
                    'barangay_official_image' => $imagePath
                ]);
            }
        }

        return redirect()->back()->with('success', 'Barangay Officials Updated Successfully.');
    }

    public function updateSkOfficialList(Request $request)
    {
        // Decode JSON from the hidden input
        $officialsData = json_decode($request->input('skOfficials_data'), true);

        // Validate the decoded data
        if (!$officialsData) {
            return back()->withErrors(['error' => 'Invalid input data.']);
        }

        foreach ($officialsData as $index => $officialData) {
            // Find the existing official by position
            $official = SkOfficial::where('position', $officialData['position'])->first();

            if ($official) {
                // Default to existing image
                $imagePath = $official->sk_official_image;

                // Check if an image was uploaded for this official
                if ($request->hasFile("skOfficials.$index.sk_official_image")) {
                    // Store the new image in public storage and get the path
                    $imagePath = $request->file("skOfficials.$index.sk_official_image")->store('images', 'public');
                }

                // Update the official's information
                $official->update([
                    'name' => ucwords(strtolower($officialData['name'])),
                    'sk_official_image' => $imagePath
                ]);
            }
        }

        return redirect()->back()->with('success', 'SK Officials Updated Successfully.');
    }


    // For Announcement
    public function addAnnouncement(Request $request)
    {
        $announcement = $request->validate([
            'title' => ['required', 'string', 'max:255'], // example of multiple rules
            'heading' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'], // ensuring end date is after or equal to start date
            'body' => ['required', 'string'],
            'announcement_image' => ['required'], // Example with file validation
            'announcement_type' => ['required', 'string'],
            'status' => ['required'] // Example of an enum-like status
        ]);
        
        if (isset($announcement['announcement_image'])) {
            $announcement['announcement_image'] = $announcement['announcement_image']->store('announcements', 'public');
        }

        Announcement::create($announcement);


        return redirect()->back()->with('success', 'Announcement Posted Successfully!');
    }

    public function editAnnouncement(Announcement $announcement, Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'title' => ['required', 'string', 'max:255'], // example of multiple rules
            'heading' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'], // ensuring end date is after or equal to start date
            'body' => ['required', 'string'],
            'announcement_image' => ['required'], // Example with file validation
            'announcement_type' => ['required', 'string'],
            
        ]);

        
        //NEED FOR ANNOUNCEMENT IMAGE UPDATE (Not updating dahil String nirereturn nya not the file)
        //NEED DIN PAG INUPDATE IMAGE MABUBURA AND TYAKA SYA MAG UUPLOAD ULIT NEW



        $announcement = Announcement::find($request->id);
        $announcement->update($request->all());

        

        return redirect()->back()->with('success', 'Announcement Updated Successfully!')->with('activeTab', $request?->activeTab)->withInput();
    }


    public function deleteAnnouncement(Request $request){
        $announcement = Announcement::find($request->id);
        $announcement->delete();

        $filePath = $announcement->announcement_image;

        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        return redirect()->back()->with('success', 'Announcement Deleted Successfully!');;
    }



    // For Admin Account
    public function createAccount(Request $request){
        $userInput = $request->validate([
            'firstname' => ['required', 'string', 'max:75'],
            'middlename' => ['nullable', 'string', 'max:75'],
            'lastname' => ['required', 'string', 'max:75'],
            'birthdate' => ['required', 'date', 'before:today'],
            'age' => ['required', 'integer', 'min:18', 'max:85'],
            'sex' => 'required',
            'email' => ['required', 'email', Rule::unique('admin_users', 'email')],
            'password' => 'required',
            'role' => 'required'
        ]);

        $userInput['firstname'] = implode(" ", array_map('ucfirst', explode(" ", strtolower($userInput['firstname']))));
        $userInput['middlename'] = implode(" ", array_map('ucfirst', explode(" ", strtolower($userInput['middlename']))));
        $userInput['lastname'] = implode(" ", array_map('ucfirst', explode(" ", strtolower($userInput['lastname']))));

        $userInput['password'] = Str::substr(($userInput['firstname']), 0, 1).Str::substr(($userInput['lastname']), 0, 1).substr(Str::replace("-", "", $userInput['birthdate']), 2);
        //FLYYMMDD
        
        $userInput['password'] = bcrypt($userInput['password']);
        

        AdminUser::create($userInput);
        

        return redirect()->back()->with('success', 'Account Added Successfully!');
    }


    public function editAdminAccount(AdminUser $adminUser, Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'firstname' => 'required',
            'middlename' => 'nullable',
            'lastname' => 'required',
            'birthdate' => 'required',
            'age' => 'required',
            'sex' => 'required',
            'email' => ['required', 'email', Rule::unique('admin_users', 'email')->ignore($request->id)],
            'password' => 'required',
            'role' => 'required'
        ]);

        $validatedData['firstname'] = implode(" ", array_map('ucfirst', explode(" ", strtolower($validatedData['firstname']))));
        $validatedData['middlename'] = implode(" ", array_map('ucfirst', explode(" ", strtolower($validatedData['middlename']))));
        $validatedData['lastname'] = implode(" ", array_map('ucfirst', explode(" ", strtolower($validatedData['lastname']))));


        $validatedData['password'] = Str::substr(($validatedData['firstname']), 0, 1).Str::substr(($validatedData['lastname']), 0, 1).substr(Str::replace("-", "", $validatedData['birthdate']), 2);
        //FLYYMMDD
        
        $validatedData['password'] = bcrypt($validatedData['password']);

        $adminUser = AdminUser::find($request->id);
        $adminUser->update($request->all());

        return redirect()->back()->with('success', 'Account Updated Successfully!');
    }


    public function deleteAdminAccount(Request $request){
        $adminUser = AdminUser::find($request->id);
        $adminUser->delete();

        return redirect()->back()->with('success', 'Account Deleted Successfully!');
    }


    public function superAdminLogout(){
        
        if(Auth::guard('super_admin')){
            Auth::guard('super_admin')->logout();
        }
        
        return redirect('super-admin-login');
    }

    public function superAdminLogin(Request $request){
        $userAdminInput = $request->validate([
            'email' => ['required', 'email', Rule::exists('super_admin_users', 'email')],
            'password' => 'required'
        ]);

        if (Auth::guard('super_admin')->attempt(['email' => $userAdminInput['email'], 'password' => $userAdminInput['password']])){
            $request->session()->regenerate();
            return redirect('super-admin-dashboard');
            //superadmin@gmail.com
            //superman
        }
            
        return redirect('super-admin-login');
    }

    public function generateReport(Request $request)
    {
        
        $reportType = $request->input('report_type');
        $filters = $request->input('filters', []);
        $moduleFilter = $request->input('module_filter', 'all');
        $reporterType = '0'; // Assuming the admin's role is the reporter type
        $reporterId = Auth::guard('super_admin')->user()->id; // Assuming the admin's ID is the reporter ID
        $superAdminUser = SuperAdminUser::find($reporterId);

        $queries = [];
        $currentDate = Carbon::now();


        switch ($moduleFilter) {
            case 'all':
                $adminAccounts = AdminUser::all();

                $queries = [
                    'cedulaQuery' => CedulaRequest::query(),
                    'indigencyQuery' => IndigencyRequest::query(),
                    'clearanceQuery' => ClearanceRequest::query(),
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

                $pdf = Pdf::loadView('super-admin/super-admin-report-template', 
                [
                    'moduleFilter' => $moduleFilter,
                    'dateStart' => $filters['from_date'],
                    'dateEnd' => $filters['to_date'],
                    'reporterType' => $reporterType,
                    'superAdminFirstname' => $superAdminUser->firstname,
                    'superAdminLastname' => $superAdminUser->lastname,

                    'totalAdminAccounts' => $adminAccounts->count(),
                    'totalDocumentIssuanceAdmins' => $adminAccounts->where('role', '1')->count(),
                    'totalJobCenterAdmins' => $adminAccounts->where('role', '2')->count(),

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

                    'totalJobReferred' => $queries['jobReferralQuery']->where('status', 'Referred')->count(),
                    'totalPendingJobReferralRequests' => $queries['jobReferralQuery']->where('status', 'Pending')->count(),
                    'totalProcessingJobReferralRequests' => $queries['jobReferralQuery']->where('status', 'Processing')->count(),
                    'totalRejectedAndCancelledJobReferralRequests' => $queries['jobReferralQuery']->where('status', 'Rejected')->count() + $queries['jobReferralQuery']->where('status', 'Cancelled')->count(),

                    'totalActiveJobAccounts' => $queries['jobAccountQuery']->where('status', 'Active')->count(),
                    'totalPendingJobAccounts' => $queries['jobAccountQuery']->where('status', 'Pending')->count(),
                    'totalDeactivatedJobAccounts' => $queries['jobAccountQuery']->where('status', 'Deactivated')->count(),
                    'totalRejectedJobAccounts' => $queries['jobAccountQuery']->where('status', 'Rejected')->count(),

                    'currentDate' => $currentDate
                ]);

                break;


            case 'super_admin_module':
                $adminAccounts = AdminUser::all();

                $pdf = Pdf::loadView('super-admin/super-admin-report-template', 
                [
                    'moduleFilter' => $moduleFilter,
                    'dateStart' => $filters['from_date'],
                    'dateEnd' => $filters['to_date'],
                    'reporterType' => $reporterType,
                    'superAdminFirstname' => $superAdminUser->firstname,
                    'superAdminLastname' => $superAdminUser->lastname,

                    'totalAdminAccounts' => $adminAccounts->count(),
                    'totalDocumentIssuanceAdmins' => $adminAccounts->where('role', '1')->count(),
                    'totalJobCenterAdmins' => $adminAccounts->where('role', '2')->count(),

                    'currentDate' => $currentDate
                ]);

                break;
            case 'document_issuance_module':
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

                $pdf = Pdf::loadView('super-admin/super-admin-report-template', 
                [
                    'moduleFilter' => $moduleFilter,
                    'dateStart' => $filters['from_date'],
                    'dateEnd' => $filters['to_date'],
                    'reporterType' => $reporterType,
                    'superAdminFirstname' => $superAdminUser->firstname,
                    'superAdminLastname' => $superAdminUser->lastname,

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
                ]);

                break;


            case 'job_center_module':
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

                $pdf = Pdf::loadView('super-admin/super-admin-report-template', 
                [
                    'moduleFilter' => $moduleFilter,
                    'dateStart' => $filters['from_date'],
                    'dateEnd' => $filters['to_date'],
                    'reporterType' => $reporterType,
                    'superAdminFirstname' => $superAdminUser->firstname,
                    'superAdminLastname' => $superAdminUser->lastname,

                    'totalJobReferred' => $queries['jobReferralQuery']->where('status', 'Referred')->count(),
                    'totalPendingJobReferralRequests' => $queries['jobReferralQuery']->where('status', 'Pending')->count(),
                    'totalProcessingJobReferralRequests' => $queries['jobReferralQuery']->where('status', 'Processing')->count(),
                    'totalRejectedAndCancelledJobReferralRequests' => $queries['jobReferralQuery']->where('status', 'Rejected')->count() + $queries['jobReferralQuery']->where('status', 'Cancelled')->count(),

                    'totalActiveJobAccounts' => $queries['jobAccountQuery']->where('status', 'Active')->count(),
                    'totalPendingJobAccounts' => $queries['jobAccountQuery']->where('status', 'Pending')->count(),
                    'totalDeactivatedJobAccounts' => $queries['jobAccountQuery']->where('status', 'Deactivated')->count(),
                    'totalRejectedJobAccounts' => $queries['jobAccountQuery']->where('status', 'Rejected')->count(),

                    'currentDate' => $currentDate
                ]);
                break;
            
            default:
                # code...
                break;
        }

        $fileName = 'Super_Admin_Report_' . now()->format('Ymd_His') . '.pdf';
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
        
    }

}
