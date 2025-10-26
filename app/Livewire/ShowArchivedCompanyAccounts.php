<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class ShowArchivedCompanyAccounts extends Component
{
    use WithPagination;

    
    public function render()
    {
        $archivedCompanyAccounts = Company::whereIn('status', ['Deactivated', 'Rejected', 'Archived'])->oldest()->paginate(10, ['*'], 'approved_company_account_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->created_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->created_at)->format('h:i A'); // e.g., 01:35 PM
                return $item;
            });
        
        return view('livewire.show-archived-company-accounts', [
            'archivedCompanyAccounts' => $archivedCompanyAccounts
        ]);
    }
}
