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
        Schema::create('mjeket', function (Blueprint $table) {
            $table->id();
            $table->string('numri_i_licences')->unique(); 
            $table->enum('titulli', ['Dr.', 'Dr. Sc.', 'Prof. Dr.']);
            $table->string('emri');
            $table->string('mbiemri'); 
            $table->string('specializimi');
            $table->enum('statusi_i_licences', ['aktive', 'pezulluar', 'skaduar'])->default('aktive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mjeket');
    }
};
