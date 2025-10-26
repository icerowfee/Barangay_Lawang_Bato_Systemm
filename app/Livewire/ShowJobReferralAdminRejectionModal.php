<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use App\Models\Applicant;
use App\Models\JobListing;
use App\Mail\DocumentStatusMail;
use Illuminate\Support\Facades\Mail;

class ShowJobReferralAdminRejectionModal extends Component
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

    public function rejectAccountRequest()
    {
        $userAccountRequest = User::find($this->id);

        if ($userAccountRequest == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $userAccountRequest->status = 'Rejected';
        $userAccountRequest->rejecting_reason = $this->rejecting_reason;
        $userAccountRequest->save();

        // Send email notification (Add this later) (REQUIRED)
        // Mail::to($userAccountRequest->email)->send(new DocumentStatusMail('Rejected', 'Cedula', $userAccountRequest->rejecting_reason));

        $this->resetExceptTab();

        $this->dispatch('show-success-toast', message: 'Account Request Rejected Successfully.');
    }


    public function rejectCompanyAccountRequest()
    {
        $companyAccountRequest = Company::find($this->id);

        if ($companyAccountRequest == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $companyAccountRequest->status = 'Rejected';
        $companyAccountRequest->rejecting_reason = $this->rejecting_reason;
        $companyAccountRequest->save();

        // Send email notification (Add this later) (REQUIRED)
        // Mail::to($userAccountRequest->email)->send(new DocumentStatusMail('Rejected', 'Cedula', $userAccountRequest->rejecting_reason));

        $this->resetExceptTab();

        $this->dispatch('show-success-toast', message: 'Company Account Request Rejected Successfully.')->with('activeTab', 'new-company-account-request-tab');
    }


    public function rejectApplicationRequest()
    {
        $applicationRequest = Applicant::find($this->id);

        if ($applicationRequest == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $applicationRequest->status = 'Rejected';
        $applicationRequest->rejecting_reason = $this->rejecting_reason;
        $applicationRequest->save();

        // Send email notification (Add this later) (REQUIRED)
        // Mail::to($userAccountRequest->email)->send(new DocumentStatusMail('Rejected', 'Cedula', $userAccountRequest->rejecting_reason));

        $this->resetExceptTab();

        $this->dispatch('show-success-toast', message: 'Job Referral Request Rejected Successfully.');
    }


    public function rejectJobListing()
    {
        $jobListing = JobListing::find($this->id);

        if ($jobListing == null) {
            $this->dispatch('show-error-toast', message: 'Something Went Wrong. Please Try Again.');
            return;
        }

        $jobListing->status = 'Rejected';
        $jobListing->rejecting_reason = $this->rejecting_reason;
        $jobListing->save();

        // Send email notification (Add this later) (REQUIRED)
        // Mail::to($userAccountRequest->email)->send(new DocumentStatusMail('Rejected', 'Cedula', $userAccountRequest->rejecting_reason));

        $this->resetExceptTab();

        $this->dispatch('show-success-toast', message: 'Job Listing Rejected Successfully.');
    }



    public function render()
    {
        return view('livewire.show-job-referral-admin-rejection-modal');
    }
}
