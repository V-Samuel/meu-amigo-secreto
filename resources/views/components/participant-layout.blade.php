<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
        </style>
    </head>
    
    <body class="font-sora antialiased text-gray-900 bg-[var(--theme-bg)]">
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <div>
                <a href="/" class="text-3xl font-bold text-[var(--theme-text)]">
                    MeuAmigoSecreto
                </a>
            </div>

            {{-- 
              MUDANÇA PRINCIPAL:
              Este layout usa 'sm:max-w-4xl' (muito mais largo) 
              em vez de 'sm:max-w-md' do guest-layout.
            --}}
            <div class="w-full sm:max-w-4xl mt-6 px-6 py-8 bg-[var(--theme-header)] shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }} {{-- O conteúdo da página será injetado aqui --}}
            </div>
        </div>
    </body>
</html>