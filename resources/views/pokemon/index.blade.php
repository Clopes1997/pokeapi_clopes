<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Lista de Pokémon
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="GET" action="{{ route('pokemon.index') }}" class="mb-4">
                        <div class="flex gap-4 mb-4">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <input type="text" name="type" value="{{ request('type') }}" placeholder="Filtrar por tipo" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Buscar</button>
                        </div>
                    </form>

                    @if($pokemon->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($pokemon as $p)
                                <div class="border rounded-lg p-4">
                                    <h3 class="font-bold">{{ $p->name }}</h3>
                                    <p>Altura: {{ $p->height }}</p>
                                    <p>Peso: {{ $p->weight }}</p>
                                    <a href="{{ route('pokemon.show', $p->id) }}" class="text-blue-500">Ver detalhes</a>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $pokemon->links() }}
                        </div>
                    @else
                        <p>Nenhum Pokémon encontrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

