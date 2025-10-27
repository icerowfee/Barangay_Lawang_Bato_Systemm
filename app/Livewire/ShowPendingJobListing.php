<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\JobListing;
use Livewire\WithPagination;

class ShowPendingJobListing extends Component
{
    use WithPagination;

    public function render()
    {

        $newJobListings = JobListing::with('company')->where('status', 'Pending')->oldest()->paginate(10, ['*'], 'pending_job_listing_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                return $item;
            });

        return view('livewire.show-pending-job-listing', [
            'newJobListings' => $newJobListings
        ]);
    }
}
