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
        Schema::create('token_authorized_events', function (Blueprint $table) {
            $table->unsignedBigInteger('token_id');
            $table->unsignedBigInteger('event_id');

            $table->foreign('token_id')
            ->references('id')
            ->on('document_folder_tokens')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('event_id')
            ->references('id')
            ->on('events')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_authorized_events');
    }
};
