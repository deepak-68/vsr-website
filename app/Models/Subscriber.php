<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    // ✅ This is REQUIRED for mass assignment
    protected $fillable = ['email'];
    
    // Optional: if you want to use timestamps
    public $timestamps = true;
}