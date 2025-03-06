@extends('admin.layout')

@section('content')
<h2 class="mb-4">Dashboard</h2>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Services</h5>
                <h2 class="mb-0">{{ $stats['total_services'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5 class="card-title">In Progress</h5>
                <h2 class="mb-0">{{ $stats['in_progress'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Completed</h5>
                <h2 class="mb-0">{{ $stats['completed'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Customers</h5>
                <h2 class="mb-0">{{ $stats['total_customers'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Recent Service Requests</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse($recentServices as $service)
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $service->car_brand }} {{ $service->car_model }}</h6>
                                <small>{{ $service->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">Customer: {{ $service->customer->name }}</p>
                            <div>
                                @foreach(json_decode($service->services_requested) as $requestedService)
                                    <span class="badge bg-secondary me-1">{{ $requestedService }}</span>
                                @endforeach
                            </div>
                            <small class="d-block mt-2">
                                Status:
                                @if($service->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($service->status === 'in_progress')
                                    <span class="badge bg-primary">In Progress</span>
                                @else
                                    <span class="badge bg-success">Completed</span>
                                @endif
                            </small>
                        </div>
                    @empty
                        <p class="text-muted">No recent service requests.</p>
                    @endforelse
                </div>
            </div>
            <div class="card-footer bg-light">
                <a href="{{ route('admin.all-services') }}" class="btn btn-sm btn-outline-dark">View All Services</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Quick Links</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.in-progress') }}" class="btn btn-outline-primary">
                        <i class="bi bi-hourglass-split me-2"></i> In-Progress Services
                    </a>
                    <a href="{{ route('admin.completed-services') }}" class="btn btn-outline-success">
                        <i class="bi bi-check-circle me-2"></i> Completed Services
                    </a>
                    <a href="{{ route('admin.customers') }}" class="btn btn-outline-info">
                        <i class="bi bi-people me-2"></i> Manage Customers
                    </a>
                    <a href="{{ route('service.form') }}" class="btn btn-outline-dark" target="_blank">
                        <i class="bi bi-plus-circle me-2"></i> New Service Request
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">System Information</h5>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                <p class="mb-1"><strong>PHP Version:</strong> {{ PHP_VERSION }}</p>
                <p class="mb-1"><strong>Server Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection