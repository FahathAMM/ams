<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Apartments table
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('floors')->nullable();
            $table->boolean('has_parking')->default(false);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Rooms table
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')->constrained('apartments')->onDelete('cascade');
            $table->string('room_number');
            $table->integer('floor');
            $table->enum('type', ['Family', 'Bachelor'])->nullable(); // Enum type for bed type

            $table->boolean('is_occupied')->default(false);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Bedspaces table
        Schema::create('bedspaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('bedspace_number')->nullable();
            $table->enum('bed_type', ['Bunk', 'Single', 'Double', 'Partition', 'Private_Room'])->nullable(); // Enum type for bed type
            $table->decimal('rate', 8, 2)->nullable();
            $table->boolean('is_occupied')->default(0);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bedspaces');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('apartments');
    }
};
