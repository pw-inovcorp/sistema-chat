<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CleanInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:clean-inactive-users';

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
        //
        $count = User::where('status', 'online')
            ->where(fn($q) => $q
                ->where('last_seen', '<', now()->subMinutes(5))
                ->orWhereNull('last_seen')
            )
            ->update(['status' => 'offline']);

        $this->info("Marcado {$count} users como offline");

    }
}
