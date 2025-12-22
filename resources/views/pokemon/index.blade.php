<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Lista de Pokémon</h2>
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
        <form method="GET" action="{{ route('pokemon.index') }}" class="search-form">
            <div class="row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome" class="input">
                <input type="text" name="type" value="{{ request('type') }}" placeholder="Filtrar por tipo" class="input">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>
    </div>

    @if($pokemon->count() > 0)
        <div class="grid grid-3">
                @foreach($pokemon as $p)
                    <div class="card pokemon-card" style="position: relative;">
                        <div class="pokemon-info">
                            <h3 class="section-title">{{ $p->name }}</h3>
                            <p class="section-text">Altura: {{ $p->height }}</p>
                            <p class="section-text">Peso: {{ $p->weight }}</p>
                            <a href="{{ route('pokemon.show', $p->id) }}" class="text-link">Ver detalhes</a>
                        </div>
                        @if($p->sprite)
                            <img src="{{ $p->sprite }}" alt="{{ $p->name }}" class="pokemon-sprite">
                        @endif
                        
                        @if(auth()->user()->roles()->where('name', 'admin')->exists())
                            <div style="position: absolute; bottom: 0.5rem; right: 2.5rem;">
                                <span style="font-size: 1.2rem; color: #ef4444; cursor: default;" title="Excluir">✕</span>
                            </div>
                        @endif

                        @can('favorite', $p)
                            @if(auth()->user()->favorites->contains($p))
                                <form method="POST" action="{{ route('pokemon.unfavorite', $p->id) }}" class="favorite-form" style="position: absolute; bottom: 0.5rem; right: 0.5rem;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 1.5rem; color: #FFD700; padding: 0; line-height: 1;">★</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('pokemon.favorite', $p->id) }}" class="favorite-form" style="position: absolute; bottom: 0.5rem; right: 0.5rem;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 1.5rem; color: #ccc; padding: 0; line-height: 1;">☆</button>
                                </form>
                            @endif
                        @endcan
                    </div>
                @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $pokemon->links() }}
        </div>
    @else
        <div class="card">
            <p class="section-text">Nenhum Pokémon encontrado.</p>
        </div>
    @endif

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

        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }, 1000);
        }
    </script>
</x-app-layout>