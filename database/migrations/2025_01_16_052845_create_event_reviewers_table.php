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
        Schema::create('event_reviewers', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('reviewer_id');

            $table->foreign('event_id')
            ->references('id')
            ->on('events')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('reviewer_id')
            ->references('id')
            ->on('citizens')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_reviewers');
    }
};
