<?php

namespace App\Traits;

use Illuminate\Support\Facades\Mail;
use App\Models\OtpVerification;

trait GeneratesOtp
{
    /**
     * Generate numeric OTP
     */
    public function generateOtp($length = 6)
    {
        return str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }

    /**
     * Send OTP via Email
     */
    public function sendOtpEmail($email, $otp, $type = 'login')
    {
        Mail::raw("Your OTP for {$type} verification is: <strong>{$otp}</strong><br>Valid for 10 minutes.", function ($message) use ($email, $type) {
            $message->to($email)
                    ->subject("OTP Verification - " . ucfirst($type));
        });
    }

    /**
     * Send OTP via SMS (Twilio Example)
     */
    public function sendOtpSms($phone, $otp, $type = 'login')
    {
        // Twilio install: composer require twilio/sdk
        /*
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');
        
        $twilio = new \Twilio\Rest\Client($sid, $token);
        $twilio->messages->create($phone, [
            'from' => $from,
            'body' => "Your OTP for {$type}: {$otp}. Valid for 10 min."
        ]);
        */
        
        // TODO: Apne SMS provider ke hisaab se implement karein
        \Log::info("SMS OTP for {$phone}: {$otp}"); // Testing ke liye
    }

    /**
     * Create new OTP record
     */
    public function createOtpRecord($email, $phone = null, $type = 'login')
    {
        // Purane unverified OTPs delete karein
        OtpVerification::where('email', $email)
            ->where('verified_at', null)
            ->delete();

        $otp = $this->generateOtp();

        return OtpVerification::create([
            'email' => $email,
            'phone' => $phone,
            'otp' => $otp,
            'type' => $type,
            'expires_at' => now()->addMinutes(10)
        ]);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp($email, $otp)
    {
        $otpRecord = OtpVerification::where('email', $email)
            ->where('otp', $otp)
            ->whereNull('verified_at')
            ->first();

        if (!$otpRecord || $otpRecord->isExpired()) {
            return false;
        }

        $otpRecord->markAsVerified();
        return true;
    }
}