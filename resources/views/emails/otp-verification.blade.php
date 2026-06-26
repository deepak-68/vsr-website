<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="text-align: center;">{{ config('app.name') }}</h2>
    
    <p>Hello,</p>
    
    <p>Your verification code is:</p>
    
    <div style="background: #f8f9fa; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px; font-size: 32px; font-weight: bold; letter-spacing: 8px;">
        {{ $otp }}
    </div>
    
    <p><strong>This code expires in 10 minutes.</strong></p>
    
    <p>If you didn't request this, please ignore this email.</p>
    
    <hr>
    <p style="font-size: 12px; color: #666; text-align: center;">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </p>
</body>
</html>