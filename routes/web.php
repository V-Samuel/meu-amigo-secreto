<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SorteioController;
use App\Http\Controllers\ParticipanteController;
use App\Http\Controllers\RestricaoController;
use App\Http\Controllers\PublicParticipantController;
use App\Http\Controllers\DesejoController;
use App\Http\Controllers\MensagemMuralController;
use App\Http\Controllers\MuralModerationController;
use App\Http\Controllers\ModoFestaController; // <-- 1. ADICIONE ESTE 'use'
use Illuminate\Support\Facades\Redirect; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rotas Públicas
Route::get('p/{token}', [PublicParticipantController::class, 'show'])->name('participant.show');
Route::post('desejos/{token}', [DesejoController::class, 'store'])->name('desejos.store');
Route::delete('desejos/{desejo}/{token}', [DesejoController::class, 'destroy'])->name('desejos.destroy');
Route::post('mural/{token}', [MensagemMuralController::class, 'store'])->name('mural.store');


/*
|--------------------------------------------------------------------------
| Rotas do Organizador (Privadas)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return Redirect::route('sorteios.index'); 
})->middleware(['auth', 'verified'])->name('dashboard');

// Todas as rotas aqui dentro exigem login
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sorteios
    Route::resource('sorteios', SorteioController::class);
    Route::post('sorteios/{sorteio}/draw', [SorteioController::class, 'performDraw'])->name('sorteios.draw');
    Route::patch('sorteios/{sorteio}/toggle-mural', [SorteioController::class, 'toggleMural'])->name('sorteios.toggle-mural');
    
    // Participantes
    Route::post('participantes', [ParticipanteController::class, 'store'])->name('participantes.store');
    Route::delete('participantes/{participante}', [ParticipanteController::class, 'destroy'])->name('participantes.destroy');
    Route::get('participantes/{participante}/edit', [ParticipanteController::class, 'edit'])->name('participantes.edit');
    Route::patch('participantes/{participante}', [ParticipanteController::class, 'update'])->name('participantes.update');

    // Restrições
    Route::post('restricoes', [RestricaoController::class, 'store'])->name('restricoes.store');
    Route::delete('restricoes/{restricao}', [RestricaoController::class, 'destroy'])->name('restricoes.destroy');

    // Moderação do Mural
    Route::delete('mural-moderation/{mensagemMural}', [MuralModerationController::class, 'destroy'])->name('mural.destroy-admin');

    // ==========================================================
    // 2. NOVA ROTA PARA O MODO FESTA (RF-022)
    // ==========================================================
    Route::get('sorteios/{sorteio}/festa', [ModoFestaController::class, 'show'])->name('sorteios.festa');

});

require __DIR__.'/auth.php';