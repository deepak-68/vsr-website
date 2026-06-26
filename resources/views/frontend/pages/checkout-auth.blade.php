@extends('frontend.layout.master')

@section('content')
<div class="breadcumb-wrapper" data-bg-src="{{ url('assets/img/breadcrumb/breadcrumb.png') }}">
    <div class="container">
        <h1 class="breadcumb-title">Verify Email</h1>
    </div>
</div>

<section class="space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="auth-card" style="background:#fff; padding:30px; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.08);">
                    
                    @if(session('info'))
                        <div class="alert alert-info">{{ session('info') }}</div>
                    @endif
                    
                    <h3 class="text-center mb-4">Complete Your Order</h3>
                    
                    <!-- Email Form -->
                    <form id="otpEmailForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Email Address *</label>
                            <input type="email" name="email" class="form-control" 
                                   value="{{ $email }}" required placeholder="Enter your email">
                        </div>
                        <button type="submit" class="vs-btn w-100" id="sendOtpBtn">
                            <i class="fas fa-key me-2"></i>Send OTP
                        </button>
                    </form>
                    
                    <!-- OTP Verification (Hidden) -->
                    <div id="otpSection" style="display:none;" class="mt-4">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            OTP sent to <strong id="otpEmailDisplay">{{ $email }}</strong>
                        </div>
                        
                        <form id="verifyOtpForm">
                            @csrf
                            <input type="hidden" name="email" id="otpEmailInput" value="{{ $email }}">
                            
                            <div class="form-group mb-3">
                                <label>Enter 6-Digit OTP *</label>
                                <input type="text" name="otp" class="form-control text-center" 
                                       maxlength="6" pattern="\d{6}" required 
                                       placeholder="••••••" style="letter-spacing:8px; font-size:18px;">
                                <small class="text-muted">Expires in <span id="otpTimer">10:00</span></small>
                            </div>
                            
                            <button type="submit" class="vs-btn w-100">
                                <i class="fas fa-check me-2"></i>Verify & Continue
                            </button>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="#" id="resendOtp" class="text-muted small">
                                <i class="fas fa-redo me-1"></i>Resend OTP
                            </a>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('cart') }}" class="text-muted">
                            <i class="fas fa-arrow-left me-1"></i>Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Send OTP
    document.getElementById('otpEmailForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('sendOtpBtn');
        const email = this.querySelector('[name="email"]').value;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        
        fetch("{{ route('auth.send-otp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('otpSection').style.display = 'block';
                document.getElementById('otpEmailDisplay').textContent = data.email;
                document.getElementById('otpEmailInput').value = data.email;
                startTimer('otpTimer', data.expires_in);
                
                // DEV: Show OTP in console
                if (data.dev_otp) {
                    console.log('DEV OTP:', data.dev_otp);
                    Swal.fire({toast:true, position:'top-end', icon:'info', title:'DEV MODE', text:'OTP: '+data.dev_otp, showConfirmButton:false, timer:5000});
                }
                
                showToast('OTP Sent', 'Check your email for the 6-digit code.', 'success');
            } else {
                showToast('Error', data.message, 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Error', 'Failed to send OTP.', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-key me-2"></i>Send OTP';
        });
    });
    
    // Verify OTP
    document.getElementById('verifyOtpForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        const formData = new FormData(this);
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
        
        fetch("{{ route('auth.verify-otp') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Success', data.message, 'success');
                setTimeout(() => { window.location.href = data.redirect; }, 1500);
            } else {
                showToast('Error', data.message, 'error');
                this.querySelector('[name="otp"]').value = '';
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Error', 'Verification failed.', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check me-2"></i>Verify & Continue';
        });
    });
    
    // Resend OTP
    document.getElementById('resendOtp')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('otpEmailForm').requestSubmit();
    });
    
    // Timer
    function startTimer(elementId, seconds) {
        const el = document.getElementById(elementId);
        let time = seconds;
        const timer = setInterval(() => {
            const m = Math.floor(time/60).toString().padStart(2,'0');
            const s = (time%60).toString().padStart(2,'0');
            el.textContent = `${m}:${s}`;
            if (time-- <= 0) { clearInterval(timer); el.textContent = 'Expired'; }
        }, 1000);
    }
    
    // Toast
    function showToast(title, message, type='success') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({toast:true, position:'top-end', icon:type, title:title, text:message, showConfirmButton:false, timer:3000});
        } else { alert(message); }
    }
});
</script>
@endpush