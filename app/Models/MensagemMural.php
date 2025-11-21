<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensagemMural extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array
     */
    // ==========================================================
    // ADICIONE ESTA LINHA
    // ==========================================================
    protected $fillable = ['sorteio_id', 'sender_participant_id', 'receiver_participant_id', 'message'];


    // ----- Relacionamentos que já fizemos -----

    public function sorteio(): BelongsTo
    {
        return $this->belongsTo(Sorteio::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Participante::class, 'sender_participant_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Participante::class, 'receiver_participant_id');
    }
}