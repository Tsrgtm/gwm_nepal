<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ads_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('prefered_model')->default('Ora 03 EV');
            $table->string('location');
            $table->string('interested_in');
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // Added status column
            $table->string('ip_address')->nullable(); // Added IP address column    
            $table->string('user_agent')->nullable(); // Added user agent column
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('ads_forms');
    }
};

