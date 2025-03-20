<?php

namespace App\Notifications;

use App\Models\CarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminServiceAlert extends Notification implements ShouldQueue
{
    use Queueable;

    protected $carService;
    protected $alertType;

    /**
     * Create a new notification instance.
     */
    public function __construct(CarService $carService, string $alertType)
    {
        $this->carService = $carService;
        $this->alertType = $alertType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('AutoX Studio: Admin Service Alert')
            ->greeting('Hello Admin,');
            
        switch ($this->alertType) {
            case 'new_request':
                $message->line('A new service request has been submitted.')
                        ->line('Order ID: ' . $this->carService->order_id)
                        ->line('Customer: ' . $this->carService->customer->name)
                        ->line('Vehicle: ' . $this->carService->car_brand . ' ' . $this->carService->car_model);
                break;
                
            case 'overdue':
                $message->line('A service has been in progress for more than 5 days.')
                        ->line('Order ID: ' . $this->carService->order_id)
                        ->line('Customer: ' . $this->carService->customer->name)
                        ->line('Vehicle: ' . $this->carService->car_brand . ' ' . $this->carService->car_model)
                        ->line('Started on: ' . $this->carService->start_date->format('M d, Y'));
                break;
        }
        
        return $message->action('View Service Details', url('/admin/service/' . $this->carService->id))
                        ->line('Thank you for using AutoX Studio Management System!');
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
            'alert_type' => $this->alertType
        ];
    }
}