<?php

namespace App\Mail;

use App\Models\CarService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomServiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $carService;
    public $customSubject;
    public $customMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(CarService $carService, string $subject, string $message)
    {
        $this->carService = $carService;
        $this->customSubject = $subject;
        $this->customMessage = $message;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->customSubject)
                   ->view('emails.custom-service')
                   ->with([
                       'carService' => $this->carService,
                       'customMessage' => $this->customMessage
                   ]);
    }
}