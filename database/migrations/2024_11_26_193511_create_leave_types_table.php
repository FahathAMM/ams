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

        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('leave_balances');

        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number_of_days');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // User (employee)
            $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('cascade');
            $table->foreignId('applied_employee_id')->constrained('employees')->onDelete('cascade'); // User (employee)
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('request_days')->default(0);
            $table->text('body')->nullable();
            $table->timestamps();
        });

        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // User (employee)
            $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('cascade');
            $table->integer('remaining_days');
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('leave_type_id')->references('id')->on('leave_types');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('leave_requests');
        Schema::dropIfExists('leave_balances');
    }
};
