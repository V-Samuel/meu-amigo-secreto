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
    Schema::create('restricaos', function (Blueprint $table) {
        $table->id(); // Id_Restrição
        
        $table->foreignId('sorteio_id')->constrained('sorteios')->onDelete('cascade');
        
        // 'participante_a_id' não pode tirar 'participante_b_id'
        $table->foreignId('participant_a_id')->constrained('participantes')->onDelete('cascade');
        $table->foreignId('participant_b_id')->constrained('participantes')->onDelete('cascade');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restricaos');
    }
};
