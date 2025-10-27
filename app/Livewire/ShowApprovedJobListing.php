<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\JobListing;
use Livewire\WithPagination;

class ShowApprovedJobListing extends Component
{
    use WithPagination;


    public $search = '';
    public $sort_by = 'lastname';
    public $sort_dir = 'asc';


    public function clearFilter()
    {
        $this->reset(['search', 'sort_by', 'sort_dir']);
    }

    // 🔹 Reset pagination when search/sort updates
    public function updatingSearch()
    {
        $this->resetPage('approved_job_listing_page');
    }

    public function updatingSortBy()
    {
        $this->resetPage('approved_job_listing_page');
    }

    public function updatingSortDir()
    {
        $this->resetPage('approved_job_listing_page');
    }



    public function render()
    {
        $query = JobListing::with('company');

        // ✅ If search is not empty, filter results
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('job_title', 'like', "%{$this->search}%")
                    ->orWhere('job_category', 'like', "%{$this->search}%");
            });
        }

        // ✅ If search is not empty, filter results
        if (!empty($this->search)) {
            $query->whereHas('company', function ($q) {
                $q->where('company_name', 'like', "%{$this->search}%")
                ->orwhere('job_title', 'like', "%{$this->search}%")
                    ->orWhere('job_category', 'like', "%{$this->search}%");
            });
        }

        // Sorting
        switch ($this->sort_by) {
            case 'job_title':
                $query->orderBy('job_title', $this->sort_dir);
                break;
            case 'job_category':
                $query->orderBy($this->sort_by, $this->sort_dir);
                break;
            case 'employment_type':
                $query->orderBy($this->sort_by, $this->sort_dir);
                break;
            case 'date':
                $query->orderBy('updated_at', $this->sort_dir);
                break;
            default:
                $query->orderBy('job_title', 'asc');
                break;
        }

        $approvedJobListings = $query->where('status', 'Active')->oldest()->paginate(10, ['*'], 'approved_job_listing_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                return $item;
            });
        return view('livewire.show-approved-job-listing',[
            'approvedJobListings' => $approvedJobListings
        ]);
    }
}
