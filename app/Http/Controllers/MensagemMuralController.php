<?php

namespace App\Http\Controllers;

use App\Models\MensagemMural;
use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class MensagemMuralController extends Controller
{
    /**
     * Salva uma nova mensagem anônima (RF-017, RF-018)
     */
    public function store(Request $request, string $token): RedirectResponse
    {
        // 1. Encontra o participante (remetente) pelo token
        $remetente = Participante::where('token', $token)->firstOrFail();

        // 2. Valida os dados
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            // 'receiver_id' pode ser nulo (para mural geral) ou um ID
            'receiver_id' => ['nullable', 'exists:participantes,id'],
        ]);
        
        // 3. Segurança: O mural está habilitado?
        if (!$remetente->sorteio->mural_enabled) {
            return Redirect::back()->with('error', 'O Mural do Mistério está desabilitado.');
        }

        // 4. Salva a mensagem
        MensagemMural::create([
            'sorteio_id' => $remetente->sorteio_id,
            'sender_participant_id' => $remetente->id,
            'receiver_participant_id' => $request->receiver_id, // Pode ser null
            'message' => $request->message,
        ]);

        return Redirect::back()->with('status', 'Mensagem enviada!');
    }
}