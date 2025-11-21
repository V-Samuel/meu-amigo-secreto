<?php

namespace App\Http\Controllers;

use App\Models\MensagemMural; // <-- Adicione
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; // <-- Adicione
use Illuminate\Support\Facades\Auth; // <-- Adicione
use Illuminate\Support\Facades\Redirect; // <-- Adicione

class MuralModerationController extends Controller
{
    /**
     * Remove (modera) uma mensagem do mural.
     * (RF-021)
     */
    public function destroy(MensagemMural $mensagemMural): RedirectResponse
    {
        // 1. Segurança: Verifica se o usuário logado é o dono do sorteio
        //    ao qual esta mensagem pertence.
        if (Auth::id() !== $mensagemMural->sorteio->user_id) {
            abort(403); // Proibido
        }

        // 2. Deleta a mensagem
        $mensagemMural->delete();

        return Redirect::back()->with('status', 'Mensagem removida com sucesso.');
    }
}