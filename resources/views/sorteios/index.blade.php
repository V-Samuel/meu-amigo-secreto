<x-app-layout>
    {{-- Isto vai para o <header> do layout --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--theme-text)] leading-tight">
            {{ __('Meus Sorteios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- MUDANÇA: Trocamos 'bg-white' por 'bg-[var(--theme-header)]' --}}
            <div class="bg-[var(--theme-header)] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-[var(--theme-text)]">
                    
                    <a href="{{ route('sorteios.create') }}">
                        <x-primary-button>
                            {{ __('Criar Novo Sorteio') }}
                        </x-primary-button>
                    </a>

                    {{-- Lista de Sorteios (RF-005) --}}
                    <div class="mt-6">
                        @if($sorteios->isEmpty())
                            <p>Você ainda não criou nenhum sorteio.</p>
                        @else
                            {{-- MUDANÇA: Trocamos 'ul' por 'div' para uma lista de links --}}
                            <div class="border-t border-[var(--theme-accent)]">
                                @foreach($sorteios as $sorteio)
                                    {{-- 
                                      MUDANÇA: O 'li' agora é um 'a' (link) clicável.
                                      A rota 'sorteios.show' já existe (do Route::resource).
                                    --}}
                                    <a href="{{ route('sorteios.show', $sorteio) }}" 
                                       class="flex justify-between items-center p-4 border-b border-[var(--theme-accent)] hover:bg-[var(--theme-bg)] transition duration-150 ease-in-out">
                                        
                                        <div>
                                            <span class="font-medium text-lg">{{ $sorteio->name }}</span>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <span class="text-sm text-gray-600">{{ $sorteio->status }}</span>
                                            {{-- Ícone de "seta" --}}
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>