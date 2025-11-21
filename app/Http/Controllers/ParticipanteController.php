<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth; 
use Illuminate\View\View;

class ParticipanteController extends Controller
{
    /**
     * Salva um novo participante...
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'sorteio_id' => ['required', 'exists:sorteios,id']
        ]);

        Participante::create([
            'sorteio_id' => $request->sorteio_id,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return Redirect::back()->with('status', 'participante-added');
    }

    // ==========================================================
    // ESTA É A LINHA CORRIGIDA
    // ==========================================================
    /**
     * Mostra o formulário para editar um participante.
     */
    public function edit(Participante $participante): View|RedirectResponse
    {
        // Verificação de Segurança
        if (Auth::id() !== $participante->sorteio->user_id) {
            abort(403);
        }

        // Verificação de Regra (Não pode editar se já foi sorteado)
        if ($participante->sorteio->status !== 'pending') {
            // Este é o RedirectResponse que o editor detectou
            return Redirect::route('sorteios.show', $participante->sorteio)
                   ->with('error', 'Não é possível editar participantes após o sorteio ser realizado.');
        }

        // Esta é a View que o editor esperava
        return view('participantes.edit', [
            'participante' => $participante,
        ]);
    }

    /**
     * Salva a atualização do participante.
     */
    public function update(Request $request, Participante $participante): RedirectResponse
    {
        // 1. Verificação de Segurança
        if (Auth::id() !== $participante->sorteio->user_id) {
            abort(403);
        }
        
        // 2. Verificação de Regra
        if ($participante->sorteio->status !== 'pending') {
            return Redirect::route('sorteios.show', $participante->sorteio)
                   ->with('error', 'Não é possível editar participantes após o sorteio ser realizado.');
        }

        // 3. Validar os dados
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        // 4. Atualizar o participante no banco
        $participante->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // 5. Redirecionar de volta para a PÁGINA DO SORTEIO
        return Redirect::route('sorteios.show', $participante->sorteio)
                       ->with('status', 'participante-updated');
    }

    /**
     * Remove o participante...
     */
    public function destroy(Participante $participante): RedirectResponse
    {
        $sorteio = $participante->sorteio;

        if (Auth::id() !== $sorteio->user_id) {
            abort(403);
        }

        if ($sorteio->status !== 'pending') {
            return Redirect::back()->with('error', 'Não é possível remover participantes após o sorteio ter sido realizado.');
        }

        $participante->delete();

        return Redirect::back()->with('status', 'participante-removed');
    }
}