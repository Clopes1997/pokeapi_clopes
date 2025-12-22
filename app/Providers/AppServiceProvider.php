<?php

namespace App\Providers;

use App\Models\Pokemon;
use App\Policies\PokemonPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Pokemon::class => PokemonPolicy::class,
    ];

    public function register(): void
    {
    }

    public function boot(): void
    {
    }
}
