<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPendingUserAccounts extends Component
{
    use WithPagination;
    
    public function render()
    {

        $newUserAccountRequests = User::where('status', 'Pending')->oldest()->paginate(10, ['*'], 'approved_user_account_page')
            ->through(function ($item) {
                $item->formatted_date = Carbon::parse($item->updated_at)->format('F d, Y'); // e.g., July 29, 2025
                $item->formatted_time = Carbon::parse($item->updated_at)->format('h:i A'); // e.g., 01:35 PM
                $item->formatted_birthdate = $item->birthdate
                    ? Carbon::parse($item->birthdate)->format('F d, Y')
                    : null;
                return $item;
            });

        return view('livewire.show-pending-user-accounts', [
            'newUserAccountRequests' => $newUserAccountRequests
        ]);
    }
}
