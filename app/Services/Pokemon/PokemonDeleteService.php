<?php

namespace App\Services\Pokemon;

use App\Models\Pokemon;
use Illuminate\Support\Facades\DB;

class PokemonDeleteService
{
    public function delete(int $apiId): void
    {
        DB::transaction(function () use ($apiId) {
            $pokemon = Pokemon::where('api_id', $apiId)->firstOrFail();
            $pokemon->delete();
        });
    }
}

