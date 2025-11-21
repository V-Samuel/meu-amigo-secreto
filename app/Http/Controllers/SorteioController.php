<?php

namespace App\Http\Controllers;

use App\Models\Sorteio;
use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Collection;

class SorteioController extends Controller
{
    // ... (index, create, store, show) ...
    
    public function index(): View
    {
        /** @var \App\Models\User $organizer */
        $organizer = Auth::user();
        $sorteios = $organizer->sorteios()->latest()->get();
        return view('sorteios.index', [
            'sorteios' => $sorteios,
        ]);
    }

    public function create(): View
    {
        return view('sorteios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['name' => ['required', 'string', 'max:255']]);
        $request->user()->sorteios()->create([
            'name' => $request->name,
            'organizer_participates' => $request->boolean('organizer_participates')
        ]);
        return Redirect::route('sorteios.index')->with('status', 'sorteio-created');
    }

    public function show(Sorteio $sorteio): View
    {
        $sorteio->load('participantes.drawnParticipant', 'restricoes.participantA', 'restricoes.participantB', 'mensagens.receiver');
        return view('sorteios.show', [
            'sorteio' => $sorteio,
        ]);
    }

    // ... (edit, update, destroy - vazios) ...
    public function edit(Sorteio $sorteio) { /* Vazio */ }
    public function update(Request $request, Sorteio $sorteio) { /* Vazio */ }
    public function destroy(Sorteio $sorteio) { /* Vazio */ }

    /**
     * Habilita/Desabilita o Mural
     */
    public function toggleMural(Sorteio $sorteio): RedirectResponse
    {
        if (Auth::id() !== $sorteio->user_id) { abort(403); }
        $sorteio->update(['mural_enabled' => !$sorteio->mural_enabled]);
        $status = $sorteio->mural_enabled ? 'Mural habilitado!' : 'Mural desabilitado.';
        return Redirect::back()->with('status', $status);
    }

    /**
     * Realiza o Sorteio
     */
    public function performDraw(Sorteio $sorteio): RedirectResponse
    {
        if (Auth::id() !== $sorteio->user_id) { abort(403); }
        if ($sorteio->status !== 'pending') {
            return Redirect::back()->with('error', 'Este sorteio já foi realizado.');
        }

        if ($sorteio->organizer_participates) {
            $organizer = Auth::user();
            $jaExiste = $sorteio->participantes()->where('email', $organizer->email)->exists();
            if (!$jaExiste) {
                $sorteio->participantes()->create([
                    'name' => $organizer->name,
                    'email' => $organizer->email,
                ]);
            }
        }
        
        $participantes = $sorteio->participantes()->get();
        $restricoes = $sorteio->restricoes;

        if ($participantes->count() < 3) {
            return Redirect::back()->with('error', 'São necessários pelo menos 3 participantes para sortear.');
        }

        $resultado = $this->runDrawAlgorithm($participantes, $restricoes);

        if ($resultado === null) {
            return Redirect::back()->with('error', 'Falha ao sortear. Verifique suas restrições.');
        }

        foreach ($resultado as $giverId => $receiverId) {
            Participante::where('id', $giverId)->update([
                'drawn_participant_id' => $receiverId
            ]);
        }
        
        $sorteio->update(['status' => 'drawn']);

        return Redirect::back()->with('status', 'Sorteio realizado com sucesso!');
    }

    /**
     * Helper: Lógica principal do algoritmo...
     */
    private function runDrawAlgorithm(Collection $participantes, Collection $restricoes): ?array
    {
        $maxTentativas = 50; 

        for ($t = 0; $t < $maxTentativas; $t++) {
            
            $doadores = $participantes->pluck('id')->shuffle();
            $recebedores = $participantes->pluck('id')->shuffle();
            
            $resultado = [];
            $possivel = true;
            
            foreach ($doadores as $doadorId) {
                $recebedorEncontrado = false;
                
                foreach ($recebedores as $key => $recebedorId) {
                    
                    if ($doadorId === $recebedorId) {
                        continue;
                    }

                    // ===============================================
                    // ESTA É A LINHA CORRIGIDA
                    // ===============================================
                    // Trocamos '$receiverId' (com 'i') por '$recebedorId' (com 'o')
                    $restrito = $restricoes->contains(function ($r) use ($doadorId, $recebedorId) {
                        return ($r->participant_a_id == $doadorId && $r->participant_b_id == $recebedorId);
                    });
                    // ===============================================

                    if (!$restrito) {
                        $resultado[$doadorId] = $recebedorId;
                        $recebedores->forget($key); 
                        $recebedorEncontrado = true;
                        break;
                    }
                } // fim loop recebedores

                if (!$recebedorEncontrado) {
                    $possivel = false;
                    break; 
                }
            } // fim loop doadores

            if ($possivel) {
                return $resultado;
            }
        } // fim loop tentativas

        return null;
    }
}