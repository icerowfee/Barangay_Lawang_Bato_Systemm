<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowApprovedUserAccounts extends Component
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
        $this->resetPage('approved_user_account_page');
    }

    public function updatingSortBy()
    {
        $this->resetPage('approved_user_account_page');
    }

    public function updatingSortDir()
    {
        $this->resetPage('approved_user_account_page');
    }





    public function render()
    {

        $query = User::query();

        // ✅ If search is not empty, filter results
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('firstname', 'like', "%{$this->search}%")
                    ->orWhere('lastname', 'like', "%{$this->search}%")
                    ->orWhere('middlename', 'like', "%{$this->search}%");
            });
        }

        // Sorting
        switch ($this->sort_by) {
            case 'name':
                $query->orderBy('lastname', $this->sort_dir)->orderBy('firstname', $this->sort_dir);
                break;
            case 'sex':
                $query->orderBy($this->sort_by, $this->sort_dir);
                break;
            case 'email':
                $query->orderBy($this->sort_by, $this->sort_dir);
                break;
            case 'date':
                $query->orderBy('updated_at', $this->sort_dir);
                break;
            default:
                $query->orderBy('lastname', 'asc');
                break;
        }


        $approvedUserAccountRequests = $query->where('status', 'Active')->oldest()->paginate(10, ['*'], 'approved_user_account_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                $item->formatted_birthdate = $item->birthdate
                    ? Carbon::parse($item->birthdate)->format('F d, Y')
                    : null;
                return $item;
            });


        return view('livewire.show-approved-user-accounts', [
            'approvedUserAccountRequests' => $approvedUserAccountRequests
        ]);
    }
}
