<?php

namespace App\Http\Controllers;

use App\Models\Sorteio;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // <-- Adicione
use Illuminate\Support\Facades\Auth; // <-- Adicione
use Illuminate\View\View; // <-- Adicione
use Illuminate\Support\Facades\Redirect; // <-- Adicione

class ModoFestaController extends Controller
{
    /**
     * Mostra a tela de apresentação do "Modo Festa" (RF-022)
     */
    public function show(Sorteio $sorteio): View|RedirectResponse
    {
        // 1. Segurança: Só o dono do sorteio pode ver
        if (Auth::id() !== $sorteio->user_id) {
            abort(403);
        }

        // 2. Regra: O "Modo Festa" só funciona se o sorteio JÁ FOI REALIZADO
        if ($sorteio->status !== 'drawn') {
            return Redirect::route('sorteios.show', $sorteio)
                   ->with('error', 'O Modo Festa só fica disponível após o sorteio ser realizado.');
        }

        // 3. Carrega todos os dados necessários
        //    Pega o amigo sorteado (drawnParticipant) e os desejos (desejos)
        $participantes = $sorteio->participantes()
                                 ->with('drawnParticipant', 'desejos') 
                                 ->get();
        
        // 4. Retorna a nova view de tela cheia
        return view('sorteios.modo-festa', [
            'sorteio' => $sorteio,
            'participantes' => $participantes,
        ]);
    }
}