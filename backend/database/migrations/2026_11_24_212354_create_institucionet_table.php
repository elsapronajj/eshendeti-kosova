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
        Schema::create('institucionet', function (Blueprint $table) {
            $table->id();
            $table->string('kodi')->unique();
            $table->string('emri');
            $table->string('qyteti');
            $table->string('telefoni');
            $table->enum('lloji', ['spital', 'qkmf']);
            $table->integer('numri_shtreterve')->nullable();
            $table->string('komuna')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institucionet');
    }
};
