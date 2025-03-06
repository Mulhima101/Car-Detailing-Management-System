@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>All Services</h2>
    <a href="{{ route('service.form') }}" class="btn btn-outline-dark" target="_blank">
        <i class="bi bi-plus-circle me-2"></i>New Service Request
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-autox-yellow">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>Services</th>
                        <th>Date Created</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($carServices as $service)
                        <tr>
                            <td>{{ $service->order_id }}</td>
                            <td>
                                <strong>{{ $service->customer->name }}</strong><br>
                                <small class="text-muted">{{ $service->customer->phone }}</small>
                            </td>
                            <td>{{ $service->car_brand }} {{ $service->car_model }}</td>
                            <td>
                                @foreach(json_decode($service->services_requested) as $requestedService)
                                    <span class="badge bg-secondary mb-1">{{ $requestedService }}</span><br>
                                @endforeach
                            </td>
                            <td>{{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y') }}</td>
                            <td>
                                @if($service->status === 'pending')
                                    <span class="badge bg-pending">Pending</span>
                                @elseif($service->status === 'in_progress')
                                    <span class="badge bg-in-progress">In Progress</span>
                                @else
                                    <span class="badge bg-completed">Completed</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal{{ $service->id }}">
                                    <i class="bi bi-pencil-square"></i> Update
                                </button>
                                
                                <!-- Update Modal -->
                                <div class="modal fade" id="updateModal{{ $service->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $service->id }}" aria-hidden="true">
                                    <!-- Same modal content as in dashboard.blade.php -->
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <p class="mb-0 text-muted">No services found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection