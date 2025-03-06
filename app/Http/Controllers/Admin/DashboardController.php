<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $inProgressServices = CarService::with('customer')
            ->where('status', 'in-progress')
            ->orderBy('start_date', 'desc')
            ->get();
        
        return view('admin.dashboard', compact('inProgressServices'));
    }
    
    public function allServices()
    {
        $services = CarService::with('customer')->orderBy('created_at', 'desc')->get();
        
        return view('admin.all_services', compact('services'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $carService = CarService::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,in-progress,completed',
        ]);
        
        $carService->status = $validated['status'];
        
        if ($validated['status'] === 'completed' && !$carService->completion_date) {
            $carService->completion_date = now();
        }
        
        $carService->save();
        
        return redirect()->back()->with('success', 'Service status updated successfully.');
    }
}