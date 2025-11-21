<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Verifique se este 'use' está aqui
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Participante extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'name', 
        'email', 
        'sorteio_id', 
        'drawn_participant_id'
    ];


    // ----- Relacionamentos que já fizemos -----

    public function sorteio(): BelongsTo
    {
        return $this->belongsTo(Sorteio::class);
    }

    public function desejos(): HasMany
    {
        return $this->hasMany(Desejo::class);
    }

    public function drawnParticipant(): BelongsTo
    {
        return $this->belongsTo(Participante::class, 'drawn_participant_id');
    }

    public function drawnBy(): HasOne
    {
        return $this->hasOne(Participante::class, 'drawn_participant_id');
    }

    // ==========================================================
    // ESTAS SÃO AS NOVAS FUNÇÕES QUE FALTAVAM (RF-019)
    // ==========================================================

    /**
     * Mensagens que este participante enviou.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(MensagemMural::class, 'sender_participant_id');
    }

    /**
     * Mensagens que este participante recebeu.
     * (Esta é a que causou o erro na linha 40)
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(MensagemMural::class, 'receiver_participant_id');
    }


    // ----- Funções do Model -----

    /**
     * Gerar o Token único (RF-012) automaticamente ao criar.
     */
    protected static function booted()
    {
        static::creating(function ($participante) {
            $participante->token = $participante->token ?? (string) Str::uuid();
        });
    }
}