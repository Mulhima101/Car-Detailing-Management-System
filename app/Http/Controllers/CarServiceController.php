public function allServices()
{
    $carServices = CarService::with('customer')
        ->orderBy('created_at', 'desc')
        ->get();
        
    return view('admin.all-services', compact('carServices'));
}

public function completedServices()
{
    $carServices = CarService::with('customer')
        ->where('status', 'completed')
        ->orderBy('service_finished_date', 'desc')
        ->get();
        
    return view('admin.completed-services', compact('carServices'));
}

public function customers()
{
    $customers = Customer::withCount('carServices')
        ->orderBy('name')
        ->get();
        
    return view('admin.customers', compact('customers'));
}