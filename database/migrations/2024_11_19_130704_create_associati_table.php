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
        Schema::create('associati', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nome');
            $table->string('cognome');
            $table->string('codice_fiscale')->unique();
            $table->string('nome_genitore');
            $table->string('cognome_genitore');
            $table->string('telefono');
            $table->string('email')->unique();
            $table->string('indirizzo');
            $table->string('citta');
            $table->string('provincia');
            $table->string('cap');
            $table->date('data_nascita');
            $table->boolean('iscritto')->default(0);
            $table->date('data_iscrizione')->nullable();
            $table->date('data_scadenza')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associati');
    }
};
