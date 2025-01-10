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
        Schema::create('document_folder_assignments', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('folder_id');

            $table->foreign('document_id')
            ->references('id')
            ->on('documents')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('folder_id')
            ->references('id')
            ->on('document_folders')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_folder_assignments');
    }
};
