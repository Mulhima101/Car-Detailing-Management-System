<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarService;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\ServiceStatusUpdated;

class DashboardController extends Controller
{
    public function index()
    {
        $inProgressServices = CarService::with('customer')
            ->where('status', 'in-progress')
            ->orderBy('start_date', 'desc')
            ->get();
        
        // Get service statistics
        $stats = [
            'total_services' => CarService::count(),
            'pending_services' => CarService::where('status', 'pending')->count(),
            'in_progress_services' => CarService::where('status', 'in-progress')->count(),
            'completed_services' => CarService::where('status', 'completed')->count(),
            'total_customers' => Customer::count()
        ];
        
        return view('admin.dashboard', compact('inProgressServices', 'stats'));
    }
    
    public function allServices(Request $request)
    {
        $query = CarService::with('customer');
        
        // Apply filters if present
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('car_brand', 'like', "%{$search}%")
                  ->orWhere('car_model', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }
        
        $services = $query->orderBy('created_at', 'desc')->get();
        
        return view('admin.all-services', compact('services'));
    }
    
    public function completedServices()
    {
        $completedServices = CarService::with('customer')
            ->where('status', 'completed')
            ->orderBy('completion_date', 'desc')
            ->get();
        
        return view('admin.completed-services', compact('completedServices'));
    }
    
    public function customers()
    {
        $customers = Customer::withCount('carServices')->get();
        return view('admin.customers', compact('customers'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $carService = CarService::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,in-progress,completed',
        ]);
        
        $oldStatus = $carService->status;
        $carService->status = $validated['status'];
        
        // If status is being changed to completed, set completion date
        if ($validated['status'] === 'completed' && !$carService->completion_date) {
            $carService->completion_date = Carbon::now();
        }
        
        // If status is being changed to in-progress and start_date is not set, set it
        if ($validated['status'] === 'in-progress' && $oldStatus === 'pending') {
            $carService->start_date = Carbon::now();
        }
        
        $carService->save();
        
        // Send notification to customer if email is available
        if ($carService->customer && $carService->customer->email) {
            $carService->customer->notify(new ServiceStatusUpdated($carService));
        }
        
        return redirect()->back()->with('success', 'Service status updated successfully.');
    }
    
    public function viewServiceDetails($id)
    {
        $service = CarService::with('customer')->findOrFail($id);
        return view('admin.service_details', compact('service'));
    }
}