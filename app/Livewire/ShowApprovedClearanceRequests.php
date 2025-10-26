<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClearanceRequest;

class ShowApprovedClearanceRequests extends Component
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
        $this->resetPage('approved_clearance_page');
    }

    public function updatingSortBy()
    {
        $this->resetPage('approved_clearance_page');
    }

    public function updatingSortDir()
    {
        $this->resetPage('approved_clearance_page');
    }   

    

    public function render()
    {
        // Always start with a base query
        $query = ClearanceRequest::query();

        // ✅ If search is not empty, filter results
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('firstname', 'like', "%{$this->search}%")
                    ->orWhere('lastname', 'like', "%{$this->search}%")
                    ->orWhere('middlename', 'like', "%{$this->search}%")
                    ->orWhere('actual_purpose', 'like', "%{$this->search}%");
            });
        }


        // Sorting
        switch ($this->sort_by) {
            case 'name':
                $query->orderBy('lastname', $this->sort_dir)->orderBy('firstname', $this->sort_dir);
                break;
            case 'date':
                $query->orderBy('updated_at', $this->sort_dir);
                break;
            case 'purpose':
                $query->orderBy('actual_purpose', $this->sort_dir);
                break;
            default:
                $query->orderBy('lastname', 'asc');
                break;
        }

        $approvedClearanceRequests = $query->where('status', 'Approved')->where('request_expires_at', '>', now())->oldest()->paginate(9, ['*'], 'approved_clearance_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                $item->formatted_birthdate = $item->birthdate
                    ? Carbon::parse($item->birthdate)->format('F d, Y')
                    : null;
                return $item;
            });


        return view('livewire.show-approved-clearance-requests', [
            'approvedClearanceRequests' => $approvedClearanceRequests
        ]);
    }
}
