<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AdsTrack;

class TrackAdClicks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request is for an ad click
        $adTrackId = $request->cookie('ad_track_id');

        if ($adTrackId) {
            $adTrack = AdsTrack::where('ad_track_id', $adTrackId)->first();

            if ($adTrack) {
                // Update the ad track record
                $adTrack->update([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'clicks' => $adTrack->clicks + 1, // Uncomment if you want to track clicks
                ]);
            } else {
                // Create a new ad track record
                AdsTrack::create([
                    'ad_track_id' => $adTrackId,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'clicks' => 1,
                ]);
            }
        }
        return $next($request);
    }
}
