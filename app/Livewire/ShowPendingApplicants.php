<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Applicant;
use Livewire\WithPagination;

class ShowPendingApplicants extends Component
{
    use WithPagination;
    
    public function render()
    {
        $newApplicationRequests = Applicant::with('user', 'jobListing')->where('status', 'Applied')->oldest()->paginate(10, ['*'], 'approved_applicants_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y');
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A');
                $item->formatted_birthdate = optional($item->user)->birthdate
                    ? Carbon::parse($item->user->birthdate)->format('F d, Y')
                    : null;
                return $item;
            });

        return view('livewire.show-pending-applicants', [
            'newApplicationRequests' => $newApplicationRequests
        ]);
    }
}
