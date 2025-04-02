<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ads_tracks', function (Blueprint $table) {
            $table->id();
            $table->string('ad_track_id')->nullable(); // Unique identifier for the ad track
            $table->string('ip_address')->nullable(); // Track user's IP
            $table->text('user_agent')->nullable(); // Track user agent (browser)
            $table->integer('clicks')->default(0); // Track number of clicks
            $table->boolean('form_filled')->default(false); // Check if the form is submitted
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads_tracks');
    }
};

