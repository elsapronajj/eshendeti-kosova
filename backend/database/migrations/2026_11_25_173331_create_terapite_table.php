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
        Schema::create('terapite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vizite_id')->constrained('vizitat')->cascadeOnDelete();
            $table->string('medikamenti');
            $table->string('dozimi');
            $table->date('data_e_fillimit');
            $table->date('data_e_perfundimit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terapite');
    }
};
