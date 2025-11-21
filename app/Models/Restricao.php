<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restricao extends Model
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
    protected $fillable = ['sorteio_id', 'participant_a_id', 'participant_b_id'];


    // ----- Relacionamentos que já fizemos -----

    public function sorteio(): BelongsTo
    {
        return $this->belongsTo(Sorteio::class);
    }
    
    public function participantA(): BelongsTo
    {
        return $this->belongsTo(Participante::class, 'participant_a_id');
    }

    public function participantB(): BelongsTo
    {
        return $this->belongsTo(Participante::class, 'participant_b_id');
    }
}