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
        Schema::create('vizitat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosje_id')->constrained('dosjet')->cascadeOnDelete();
            $table->foreignId('mjek_id')->constrained('mjeket');
            $table->foreignId('institucion_id')->constrained('institucionet');
            $table->date('data');
            $table->enum('lloji', ['urgjence', 'kontroll', 'shtrim']);
            $table->string('arsyeja');
            $table->text('pershkrimi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vizitat');
    }
};
