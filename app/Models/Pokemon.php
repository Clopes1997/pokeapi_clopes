<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pokemon extends Model
{
    protected $table = 'pokemons';

    protected $fillable = [
        'api_id',
        'name',
        'height',
        'weight',
        'sprite',
    ];

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class);
    }

    public function moves(): BelongsToMany
    {
        return $this->belongsToMany(Move::class);
    }

    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(Ability::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
