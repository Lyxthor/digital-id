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
        Schema::create('event_document_requirements', function (Blueprint $table) {

            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('type_id');

            $table->foreign('event_id')
            ->references('id')
            ->on('events')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('type_id')
            ->references('id')
            ->on('document_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_document_requirements');
    }
};
