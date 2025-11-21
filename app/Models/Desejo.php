<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Desejo extends Model
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
    protected $fillable = ['participante_id', 'description'];


    // ----- Relacionamento que já fizemos -----

    // Um Desejo pertence a um Participante
    public function participante(): BelongsTo
    {
        return $this->belongsTo(Participante::class);
    }
}
