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
        Schema::create('alergjite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosje_id')->constrained('dosjet')->cascadeOnDelete();
            $table->string('substanca');
            $table->enum('ashpersia', ['e_lehte', 'mesatare', 'e_rende']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alergjite');
    }
};
