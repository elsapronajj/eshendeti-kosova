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
        Schema::create('autorizimet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pacient_id')->constrained('pacientet')->cascadeOnDelete();
            $table->foreignId('institucion_id')->constrained('institucionet')->cascadeOnDelete();
            $table->enum('lloji', ['i_perhershem', 'i_perkohshem']);
            $table->date('data_e_fillimit');
            $table->date('data_e_skadimit')->nullable();
            $table->enum('statusi', ['aktiv', 'revokuar', 'skaduar'])->default('aktiv');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autorizimet');
    }
};
