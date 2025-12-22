<?php

namespace App\Http\Requests\Pokemon;

use App\Models\Pokemon;
use Illuminate\Foundation\Http\FormRequest;

class ImportPokemonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $apiId = (int) $this->route('apiId');
            if (Pokemon::where('api_id', $apiId)->exists()) {
                $validator->errors()->add('pokemon', 'Este Pokémon já foi importado');
            }
        });
    }
}
