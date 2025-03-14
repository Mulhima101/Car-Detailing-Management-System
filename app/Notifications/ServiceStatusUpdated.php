// app/Notifications/ServiceStatusUpdated.php

<?php

namespace App\Notifications;

use App\Models\CarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceStatusUpdated extends Notification implements ShouldQueue
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
        $statusMessages = [
            'pending' => 'Your service request has been received and is pending',
            'in-progress' => 'Great news! Work has begun on your vehicle',
            'completed' => 'Your service has been completed and your vehicle is ready!'
        ];
        
        $message = $statusMessages[$this->carService->status] ?? 'Your service status has been updated';
        
        return (new MailMessage)
                    ->subject('AutoX Studio: Service Status Update')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line($message)
                    ->line('Service Details:')
                    ->line('Order ID: ' . $this->carService->order_id)
                    ->line('Vehicle: ' . $this->carService->car_brand . ' ' . $this->carService->car_model)
                    ->line('License Plate: ' . $this->carService->license_plate)
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
            'status' => $this->carService->status
        ];
    }
}