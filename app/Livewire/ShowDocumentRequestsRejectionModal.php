<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CedulaRequest;
use App\Mail\DocumentStatusMail;
use App\Models\ClearanceRequest;
use App\Models\IndigencyRequest;
use Illuminate\Support\Facades\Mail;

class ShowDocumentRequestsRejectionModal extends Component
{

    public $activeTab;
    public $id;
    public $rejecting_reason;
    public $status;

    public function mount($activeTab)
    {
        $this->activeTab = $activeTab;
    }

    public function resetExceptTab()
    {
        $activeTab = $this->activeTab;
        $this->reset(); // clears all public properties
        $this->activeTab = $activeTab; // restore the tab value
    }

    public function rejectCedulaRequest()
    {
        $cedulaRequest = CedulaRequest::find($this->id);

        if ($cedulaRequest == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $cedulaRequest->rejecting_reason = $this->rejecting_reason;
        $cedulaRequest->status = 'Rejected';
        $cedulaRequest->save();

        // Send email notification
        Mail::to($cedulaRequest->email)->send(new DocumentStatusMail('Rejected', 'Cedula', $cedulaRequest->rejecting_reason));

        $this->resetExceptTab();

        $this->dispatch('show-success-toast', message: 'Cedula Request Rejected Successfully.');
    }

    public function rejectClearanceRequest()
    {
        $clearanceRequest = ClearanceRequest::find($this->id);

        if ($clearanceRequest == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $clearanceRequest->rejecting_reason = $this->rejecting_reason;
        $clearanceRequest->status = 'Rejected';
        $clearanceRequest->save();

        // Send email notification
        Mail::to($clearanceRequest->email)->send(new DocumentStatusMail('Rejected', 'Clearance', $clearanceRequest->rejecting_reason));

        $this->resetExceptTab();

        $this->dispatch('show-success-toast', message: 'Clearance Request Rejected Successfully.');
    }

    public function rejectIndigencyRequest()
    {
        $indigencyRequest = IndigencyRequest::find($this->id);

        if ($indigencyRequest == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $indigencyRequest->rejecting_reason = $this->rejecting_reason;
        $indigencyRequest->status = 'Rejected';
        $indigencyRequest->save();

        // Send email notification
        Mail::to($indigencyRequest->email)->send(new DocumentStatusMail('Rejected', 'Indigency', $indigencyRequest->rejecting_reason));

        $this->resetExceptTab();

        $this->dispatch('show-success-toast', message: 'Indigency Request Rejected Successfully.');
    }

    public function render()
    {
        return view('livewire.show-document-requests-rejection-modal');
    }
}
