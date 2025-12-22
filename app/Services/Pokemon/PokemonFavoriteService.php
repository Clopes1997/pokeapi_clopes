<?php

namespace App\Services\Pokemon;

use App\Models\Pokemon;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class PokemonFavoriteService
{
    /**
     * O parâmetro recebido nos endpoints é o api_id (PokéAPI), não o id do banco.
     */
    public function addFavorite(User $user, int $apiId): void
    {
        $pokemon = Pokemon::query()->where('api_id', $apiId)->first();

        if (!$pokemon) {
            throw new ModelNotFoundException('Pokémon não encontrado');
        }

        $pokemonId = (int) $pokemon->getKey();

        if ($user->favorites()->where('pokemon_id', $pokemonId)->exists()) {
            throw ValidationException::withMessages([
                'pokemon' => ['Este Pokémon já está nos seus favoritos'],
            ]);
        }

        $user->favorites()->attach($pokemonId);
    }

    /**
     * O parâmetro recebido nos endpoints é o api_id (PokéAPI), não o id do banco.
     */
    public function removeFavorite(User $user, int $apiId): void
    {
        $pokemon = Pokemon::query()->where('api_id', $apiId)->first();

        if (!$pokemon) {
            throw new ModelNotFoundException('Pokémon não encontrado');
        }

        $pokemonId = (int) $pokemon->getKey();
        $user->favorites()->detach($pokemonId);
    }

    public function getUserFavorites(User $user): Collection
    {
        return $user->favorites()->get();
    }
}

