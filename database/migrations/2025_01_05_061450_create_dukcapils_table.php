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
            $table->string('nik')->unique();
            $table->string('name');
            $table->enum('gender', ['m', 'f']);
            $table->date('birth_date');
            $table->string('birth_place');
            $table->text('address');
            $table->string('village');
            $table->string('district');
            $table->string('regency');
            $table->string('province');
            $table->string('blood_type')->nullable()->default('-');
            $table->string('religion')->nullable()->default('katholik');
            $table->string('education')->nullable()->default('belum/tidak sekolah');
            $table->string('marriage_status')->nullable()->default('belum kawin');
            $table->string('job')->nullable()->default('belum bekerja');
            $table->string('pp_img_path')->default('no_profile.enc');
            $table->boolean('active_status');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('province_authority');
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
