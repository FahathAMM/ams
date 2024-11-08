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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // User (employee)
            $table->foreignId('report_manager_id')->constrained('employees')->onDelete('cascade'); // Supervisor
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // customer
            $table->date('eod_date')->nullable();
            $table->string('subject')->nullable();
            $table->string('task_code')->nullable();
            $table->text('task_description')->nullable();
            $table->string('duration')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
