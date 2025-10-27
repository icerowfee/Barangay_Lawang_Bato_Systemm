<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Applicant;
use Livewire\WithPagination;

class ShowApprovedApplicants extends Component
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
        $this->resetPage('approved_applicants_page');
    }

    public function updatingSortBy()
    {
        $this->resetPage('approved_applicants_page');
    }

    public function updatingSortDir()
    {
        $this->resetPage('approved_applicants_page');
    }

    public function render()
    {

        $query = Applicant::with('user')->with('jobListing')
            ->join('users', 'applicants.user_id', '=', 'users.id')
            ->select('applicants.*', 'users.lastname', 'users.firstname', 'users.email');

        // ✅ Search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('users.lastname', 'like', "%{$this->search}%")
                    ->orWhere('users.middlename', 'like', "%{$this->search}%")
                    ->orWhere('users.firstname', 'like', "%{$this->search}%")
                    ->orWhere('users.email', 'like', "%{$this->search}%");
            });
        }

        // ✅ Sorting
        switch ($this->sort_by) {
            case 'name':
                $query->orderBy('users.lastname', $this->sort_dir)
                    ->orderBy('users.firstname', $this->sort_dir);
                break;
            case 'email':
                $query->orderBy('users.email', $this->sort_dir);
                break;
            case 'date':
                $query->orderBy('applicants.updated_at', $this->sort_dir);
                break;
            default:
                $query->orderBy('users.lastname', 'asc');
                break;
        }

        $approvedApplicationRequests = $query
            ->where('applicants.status', 'Shortlisted')
            ->oldest('applicants.created_at')
            ->paginate(10, ['*'], 'approved_applicants_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y');
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A');
                $item->formatted_birthdate = optional($item->user)->birthdate
                    ? Carbon::parse($item->user->birthdate)->format('F d, Y')
                    : null;
                return $item;
            });

        return view('livewire.show-approved-applicants', [
            'approvedApplicationRequests' => $approvedApplicationRequests
        ]);
    }
}
