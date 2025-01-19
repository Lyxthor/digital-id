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
        Schema::create('claim_citizen_requests', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->string('username');
            $table->string('email');
            $table->string('mobile');
            $table->string('password');
            $table->string('request_password');
            $table->enum('status', ['waiting', 'accepted', 'denied']);
            $table->unsignedBigInteger('citizen_id');
            $table->foreign('citizen_id')
            ->references('id')
            ->on('citizens')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claim_citizen_requests');
    }
};
