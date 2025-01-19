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
        Schema::create('document_type_requisites', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('requisite_id');

            $table->foreign('type_id')
            ->references('id')
            ->on('document_types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreign('requisite_id')
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
        Schema::dropIfExists('document_type_requisites');
    }
};
