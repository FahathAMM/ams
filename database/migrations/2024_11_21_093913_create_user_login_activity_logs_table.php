<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('user_login_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key
            $table->string('action'); // login, logout, or failed
            $table->string('session_id')->nullable(); // Session ID
            $table->string('ip_address')->nullable(); // IP address
            $table->string('location')->nullable(); // Geolocation
            $table->string('device')->nullable(); // Device type
            $table->string('os')->nullable(); // Operating system
            $table->string('browser')->nullable(); // Browser
            $table->timestamp('login_time')->nullable(); // Login time
            $table->timestamp('logout_time')->nullable(); // Logout time
            $table->string('status')->default('success'); // Status (e.g., success, failed)
            $table->string('reason')->nullable(); // Reason for failed login attempts
            $table->timestamp('attempted_at')->nullable(); // Failed attempt timestamp
            $table->text('user_agent')->nullable(); // Browser or device details
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_login_activity_logs');
    }
};
