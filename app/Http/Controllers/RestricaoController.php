<?php

namespace App\Http\Controllers;

use App\Models\Restricao;
use App\Models\Sorteio;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RestricaoController extends Controller
{
    /**
     * Salva uma nova restrição (RF-009)
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validar os dados
        $request->validate([
            'sorteio_id' => ['required', 'exists:sorteios,id'],
            'participant_a_id' => ['required', 'exists:participantes,id', 'different:participant_b_id'],
            'participant_b_id' => ['required', 'exists:participantes,id'],
        ]);

        // 2. Segurança: Pega o sorteio e verifica se o dono é o usuário logado
        $sorteio = Sorteio::findOrFail($request->sorteio_id);
        if (Auth::id() !== $sorteio->user_id) {
            abort(403);
        }

        // 3. Regra de Negócio: Não pode adicionar restrições se o sorteio não estiver pendente
        if ($sorteio->status !== 'pending') {
             return Redirect::back()->with('error', 'Não é possível adicionar restrições após o sorteio ser realizado.');
        }

        // 4. Cria a restrição
        Restricao::create([
            'sorteio_id' => $request->sorteio_id,
            'participant_a_id' => $request->participant_a_id,
            'participant_b_id' => $request->participant_b_id,
        ]);

        return Redirect::back()->with('status', 'restricao-added');
    }


    /**
     * Remove uma restrição (RF-009)
     */
    public function destroy(Restricao $restricao): RedirectResponse
    {
        // 1. Segurança: Pega a restrição e verifica se o dono é o usuário logado
        if (Auth::id() !== $restricao->sorteio->user_id) {
            abort(403);
        }

        // 2. Regra de Negócio: Não pode remover restrições se o sorteio não estiver pendente
        if ($restricao->sorteio->status !== 'pending') {
             return Redirect::back()->with('error', 'Não é possível remover restrições após o sorteio ser realizado.');
        }

        // 3. Deleta a restrição
        $restricao->delete();

        return Redirect::back()->with('status', 'restricao-removed');
    }
}