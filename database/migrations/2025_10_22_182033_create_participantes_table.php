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
    Schema::create('participantes', function (Blueprint $table) {
        $table->id(); // Id_Participantes
        
        // Chave estrangeira para o SORTEIO
        $table->foreignId('sorteio_id')->constrained('sorteios')->onDelete('cascade');
        
        $table->string('name')->comment('Nome'); // RF-006 [cite: 10]
        $table->string('email')->nullable();
        $table->string('token')->unique()->nullable()->comment('Link único para RF-012/RF-014'); // [cite: 18, 21]
        
        // 'amigo_secreto_id' do DER (quem eu tirei)
        $table->unsignedBigInteger('drawn_participant_id')->nullable();
        
        $table->timestamps();

        // Definição da chave estrangeira para ela mesma
        $table->foreign('drawn_participant_id')
              ->references('id')
              ->on('participantes')
              ->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
