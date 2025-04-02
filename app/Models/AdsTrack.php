<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsTrack extends Model
{
    use HasFactory;

    protected $table = 'ads_tracks'; // Define the table name

    protected $fillable = [
        'ip_address',
        'user_agent',
        'clicks',
        'form_filled',
        'ad_track_id',
    ];

    /**
     * Check if the user has filled the form.
     */
    public function hasFilledForm(): bool
    {
        return $this->form_filled;
    }
}

