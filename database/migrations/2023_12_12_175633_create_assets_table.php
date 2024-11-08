<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('category_id')->nullable();
            $table->string('img')->nullable();
            $table->json('tags')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('condition')->nullable();
            $table->string('warranty_nfo')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('employee_id')->nullable();
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
