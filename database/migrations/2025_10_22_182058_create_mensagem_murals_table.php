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
    Schema::create('mensagem_murals', function (Blueprint $table) {
        $table->id(); // Id_Mural
        
        $table->foreignId('sorteio_id')->constrained('sorteios')->onDelete('cascade');
        
        // 'remetente_id' (anônimo na view, mas logado no sistema)
        $table->foreignId('sender_participant_id')->constrained('participantes')->onDelete('cascade');
        
        // 'destinatario_id' (se for NULO, é uma msg geral RF-017) [cite: 26]
        $table->foreignId('receiver_participant_id')->nullable()->constrained('participantes')->onDelete('cascade');
        
        $table->text('message')->comment('Mensagem');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensagem_murals');
    }
};
