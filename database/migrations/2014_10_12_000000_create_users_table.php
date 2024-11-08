<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('designation')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('contact')->nullable();
            $table->string('branch')->nullable();
            $table->string('img')->nullable();
            $table->date('joining_date')->nullable();
            // $table->integer('employee_id')->default(0);
            $table->integer('is_active')->default(0);
            $table->text('description')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('role_id')->default(1); // Foreign key column
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // User (employee)

            // Foreign key constraint
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
