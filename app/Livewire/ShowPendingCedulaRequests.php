<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CedulaRequest;
use App\Mail\DocumentStatusMail;
use Illuminate\Support\Facades\Mail;

class ShowPendingCedulaRequests extends Component
{
    use WithPagination;

    public $id;
    public $status;
    public $activeTab;
    public $activePopup;
    public $actual_purpose;


    public function approveCedulaRequest($id)
    {
        $cedulaRequest = CedulaRequest::find($id);

        // ✅ Check if the record exists
        if ($cedulaRequest == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $cedulaRequest->status = 'Approved';
        $cedulaRequest->request_expires_at = now()->addDays(3)->endOfDay();// Set the expiration date to 3 days from now
        $cedulaRequest->save();

        // Send email notification
        Mail::to($cedulaRequest->email)->send(new DocumentStatusMail('Approved', 'Cedula', null));


        $this->reset();

        $this->dispatch('show-success-toast', message: 'Cedula Request Approved Successfully.');
    }

    
    public function render()
    {
        $newCedulaRequests = CedulaRequest::where('status', 'Pending')->oldest()->paginate(10, ['*'], 'pending_cedula_page')
        ->through(function ($item) {
            $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
            $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
            $item->formatted_birthdate = $item->birthdate 
                ? Carbon::parse($item->birthdate)->format('F d, Y') 
                : null;
            return $item;
        });

        
        return view('livewire.show-pending-cedula-requests', [
            'newCedulaRequests' => $newCedulaRequests
        ]);
    }
}
