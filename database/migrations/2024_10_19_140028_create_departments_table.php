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
        Schema::create('departments', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('department_name', 255); // Department name
            $table->string('department_code', 10)->unique(); // Unique department code
            $table->text('description')->nullable(); // Description of the department
            $table->unsignedBigInteger('branch_id'); // Foreign key referencing branches table
            $table->string('email', 255)->nullable(); // Department email
            $table->string('phone_number', 20)->nullable(); // Contact phone number
            $table->date('established_date')->nullable(); // Date when the department was established
            $table->boolean('is_active')->default(1); // Status of the department
            $table->timestamps(); // created_at and updated_at
            $table->text('notes')->nullable(); // Additional notes

            // Foreign key constraint
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
