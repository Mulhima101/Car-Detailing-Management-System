@extends('admin.layout')

@section('content')
<div class="page-title">
    <h2>Settings</h2>
    <a href="{{ route('service.create') }}" class="btn btn-yellow">
        <i class="fas fa-plus-circle me-1"></i> New Service Request
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user-cog me-2"></i> Account Settings
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
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bell me-2"></i> Notification Settings
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
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-lock me-2"></i> Change Password
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
    
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cogs me-2"></i> System Settings
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
@endsection