<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class TestEmail extends Command
{
    protected $signature = 'autox:test-email';
    protected $description = 'Test email functionality';

    public function handle()
    {
        $this->info('Sending test email...');

        try {
            Mail::raw('This is a test email from AutoX Service System', function (Message $message) {
                $message->to('test@example.com')
                    ->subject('AutoX Service - Test Email');
            });

            $this->info('Test email has been logged. Check the laravel.log file.');
        } catch (\Exception $e) {
            $this->error('Error sending test email: ' . $e->getMessage());
        }
    }
}