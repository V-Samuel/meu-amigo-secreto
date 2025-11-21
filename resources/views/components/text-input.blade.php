@props([
    'disabled' => false,
    'withError' => false
])

@php
// MUDANÇA: Trocamos as cores padrão (border-gray-300 e focus:border-indigo-500)
// pelas cores do nosso tema (border-[var(--theme-accent)] e focus:border-green-700)
$classes = ($withError ?? false)
            ? 'border-red-500 focus:border-red-600 focus:ring-red-600'
            : 'border-[var(--theme-accent)] focus:border-green-700 focus:ring-green-700';
@endphp

{{-- Adicionamos 'bg-white/50' para uma leve transparência --}}
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => $classes . ' bg-white/50 rounded-md shadow-sm text-gray-900'
]) !!}>