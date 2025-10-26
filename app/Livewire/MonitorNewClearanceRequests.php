<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClearanceRequest;

class MonitorNewClearanceRequests extends Component
{
    public $hasNewRequests = false;
    public $latestRequestCount = 0;

    public function mount()
    {
        $this->latestRequestCount = ClearanceRequest::where('status', 'Pending')->count();

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

    

    #[On('clearance-request-updated')]
    public function runCheck()
    {
        $currentCount = ClearanceRequest::where('status', 'Pending')->count();

        // 🔹 If there are pending requests, keep the indicator ON
        if ($currentCount > 0) {
            $this->hasNewRequests = true;
            $this->latestRequestCount = $currentCount;

            // Notify Alpine only once (if not already visible)
            $this->dispatch('new-clearance-request-detected');
        } 
        // 🔹 If no pending requests left, turn off the indicator
        else {
            $this->hasNewRequests = false;
            $this->latestRequestCount = 0;

            // Notify Alpine.js to remove the indicator
            $this->dispatch('no-new-clearance-request');
        }
    }

    public function render()
    {
        return view('livewire.monitor-new-clearance-requests');
    }
}
