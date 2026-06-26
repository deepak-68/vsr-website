<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = ['user_id', 'email', 'phone', 'otp', 'type', 'expires_at', 'verified_at'];
    
    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];
    
    public function isExpired()
    {
        return now()->greaterThan($this->expires_at);
    }
    
    public function markAsVerified()
    {
        $this->verified_at = now();
        $this->save();
    }
}