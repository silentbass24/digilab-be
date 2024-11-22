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
        Schema::create('corsi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titolo');
            $table->text('descrizione');
            $table->dateTime('data_inizio');
            $table->dateTime('data_fine');
            $table->float('costo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corsi');
    }
};
