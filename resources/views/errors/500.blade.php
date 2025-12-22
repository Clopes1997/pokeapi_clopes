<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Erro 500
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Erro ao comunicar com a API de Pokémon</h1>
                    <p>{{ $exception->getMessage() ?: 'Erro ao comunicar com a API de Pokémon' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

