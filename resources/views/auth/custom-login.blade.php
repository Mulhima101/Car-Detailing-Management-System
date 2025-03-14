<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AutoX Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .brand-name {
            margin-bottom: 20px;
        }
        .brand-name span.yellow {
            color: #FFCE00;
            font-weight: bold;
        }
        .brand-name span.dark {
            color: #333;
            font-weight: bold;
        }
        .subtitle {
            color: #777;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 20px;
        }
        .btn-signin {
            background-color: #FFCE00;
            color: #333;
            border: none;
            border-radius: 4px;
            padding: 12px;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
        }
        .btn-signin:hover {
            background-color: #e6b800;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.8rem;
            color: #999;
        }
        .field-label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .text-danger {
            color: #dc3545;
            font-size: 0.9rem;
            text-align: left;
            margin-top: -15px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="brand-name">
            <h2><span class="yellow">AutoX</span> <span class="dark">Service</span></h2>
        </div>
        <p class="subtitle">Management System</p>
        
        @if (session('status'))
            <div class="alert alert-success mb-3">
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="field-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                
                @error('email')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="password" class="field-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                
                @error('password')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-signin">Sign In</button>
        </form>
        
        <div class="footer">
            &copy; 2025 AutoX Studio. All rights reserved.
        </div>
    </div>
</body>
</html>