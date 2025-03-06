@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Customers</h2>
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
                        <th>Name</th>
                        <th>Contact Information</th>
                        <th>Address</th>
                        <th>Total Services</th>
                        <th>First Service</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td><strong>{{ $customer->name }}</strong></td>
                            <td>
                                <p class="mb-1">{{ $customer->phone }}</p>
                                <small class="text-muted">{{ $customer->email ?: 'No email provided' }}</small>
                            </td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->car_services_count }}</td>
                            <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('M d, Y') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $customer->id }}">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                
                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal{{ $customer->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $customer->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title" id="viewModalLabel{{ $customer->id }}">Customer: {{ $customer->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <h6 class="mb-2">Contact Information</h6>
                                                    <p class="mb-1"><strong>Phone:</strong> {{ $customer->phone }}</p>
                                                    <p class="mb-1"><strong>Email:</strong> {{ $customer->email ?: 'No email provided' }}</p>
                                                    <p class="mb-1"><strong>Address:</strong> {{ $customer->address }}</p>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <h6 class="mb-2">Service History</h6>
                                                    @if($customer->car_services_count > 0)
                                                        <p>Customer has requested {{ $customer->car_services_count }} service(s)</p>
                                                        
                                                        <div class="mt-3">
                                                            <h6>Recent Services:</h6>
                                                            <ul class="list-group">
                                                                @foreach($customer->carServices()->latest()->take(5)->get() as $service)
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <strong>{{ $service->order_id }}</strong> - {{ $service->car_brand }} {{ $service->car_model }}
                                                                            <br>
                                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($service->created_at)->format('M d, Y') }}</small>
                                                                        </div>
                                                                        <span class="badge bg-{{ $service->status === 'pending' ? 'warning text-dark' : ($service->status === 'in_progress' ? 'primary' : 'success') }}">
                                                                            {{ ucfirst($service->status) }}
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @else
                                                        <p>No services requested yet.</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="mb-0 text-muted">No customers found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection