<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CarService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceRequestController extends Controller
{
    public function create()
    {
        return view('service_request_form');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'car_brand' => 'required|string|max:50',
            'car_model' => 'required|string|max:100',
            'license_plate' => 'required|string|max:20',
            'color' => 'nullable|string|max:50',
            'services' => 'required|array',
            'notes' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Create or find the customer
            $customer = Customer::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'name' => $validated['customer_name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ]
            );
            
            // Create the car service record
            $carService = new CarService([
                'car_brand' => $validated['car_brand'],
                'car_model' => $validated['car_model'],
                'license_plate' => $validated['license_plate'],
                'color' => $validated['color'] ?? null,
                'services' => $validated['services'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);
            
            $customer->carServices()->save($carService);
            
            DB::commit();
            
            return redirect()->route('service.thankyou', ['id' => $carService->id])
                ->with('success', 'Your service request has been submitted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to submit service request: ' . $e->getMessage()]);
        }
    }

    public function thankYou($id)
    {
        $carService = CarService::with('customer')->findOrFail($id);
        
        return view('service_thankyou', compact('carService'));
    }
}