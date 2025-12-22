<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Meus Favoritos</h2>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        @if($favorites->count() > 0)
            <div class="grid grid-3">
                @foreach($favorites as $pokemon)
                    <div class="card pokemon-card">
                        <div class="pokemon-info">
                            <h3 class="section-title">{{ $pokemon->name }}</h3>
                            <p class="section-text">Altura: {{ $pokemon->height }}</p>
                            <p class="section-text">Peso: {{ $pokemon->weight }}</p>
                            <a href="{{ route('pokemon.show', $pokemon->id) }}" class="text-link">Ver detalhes</a>
                        </div>
                        @if($pokemon->sprite)
                            <img src="{{ $pokemon->sprite }}" alt="{{ $pokemon->name }}" class="pokemon-sprite">
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="section-text">Você ainda não tem Pokémon favoritados.</p>
        @endif
    </div>
</x-app-layout>