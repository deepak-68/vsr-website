@extends('frontend.layout.master')

@section('content')
<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
    <div class="container">
        <h1 class="breadcumb-title">Forgot Password</h1>
    </div>
</div>

<section class="space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                
                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <div class="auth-wrapper">
                    <div class="auth-header text-center mb-4">
                        <h2>Reset Password</h2>
                        <p class="text-muted">Enter your email to receive reset link</p>
                    </div>
                    
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label for="email">Email Address</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="Enter your registered email">
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <button type="submit" class="vs-btn w-100">Send Reset Link</button>
                        
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-muted">← Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection