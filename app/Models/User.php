<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // <--- CORREÇÃO 1: Mova esta linha para cá

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    // use Illuminate\Database\Eloquent\Relations\HasMany; // <--- REMOVA DESTA LINHA

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // <--- CORREÇÃO 2: A função deve ficar AQUI, dentro da classe
    /**
     * Pega todos os sorteios do Usuário (Organizador)
     */
    public function sorteios(): HasMany
    {
        // Um Organizador (User) tem muitos Sorteios
        // É uma boa prática adicionar Sorteio::class aos 'use' no topo também.
        return $this->hasMany(Sorteio::class);
    }
}

// A função estava aqui fora, o que causa o erro.