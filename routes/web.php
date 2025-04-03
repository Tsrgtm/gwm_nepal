<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdsForm;
use App\Http\Controllers\AdTrackController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ExcelExport;
use App\Http\Middleware\TrackAdClicks;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::post('/', [AdsForm::class, 'submit'])->name('ads.submit');

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::get('/admin', function () {
    return view('admin');
})->middleware('auth')->name('admin');

Route::get('/admin/export', [ExcelExport::class, 'exportToExcel'])->middleware('auth')->name('ads.export');

Route::post('/', [AdsForm::class, 'submit'])->name('ads.submit');
Route::post('/store-ad-track-id', [AdTrackController::class, 'store']);
