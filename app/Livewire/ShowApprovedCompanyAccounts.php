<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class ShowApprovedCompanyAccounts extends Component
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
        $this->resetPage('approved_company_account_page');
    }

    public function updatingSortBy()
    {
        $this->resetPage('approved_company_account_page');
    }

    public function updatingSortDir()
    {
        $this->resetPage('approved_company_account_page');
    }



    public function render()
    {

        $query = Company::query(); // Start with the base query

        // ✅ If search is not empty, filter results
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('company_name', 'like', "%{$this->search}%")
                    ->orWhere('contact_person_name', 'like', "%{$this->search}%")
                    ->orWhere('account_email', 'like', "%{$this->search}%");
            });
        }

        // Sorting
        switch ($this->sort_by) {
            case 'company_name':
                $query->orderBy('company_name', $this->sort_dir);
                break;
            case 'contact_person_name':
                $query->orderBy('contact_person_name', $this->sort_dir);
                break;
            case 'email':
                $query->orderBy('account_email', $this->sort_dir);
                break;
            case 'business_type':
                $query->orderBy('business_type', $this->sort_dir);
                break;
            case 'date':
                $query->orderBy('updated_at', $this->sort_dir);
                break;
            default:
                $query->orderBy('company_name', 'asc');
                break;
        }



        $approvedCompanyAccountRequests = $query->where('status', 'Verified')->oldest()->paginate(9, ['*'], 'approved_company_account_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                return $item;
            });

        return view('livewire.show-approved-company-accounts', [
            'approvedCompanyAccountRequests' => $approvedCompanyAccountRequests
        ]);
    }
}
