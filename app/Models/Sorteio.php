<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sorteio extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     *
     * @var array
     */
    // ==========================================================
    // ESTA É A LINHA MODIFICADA
    // ==========================================================
    protected $fillable = [
        'name',
        'status',
        'mural_enabled',
        'organizer_participates' // <-- ADICIONE ESTA LINHA
    ];


    // ----- Relacionamentos que já fizemos -----

    // Um Sorteio pertence a um Organizador (User)
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Um Sorteio tem muitos Participantes
    public function participantes(): HasMany
    {
        return $this->hasMany(Participante::class);
    }

    // Um Sorteio tem muitas Restrições
    public function restricoes(): HasMany
    {
        return $this->hasMany(Restricao::class);
    }

    // Um Sorteio tem muitas Mensagens no Mural
    public function mensagens(): HasMany
    {
        return $this->hasMany(MensagemMural::class);
    }
}