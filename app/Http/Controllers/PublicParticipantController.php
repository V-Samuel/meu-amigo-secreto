<?php

namespace App\Http\Controllers;

use App\Models\Participante;
// use App\Models\MensagemMural; // (Não é necessário, usamos a relação)
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicParticipantController extends Controller
{
    /**
     * Mostra a página pública do participante.
     * (RF-014)
     */
    public function show(string $token): View
    {
        // 1. Encontra o participante pelo token
        $participante = Participante::where('token', $token)
                                    ->firstOrFail();
        
        // 2. Carrega as listas de desejo (RF-010, RF-015)
        $participante->load('desejos', 'drawnParticipant.desejos');

        // ==========================================================
        // 3. MUDANÇA AQUI: Carregamos os dados do Mural
        // ==========================================================
        $sorteio = $participante->sorteio;

        // Pega todos os participantes do grupo (para o <select> do formulário)
        $outrosParticipantes = $sorteio->participantes->where('id', '!=', $participante->id);

        // Pega mensagens gerais (RF-017)
        $mensagensGerais = $sorteio->mensagens()
                                  ->whereNull('receiver_participant_id')
                                  ->latest()
                                  ->get();
        
        // Pega mensagens enviadas para este participante (RF-019)
        $mensagensParaMim = $participante->receivedMessages()
                                        ->latest()
                                        ->get();
        
        // 4. Retorna a view pública com todos os dados
        return view('participantes.public-show', [
            'participante' => $participante,
            'outrosParticipantes' => $outrosParticipantes,
            'mensagensGerais' => $mensagensGerais,
            'mensagensParaMim' => $mensagensParaMim,
        ]);
    }
}