<?php

namespace App\Console\Commands;

use App\Models\CedulaRequest;
use Illuminate\Console\Command;
use App\Models\ClearanceRequest;
use App\Models\IndigencyRequest;
use Illuminate\Support\Facades\Log;

class ExpireDocumentRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-document-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        CedulaRequest::where('status', 'Approved')
            ->where('request_expires_at', '<', now())
            ->update(['status' => 'Expired']);
        IndigencyRequest::where('status', 'Approved')
            ->where('request_expires_at', '<', now())
            ->update(['status' => 'Expired']);
        ClearanceRequest::where('status', 'Approved')
            ->where('request_expires_at', '<', now())
            ->update(['status' => 'Expired']);
        
        Log::info('ExpireDocumentRequests command ran.');
    }
}
