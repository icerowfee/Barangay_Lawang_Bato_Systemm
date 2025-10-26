<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Mail\DocumentStatusMail;
use App\Models\ClearanceRequest;
use Illuminate\Support\Facades\Mail;

class ShowPendingClearanceRequests extends Component
{
    use WithPagination;

    public $id;
    public $status;
    public $activeTab;
    public $activePopup;
    public $actual_purpose;


    public function resetModal()
    {
        $this->resetErrorBag(); // Clears validation messages
        $this->resetValidation(); // Clears validation state
        $this->reset(); // Resets all public properties
    }

    public function approveClearanceRequest()
    {
        $validatedData = $this->validate(
            [
                'actual_purpose' => 'required'
            ],
            [
                'actual_purpose.required' => 'Actual purpose is required.'
            ]
        );

        $clearanceRequest = ClearanceRequest::find($this->id);

        // ✅ Check if the record exists
        if ($clearanceRequest == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $clearanceRequest->status = 'Approved';
        $clearanceRequest->actual_purpose = $validatedData['actual_purpose'];
        $clearanceRequest->request_expires_at = now()->addDays(3)->endOfDay(); // Set the expiration date to 3 days from now
        $clearanceRequest->save();

        // Send email notification
        Mail::to($clearanceRequest->email)->send(new DocumentStatusMail('Approved', 'Clearance', null));

        $this->reset();

        $this->dispatch('show-success-toast', message: 'Clearance Request Approved Successfully.');
    }


    public function render()
    {
        $newClearanceRequests = ClearanceRequest::where('status', 'Pending')->oldest()->paginate(10, ['*'], 'pending_clearance_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                $item->formatted_birthdate = $item->birthdate
                    ? Carbon::parse($item->birthdate)->format('F d, Y')
                    : null;
                return $item;
            });

        return view('livewire.show-pending-clearance-requests', [
            'newClearanceRequests' => $newClearanceRequests
        ]);
    }
}
