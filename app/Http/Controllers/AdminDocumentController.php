<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;

use App\Models\CedulaRequest;
use App\Mail\DocumentStatusMail;
use App\Models\ClearanceRequest;
use App\Models\IndigencyRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDocumentController extends Controller
{

    public function claimCedula(Request $request) //Remove
    {
        $cedulaRequest = CedulaRequest::find($request->id);
        $cedulaRequest->status = 'Completed';
        $cedulaRequest->request_expires_at = now()->addDays(3)->endOfDay(); // Set the expiration date to 3 days from now
        $cedulaRequest->save();

        return redirect()->back()->with('success', 'Cedula Request Claimed Successfully.')->with('activeTab', $request?->activeTab)->with('activePopup', $request?->activePopup);
    }

    //FOR SAMPLE ONLY (CHANGE PA YUNG FILE NITO)
    public function printCedula(CedulaRequest $cedulaRequest, Request $request){

        $cedulaRequest = CedulaRequest::find($request->id);

        $pdf = new Fpdi();

        // Add a new page
        $pdf->AddPage();
    
        // Set the source PDF file (template)
        $pdf->setSourceFile(storage_path('app/public/document-templates/barangay-certification-template.pdf'));
    
        // Import the first page
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template);
    
        // Set Name font and position
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(100, 44);
        $pdf->Write(10, $cedulaRequest->lastname . $cedulaRequest->firstname . $cedulaRequest->middlename);

        // Set Address font and position
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(58, 53);
        $pdf->Write(10, $cedulaRequest->barangay . $cedulaRequest->city. $cedulaRequest->province);

        // Set Last Name font and position
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(63, 64.5);
        $pdf->Write(10, $cedulaRequest->lastname);
        
    
        // Create the file name
        $filename = $cedulaRequest->lastname . '-cedula.pdf';

        $cedulaRequest->status = 'Completed';
        $cedulaRequest->save();
    
        // Save the file to storage (optional) or just return it to browser
        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output();
        }, $filename);
    }


    //FOR SAMPLE ONLY (CHANGE PA YUNG FILE NITO)
    public function printClearance(ClearanceRequest $clearanceRequest, Request $request){
        $validatedData = $request->validate([
            'actual_purpose' => 'required'
        ]);

        $clearanceRequest = ClearanceRequest::find($request->id);

        $clearanceRequest->actual_purpose = $request->actual_purpose;
        $clearanceRequest->save();

        $pdf = new Fpdi();

        // Add a new page
        $pdf->AddPage();
    
        // Set the source PDF file (template)
        $pdf->setSourceFile(storage_path('app/public/document-templates/barangay-certification-template.pdf'));
    
        // Import the first page
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template);
    
        // Set Name font and position
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(100, 44);
        $pdf->Write(10, $clearanceRequest->lastname . $clearanceRequest->firstname . $clearanceRequest->actual_purpose);

        // Set Address font and position
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(58, 53);
        $pdf->Write(10, $clearanceRequest->barangay . $clearanceRequest->city. $clearanceRequest->province);

        // Set Last Name font and position
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(63, 64.5);
        $pdf->Write(10, $clearanceRequest->lastname);
        
    
        // Create the file name
        $filename = $clearanceRequest->lastname . '-clearance.pdf';

        $clearanceRequest->status = 'Completed';
        $clearanceRequest->save();
    
        // Save the file to storage (optional) or just return it to browser
        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output();
        }, $filename);
    }

    //FOR SAMPLE ONLY (CHANGE PA YUNG FILE NITO)
    public function printIndigency(IndigencyRequest $indigencyRequest, Request $request){

        $validatedData = $request->validate([
            'actual_purpose' => 'required'
        ]);

        $indigencyRequest = IndigencyRequest::find($request->id);
        $indigencyRequest->actual_purpose = $request->actual_purpose;
        $indigencyRequest->save();

        $pdf = new Fpdi();

        // Add a new page
        $pdf->AddPage();
    
        // Set the source PDF file (template)
        $pdf->setSourceFile(storage_path('app/public/document-templates/barangay-certification-template.pdf'));
    
        // Import the first page
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template);
    
        // Set Name font and position
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(100, 44);
        $pdf->Write(10, $indigencyRequest->lastname . $indigencyRequest->firstname . $indigencyRequest->middlename);

        // Set Address font and position
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(58, 53);
        $pdf->Write(10, $indigencyRequest->barangay . $indigencyRequest->city. $indigencyRequest->province);

        // Create the file name
        $filename = $indigencyRequest->lastname . '-indigency.pdf';
    
        $indigencyRequest->status = 'Completed';
        $indigencyRequest->save();

        // Save the file to storage (optional) or just return it to browser
        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output();
        }, $filename);
    }


    public function updateCedulaNumber(IndigencyRequest $indigencyRequest, Request $request) //remove
    {
        $validatedData = $request->validate([
            'cedula_number' => 'nullable',
            'id' => ['required'],
        ]);

        $indigencyRequest = IndigencyRequest::find($request->id);
        $indigencyRequest->cedula_number = $request->cedula_number;
        $indigencyRequest->save();


        return redirect()->back()->with('success', 'Cedula Number Updated Successfully.');
    }

    public function showDocumentRequests(Request $request)
    {
        
        // $newCedulaRequests = CedulaRequest::where('status', 'Pending')->oldest()->paginate(12, ['*'], 'pending_cedula_page')
        // ->through(function ($item) {
        //     $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
        //     $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
        //     $item->formatted_birthdate = $item->birthdate 
        //         ? Carbon::parse($item->birthdate)->format('F d, Y') 
        //         : null;
        //     return $item;
        // });

        // $approvedCedulaRequests = CedulaRequest::where('status', 'Approved')->where('request_expires_at', '>', now())->oldest()->paginate(9, ['*'], 'approved_cedula_page')
        // ->through(function ($item) {
        //     $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
        //     $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
        //     $item->formatted_birthdate = $item->birthdate 
        //         ? Carbon::parse($item->birthdate)->format('F d, Y') 
        //         : null;
        //     return $item;
        // });
        

        // $newClearanceRequests = ClearanceRequest::where('status', 'Pending')->oldest()->paginate(12, ['*'], 'pending_clearance_page')
        // ->through(function ($item) {
        //     $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
        //     $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
        //     $item->formatted_birthdate = $item->birthdate 
        //         ? Carbon::parse($item->birthdate)->format('F d, Y') 
        //         : null;
        //     return $item;
        // });


        // $approvedClearanceRequests = ClearanceRequest::where('status', 'Approved')->where('request_expires_at', '>', now())->oldest()->paginate(9, ['*'], 'approved_clearance_page')
        // ->through(function ($item) {
        //     $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
        //     $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
        //     $item->formatted_birthdate = $item->birthdate 
        //         ? Carbon::parse($item->birthdate)->format('F d, Y') 
        //         : null;
        //     return $item;
        // });

        // $newIndigencyRequests = IndigencyRequest::where('status', 'Pending')->oldest()->paginate(12, ['*'], 'pending_indigency_page')
        // ->through(function ($item) {
        //     $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
        //     $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
        //     $item->formatted_birthdate = $item->birthdate 
        //         ? Carbon::parse($item->birthdate)->format('F d, Y') 
        //         : null;
        //     return $item;
        // });

        // $approvedIndigencyRequests = IndigencyRequest::where('status', 'Approved')->where('request_expires_at', '>', now())->oldest()->paginate(9, ['*'], 'approved_indigency_page')
        // ->through(function ($item) {
        //     $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
        //     $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
        //     $item->formatted_birthdate = $item->birthdate 
        //         ? Carbon::parse($item->birthdate)->format('F d, Y') 
        //         : null;
        //     return $item;
        // });

    
        switch ($request->document_type) {
            // case 'cedula':
            //     $query = CedulaRequest::query();
            //     $sortBy = $request->input('cedula_sort_by', 'lastname'); // default to lastname
            //     $sortDir = $request->input('cedula_sort_dir', 'asc');    // default to ascending
            //     $search = $request->input('cedula_search');
                

            //     if ($search) {
            //         $query->where(function ($q) use ($search) {
            //             $q->where('firstname', 'like', "%{$search}%")
            //             ->orWhere('lastname', 'like', "%{$search}%")
            //             ->orWhere('middlename', 'like', "%{$search}%");
            //         });
            //     }
            
            //     // Sorting
            //     switch ($sortBy) {
            //         case 'name':
            //             $query->orderBy('lastname', $sortDir)->orderBy('firstname', $sortDir);
            //             break;
            //         case 'date':
            //             $query->orderBy('updated_at', $sortDir);
            //             break;
            //         default:
            //             $query->orderBy('lastname', 'asc');
            //             break;
            //     }
            
            //     $approvedCedulaRequests = $query->where('status', 'Approved')->where('request_expires_at', '>', now())->oldest()->paginate(12, ['*'], 'approved_cedula_page')
            //     ->through(function ($item) {
            //         $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
            //         $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
            //         $item->formatted_birthdate = $item->birthdate 
            //             ? Carbon::parse($item->birthdate)->format('F d, Y') 
            //             : null;
            //         return $item;
            //     });
            //     break;
                
            case 'clearance':
                // $query = ClearanceRequest::query();
                // $sortBy = $request->input('clearance_sort_by', 'lastname'); // default to lastname
                // $sortDir = $request->input('clearance_sort_dir', 'asc');    // default to ascending
                // $search = $request->input('clearance_search');
    
                // if ($search) {
                //     $query->where(function ($q) use ($search) {
                //         $q->where('firstname', 'like', "%{$search}%")
                //         ->orWhere('lastname', 'like', "%{$search}%")
                //         ->orWhere('middlename', 'like', "%{$search}%")
                //         ->orWhere('actual_purpose', 'like', "%{$search}%");
                //     });
                // }
            
                // // Sorting
                // switch ($sortBy) {
                //     case 'name':
                //         $query->orderBy('lastname', $sortDir)->orderBy('firstname', $sortDir);
                //         break;
                //     case 'purpose':
                //         $query->orderBy('actual_purpose', $sortDir);
                //         break;
                //     case 'date':
                //         $query->orderBy('updated_at', $sortDir);
                //         break;
                //     default:
                //         $query->orderBy('lastname', 'asc');
                //         break;
                // }
            
                // $activeTab = $request->input('activeTab', 'clearanceTab');
                // $approvedClearanceRequests = $query->where('status', 'Approved')->where('request_expires_at', '>', now())->oldest()->paginate(12, ['*'], 'approved_clearance_page')
                // ->through(function ($item) {
                //     $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                //     $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                //     $item->formatted_birthdate = $item->birthdate 
                //         ? Carbon::parse($item->birthdate)->format('F d, Y') 
                //         : null;
                //     return $item;
                // });
                // break;

            case 'indigency':
                // $query = IndigencyRequest::query();
                // $sortBy = $request->input('indigency_sort_by', 'representative_lastname'); // default to lastname
                // $sortDir = $request->input('indigency_sort_dir', 'asc');    // default to ascending
                // $search = $request->input('indigency_search');
    
                // if ($search) {
                //     $query->where(function ($q) use ($search) {
                //         $q->where('representative_firstname', 'like', "%{$search}%")
                //         ->orWhere('representative_lastname', 'like', "%{$search}%")
                //         ->orWhere('representative_middlename', 'like', "%{$search}%")
                //         ->orWhere('actual_purpose', 'like', "%{$search}%");
                //     });
                // }
            
                // // Sorting
                // switch ($sortBy) {
                //     case 'name':
                //         $query->orderBy('representative_lastname', $sortDir)->orderBy('representative_firstname', $sortDir);
                //         break;
                //     case 'purpose':
                //         $query->orderBy('actual_purpose', $sortDir);
                //         break;
                //     case 'date':
                //         $query->orderBy('updated_at', $sortDir);
                //         break;
                //     default:
                //         $query->orderBy('representative_lastname', 'asc');
                //         break;
                // }
            
                // $approvedIndigencyRequests = $query->where('status', 'Approved')->where('request_expires_at', '>', now())->oldest()->paginate(12, ['*'], 'approved_indigency_page')
                // ->through(function ($item) {
                //     $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                //     $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                //     $item->formatted_birthdate = $item->birthdate 
                //         ? Carbon::parse($item->birthdate)->format('F d, Y') 
                //         : null;
                //     return $item;
                // });
                // break;
            
            default:
                break;
        }

        

        $newCedulaRequestsCount = CedulaRequest::where('status', 'Pending')->count();
        
        

        return view('admin/admin-document-request',
        ['newCedulaRequestsCount' => $newCedulaRequestsCount
        // 'mergedRequests' => $paginatedRequests, 
        // 'newCedulaRequests' => $newCedulaRequests, 
        // 'approvedCedulaRequests' => $approvedCedulaRequests, 
        // 'newClearanceRequests' => $newClearanceRequests, 
        // 'approvedClearanceRequests' => $approvedClearanceRequests, 
        // 'newIndigencyRequests' => $newIndigencyRequests, 
        // 'approvedIndigencyRequests' => $approvedIndigencyRequests
        ])->with([
            'activeTab' => $request->input('activeTab', $request?->activeTab),
            'activePopup' => $request->input('activePopup', null),
            'document_type' => $request->input('document_type', $request?->document_type),
        ]);
    }

    // public function rejectCedulaRequest(Request $request)
    // {
    //     $cedulaRequest = CedulaRequest::find($request->id);
    //     $cedulaRequest->rejecting_reason = $request->rejecting_reason;
    //     $cedulaRequest->status = 'Rejected';
    //     $cedulaRequest->save();

    //     // Send email notification
    //     Mail::to($cedulaRequest->email)->send(new DocumentStatusMail('Rejected', 'Cedula', $cedulaRequest->rejecting_reason));

    //     return redirect()->back()->with('success', 'Cedula Request Rejected Successfully.')->with('activeTab', $request?->activeTab)->with('activePopup', $request?->activePopup);
    // }

    // public function rejectClearanceRequest(Request $request)
    // {
    //     $clearanceRequest = ClearanceRequest::find($request->id);
    //     $clearanceRequest->rejecting_reason = $request->rejecting_reason;
    //     $clearanceRequest->status = 'Rejected';
    //     $clearanceRequest->save();

    //     // Send email notification
    //     Mail::to($clearanceRequest->email)->send(new DocumentStatusMail('Rejected', 'Clearance', $clearanceRequest->rejecting_reason));

    //     return redirect()->back()->with('success', 'Clearance Request Rejected Successfully.')->with('activeTab', $request?->activeTab)->with('activePopup', $request?->activePopup);
    // }

    // public function rejectIndigencyRequest(Request $request)
    // {
    //     $indigencyRequest = IndigencyRequest::find($request->id);
    //     $indigencyRequest->rejecting_reason = $request->rejecting_reason;
    //     $indigencyRequest->status = 'Rejected';
    //     $indigencyRequest->save();

    //     // Send email notification
    //     Mail::to($indigencyRequest->email)->send(new DocumentStatusMail('Rejected', 'Indigency', $indigencyRequest->rejecting_reason));

    //     return redirect()->back()->with('success', 'Indigency Request Rejected Successfully.')->with('activeTab', $request?->activeTab)->with('activePopup', $request?->activePopup);
    // }

    // public function approveCedulaRequest(Request $request)
    // {
    //     $cedulaRequest = CedulaRequest::find($request->id);
    //     $cedulaRequest->status = 'Approved';
    //     $cedulaRequest->request_expires_at = now()->addDays(3)->endOfDay();// Set the expiration date to 3 days from now
    //     $cedulaRequest->save();

    //     // Send email notification
    //     Mail::to($cedulaRequest->email)->send(new DocumentStatusMail('Approved', 'Cedula', null));

    //     return redirect()->back()->with('success', 'Cedula Request Approved Successfully.')->with('activeTab', $request?->activeTab)->with('activePopup', $request?->activePopup);
    // }

    // public function approveClearanceRequest(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'actual_purpose' => 'required'
    //     ],
    //     [
    //         'actual_purpose.required' => 'Actual purpose is required.'
    //     ]);

    //     $clearanceRequest = ClearanceRequest::find($request->id);
    //     $clearanceRequest->status = 'Approved';
    //     $clearanceRequest->actual_purpose = $request->actual_purpose;
    //     $clearanceRequest->request_expires_at = now()->addDays(3)->endOfDay(); // Set the expiration date to 3 days from now
    //     $clearanceRequest->save();

    //     // Send email notification
    //     Mail::to($clearanceRequest->email)->send(new DocumentStatusMail('Approved', 'Clearance', null));

    //     return redirect()->back()->with('success', 'Clearance Request Approved Successfully.')->with('activeTab', $request?->activeTab)->with('activePopup', $request?->activePopup);
    // }

    // public function approveIndigencyRequest(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'actual_purpose' => 'required'
    //     ],
    //     [
    //         'actual_purpose.required' => 'Actual purpose is required.'
    //     ]);

    //     $indigencyRequest = IndigencyRequest::find($request->id);
    //     $indigencyRequest->status = 'Approved';
    //     $indigencyRequest->actual_purpose = $request->actual_purpose;
    //     $indigencyRequest->request_expires_at = now()->addDays(3)->endOfDay(); // Set the expiration date to 3 days from now
    //     $indigencyRequest->save();

    //     // Send email notification
    //     Mail::to($indigencyRequest->email)->send(new DocumentStatusMail('Approved', 'Indigency', null));

    //     return redirect()->back()->with('success', 'Indigency Request Approved Successfully.')->with('activeTab', $request?->activeTab)->with('activePopup', $request?->activePopup);
    // }

    

}
