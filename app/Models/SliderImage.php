<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderImage extends Model
{
    protected $table = 'slider_images'; // Table name confirm karein
    
    protected $fillable = ['image', 'status'];
}