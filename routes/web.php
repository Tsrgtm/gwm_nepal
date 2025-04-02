<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdsForm;
use App\Http\Controllers\AdTrackController;

Route::get('/', function () {
    return view('index');
});

Route::post('/', [AdsForm::class, 'submit'])->name('ads.submit');
Route::post('/store-ad-track-id', [AdTrackController::class, 'store']);
