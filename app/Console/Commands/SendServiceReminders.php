<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CarService;
use Carbon\Carbon;
use App\Notifications\ServiceCompletionReminder;

class SendServiceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autox:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for services that have been in progress for more than 3 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(3);
        
        $services = CarService::with('customer')
            ->where('status', 'in-progress')
            ->where('start_date', '<=', $cutoffDate)
            ->whereDoesntHave('notifications', function($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(1));
            })
            ->get();
        
        $count = 0;
        foreach ($services as $service) {
            if ($service->customer && $service->customer->email) {
                $service->customer->notify(new ServiceCompletionReminder($service));
                $count++;
            }
        }
        
        $this->info("Sent {$count} service reminders.");
    }
}