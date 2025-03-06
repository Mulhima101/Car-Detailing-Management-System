<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoX Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <style>
        :root {
            --autox-yellow: #FFDD00;
        }
        .bg-autox-yellow {
            background-color: var(--autox-yellow);
        }
        .btn-autox {
            background-color: var(--autox-yellow);
            color: #000;
            border: none;
        }
        .btn-autox:hover {
            background-color: #e6c700;
            color: #000;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #212529;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: 10px 20px;
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        .sidebar .nav-link.active {
            color: #000;
            background-color: var(--autox-yellow);
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .badge.bg-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge.bg-in-progress {
            background-color: #0d6efd;
        }
        .badge.bg-completed {
            background-color: #198754;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="px-3 mb-4">
            <h4 class="text-white mb-0">
                <span class="text-white">Auto</span><span style="color: #FFDD00">X</span> 
            </h4>
            <p class="text-white-50 small">Admin Dashboard</p>
        </div>
        <ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.in-progress') ? 'active' : '' }}" href="{{ route('admin.in-progress') }}">
            <i class="bi bi-hourglass-split me-2"></i> In-Progress
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.all-services') ? 'active' : '' }}" href="{{ route('admin.all-services') }}">
            <i class="bi bi-car-front me-2"></i> All Services
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.completed-services') ? 'active' : '' }}" href="{{ route('admin.completed-services') }}">
            <i class="bi bi-check-circle me-2"></i> Completed Services
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}" href="{{ route('admin.customers') }}">
            <i class="bi bi-people me-2"></i> Customers
        </a>
    </li>
    <li class="nav-item mt-5">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </li>
    </ul>
    </div>
    
    <div class="content">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>