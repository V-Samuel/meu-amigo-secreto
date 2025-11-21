<x-app-layout>
    {{-- Título da Página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--theme-text)] leading-tight">
            {{-- Link "breadcrumb" para voltar ao sorteio --}}
            <a href="{{ route('sorteios.show', $participante->sorteio) }}" class="text-gray-500 hover:underline">
                {{ $participante->sorteio->name }}
            </a>
            <span class="text-gray-400 mx-2">/</span>
            Editar Participante
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[var(--theme-header)] shadow-sm sm:rounded-lg">
                <div class="p-6 text-[var(--theme-text)]">
                    
                    {{-- Formulário aponta para 'participantes.update' com método PATCH --}}
                    <form method="POST" action="{{ route('participantes.update', $participante) }}" class="mt-4 space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <x-input-label for="name" :value="__('Nome do Participante')" />
                            {{-- O :value="old('name', $participante->name)" preenche o campo com o dado atual --}}
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full md:w-1/2" 
                                          :value="old('name', $participante->name)" 
                                          required 
                                          :with-error="$errors->has('name')" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="email" :value="__('E-mail (Opcional)')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full md:w-1/2" 
                                          :value="old('email', $participante->email)" 
                                          :with-error="$errors->has('email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <x-primary-button>
                                {{ __('Salvar Alterações') }}
                            </x-primary-button>
                            
                            {{-- Link "Cancelar" para voltar --}}
                            <a href="{{ route('sorteios.show', $participante->sorteio) }}" class="text-sm text-gray-600 hover:underline">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>