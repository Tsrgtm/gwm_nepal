<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AdsForm as AdsFormModel;
use App\Models\AdsTrack;
use Illuminate\Support\Facades\DB; // For database transactions
use Illuminate\Support\Facades\Log; // for logging errors

class AdsForm extends Controller
{
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:10|min:10',
            'location' => 'required',
            'interested_in' => 'required',
            'message' => 'string|nullable|max:1000',
            'ad_track_id' => 'nullable|string', //validate that the track id is a string, and allow it to be null.
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Please fill in all required fields.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                // Create a new AdsForm instance
                $adsForm = new AdsFormModel([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'location' => $request->location,
                    'interested_in' => $request->interested_in,
                    'message' => $request->message,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                ]);

                // Save the form data to the database
                $adsForm->save();

                if ($request->filled('ad_track_id')) {
                    $adTrack = AdsTrack::where('ad_track_id', $request->ad_track_id)->first();

                    if ($adTrack) {
                        $adTrack->update(['form_filled' => true]);
                    }
                }
            });

            session()->flash('success', 'Your form has been submitted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while submitting your form. Please try again.');
        }

        return redirect()->back();
    }
}
?>