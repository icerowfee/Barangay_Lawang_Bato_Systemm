<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\IndigencyRequest;

class MonitorNewIndigencyRequests extends Component
{
    public $hasNewRequests = false;
    public $latestRequestCount = 0;

    public function mount()
    {
        $this->latestRequestCount = IndigencyRequest::where('status', 'Pending')->count();

        // If there are already pending requests on load
        if ($this->latestRequestCount > 0) {
            $this->hasNewRequests = true;
        }
    }

    #[On('refresh')]
    public function checkForNewRequests()
    {
        $this->runCheck();
    }

    

    #[On('indigency-request-updated')]
    public function runCheck()
    {
        $currentCount = IndigencyRequest::where('status', 'Pending')->count();

        // 🔹 If there are pending requests, keep the indicator ON
        if ($currentCount > 0) {
            $this->hasNewRequests = true;
            $this->latestRequestCount = $currentCount;

            // Notify Alpine only once (if not already visible)
            $this->dispatch('new-indigency-request-detected');
        } 
        // 🔹 If no pending requests left, turn off the indicator
        else {
            $this->hasNewRequests = false;
            $this->latestRequestCount = 0;

            // Notify Alpine.js to remove the indicator
            $this->dispatch('no-new-indigency-request');
        }
    }

    public function render()
    {
        return view('livewire.monitor-new-indigency-requests');
    }
}
