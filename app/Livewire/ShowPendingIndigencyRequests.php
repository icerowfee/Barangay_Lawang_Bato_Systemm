<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Mail\DocumentStatusMail;
use App\Models\IndigencyRequest;
use Illuminate\Support\Facades\Mail;

class ShowPendingIndigencyRequests extends Component
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
    }

    public function approveIndigencyRequest()
    {
        $validatedData = $this->validate([
            'actual_purpose' => 'required'
        ],
        [
            'actual_purpose.required' => 'Actual purpose is required.'
        ]);

        $indigencyRequest = IndigencyRequest::find($this->id);

        // ✅ Check if the record exists
        if ($indigencyRequest == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $indigencyRequest->status = 'Approved';
        $indigencyRequest->actual_purpose = $validatedData['actual_purpose'];
        $indigencyRequest->request_expires_at = now()->addDays(3)->endOfDay(); // Set the expiration date to 3 days from now
        $indigencyRequest->save();

        // Send email notification
        Mail::to($indigencyRequest->email)->send(new DocumentStatusMail('Approved', 'Indigency', null));

        $this->reset();

        $this->dispatch('show-success-toast', message: 'Indigency Request Approved Successfully.');
    }

    public function render()
    {
        $newIndigencyRequests = IndigencyRequest::where('status', 'Pending')->oldest()->paginate(10, ['*'], 'pending_indigency_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                $item->formatted_birthdate = $item->birthdate
                    ? Carbon::parse($item->birthdate)->format('F d, Y')
                    : null;
                return $item;
            });

        return view('livewire.show-pending-indigency-requests', [
            'newIndigencyRequests' => $newIndigencyRequests
        ]);
    }
}
