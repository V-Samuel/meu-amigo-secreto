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
        Schema::table('sorteios', function (Blueprint $table) {
            // Adiciona a nova coluna (default: false)
            $table->boolean('organizer_participates')->default(false)->after('mural_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sorteios', function (Blueprint $table) {
            $table->dropColumn('organizer_participates');
        });
    }
};