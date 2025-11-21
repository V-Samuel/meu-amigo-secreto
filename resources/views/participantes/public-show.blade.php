{{-- MUDANÇA 1: Usar o novo layout mais largo --}}
<x-participant-layout>
    
    {{-- Alertas (mantêm-se iguais) --}}
    @if (session('status'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Ops!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- 1. Card "Quem eu Tirei" (Full-Width) --}}
    {{-- MUDANÇA 2: Adicionamos a classe .participant-card para o GSAP --}}
    <div class="participant-card w-full text-[var(--theme-text)]">
        <h2 class="text-2xl font-bold text-center">
            Olá, {{ $participante->name }}!
        </h2>
        <p class="text-center text-lg mt-4">
            O sorteio do <strong class="text-green-800">{{ $participante->sorteio->name }}</strong> foi realizado!
        </p>
        <div class="mt-8 text-center p-6 bg-[var(--theme-wave)] rounded-lg">
            <p class="text-lg">Você tirou:</p>
            <h3 class="text-4xl font-bold text-green-700 my-2">
                {{ $participante->drawnParticipant->name }}
            </h3>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- MUDANÇA 3: Criamos uma Grelha (Grid) de 2 Colunas --}}
    {{-- =============================================== --}}
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        
        {{-- COLUNA 1: Desejos do Amigo e Mural (Formulário) --}}
        <div class="space-y-6">
            {{-- 2. Card "Desejos de quem eu tirei" (RF-015) --}}
            <div class="participant-card">
                <h4 class="font-medium text-lg">Lista de Desejos de <span class="text-green-700">{{ $participante->drawnParticipant->name }}</span>:</h4>
                <div class="mt-2 p-4 border border-[var(--theme-accent)] rounded-md bg-white/50 h-48 overflow-y-auto">
                    @if($participante->drawnParticipant->desejos->isEmpty())
                        <p class="text-gray-600 text-sm italic">
                            {{ $participante->drawnParticipant->name }} ainda não adicionou nenhum desejo.
                        </p>
                    @else
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($participante->drawnParticipant->desejos as $desejo)
                                <li>{{ $desejo->description }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- 4. Card "Mural do Mistério" (Formulário de Envio) --}}
            @if($participante->sorteio->mural_enabled)
            <div class="participant-card pt-6 border-t border-[var(--theme-accent)]">
                <h3 class="text-xl font-bold text-center">Mural do Mistério 🕵️</h3>
                <form method="POST" action="{{ route('mural.store', $participante->token) }}" class="mt-4 space-y-3">
                    @csrf
                    <div>
                        <x-input-label for="message" value="Enviar mensagem anônima:" />
                        <textarea id="message" name="message" rows="3"
                                  class="border-[var(--theme-accent)] focus:border-green-700 focus:ring-green-700 bg-white/50 rounded-md shadow-sm text-gray-900 mt-1 block w-full"
                                  placeholder="Escreva sua mensagem... (será 100% anônimo)"
                                  required>{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="receiver_id" value="Para:" />
                        <select name="receiver_id" class="border-[var(--theme-accent)] focus:border-green-700 focus:ring-green-700 bg-white/50 rounded-md shadow-sm text-gray-900 mt-1 block w-full">
                            <option value="">Mural Geral (todos podem ver)</option>
                            <option value="{{ $participante->drawnParticipant->id }}">
                                A pessoa que eu tirei (somente ela verá)
                            </option>
                        </select>
                    </div>
                    <x-primary-button>Enviar Mensagem Anônima</x-primary-button>
                </form>
            </div>
            @endif
        </div> {{-- Fim da Coluna 1 --}}


        {{-- COLUNA 2: Meus Desejos e Mural (Mensagens) --}}
        <div class="space-y-6">
            {{-- 3. Card "Meus Desejos" (RF-010) --}}
            <div class="participant-card">
                <h4 class="font-medium text-lg">Minha Lista de Desejos (para seu amigo secreto ver)</h4>
                <form method="POST" action="{{ route('desejos.store', $participante->token) }}" class="mt-4 flex space-x-2">
                    @csrf
                    <x-text-input id="description" name="description" type="text" class="block w-full" placeholder="Ex: Livro, Chocolate..." required :with-error="$errors->has('description')" />
                    <x-primary-button>Adicionar</x-primary-button>
                </form>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                
                <div class="mt-4 h-48 overflow-y-auto border border-[var(--theme-accent)] rounded-md bg-white/50 p-2">
                    @if($participante->desejos->isEmpty())
                        <p class="text-gray-600 text-sm italic p-2">Você ainda não adicionou nenhum desejo.</p>
                    @else
                        <ul class="divide-y divide-[var(--theme-accent)]">
                            @foreach($participante->desejos as $desejo)
                                <li class="py-2 px-2 flex justify-between items-center">
                                    <span>{{ $desejo->description }}</span>
                                    <form method="POST" action="{{ route('desejos.destroy', [$desejo, $participante->token]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:underline">Remover</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- 4. Card "Mural do Mistério" (Leitura) --}}
            @if($participante->sorteio->mural_enabled)
            <div class="participant-card pt-6 border-t border-[var(--theme-accent)]">
                {{-- Mensagens para Mim --}}
                <h4 class="font-medium text-lg mt-4">Mensagens para você:</h4>
                <div class="mt-2 space-y-2 h-40 overflow-y-auto border border-[var(--theme-accent)] rounded-md bg-white/50 p-3">
                    @forelse($mensagensParaMim as $mensagem)
                        <div class="p-3 bg-[var(--theme-wave)] rounded-md">
                            <p class="text-sm italic">"{{ $mensagem->message }}"</p>
                            <span class="text-xs text-gray-500">- Amigo secreto ({{ $mensagem->created_at->diffForHumans() }})</span>
                        </div>
                    @empty
                        <p class="text-gray-600 text-sm italic">Ninguém te enviou uma mensagem direta ainda.</p>
                    @endforelse
                </div>

                {{-- Mensagens Gerais --}}
                <h4 class="font-medium text-lg mt-6">Mural Geral:</h4>
                <div class="mt-2 space-y-2 h-40 overflow-y-auto border border-[var(--theme-accent)] rounded-md bg-white/50 p-3">
                    @forelse($mensagensGerais as $mensagem)
                        <div class="p-3 bg-white/50 rounded-md">
                            <p class="text-sm italic">"{{ $mensagem->message }}"</p>
                            <span class="text-xs text-gray-500">- Amigo secreto ({{ $mensagem->created_at->diffForHumans() }})</span>
                        </div>
                    @empty
                        <p class="text-gray-600 text-sm italic">Ninguém escreveu no mural geral ainda.</p>
                    @endforelse
                </div>
            </div>
            @endif
        </div> {{-- Fim da Coluna 2 --}}
        
    </div> {{-- Fim da Grelha (Grid) --}}


    {{-- =============================================== --}}
    {{-- MUDANÇA 4: Script de Animação GSAP + ScrollTrigger --}}
    {{-- =============================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.gsap && window.ScrollTrigger) {
                
                // Seleciona todos os cards
                const cards = gsap.utils.toArray('.participant-card');
                
                cards.forEach((card) => {
                    gsap.from(card, { // Anima cada card
                        scrollTrigger: {
                            trigger: card,
                            start: "top 90%", // Inicia quando o topo do card estiver a 90% da tela
                            toggleActions: "play none none none",
                        },
                        opacity: 0,
                        y: 40,
                        duration: 0.8,
                        ease: 'power3.out'
                    });
                });
            }
        });
    </script>
</x-participant-layout>