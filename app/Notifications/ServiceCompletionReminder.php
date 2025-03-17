<?php

namespace App\Notifications;

use App\Models\CarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceCompletionReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $carService;

    /**
     * Create a new notification instance.
     */
    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('AutoX Studio: Your Vehicle Will Be Ready Soon')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('We wanted to let you know that your vehicle is scheduled to be ready soon.')
                    ->line('Service Details:')
                    ->line('Order ID: ' . $this->carService->order_id)
                    ->line('Vehicle: ' . $this->carService->car_brand . ' ' . $this->carService->car_model)
                    ->line('Status: ' . ucfirst($this->carService->status))
                    ->action('View Service Details', url('/service/status/' . $this->carService->id))
                    ->line('Thank you for choosing AutoX Studio!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'car_service_id' => $this->carService->id,
            'order_id' => $this->carService->order_id,
        ];
    }
}