<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-t">
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
    <body class="font-sora antialiased">
        {{-- 
          MUDANÇA: Trocamos 'min-h-screen bg-gray-100' 
          pelo nosso fundo temático 'min-h-screen bg-[var(--theme-bg)]' 
        --}}
        <div class="min-h-screen bg-[var(--theme-bg)]">
            
            {{-- MUDANÇA: Trocamos 'bg-white' pelo nosso 'bg-[var(--theme-header)]' --}}
            @include('layouts.navigation', ['headerBg' => 'bg-[var(--theme-header)]'])

            @if (isset($header))
                {{-- MUDANÇA: Trocamos 'bg-white' pelo nosso 'bg-[var(--theme-header)]' --}}
                <header class="bg-[var(--theme-header)] shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>