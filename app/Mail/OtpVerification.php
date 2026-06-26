<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $purpose;

    public function __construct($otp, $purpose = 'checkout')
    {
        $this->otp = $otp;
        $this->purpose = $purpose;
    }

    public function build()
    {
        return $this->subject('Verify Your Email - ' . config('app.name'))
                    ->view('emails.otp-verification')
                    ->with(['otp' => $this->otp, 'purpose' => $this->purpose]);
    }
}