<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Detalhes do Pokémon</h2>
    </x-slot>

    <div class="card" style="position: relative;">
        @can('favorite', $pokemon)
            @if($isFavorited)
                <form method="POST" action="{{ route('pokemon.unfavorite', $pokemon->id) }}" class="favorite-form" style="position: absolute; top: 1rem; right: 1rem;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 2rem; color: #FFD700; padding: 0; line-height: 1;">★</button>
                </form>
            @else
                <form method="POST" action="{{ route('pokemon.favorite', $pokemon->id) }}" class="favorite-form" style="position: absolute; top: 1rem; right: 1rem;">
                    @csrf
                    <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 2rem; color: #ccc; padding: 0; line-height: 1;">☆</button>
                </form>
            @endif
        @endcan

        <h1 class="page-title">{{ $pokemon->name }}</h1>
        
        @if($pokemon->sprite)
            <img src="{{ $pokemon->sprite }}" alt="{{ $pokemon->name }}">
        @endif

        <div class="grid">
            <div>
                <p class="section-text"><strong>Altura:</strong> {{ $pokemon->height }}</p>
            </div>
            <div>
                <p class="section-text"><strong>Peso:</strong> {{ $pokemon->weight }}</p>
            </div>
        </div>

        <div class="stack section-group">
            <h2 class="section-title">Tipos</h2>
            <div class="row">
                @foreach($pokemon->types as $type)
                    <span class="pill">{{ $type->name }}</span>
                @endforeach
            </div>
        </div>

        <div class="stack section-group">
            <h2 class="section-title">Movimentos</h2>
            <div class="row">
                @foreach($pokemon->moves as $move)
                    <span class="pill">{{ $move->name }}</span>
                @endforeach
            </div>
        </div>

        <div class="stack section-group">
            <h2 class="section-title">Habilidades</h2>
            <div class="row">
                @foreach($pokemon->abilities as $ability)
                    <span class="pill">{{ $ability->name }}</span>
                @endforeach
            </div>
        </div>

        @can('delete', $pokemon)
            <div class="stack section-group" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
                <form method="POST" action="{{ route('pokemon.destroy', $pokemon->id) }}" onsubmit="return confirm('Tem certeza que deseja excluir este Pokémon? Esta ação não pode ser desfeita.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="background-color: #dc2626; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; border: none; cursor: pointer; font-weight: 600; font-size: 1rem;">
                        Excluir Pokémon
                    </button>
                </form>
            </div>
        @endcan
    </div>

    <script>
        document.querySelectorAll('.favorite-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                    method: this.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(() => {
                    window.location.reload();
                });
            });
        });

    </script>
</x-app-layout>