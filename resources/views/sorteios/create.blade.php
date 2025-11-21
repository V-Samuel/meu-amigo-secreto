<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--theme-text)] leading-tight">
            {{ __('Criar Novo Sorteio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[var(--theme-header)] shadow-sm sm:rounded-lg">
                <div class="p-6 text-[var(--theme-text)]">
                    
                    <form method="POST" action="{{ route('sorteios.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nome do Sorteio')" />
                            <x-text-input id="name" class="block mt-1 w-full" 
                                   type="text" 
                                   name="name" 
                                   :value="old('name')" 
                                   required 
                                   autofocus 
                                   :with-error="$errors->has('name')"
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- =============================================== --}}
                        {{-- NOVO CHECKBOX DE PARTICIPAÇÃO --}}
                        {{-- =============================================== --}}
                        <div class="block mt-4">
                            <label for="organizer_participates" class="inline-flex items-center">
                                <input id="organizer_participates" type="checkbox" 
                                       class="rounded border-[var(--theme-accent)] text-green-600 shadow-sm focus:ring-green-500 bg-white/50" 
                                       name="organizer_participates" value="1" 
                                       @checked(old('organizer_participates'))>
                                <span class="ms-2 text-sm text-gray-700">{{ __('Eu vou participar deste sorteio') }}</span>
                            </label>
                        </div>
                        {{-- =============================================== --}}
                        {{-- FIM DO NOVO BLOCO --}}
                        {{-- =============================================== --}}


                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('sorteios.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Salvar Sorteio') }}
                            </x-primary-button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>