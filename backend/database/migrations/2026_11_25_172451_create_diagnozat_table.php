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
        Schema::create('diagnozat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vizite_id')->constrained('vizitat')->cascadeOnDelete();
            $table->string('kodi');
            $table->string('pershkrimi');
            $table->date('data');
            $table->enum('statusi', ['aktive', 'jo_aktive'])->default('aktive'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnozat');
    }
};
