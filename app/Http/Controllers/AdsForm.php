<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use App\Models\AdsForm as AdsFormModel;
use App\Models\AdsTrack;
use Illuminate\Support\Facades\Session;
use Log;

class AdsForm extends Controller
{
    public function submit(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'prefered_model' => 'required',
            'location' => 'required',
            'interested_in' => 'required',
            'message' => 'string|nullable|max:1000',
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Please fill in all required fields.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new AdsForm instance$
        $adsForm = new AdsFormModel([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'prefered_model'=> $request->prefered_model,
            'location'=> $request->location,
            'interested_in'=> $request->interested_in,
            'message'=> $request->message,   
            'status'=> 'pending', // Default status
            'ip_address'=> $request->ip(), // Store the user's IP address
            'user_agent'=> $request->header('User-Agent'), // Store the user's user agent         
        ]);

        // Save the form data to the database
        $adsForm->save();

        $adTrackId = $request->ad_track_id;

        $existingAdTrack = AdsTrack::where('ad_track_id', $adTrackId)->firstOrFail();

        if ($existingAdTrack) {
            Log::info('Ad track ID found: ' . $adTrackId);
            $existingAdTrack->update(['form_filled' => true]);
        }


        // Flash success message
        session()->flash('success', 'Your form has been submitted successfully.');

        return redirect()->back();

    }
}

