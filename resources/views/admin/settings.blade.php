<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - AutoX</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/autox.css') }}" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #212529;
            color: white;
            padding-top: 20px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
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
        <div class="px-3 mb-4">
            <h4 class="text-white mb-0">
                <span class="text-white">Auto</span><span style="color: #FFDD00">X</span> 
            </h4>
            <p class="text-white-50 small">Admin Dashboard</p>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.customers') }}">
                    <i class="fas fa-users me-2"></i> Customers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.services') }}">
                    <i class="fas fa-car me-2"></i> All Services
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.completed-services') }}">
                    <i class="fas fa-check-circle me-2"></i> Completed Services
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.settings') }}">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
            </li>
            <li class="nav-item mt-5">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Settings</h2>
        </div>

        <!-- Alerts for success/error messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <!-- Account Settings Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user-cog me-2"></i> Account Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>

                <!-- Password Change Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-lock me-2"></i> Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Notification Settings Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-bell me-2"></i> Notification Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST">
                            @csrf
                            <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="statusUpdates" name="notification_status_updates" checked>
                                    <label class="form-check-label" for="statusUpdates">Service Status Updates</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="completionReminders" name="notification_completion_reminders" checked>
                                    <label class="form-check-label" for="completionReminders">Service Completion Reminders</label>
                                    </div>
                                    <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="marketingEmails" name="notification_marketing_emails">
                                    <label class="form-check-label" for="marketingEmails">Marketing Emails</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save Notification Settings</button>
                                    </form>
                                    </div>
                                    </div>

                                    <!-- System Settings Card -->
                                    <div class="card mb-4">
                                    <div class="card-header">
                                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i> System Settings</h5>
                                    </div>
                                    <div class="card-body">
                                    <form action="#" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="companyName" name="company_name" value="AutoX Studio">
                                    </div>
                                    <div class="mb-3">
                                    <label for="companyEmail" class="form-label">Company Email</label>
                                    <input type="email" class="form-control" id="companyEmail" name="company_email" value="info@autoxstudio.com.au">
                                    </div>
                                    <div class="mb-3">
                                    <label for="companyPhone" class="form-label">Company Phone</label>
                                    <input type="text" class="form-control" id="companyPhone" name="company_phone" value="(02) 1234 5678">
                                    </div>
                                    <div class="mb-3">
                                    <label for="reminderDays" class="form-label">Send Reminders (Days before completion)</label>
                                    <input type="number" class="form-control" id="reminderDays" name="reminder_days" value="1" min="1" max="7">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save System Settings</button>
                                    </form>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>

                                    <!-- Bootstrap JS -->
                                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                                    </body>
                                    </html>