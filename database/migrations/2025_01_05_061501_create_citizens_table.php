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
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('name');
            $table->enum('gender', ['m', 'f']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->text('current_address');
            $table->string('blood_type')->nullable()->default('-');
            $table->string('job')->nullable()->default('serabutan');
            $table->string('pp_img_path');
            $table->string('no_kk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
