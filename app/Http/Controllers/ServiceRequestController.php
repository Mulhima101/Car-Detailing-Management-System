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

    // app/Http/Controllers/ServiceRequestController.php (add this method)

    public function status($id)
    {
        $carService = CarService::with('customer')->findOrFail($id);
        
        return view('service_status', compact('carService'));
    }
    public function store(Request $request)
    {
        // Let's dump all the form data to see what's being received
        // Comment this out after debugging
        // dd($request->all());
        
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
            'ceramic_coating_type' => 'nullable|string',
            'paint_correction_type' => 'nullable|string',
            'custom_service_description' => 'nullable|string',
        ]);
        
        // Process the services with sub-options
        $processedServices = $validated['services'];
        
        // Add sub-option details to the services
        foreach ($processedServices as $key => $service) {
            if ($service === 'Ceramic Coating' && isset($validated['ceramic_coating_type'])) {
                $processedServices[$key] = $service . ' - ' . $validated['ceramic_coating_type'];
            } 
            else if ($service === 'Paint Correction' && isset($validated['paint_correction_type'])) {
                $processedServices[$key] = $service . ' - ' . $validated['paint_correction_type'];
            }
            else if ($service === 'Custom' && isset($validated['custom_service_description'])) {
                $processedServices[$key] = $service . ' - ' . $validated['custom_service_description'];
            }
        }
        
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
                'car_brand' => $validated['car_brand'], // Make sure this is being passed correctly
                'car_model' => $validated['car_model'],
                'license_plate' => $validated['license_plate'],
                'color' => $validated['color'] ?? null,
                'services' => $processedServices,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);
            
            // For debugging, you can dump the CarService object before saving
            // dd($carService);
            
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