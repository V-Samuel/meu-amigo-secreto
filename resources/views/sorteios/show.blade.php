<x-app-layout>
    {{-- Título da Página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--theme-text)] leading-tight">
            Gerenciar: {{ $sorteio->name }}
            <span class="ml-4 px-3 py-1 text-sm font-medium rounded-full
                @if($sorteio->status == 'pending') bg-yellow-100 text-yellow-800 @else bg-green-100 text-green-800 @endif">
                {{ $sorteio->status == 'pending' ? 'Pendente' : 'Realizado' }}
            </span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Bloco de Alerta --}}
            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Sucesso!</strong>
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Ops! Algo deu errado.</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="space-y-6">
                {{-- BLOCO 1: SÓ APARECE SE O SORTEIO ESTIVER PENDENTE --}}
                @if($sorteio->status == 'pending')
                
                    {{-- CARD 1: Adicionar Participantes (RF-006) --}}
                    <div class="bg-[var(--theme-header)] shadow-sm sm:rounded-lg">
                        <div class="p-6 text-[var(--theme-text)]">
                            <h3 class="text-lg font-medium">Adicionar Participante (RF-006)</h3>
                            <form method="POST" action="{{ route('participantes.store') }}" class="mt-4 space-y-4">
                                @csrf
                                <input type="hidden" name="sorteio_id" value="{{ $sorteio->id }}">
                                <div>
                                    <x-input-label for="name" :value="__('Nome do Participante')" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full md:w-1/2" :value="old('name')" required :with-error="$errors->has('name')" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('E-mail (Opcional - para envio do resultado)')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full md:w-1/2" :value="old('email')" :with-error="$errors->has('email')" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <x-primary-button>
                                    {{ __('Adicionar') }}
                                </x-primary-button>
                            </form>
                        </div>
                    </div>

                    {{-- CARD 2: Lista de Participantes (RF-007, RF-008) --}}
                    <div class="bg-[var(--theme-header)] shadow-sm sm:rounded-lg">
                        <div class="p-6 text-[var(--theme-text)]">
                            <h3 class="text-lg font-medium">Participantes Adicionados ({{ $sorteio->participantes->count() }})</h3>
                            <div class="mt-4">
                                @if($sorteio->participantes->isEmpty())
                                    <p class="text-gray-600">Nenhum participante adicionado ainda.</p>
                                @else
                                    <ul class="divide-y divide-[var(--theme-accent)]">
                                        @foreach($sorteio->participantes as $participante)
                                            <li class="py-3 flex justify-between items-center">
                                                <div>
                                                    <span class="font-medium">{{ $participante->name }}</span>
                                                    <span class="text-sm text-gray-600 ml-2">{{ $participante->email }}</span>
                                                </div>
                                                <div class="flex items-center space-x-4">
                                                    <a href="{{ route('participantes.edit', $participante) }}" class="text-sm text-blue-600 hover:underline">
                                                        Editar
                                                    </a>
                                                    <form method="POST" action="{{ route('participantes.destroy', $participante) }}">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-sm text-red-600 hover:underline" onclick="return confirm('Tem certeza que deseja remover {{ addslashes($participante->name) }}?')">
                                                            Remover
                                                        </button>
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- CARD 3: RESTRIÇÕES (RF-009) --}}
                    <div class="bg-[var(--theme-header)] shadow-sm sm:rounded-lg">
                        <div class="p-6 text-[var(--theme-text)]">
                            <h3 class="text-lg font-medium">Definir Restrições (RF-009)</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Defina quem NÃO PODE tirar quem.
                            </p>
                            @if($sorteio->participantes->count() >= 2)
                                <form method="POST" action="{{ route('restricoes.store') }}" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="sorteio_id" value="{{ $sorteio->id }}">
                                    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                                        <select name="participant_a_id" class="border-[var(--theme-accent)] focus:border-green-700 focus:ring-green-700 bg-white/50 rounded-md shadow-sm text-gray-900 w-full">
                                            <option value="">Selecione...</option>
                                            @foreach($sorteio->participantes as $participante)
                                                <option value="{{ $participante->id }}" @selected(old('participant_a_id') == $participante->id)>
                                                    {{ $participante->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="font-medium">não pode tirar</span>
                                        <select name="participant_b_id" class="border-[var(--theme-accent)] focus:border-green-700 focus:ring-green-700 bg-white/50 rounded-md shadow-sm text-gray-900 w-full">
                                            <option value="">Selecione...</option>
                                            @foreach($sorteio->participantes as $participante)
                                                <option value="{{ $participante->id }}" @selected(old('participant_b_id') == $participante->id)>
                                                    {{ $participante->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-primary-button class="ml-0 md:ml-4 flex-shrink-0">
                                            {{ __('Salvar Restrição') }}
                                        </x-primary-button>
                                    </div>
                                    <x-input-error :messages="$errors->get('participant_a_id')" class="mt-2" />
                                    <x-input-error :messages="$errors->get('participant_b_id')" class="mt-2" />
                                </form>
                            @else
                                <p class="mt-4 text-sm text-gray-600">Você precisa de pelo menos 2 participantes para definir restrições.</p>
                            @endif
                            <div class="mt-6">
                                <h4 class="font-medium">Restrições Salvas:</h4>
                                @if($sorteio->restricoes->isEmpty())
                                    <p class="text-gray-600 text-sm mt-2">Nenhuma restrição definida.</p>
                                @else
                                    <ul class="divide-y divide-[var(--theme-accent)] mt-2">
                                        @foreach($sorteio->restricoes as $restricao)
                                            <li class="py-2 flex justify-between items-center">
                                                <span>
                                                    @if($restricao->participantA && $restricao->participantB)
                                                        <span class="font-medium">{{ $restricao->participantA->name }}</span>
                                                        <span class="text-gray-600"> não pode tirar </span>
                                                        <span class="font-medium">{{ $restricao->participantB->name }}</span>
                                                    @else
                                                        <span class="text-red-500 italic">Restrição inválida (participante removido)</span>
                                                    @endif
                                                </span>
                                                <form method="POST" action="{{ route('restricoes.destroy', $restricao) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-sm text-red-600 hover:underline">Remover</button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Card do Mural (RF-020) --}}
                    <div class="bg-[var(--theme-header)] shadow-sm sm:rounded-lg">
                        <div class="p-6 text-[var(--theme-text)]">
                            <h3 class="text-lg font-medium">Mural do Mistério (RF-020)</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Permite que participantes enviem mensagens anónimas entre si.
                            </p>
                            <form method="POST" action="{{ route('sorteios.toggle-mural', $sorteio) }}" class="mt-4">
                                @csrf
                                @method('PATCH')
                                @if($sorteio->mural_enabled)
                                    <x-primary-button class="bg-red-600 hover:bg-red-500 focus:bg-red-700 active:bg-red-700 focus:ring-red-500">
                                        {{ __('Desabilitar Mural') }}
                                    </x-primary-button>
                                @else
                                    <x-primary-button class="bg-blue-600 hover:bg-blue-500">
                                        {{ __('Habilitar Mural') }}
                                    </x-primary-button>
                                @endif
                            </form>
                        </div>
                    </div>

                    {{-- Card de Moderação (RF-021) --}}
                    @if($sorteio->mural_enabled)
                    <div class="bg-white/50 shadow-sm sm:rounded-lg">
                        <div class="p-6 text-[var(--theme-text)]">
                            <h3 class="text-lg font-medium">Moderação do Mural (RF-021)</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Apague mensagens inadequadas. A identidade do remetente é 100% anônima.
                            </p>
                            <div class="mt-4">
                                @if($sorteio->mensagens->isEmpty())
                                    <p class="text-gray-600 text-sm italic">Nenhuma mensagem no mural ainda.</p>
                                @else
                                    <ul class="divide-y divide-[var(--theme-accent)]">
                                        @foreach($sorteio->mensagens->sortByDesc('created_at') as $mensagem)
                                            <li class="py-3">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <p class="text-sm italic">"{{ $mensagem->message }}"</p>
                                                        <span class="text-xs text-gray-500">
                                                            Para: 
                                                            @if($mensagem->receiver)
                                                                <span class="font-medium">{{ $mensagem->receiver->name }}</span> (Direta)
                                                            @else
                                                                <span class="font-medium">Mural Geral</span>
                                                            @endif
                                                            - {{ $mensagem->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                    <form method="POST" action="{{ route('mural.destroy-admin', $mensagem) }}" class="ml-4">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-sm text-red-600 hover:underline" onclick="return confirm('Apagar esta mensagem?')">Apagar</button>
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif


                    {{-- CARD 4: BOTÃO DE SORTEAR (RF-011) --}}
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">Realizar Sorteio (RF-011)</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Atenção: Esta ação é irreversível. O sorteio será realizado e os participantes não poderão mais ser editados ou removidos.
                            </p>
                            
                            @if($sorteio->participantes->count() >= 3)
                                <form method="POST" action="{{ route('sorteios.draw', $sorteio) }}" class="mt-4">
                                    @csrf
                                    <x-primary-button class="bg-green-600 hover:bg-green-500 focus:bg-green-700 active:bg-green-700 focus:ring-green-500">
                                        {{ __('Realizar Sorteio Agora!') }}
                                    </x-primary-button>
                                </form>
                            @else
                                <p class="mt-4 text-sm font-medium text-yellow-700">
                                    Você precisa de pelo menos 3 participantes para realizar o sorteio.
                                </p>
                            @endif
                        </div>
                    </div>
                
                {{-- =============================================== --}}
                {{-- BLOCO 2: SE O SORTEIO FOI REALIZADO (drawn) --}}
                {{-- =============================================== --}}
                @else 
                    
                    {{-- =============================================== --}}
                    {{-- MUDANÇA: Lógica de exibição dos resultados --}}
                    {{-- =============================================== --}}
                    
                    {{-- Se o Admin NÃO participa, mostre os resultados (RF-013) --}}
                    @if(!$sorteio->organizer_participates)
                        <div class="bg-[var(--theme-header)] shadow-sm sm:rounded-lg">
                            <div class="p-6 text-[var(--theme-text)]">
                                <h3 class="text-lg font-medium">Resultado do Sorteio (Visão do Organizador)</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    Aqui está a lista completa de quem tirou quem. (RF-013)
                                </p>
                                <ul class="divide-y divide-[var(--theme-accent)] mt-4">
                                    @foreach($sorteio->participantes as $participante)
                                        <li class="py-3">
                                            <span class="font-medium">{{ $participante->name }}</span>
                                            <span class="text-gray-600 mx-2">tirou</span>
                                            <span class="font-medium text-green-700">
                                                {{ $participante->drawnParticipant->name ?? '[ERRO]' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        {{-- Se o Admin PARTICIPA, mostre esta mensagem --}}
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Você está participando!</strong>
                            <span class="block sm:inline">O sorteio foi realizado! Para manter a surpresa, a lista de resultados não é exibida. Pegue seu link de participante abaixo para descobrir seu amigo secreto.</span>
                        </div>
                    @endif


                    {{-- MODO FESTA (RF-022) --}}
                    <div class="bg-blue-900 text-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-white">Módulo: Modo Festa (RF-022)</h3>
                            <p class="mt-1 text-sm text-blue-200">
                                Inicie o assistente de revelação em tela cheia para a festa.
                            </p>
                            <a href="{{ route('sorteios.festa', $sorteio) }}" target="_blank"
                               class="inline-block mt-4 px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400">
                                {{ __('Iniciar Modo Festa') }}
                            </a>
                        </div>
                    </div>
                    
                    {{-- Card do Mural (RF-020) - Pós Sorteio --}}
                    <div class="bg-[var(--theme-header)] shadow-sm sm:rounded-lg">
                        <div class="p-6 text-[var(--theme-text)]">
                            <h3 class="text-lg font-medium">Mural do Mistério (RF-020)</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                O mural está atualmente: 
                                <span class="font-bold {{ $sorteio->mural_enabled ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $sorteio->mural_enabled ? 'HABILITADO' : 'DESABILITADO' }}
                                </span>
                            </p>
                            <form method="POST" action="{{ route('sorteios.toggle-mural', $sorteio) }}" class="mt-4">
                                @csrf
                                @method('PATCH')
                                @if($sorteio->mural_enabled)
                                    <x-primary-button class="bg-red-600 hover:bg-red-500 focus:bg-red-700 active:bg-red-700 focus:ring-red-500">
                                        {{ __('Desabilitar Mural') }}
                                    </x-primary-button>
                                @else
                                    <x-primary-button class="bg-blue-600 hover:bg-blue-500">
                                        {{ __('Habilitar Mural') }}
                                    </x-primary-button>
                                @endif
                            </form>
                        </div>
                    </div>

                    {{-- Card de Moderação (RF-021) - Pós Sorteio --}}
                    @if($sorteio->mural_enabled || $sorteio->mensagens->count() > 0)
                    <div class="bg-white/50 shadow-sm sm:rounded-lg">
                        <div class="p-6 text-[var(--theme-text)]">
                            <h3 class="text-lg font-medium">Moderação do Mural (RF-021)</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Apague mensagens inadequadas. A identidade do remetente é 100% anônima.
                            </p>
                            <div class="mt-4">
                                @if($sorteio->mensagens->isEmpty())
                                    <p class="text-gray-600 text-sm italic">Nenhuma mensagem no mural ainda.</p>
                                @else
                                    <ul class="divide-y divide-[var(--theme-accent)]">
                                        @foreach($sorteio->mensagens->sortByDesc('created_at') as $mensagem)
                                            <li class="py-3">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <p class="text-sm italic">"{{ $mensagem->message }}"</p>
                                                        <span class="text-xs text-gray-500">
                                                            Para: 
                                                            @if($mensagem->receiver)
                                                                <span class="font-medium">{{ $mensagem->receiver->name }}</span> (Direta)
                                                            @else
                                                                <span class="font-medium">Mural Geral</span>
                                                            @endif
                                                            - {{ $mensagem->created_at->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                    <form method="POST" action="{{ route('mural.destroy-admin', $mensagem) }}" class="ml-4">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-sm text-red-600 hover:underline" onclick="return confirm('Apagar esta mensagem?')">Apagar</button>
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- CARD 6: LINKS DE PARTILHA (RF-012) --}}
                    <div class="bg-[var(--theme-header)] shadow-sm sm:rounded-lg">
                        <div class="p-6 text-[var(--theme-text)]">
                            <h3 class="text-lg font-medium">Links de Partilha (RF-012)</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Envie o link único abaixo para cada participante.
                            </p>
                            
                            <div class="mt-4 space-y-3">
                                @foreach($sorteio->participantes as $participante)
                                    <div>
                                        <x-input-label :value="$participante->name" />
                                        {{-- Destaque especial se for o link do próprio admin --}}
                                        @if($sorteio->organizer_participates && $participante->email == Auth::user()->email)
                                            <p class="text-sm text-green-600 font-medium mb-1">Este é o seu link!</p>
                                        @endif
                                        <x-text-input 
                                            class="w-full mt-1 bg-white {{ ($sorteio->organizer_participates && $participante->email == Auth::user()->email) ? 'border-2 border-green-500' : '' }}" 
                                            type="text" 
                                            readonly 
                                            value="{{ route('participant.show', $participante->token) }}" 
                                            onclick="this.select();"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                @endif
            </div>
        </div>
    </div>
</x-app-layout>