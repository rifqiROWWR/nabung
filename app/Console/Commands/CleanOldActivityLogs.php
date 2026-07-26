<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class CleanOldActivityLogs extends Command
{
    protected $signature = 'logs:clean';
    protected $description = 'Hapus activity log yang lebih tua dari 30 hari untuk hemat storage';

    public function handle(): void
    {
        $deleted = ActivityLog::where('created_at', '<', now()->subDays(8))->delete();

        $this->info("Berhasil menghapus {$deleted} log lama.");
    }
}