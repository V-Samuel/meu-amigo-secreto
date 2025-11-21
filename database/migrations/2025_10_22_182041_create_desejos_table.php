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
    Schema::create('desejos', function (Blueprint $table) {
        $table->id(); // Id_Desejo
        
        // Chave estrangeira para o PARTICIPANTE
        $table->foreignId('participante_id')->constrained('participantes')->onDelete('cascade');
        
        $table->text('description')->comment('Descrição'); // RF-010 [cite: 15]
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desejos');
    }
};
