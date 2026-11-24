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
        Schema::create('pacientet', function (Blueprint $table) {
            $table->id();
            $table->string('numri_personal')->unique();
            $table->string('emri');
            $table->string('mbiemri');
            $table->date('data_e_lindjes');
            $table->enum('gjinia', ['M', 'F']);
            $table->enum('grupi_gjakut', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->string('telefoni');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientet');
    }
};
