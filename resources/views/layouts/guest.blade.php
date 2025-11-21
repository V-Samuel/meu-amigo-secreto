<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fontes (Trocando Figtree por Sora, da welcome page) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;700&display=swap" rel="stylesheet">

        <!-- Tailwind CSS (Vite) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Configuração de Cores do Tema (Copiado da welcome.blade.php) -->
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
    
    {{-- Mudando o fundo para bg-[var(--theme-bg)] e a fonte para font-sora --}}
    <body class="font-sora antialiased text-gray-900 bg-[var(--theme-bg)]">
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <!-- Logo (Apontando para a página inicial) -->
            <div>
                <a href="/" class="text-3xl font-bold text-[var(--theme-text)]">
                    MeuAmigoSecreto
                </a>
            </div>

            {{-- Mudando o card de 'bg-white' para 'bg-[var(--theme-header)]' --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-[var(--theme-header)] shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }} {{-- <-- O formulário (login ou registro) é injetado aqui --}}
            </div>
        </div>
    </body>
</html>
