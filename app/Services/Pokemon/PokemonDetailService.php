<?php

namespace App\Services\Pokemon;

use App\Models\Pokemon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PokemonDetailService
{
    public function __construct(
        private PokemonImportService $importService
    ) {
    }

    public function getById(int $id): Pokemon
    {
        // O $id recebido é o api_id, não o id do banco
        $pokemon = Pokemon::with(['types', 'moves', 'abilities'])
            ->where('api_id', $id)
            ->first();

        if ($pokemon) {
            return $pokemon;
        }

        // Lazy import: se não existe no banco, busca na API simulada e persiste.
        // - Not found -> ModelNotFoundException (404)
        // - Falha de integração -> HttpException (500)
        $this->importService->import($id);
        
        // Após importar com sucesso, busca novamente pelo api_id
        $pokemon = Pokemon::with(['types', 'moves', 'abilities'])
            ->where('api_id', $id)
            ->first();
        
        if (!$pokemon) {
            throw new ModelNotFoundException('Pokémon não encontrado');
        }

        return $pokemon;
    }
}

