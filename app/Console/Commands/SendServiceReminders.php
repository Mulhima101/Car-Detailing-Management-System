<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CarService;
use App\Models\User;
use App\Notifications\AdminServiceAlert;
use App\Notifications\ServiceCompletionReminder;
use Carbon\Carbon;

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
        // Get reminder days from settings or use default
        $reminderDays = config('autox.reminder_days', 3);
        $cutoffDate = Carbon::now()->subDays($reminderDays);
        
        // Get overdue services
        $services = CarService::with('customer')
            ->where('status', 'in-progress')
            ->where('start_date', '<=', $cutoffDate)
            ->whereDoesntHave('notifications', function($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(1));
            })
            ->get();
        
        $customerCount = 0;
        $adminCount = 0;
        
        foreach ($services as $service) {
            // Send notification to customer
            if ($service->customer && $service->customer->email) {
                $service->customer->notify(new ServiceCompletionReminder($service));
                $customerCount++;
            }
            
            // Send notification to admin for services older than 5 days
            if ($service->start_date && $service->start_date->diffInDays(now()) >= 5) {
                $admins = User::where('is_admin', true)->get();
                foreach ($admins as $admin) {
                    $admin->notify(new AdminServiceAlert($service, 'overdue'));
                    $adminCount++;
                }
            }
        }
        
        $this->info("Sent {$customerCount} customer service reminders.");
        $this->info("Sent {$adminCount} admin overdue alerts.");
    }
}