<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsForm extends Model
{
    use HasFactory;

    protected $table = 'ads_forms'; // Ensure the table name is correct

    protected $fillable = [
        'name', 'email', 'phone', 'prefered_model',
        'location', 'interested_in', 'message',
        'status', 'ip_address', 'user_agent'
    ];
}

