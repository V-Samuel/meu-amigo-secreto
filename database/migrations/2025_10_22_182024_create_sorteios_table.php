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
    Schema::create('sorteios', function (Blueprint $table) {
        $table->id(); // Id_Sorteio
        
        // Chave estrangeira para o USUARIO (Organizador)
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        
        $table->string('name')->comment('Nome_Sorteio'); // RF-004
        $table->string('status')->default('pending')->comment('pending, drawn, finished');
        $table->boolean('mural_enabled')->default(true)->comment('Mural_Habilitado - RF-020'); // [cite: 29]
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sorteios');
    }
};
