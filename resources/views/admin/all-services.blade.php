<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Services - AutoX</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/autox.css') }}" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
        }
        .main-content {
            margin-left: 250px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <h4><span class="brand-yellow">AutoX</span></h4>
            <div>Admin Dashboard</div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.customers') }}">
                    <i class="fas fa-users"></i> Customers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.services') }}">
                    <i class="fas fa-car"></i> All Services
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.settings') }}">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>
            <li class="nav-item mt-5">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center page-title">
            <h2>All Services</h2>
            <a href="{{ route('service.create') }}" class="btn btn-yellow">
                <i class="fas fa-plus-circle"></i> New Service Request
            </a>
        </div>

        <!-- Alerts for success/error messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services') }}" method="GET" class="row align-items-end">
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Order ID, Customer, Car..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('admin.services') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- All Services Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Service Records</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Vehicle</th>
                                <th>Services</th>
                                <th>Status</th>
                                <th>Dates</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($services) > 0)
                                @foreach($services as $service)
                                    <tr>
                                        <td>{{ $service->order_id }}</td>
                                        <td>
                                            <div>{{ $service->customer->name }}</div>
                                            <small class="text-muted">{{ $service->customer->email }}</small>
                                        </td>
                                        <td>
                                            <div>{{ $service->car_brand }} {{ $service->car_model }}</div>
                                            <small class="text-muted">{{ $service->license_plate }}</small>
                                        </td>
                                        <td>
                                            @foreach($service->services as $serviceItem)
                                                <span class="badge bg-secondary">{{ $serviceItem }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $service->status }}">
                                                {{ ucfirst($service->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div><strong>Start:</strong> {{ $service->start_date->format('M d, Y') }}</div>
                                            @if($service->completion_date)
                                                <div><strong>Completed:</strong> {{ $service->completion_date->format('M d, Y') }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewServiceModal-{{ $service->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#updateStatusModal-{{ $service->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- View Service Modal -->
                                            <div class="modal fade" id="viewServiceModal-{{ $service->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Service Details - {{ $service->order_id }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Same content as in dashboard.blade.php -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6>Customer Information</h6>
                                                                    <p><strong>Name:</strong> {{ $service->customer->name }}</p>
                                                                    <p><strong>Phone:</strong> {{ $service->customer->phone }}</p>
                                                                    <p><strong>Email:</strong> {{ $service->customer->email }}</p>
                                                                    <p><strong>Address:</strong> {{ $service->customer->address }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>Vehicle Information</h6>
                                                                    <p><strong>Brand & Model:</strong> {{ $service->car_brand }} {{ $service->car_model }}</p>
                                                                    <p><strong>License Plate:</strong> {{ $service->license_plate }}</p>
                                                                    <p><strong>Color:</strong> {{ $service->color ?? 'N/A' }}</p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6>Service Details</h6>
                                                                    <p><strong>Services:</strong></p>
                                                                    <ul>
                                                                        @foreach($service->services as $serviceItem)
                                                                            <li>{{ $serviceItem }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                    <p><strong>Notes:</strong> {{ $service->notes ?? 'N/A' }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6>Status Information</h6>
                                                                    <p><strong>Current Status:</strong> <span class="status-badge status-{{ $service->status }}">{{ ucfirst($service->status) }}</span></p>
                                                                    <p><strong>Started:</strong> {{ $service->start_date->format('M d, Y, h:i A') }}</p>
                                                                    @if($service->completion_date)
                                                                        <p><strong>Completed:</strong> {{ $service->completion_date->format('M d, Y, h:i A') }}</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Update Status Modal -->
                                            <div class="modal fade" id="updateStatusModal-{{ $service->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Update Status - {{ $service->order_id }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('admin.service.update-status', $service->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-select" id="status" name="status" required>
                                                                        <option value="pending" {{ $service->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                        <option value="in-progress" {{ $service->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                                                        <option value="completed" {{ $service->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                                    </select>
                                                                </div>
                                                                <div class="alert alert-info">
                                                                    <small>Note: Marking as "Completed" will automatically set the completion date to the current time.</small>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update Status</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">No services found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>