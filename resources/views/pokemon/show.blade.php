<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalhes do Pokémon
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
                    <h1 class="text-2xl font-bold mb-4">{{ $pokemon->name }}</h1>
                    
                    @if($pokemon->sprite)
                        <img src="{{ $pokemon->sprite }}" alt="{{ $pokemon->name }}" class="mb-4">
                    @endif

                    <p><strong>Altura:</strong> {{ $pokemon->height }}</p>
                    <p><strong>Peso:</strong> {{ $pokemon->weight }}</p>

                    <div class="mt-4">
                        <h2 class="text-xl font-bold mb-2">Tipos:</h2>
                        <ul>
                            @foreach($pokemon->types as $type)
                                <li>{{ $type->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-4">
                        <h2 class="text-xl font-bold mb-2">Movimentos:</h2>
                        <ul>
                            @foreach($pokemon->moves as $move)
                                <li>{{ $move->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-4">
                        <h2 class="text-xl font-bold mb-2">Habilidades:</h2>
                        <ul>
                            @foreach($pokemon->abilities as $ability)
                                <li>{{ $ability->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

