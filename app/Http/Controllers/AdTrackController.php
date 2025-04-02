<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdsTrack;  // Assuming you have a model for storing the ad track IDs

class AdTrackController extends Controller
{
    public function store(Request $request)
    {
        $adTrackId = $request->input('ad_track_id');
        
        // Check if the ad_track_id already exists in the database
        $existingAdTrack = AdsTrack::where('ad_track_id', $adTrackId)->first();

        if (!$existingAdTrack) {
            // If the ad_track_id doesn't exist, create a new record
            AdsTrack::create([
                'ad_track_id' => $adTrackId,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'clicks' => 1, // Initialize clicks to 1
            ]);

            return;
        }
    }
}
