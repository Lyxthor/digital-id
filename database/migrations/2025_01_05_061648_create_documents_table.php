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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('documentable_id');
            $table->foreign('type_id')
            ->references('id')
            ->on('document_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('owner_id')
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
        Schema::dropIfExists('documents');
    }
};
