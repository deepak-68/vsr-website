@extends('frontend.layout.master')

@section('content')
<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
    <div class="container">
        <h1 class="breadcumb-title">New Password</h1>
    </div>
</div>

<section class="space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                
                <div class="auth-wrapper">
                    <div class="auth-header text-center mb-4">
                        <h2>Create New Password</h2>
                        <p class="text-muted">Enter your new password below</p>
                    </div>
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="form-group mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" 
                                   class="form-control" 
                                   name="email" 
                                   value="{{ $email ?? old('email') }}" 
                                   required readonly>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="password">New Password</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   minlength="6">
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   name="password_confirmation" 
                                   required>
                        </div>
                        
                        <button type="submit" class="vs-btn w-100">Reset Password</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection