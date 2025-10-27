<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Applicant;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class ShowArchivedApplicants extends Component
{
    use WithPagination;
    
    public function render()
    {

        $archivedApplicationRequests = Applicant::with('user', 'jobListing')->whereIn('status', ['Rejected', 'Rejected by Company', 'Accepted by Company'])->oldest()->paginate(10, ['*'], 'archived_applicants_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y');
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A');
                $item->formatted_birthdate = optional($item->user)->birthdate
                    ? Carbon::parse($item->user->birthdate)->format('F d, Y')
                    : null;
                return $item;
            });

        return view('livewire.show-archived-applicants', [
            'archivedApplicationRequests' => $archivedApplicationRequests
        ]);
    }
}
