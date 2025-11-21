<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modo Festa: {{ $sorteio->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --theme-bg: #e4fdf2;
            --theme-header: #effff8;
            --theme-wave: #D7F5E8;
            --theme-text: #052e16; 
            --theme-accent: #9DC7B4;
            --theme-button: #a2a8ba;
            --theme-button-hover: #9299ab;
        }
        .font-sora { font-family: 'Sora', sans-serif; }
    </style>
</head>
<body class="font-sora antialiased bg-[var(--theme-bg)] text-[var(--theme-text)] min-h-screen flex items-center justify-center p-4">

    <div x-data="{
            tela: 'selecao', 
            participantes: {{ $participantes->keyBy('id') }},
            jaForam: [],
            selecionado: null
        }" 
         class="bg-[var(--theme-header)] w-full max-w-4xl p-8 rounded-lg shadow-2xl text-center">

        <h2 class="text-3xl font-bold text-green-800">{{ $sorteio->name }}</h2>
        <p class="text-lg">Modo Festa - Assistente de Revelação</p>

        {{-- TELA 1: SELEÇÃO DE PARTICIPANTES (RF-023) --}}
        <div x-show="tela === 'selecao'" x-transition>
            <h3 class="text-2xl font-semibold mt-8 mb-4">Quem vai começar a revelar?</h3>
            
            <div class="flex flex-wrap justify-center gap-4">
                @foreach($participantes as $participante)
                    <button 
                        x-bind:disabled="jaForam.includes({{ $participante->id }})"
                        x-on:click="tela = 'revelando'; selecionado = participantes[{{ $participante->id }}]"
                        class="px-6 py-3 rounded-lg font-medium text-lg transition
                               border-2 border-[var(--theme-accent)]
                               hover:bg-[var(--theme-wave)]
                               disabled:bg-gray-200 disabled:text-gray-400 disabled:border-gray-300 disabled:line-through">
                        {{ $participante->name }}
                    </button>
                @endforeach
            </div>

            <a href="{{ route('sorteios.show', $sorteio) }}" class="inline-block mt-12 text-sm text-gray-500 hover:underline">
                &larr; Voltar ao Painel de Controle
            </a>
        </div>

        {{-- TELA 2: REVELAÇÃO (RF-024, RF-025, RF-026) --}}
        <div x-show="tela === 'revelando' && selecionado" x-transition.opacity.duration.500ms style="display: none;">
            
            <h3 class="text-2xl font-semibold mt-8 mb-4" x-text="`Revelação de: ${selecionado.name}`"></h3>
            
            <div class="text-left bg-white/50 p-4 rounded-lg border border-[var(--theme-accent)]">
                <h4 class="font-bold">Lista de Desejos de <span x-text="selecionado.name"></span>:</h4>
                <ul class="list-disc list-inside mt-2 text-gray-700">
                    <template x-if="selecionado.desejos.length === 0">
                        <li class="italic text-sm">Não adicionou nenhum desejo.</li>
                    </template>
                    <template x-for="desejo in selecionado.desejos">
                        <li x-text="desejo.description"></li>
                    </template>
                </ul>
            </div>

            <p class="text-xl my-6">Quem você acha que tirou <span x-text="selecionado.name" class="font-bold"></span>?</p>

            {{-- =============================================== --}}
            {{-- MUDANÇA 2: Trocamos o 'alert()' pelo 'Swal.fire()' (SweetAlert) --}}
            {{-- =============================================== --}}
            <button 
                x-on:click="jaForam.push(selecionado.id); Swal.fire({ title: 'Revelado!', html: `Quem tirou <strong>${selecionado.name}</strong> foi...<br><br><h2 class=\'text-3xl font-bold text-green-700\'>${selecionado.drawn_participant.name}!</h2>`, icon: 'success', confirmButtonText: 'Próximo!' }).then(() => { tela = 'selecao'; });"
                class="px-8 py-4 rounded-lg font-bold text-xl text-white transition bg-green-600 hover:bg-green-500">
                Revelar!
            </button>
        </div>
    </div>

</body>
</html>