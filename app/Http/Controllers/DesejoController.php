<?php

namespace App\Http\Controllers;

use App\Models\Desejo;
use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class DesejoController extends Controller
{
    /**
     * Salva um novo desejo (RF-010)
     */
    public function store(Request $request, string $token): RedirectResponse
    {
        // 1. Encontra o participante pelo token
        $participante = Participante::where('token', $token)->firstOrFail();

        // 2. Valida os dados
        $request->validate([
            'description' => ['required', 'string', 'max:500'],
        ]);

        // 3. Salva o desejo associado a este participante
        $participante->desejos()->create([
            'description' => $request->description,
        ]);

        return Redirect::back()->with('status', 'Desejo adicionado!');
    }


    /**
     * Remove um desejo (RF-010)
     */
    public function destroy(Desejo $desejo, string $token): RedirectResponse
    {
        // 1. Encontra o participante pelo token
        $participante = Participante::where('token', $token)->firstOrFail();

        // 2. Segurança: Verifica se o desejo que estão tentando apagar
        //    pertence REALMENTE ao participante dono deste token.
        if ($desejo->participante_id !== $participante->id) {
            abort(403); // Proibido
        }

        // 3. Deleta o desejo
        $desejo->delete();

        return Redirect::back()->with('status', 'Desejo removido!');
    }
}
