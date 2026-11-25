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
        Schema::create('mjek_institucion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mjek_id')->constrained('mjeket')->cascadeOnDelete();
            $table->foreignId('institucion_id')->constrained('institucionet')->cascadeOnDelete();
            $table->unique(['mjek_id', 'institucion_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mjek_institucion');
    }
};