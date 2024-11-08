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
        Schema::create('menu_headers', function (Blueprint $table) {
            $table->id();

            $table->string('name1');
            $table->string('name2');
            $table->integer('is_active')->default(1);
            $table->integer('sequence')->nullable();
            $table->string('icon')->nullable();

            $table->integer('menu_code')->unique()->nullable();
            $table->json('menu')->nullable();
            $table->timestamps();
        });

        Schema::create('menu_details', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_header_id');
            $table->string('name1')->nullable();
            $table->string('name2')->nullable();
            $table->string('sequence')->nullable();
            $table->string('page_url')->nullable();
            $table->string('menu_slug')->nullable();
            $table->integer('is_submenu_available')->default(1);
            $table->integer('is_active')->default(1);
            $table->string('icon')->nullable();

            $table->timestamps();
        });

        Schema::create('menu_sub_details', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_detail_id');
            $table->string('name1')->nullable();
            $table->string('name2')->nullable();
            $table->string('sequence')->nullable();
            $table->string('page_url')->nullable();
            $table->string('menu_slug')->nullable();
            $table->integer('is_active')->default(1);
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_sub_details');
        Schema::dropIfExists('menu_details');
        Schema::dropIfExists('menu_headers');
    }
};
