<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Models\PurchaseOrderTransaction;

class ForceDeleteSoftDeleted extends Command
{
    protected $signature = 'force-delete:soft-deleted';
    protected $description = 'Force delete soft-deleted records older than a specific time';

    public function handle()
    {
        // $threshold = Carbon::now()->subDays(30); // adjust the threshold as needed
        $threshold = Carbon::now()->subMinute(1); // adjust the threshold as needed

        PurchaseOrderTransaction::onlyTrashed()
            ->where('deleted_at', '<=', $threshold)
            ->forceDelete();

        $this->info('Soft-deleted records older than '.$threshold.' have been force deleted.');
    }
}
