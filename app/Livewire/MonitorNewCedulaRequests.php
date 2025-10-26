<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CedulaRequest;

class MonitorNewCedulaRequests extends Component
{
    public $hasNewRequests = false;
    public $latestRequestCount = 0;

    public function mount()
    {
        $this->latestRequestCount = CedulaRequest::where('status', 'Pending')->count();

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

    

    #[On('cedula-request-updated')]
    public function runCheck()
    {
        $currentCount = CedulaRequest::where('status', 'Pending')->count();

        // 🔹 If there are pending requests, keep the indicator ON
        if ($currentCount > 0) {
            $this->hasNewRequests = true;
            $this->latestRequestCount = $currentCount;

            // Notify Alpine only once (if not already visible)
            $this->dispatch('new-cedula-request-detected');
        } 
        // 🔹 If no pending requests left, turn off the indicator
        else {
            $this->hasNewRequests = false;
            $this->latestRequestCount = 0;

            // Notify Alpine.js to remove the indicator
            $this->dispatch('no-new-cedula-request');
        }
    }
    
    public function render()
    {
        return view('livewire.monitor-new-cedula-requests');
    }
}
