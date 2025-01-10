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
        Schema::create('dukcapils', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['m', 'f']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->text('current_address');
            $table->string('pp_img_path');
            $table->boolean('active_status');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dukcapils');
    }
};
