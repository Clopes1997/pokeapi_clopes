<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Erro 404</h2>
    </x-slot>

    <div class="card">
        <h1 class="section-title">Pokémon não encontrado</h1>
        <p class="section-text">{{ $exception->getMessage() ?: 'Pokémon não encontrado' }}</p>
    </div>
</x-app-layout>

