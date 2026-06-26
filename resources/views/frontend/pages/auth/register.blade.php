@extends('frontend.layout.master')

@section('content')
<!--==============================
    Breadcumb
============================== -->
<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
    <div class="container z-index-common">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title">Register</h1>
        </div>
        <div class="breadcumb-menu-wrap">
            <ul class="breadcumb-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Register</li>
            </ul>
        </div>
    </div>
</div>

<!--==============================
    Register Area
============================== -->
<section class="space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div class="auth-wrapper">
                    <div class="auth-header text-center mb-4">
                        <h2>Create Account</h2>
                        <p class="text-muted">Join us and start shopping today</p>
                    </div>
                    
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autofocus
                                           placeholder="Enter your name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone">Phone Number <span class="text-muted">(Optional)</span></label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}" 
                                           placeholder="Enter your phone">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   placeholder="Enter your email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               required 
                                               placeholder="Create password">
                                        <button type="button" class="input-group-text bg-white border-start-0" id="togglePassword">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Minimum 6 characters</small>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required 
                                           placeholder="Confirm password">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <div class="custom-checkbox">
                                <input type="checkbox" id="terms" name="terms" required>
                                <label for="terms" class="mb-0">
                                    I agree to the <a href="#" target="_blank" class="text-primary">Terms & Conditions</a> 
                                    and <a href="#" target="_blank" class="text-primary">Privacy Policy</a> 
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            @error('terms')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="vs-btn w-100 mb-3" id="registerBtn">
                            <span class="btn-text">Create Account</span>
                            <span class="btn-loading" style="display:none;">
                                <i class="fas fa-spinner fa-spin me-2"></i>Creating...
                            </span>
                        </button>
                        
                    </form>
                    
                    <div class="auth-footer text-center">
                        <p class="mb-0">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-primary fw-medium">Login Here</a>
                        </p>
                    </div>
                    
                    <!-- Optional: Social Register -->
                    <div class="auth-divider my-4">
                        <span>or register with</span>
                    </div>
                    
                    <div class="social-login d-flex gap-2 justify-content-center">
                        <a href="{{ route('auth.google') }}" class="social-btn google">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-btn apple">
                            <i class="fab fa-apple"></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .auth-wrapper {
        background: #fff;
        border-radius: 12px;
        padding: 40px 30px;
        box-shadow: 0 5px 30px rgba(0,0,0,0.08);
    }
    .auth-header h2 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .form-control {
        border: 1px solid #e0e0e0;
        padding: 12px 16px;
        border-radius: 8px;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }
    .input-group-text {
        cursor: pointer;
        border-radius: 0 8px 8px 0;
    }
    .custom-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-right: 6px;
        cursor: pointer;
    }
    .auth-divider {
        position: relative;
        text-align: center;
        color: #999;
        font-size: 13px;
    }
    .auth-divider::before,
    .auth-divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 40%;
        height: 1px;
        background: #e0e0e0;
    }
    .auth-divider::before { left: 0; }
    .auth-divider::after { right: 0; }
    .social-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e0e0e0;
        color: #666;
        transition: all 0.2s;
        text-decoration: none;
    }
    .social-btn:hover {
        border-color: #3498db;
        color: #3498db;
        transform: translateY(-2px);
    }
    .social-btn.google:hover { color: #db4437; border-color: #db4437; }
    .social-btn.facebook:hover { color: #4267B2; border-color: #4267B2; }
    .social-btn.apple:hover { color: #000; border-color: #000; }
</style>
@endpush

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
    
    // 🔹 Form Submission with Loading State
    const registerForm = document.getElementById('registerForm');
    const registerBtn = document.getElementById('registerBtn');
    
    registerForm?.addEventListener('submit', function(e) {
        const btnText = registerBtn.querySelector('.btn-text');
        const btnLoading = registerBtn.querySelector('.btn-loading');
        
        // Show loading state
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
        registerBtn.disabled = true;
        
        // Allow form to submit normally (server-side validation)
    });
    
    // 🔹 Password Strength Indicator (Optional)
    const passwordField = document.getElementById('password');
    passwordField?.addEventListener('input', function() {
        const value = this.value;
        let strength = 0;
        
        if (value.length >= 6) strength++;
        if (value.match(/[a-z]+/)) strength++;
        if (value.match(/[A-Z]+/)) strength++;
        if (value.match(/[0-9]+/)) strength++;
        if (value.match(/[^a-zA-Z0-9]+/)) strength++;
        
        // You can add visual feedback here if needed
    });
    
    // 🔹 Show Validation Errors via SweetAlert
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#3498db'
        });
    @endif
    
});
</script>
@endpush