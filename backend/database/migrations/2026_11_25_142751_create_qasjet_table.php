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
        Schema::create('qasjet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosje_id')->constrained('dosjet')->cascadeOnDelete();
            $table->foreignId('mjek_id')->constrained('mjeket')->cascadeOnDelete();
            $table->dateTime('data_ora');
            $table->string('arsyeja');
            $table->boolean('eshte_emergjente')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qasjet');
    }
};
