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
        Schema::create('iscrizione_corsi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('associato_id');
            $table->foreign('associato_id')->references('id')->on('associati')->onDelete('cascade');
            $table->uuid('corso_id');
            $table->foreign('corso_id')->references('id')->on('corsi')->onDelete('cascade');
            $table->date('data_iscrizione');
            $table->boolean('pagato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iscrizione_corsi');
    }
};
