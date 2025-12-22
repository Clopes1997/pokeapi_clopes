<?php

namespace App\Services\Pokemon;

use App\ApiClients\PokemonApiClient;
use App\Models\Ability;
use App\Models\Move;
use App\Models\Pokemon;
use App\Models\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PokemonImportService
{
    public function __construct(
        private PokemonApiClient $apiClient
    ) {
    }

    public function import(int $apiId): void
    {
        try {
            $data = $this->apiClient->getPokemon($apiId);
        } catch (\RuntimeException $e) {
            throw new HttpException(500, 'Erro ao comunicar com a API de Pokémon');
        }

        if (isset($data['detail'])) {
            if ($data['detail'] === 'Not found.') {
                throw new ModelNotFoundException('Pokémon não encontrado');
            }
            throw new HttpException(500, 'Erro ao comunicar com a API de Pokémon');
        }

        DB::transaction(function () use ($data) {
            $sprite = $data['sprites']['front_default'] ?? null;

            $pokemon = Pokemon::updateOrCreate(
                ['api_id' => $data['id']],
                [
                    'name' => $data['name'],
                    'height' => $data['height'],
                    'weight' => $data['weight'],
                    'sprite' => $sprite,
                ]
            );

            $typeIds = [];
            foreach ($data['types'] ?? [] as $typeData) {
                $type = Type::firstOrCreate(['name' => $typeData['type']['name']]);
                $typeIds[] = $type->id;
            }
            $pokemon->types()->sync($typeIds);

            $moveIds = [];
            foreach ($data['moves'] ?? [] as $moveData) {
                $move = Move::firstOrCreate(['name' => $moveData['move']['name']]);
                $moveIds[] = $move->id;
            }
            $pokemon->moves()->sync($moveIds);

            $abilityIds = [];
            foreach ($data['abilities'] ?? [] as $abilityData) {
                $ability = Ability::firstOrCreate(['name' => $abilityData['ability']['name']]);
                $abilityIds[] = $ability->id;
            }
            $pokemon->abilities()->sync($abilityIds);
        });
    }
}

