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
        Schema::create('token_authorized_citizens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('token_id');
            $table->unsignedBigInteger('citizen_id');

            $table->foreign('token_id')
            ->references('id')
            ->on('document_folder_tokens')
            ->onDelete('cascade')
            ->onUpdate('cascade');

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
        Schema::dropIfExists('token_authorized_citizens');
    }
};
