<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('branch_name', 255); // Branch name
            $table->string('branch_code', 10)->unique(); // Unique branch code
            $table->text('location_address'); // Full address of the branch
            $table->string('city', 100); // City of the branch
            $table->string('state', 100)->nullable(); // State or province
            $table->string('country', 100); // Country
            $table->string('postal_code', 20)->nullable(); // Postal or ZIP code
            $table->string('phone_number', 20)->nullable(); // Contact phone number
            $table->string('email', 255)->nullable(); // Official email address
            $table->date('opening_date')->nullable(); // Date the branch was opened
            $table->boolean('is_active')->default(1); // Status of the branch
            $table->timestamps(); // created_at and updated_at
            $table->text('notes')->nullable(); // Additional notes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
