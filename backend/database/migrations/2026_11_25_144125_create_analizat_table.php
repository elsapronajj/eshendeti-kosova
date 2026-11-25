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
        Schema::create('analizat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vizite_id')->constrained('vizitat')->cascadeOnDelete();
            $table->string('lloji');
            $table->decimal('rezultati',8,2);
            $table->string('njesia');
            $table->decimal('kufiri_i_poshtem',8,2);
            $table->decimal('kufiri_i_siperm',8,2);
            $table->date('data');
            $table->enum('statusi',['normal','jashte_kufijve']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analizat');
    }
};
