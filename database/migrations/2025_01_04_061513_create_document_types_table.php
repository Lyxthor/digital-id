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
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('category', ['official', 'custom']);
            $table->enum('ownership_count', ['mono', 'multi']); // berapa banyak dokumen dengan type yang sama dapat dimiliki
            $table->enum('membership_count', ['mono', 'multi']);
            $table->enum('member_ownership', ['main', 'all']); // siapa saja pemilik dari dokumen ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};
