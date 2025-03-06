<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarService extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id', 
        'customer_id', 
        'car_brand', 
        'car_model', 
        'services_requested',
        'status', 
        'service_started_date', 
        'service_finished_date',
        'notes'
    ];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    // Generate order ID automatically and handle dates
    protected static function booted()
    {
        static::creating(function ($carService) {
            $carService->order_id = 'AX-' . date('Ymd') . rand(1000, 9999);
            
            if ($carService->status == 'in_progress' && is_null($carService->service_started_date)) {
                $carService->service_started_date = now();
            }
        });
        
        static::updating(function ($carService) {
            // If status is changing to in_progress and start date is not set
            if ($carService->status == 'in_progress' && is_null($carService->service_started_date)) {
                $carService->service_started_date = now();
            }
            
            // If status is changing to completed and finish date is not set
            if ($carService->status == 'completed' && is_null($carService->service_finished_date)) {
                $carService->service_finished_date = now();
            }
        });
    }
}