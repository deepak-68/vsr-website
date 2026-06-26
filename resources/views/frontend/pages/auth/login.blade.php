
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
<section class="space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                
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
                
               {{-- 🔹 UPDATED CONDITION - Query string + Session dono check karein --}}
@php
    $showOtpForm = 
        request('verify_otp') == 1 && request('otp_email') ||
        (session('otp_step') == 'verify' && session('otp_email'));
    
    $otpEmail = request('otp_email') ?: session('otp_email');
@endphp

@if($showOtpForm)
    <!-- 🔹 OTP Verification Form -->
    <div class="auth-wrapper">
        <div class="auth-header text-center mb-4">
            <h2>Verify OTP</h2>
            <p class="text-muted">
                Enter the 6-digit code sent to <strong>{{ $otpEmail }}</strong>
            </p>
        </div>
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <form method="POST" action="{{ route('verify-otp') }}" id="otpVerifyForm">
            @csrf
            <input type="hidden" name="email" value="{{ $otpEmail }}">
            <input type="hidden" name="type" value="{{ request('type') ?: session('otp_type', 'login') }}">
            
            <div class="form-group mb-4">
                <label for="otp" class="text-center d-block mb-2">One-Time Password</label>
                <input type="text" 
                       class="form-control text-center fs-4 fw-bold @error('otp') is-invalid @enderror" 
                       id="otp" 
                       name="otp" 
                       maxlength="6" 
                       pattern="\d{6}"
                       inputmode="numeric"
                       required 
                       placeholder="••••••"
                       style="letter-spacing: 10px;"
                       autofocus>
                @error('otp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <small class="text-muted d-block mt-2 text-center">
                    OTP expires in 10 minutes
                </small>
            </div>
            
            <button type="submit" class="vs-btn w-100 mb-3" id="verifyBtn">
                <span class="btn-text">Verify & Login</span>
                <span class="btn-loading" style="display:none;">
                    <i class="fas fa-spinner fa-spin me-2"></i>Verifying...
                </span>
            </button>
            
            <div class="text-center mb-3">
                <small class="text-muted">
                    Didn't receive code? 
                    <button type="submit" form="resendOtpForm" class="btn btn-link p-0 border-0 text-primary text-decoration-none">
                        Resend OTP
                    </button>
                </small>
            </div>
        </form>
        
        <form id="resendOtpForm" method="POST" action="{{ route('resend-otp') }}" class="d-none">
            @csrf
            <input type="hidden" name="email" value="{{ $otpEmail }}">
            <input type="hidden" name="type" value="{{ request('type') ?: session('otp_type', 'login') }}">
        </form>
        
        <div class="text-center mt-4 pt-3 border-top">
            <a href="{{ route('login') }}" class="text-muted text-decoration-none">
                ← Back to password login
            </a>
        </div>
    </div>
    
                    
                @else
                    <!-- 🔹 Traditional Login Form -->
                    <div class="auth-wrapper">
                        <div class="auth-header text-center mb-4">
                            <h2>Welcome Back</h2>
                            <p class="text-muted">Login to your account to continue</p>
                        </div>
                        
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf
                            
                            <div class="form-group mb-3">
                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus
                                       placeholder="Enter your email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required 
                                           placeholder="Enter your password">
                                    <button type="button" class="input-group-text bg-white border-start-0" id="togglePassword">
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-4 d-flex justify-content-between align-items-center">
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="remember" name="remember">
                                    <label for="remember" class="mb-0">Remember Me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-muted small">
                                    Forgot Password?
                                </a>
                            </div>
                            
                            <button type="submit" class="vs-btn w-100 mb-3" id="loginBtn">
                                <span class="btn-text">Login</span>
                                <span class="btn-loading" style="display:none;">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Logging in...
                                </span>
                            </button>
                            
                        </form>
                        
                        <!-- 🔹 OTP Login Trigger -->
                        <div class="text-center my-3">
                            <span class="text-muted small">or</span>
                        </div>
                        
                        <form method="POST" action="{{ route('request-otp') }}">
                            @csrf
                            <input type="hidden" name="type" value="login">
                            <div class="input-group">
                                <input type="email" 
                                       name="email" 
                                       class="form-control" 
                                       placeholder="Enter email for OTP login"
                                       value="{{ old('email') }}"
                                       required>
                                <button type="submit" class="vs-btn">Get OTP</button>
                            </div>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </form>
                        
                        <div class="auth-footer text-center mt-4">
                            <p class="mb-0">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="text-primary fw-medium">Register Now</a>
                            </p>
                        </div>
                        
                        <!-- Social Login (Optional) -->
                        {{-- <div class="auth-divider my-4">
                            <span>or continue with</span>
                        </div> --}}
                        
                        {{-- <div class="social-login d-flex gap-2 justify-content-center">
                            <a href="{{ route('auth.google') }}" class="social-btn google">
                                <i class="fab fa-google"></i>
                            </a>
                            <a href="#" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-btn apple">
                                <i class="fab fa-apple"></i>
                            </a>
                        </div> --}}
                        
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</section>
@endsection



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 🔹 Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    togglePassword?.addEventListener('click', function() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        this.querySelector('i').className = type === 'password' ? 'far fa-eye' : 'far fa-eye-slash';
    });
    
    // 🔹 Loading State for Traditional Forms (Minimal JS)
    const forms = ['loginForm', 'otpVerifyForm'];
    forms.forEach(formId => {
        const form = document.getElementById(formId);
        const btn = form?.querySelector('button[type="submit"]');
        form?.addEventListener('submit', function() {
            const btnText = btn?.querySelector('.btn-text');
            const btnLoading = btn?.querySelector('.btn-loading');
            if (btnText && btnLoading) {
                btnText.style.display = 'none';
                btnLoading.style.display = 'inline';
                btn.disabled = true;
            }
        });
    });
    
    // 🔹 Auto-focus OTP input
    const otpInput = document.getElementById('otp');
    otpInput?.focus();
});
</script>
@endpush