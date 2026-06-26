@extends('frontend.layout.master')

@section('content')

<!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Login</h1>
        </div>
        <div class="breadcumb-menu-wrap">
            <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Login</li>
            </ul>
        </div>
    </div>
</div>

<!--==============================
    Login Area
============================== -->
<section class="login-register space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="login-form-wrapper">
                    
                    <!-- Session Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h3 class="form-title mb-4">Login to Your Account</h3>
                    
                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf
                        
                        <div class="form-group">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your email"
                                   required 
                                   autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password"
                                       required>
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-between align-items-center flex-wrap">
                            <div class="custom-checkbox">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Remember Me</label>
                            </div>
                            @if(Route::has('password.request'))
                                <a class="text-reset fw-medium" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="vs-btn w-100">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </div>

                        <p class="form-footer text-center mt-3 mb-0">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-reset fw-medium">Register Here</a>
                        </p>
                    </form>

                    <!-- Optional: Social Login -->
                    @if(config('services.google.client_id') || config('services.facebook.client_id'))
                        <div class="login-divider my-4">
                            <span>Or continue with</span>
                        </div>
                        
                        <div class="social-login d-flex gap-3 justify-content-center">
                            @if(config('services.google.client_id'))
                                <a href="{{ route('auth.google') }}" class="social-btn google">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                                    </svg>
                                </a>
                            @endif
                            
                            @if(config('services.facebook.client_id'))
                                <a href="{{ route('auth.facebook') }}" class="social-btn facebook">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.315 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .login-form-wrapper {
        background: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }
    
    .form-title {
        font-weight: 600;
        text-align: center;
        color: #2c3e50;
    }
    
    .form-group label {
        font-weight: 500;
        margin-bottom: 8px;
        color: #34495e;
    }
    
    .form-control {
        padding: 12px 15px;
        border: 1px solid #e1e5eb;
        border-radius: 4px;
        transition: border-color 0.2s;
    }
    
    .form-control:focus {
        border-color: #27ae60;
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
    }
    
    .form-control.is-invalid {
        border-color: #e74c3c;
    }
    
    .invalid-feedback {
        display: block;
        font-size: 13px;
        color: #e74c3c;
        margin-top: 4px;
    }
    
    .password-wrapper {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #7f8c8d;
        cursor: pointer;
        padding: 0;
    }
    
    .password-toggle:hover {
        color: #2c3e50;
    }
    
    .custom-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .custom-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .vs-btn {
        padding: 12px 24px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .form-footer {
        font-size: 14px;
        color: #7f8c8d;
    }
    
    .form-footer a {
        color: #27ae60;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .form-footer a:hover {
        color: #219653;
        text-decoration: underline;
    }
    
    .login-divider {
        position: relative;
        text-align: center;
    }
    
    .login-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e1e5eb;
    }
    
    .login-divider span {
        background: #fff;
        padding: 0 15px;
        color: #7f8c8d;
        font-size: 14px;
        position: relative;
    }
    
    .social-login {
        gap: 12px;
    }
    
    .social-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border: 1px solid #e1e5eb;
        transition: all 0.2s;
        color: #2c3e50;
    }
    
    .social-btn:hover {
        background: #27ae60;
        border-color: #27ae60;
        color: #fff;
        transform: translateY(-2px);
    }
    
    .social-btn.google:hover {
        background: #4285F4;
        border-color: #4285F4;
    }
    
    .social-btn.facebook:hover {
        background: #1877F2;
        border-color: #1877F2;
    }
    
    @media (max-width: 576px) {
        .login-form-wrapper {
            padding: 30px 20px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (toggleBtn && passwordInput) {
        toggleBtn.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.querySelector('i').className = type === 'password' ? 'far fa-eye' : 'far fa-eye-slash';
        });
    }
    
    // Auto-focus email field
    const emailInput = document.getElementById('email');
    if (emailInput && !emailInput.value) {
        emailInput.focus();
    }
});
</script>
@endpush