<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            body {
                background-color: var(--theme-bg);
                color: var(--theme-text);
            }
        </style>
    </head>
    <body class="font-sora antialiased">
        <div class="relative min-h-screen">
            <header class="absolute top-0 left-0 w-full z-10 py-4 px-4 sm:px-6 lg:px-8 bg-[var(--theme-header)] shadow-sm">
                <nav class="container mx-auto flex justify-between items-center">
                    <a href="/" class="text-2xl font-bold text-green-800">
                        MeuAmigoSecreto
                    </a>
                    
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/sorteios') }}" 
                                   class="px-6 py-2 rounded-md font-medium text-[var(--theme-text)] bg-[var(--theme-wave)] hover:bg-[var(--theme-accent)] transition-colors">
                                   Painel
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="text-sm font-medium text-gray-600 hover:text-gray-900">
                                   Entrar
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="px-5 py-2 rounded-md font-medium text-white bg-[var(--theme-button)] hover:bg-[var(--theme-button-hover)] transition-colors">
                                       Cadastrar
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </nav>
            </header>

            <main class="relative overflow-hidden">
                <section id="landing-hero" class="container mx-auto min-h-screen grid grid-cols-1 md:grid-cols-2 items-center pt-32 pb-16 px-6">
                    <div class="space-y-6 text-center md:text-left">
                        <h1 id="landing-hero-title" class="text-4xl md:text-6xl font-bold leading-tight">
                            Organize seu <span class="text-green-700">Amigo Secreto</span> 100% Online
                        </h1>
                        <p id="landing-hero-subtitle" class="text-lg text-gray-700 max-w-lg mx-auto md:mx-0">
                            Crie grupos, defina restrições, envie convites e deixe que a gente cuida do sorteio. Rápido, divertido e gratuito!
                        </p>
                        <div id="landing-hero-cta">
                            <a href="{{ route('register') }}" 
                               class="inline-block px-8 py-3 rounded-md font-bold text-white bg-[var(--theme-button)] hover:bg-[var(--theme-button-hover)] transition-transform duration-300 hover:scale-105 shadow-lg">
                                Começar Agora!
                            </a>
                        </div>
                    </div>
                    
                    <div id="landing-hero-image" class="hidden md:flex items-center justify-center relative">
                        <div class="w-96 h-96 bg-[var(--theme-wave)] rounded-full absolute opacity-50 -translate-x-10"></div>
                        <img src="https://placehold.co/500x500/D7F5E8/052e16?text=🎁" 
                             alt="Caixa de presente de amigo secreto" 
                             class="w-full max-w-md rounded-full relative z-0 shadow-xl"
                             onerror="this.src='https://placehold.co/500x500/D7F5E8/052e16?text=🎁'">
                    </div>
                </section>

                {{-- =============================================== --}}
                {{-- MUDANÇA: NOVA SECÇÃO "COMO FUNCIONA" --}}
                {{-- =============================================== --}}
                <section id="features-section" class="container mx-auto py-24 px-6">
                    <h2 class="text-4xl font-bold text-center mb-16">
                        Tudo em 3 passos simples
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                        
                        <div class="feature-card bg-[var(--theme-header)] p-8 rounded-lg shadow-lg border border-[var(--theme-accent)]">
                            <h3 class="text-2xl font-bold text-green-700 mb-3">1. Crie o Grupo</h3>
                            <p class="text-gray-700">Dê um nome ao seu sorteio, defina as regras e se você vai participar ou não.</p>
                        </div>
                        
                        <div class="feature-card bg-[var(--theme-header)] p-8 rounded-lg shadow-lg border border-[var(--theme-accent)]">
                            <h3 class="text-2xl font-bold text-green-700 mb-3">2. Convide</h3>
                            <p class="text-gray-700">Adicione os nomes dos seus amigos e envie o link único para cada um.</p>
                        </div>
                        
                        <div class="feature-card bg-[var(--theme-header)] p-8 rounded-lg shadow-lg border border-[var(--theme-accent)]">
                            <h3 class="text-2xl font-bold text-green-700 mb-3">3. Sorteie!</h3>
                            <p class="text-gray-700">Quando todos estiverem prontos, aperte o botão e deixe a mágica acontecer!</p>
                        </div>
                        
                    </div>
                </section>
                {{-- =============================================== --}}
                {{-- FIM DA NOVA SECÇÃO --}}
                {{-- =============================================== --}}

            </main>
        </div>
    </body>
</html>