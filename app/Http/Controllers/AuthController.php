<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\OtpVerification;
use App\Traits\GeneratesOtp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password; 
use Illuminate\Support\Facades\Mail; 
class AuthController extends Controller
{
    use GeneratesOtp;

    // ===============================
    // 🔐 TRADITIONAL LOGIN
    // ===============================
    
    public function showLoginForm()
    {
        if (auth()->check()) return redirect()->route('home');
        
        // Clear OTP session if any
        session()->forget(['otp_step', 'otp_email', 'otp_type']);
        
        return view('frontend.pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Please enter your password',
            'password.min' => 'Password must be at least 6 characters'
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Restore cart if preserved
            if (Session::has('cart_before_auth')) {
                $existing = Session::get('cart', []);
                $preserved = Session::get('cart_before_auth', []);
                Session::put('cart', array_merge($existing, $preserved));
                Session::forget('cart_before_auth');
            }
            
            return redirect()->intended(route('home'))->with('success', 'Welcome back!');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])
                    ->withInput($request->only('email'));
    }

    // ===============================
    // 🔑 OTP FLOW (Controller-Driven)
    // ===============================

    /**
     * Step 1: Request OTP → Store in session → Redirect to verify step
     */
public function requestOtp(Request $request)
{
    Log::info('=== OTP Request Started ===');
    
    $request->validate([
        'email' => 'required|email',
        'type' => 'in:login,register,checkout'
    ]);

    // Delete old OTPs
    OtpVerification::where('email', $request->email)
        ->where('type', $request->type ?? 'login')
        ->whereNull('verified_at')
        ->delete();

    // Generate OTP
    $otp = $this->generateOtp();
    OtpVerification::create([
        'email' => $request->email,
        'otp' => $otp,
        'type' => $request->type ?? 'login',
        'expires_at' => now()->addMinutes(10)
    ]);

    // Send email
    $this->sendOtpEmail($request->email, $otp, $request->type ?? 'login');

    // 🔹 FIX: Query string mein pass karein (session ki jagah)
    return redirect()
        ->route('login', [
            'verify_otp' => 1,
            'otp_email' => $request->email
        ])
        ->with('success', 'OTP sent to ' . $request->email);
}
    /**
     * Step 2: Verify OTP → Login/Register → Redirect
     */
    public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|digits:6',
    ]);

    $otpRecord = OtpVerification::where('email', $request->email)
        ->where('otp', $request->otp)
        ->where('type', $request->type ?? 'login')
        ->whereNull('verified_at')
        ->first();

    if (!$otpRecord || $otpRecord->isExpired()) {
        return back()->with('error', 'Invalid or expired OTP. Please try again.');
    }

    $otpRecord->markAsVerified();

    // Login
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return back()->with('error', 'No account found with this email.');
    }

    Auth::login($user);
    
    return redirect()->intended(route('home'))->with('success', 'Logged in successfully!');
}

    /**
     * Resend OTP (Same logic as requestOtp)
     */
    public function resendOtp(Request $request)
    {
        $email = $request->input('email') ?? Session::get('otp_email');
        $type = $request->input('type') ?? Session::get('otp_type') ?? 'login';

        if (!$email) {
            return back()->with('error', 'Email not found. Please start over.');
        }

        // Cooldown: 30 seconds
        $lastOtp = OtpVerification::where('email', $email)
            ->where('type', $type)
            ->latest()
            ->first();
            
        if ($lastOtp && $lastOtp->created_at->addSeconds(30)->isFuture()) {
            return back()->with('error', 'Please wait 30 seconds before requesting a new OTP.');
        }

        return $this->requestOtp(new Request([
            'email' => $email,
            'type' => $type
        ]));
    }

    // ===============================
    // 👤 REGISTER (With OTP Support)
    // ===============================
    
    public function showRegisterForm()
    {
        if (auth()->check()) return redirect()->route('home');
        return view('frontend.pages.auth.register');
    }

    public function register(Request $request)
    {
        // Agar OTP se aaya hai toh email session se lo
        $email = Session::get('otp_verified_email') ?? $request->email;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => $request->has('otp_verified_email') ? 'nullable' : 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'terms' => 'accepted'
        ], [
            'name.required' => 'Please enter your full name',
            'email.required' => 'Please enter your email address',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Please create a password',
            'password.min' => 'Password must be at least 6 characters',
            'password.confirmed' => 'Passwords do not match',
            'terms.accepted' => 'You must agree to the Terms & Conditions'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'email_verified_at' => now()
        ]);

        Session::forget('otp_verified_email');
        Auth::login($user);
        
        // Restore cart
        if (Session::has('cart_before_auth')) {
            $existing = Session::get('cart', []);
            $preserved = Session::get('cart_before_auth', []);
            Session::put('cart', array_merge($existing, $preserved));
            Session::forget('cart_before_auth');
        }

        return redirect()->route('home')->with('success', 'Account created successfully! Welcome aboard.');
    }

    // ===============================
    // 🚪 LOGOUT
    // ===============================
    
    public function logout(Request $request)
{
    // 🔹 Step 1: Cart & Wishlist ko backup karein (before session invalidate)
    $cartBackup = session('cart', []);
    $wishlistBackup = session('wishlist', []);
    
    // 🔹 Step 2: User ko logout karein + session invalidate karein
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    // 🔹 Step 3: Cart & Wishlist wapas restore karein (new session mein)
    session([
        'cart' => $cartBackup,
        'wishlist' => $wishlistBackup
    ]);
    
    return redirect()->route('home')->with('success', 'Logged out successfully.');
}

    // ===============================
    // 🔑 PASSWORD RESET (Existing)
    // ===============================
    
    public function showForgotForm()
    {
        return view('frontend.pages.auth.forgot-password');
    }

   public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email|exists:users,email'], [
        'email.exists' => 'No account found with this email address.'
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
        return back()->with('status', 'Password reset link sent to your email! Please check inbox/spam.');
    }

    return back()->withErrors(['email' => __($status)]);
}
public function showResetForm(Request $request, $token)
{
    return view('frontend.pages.auth.reset-password', [
        'token' => $token,
        'email' => $request->email
    ]);
}

    public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:6|confirmed',
    ], [
        'password.confirmed' => 'Passwords do not match.'
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
            
            // Optional: Delete old tokens
            // $user->tokens()->delete();
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return redirect()->route('login')->with('success', 'Password reset successfully! Please login with new password.');
    }

    return back()->withErrors(['email' => [__($status)]]);
}
}