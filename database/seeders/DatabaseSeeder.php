<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Move;
use App\Models\Pokemon;
use App\Models\Role;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Roles (if not already seeded)
        $viewer = Role::firstOrCreate(['name' => 'viewer'], ['display_name' => 'Viewer']);
        $editor = Role::firstOrCreate(['name' => 'editor'], ['display_name' => 'Editor']);
        $admin = Role::firstOrCreate(['name' => 'admin'], ['display_name' => 'Administrator']);

        // Seed Users (if not already seeded)
        $viewerUser = User::firstOrCreate(
            ['username' => 'viewer'],
            [
                'name' => 'Viewer User',
                'email' => 'viewer@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        if (!$viewerUser->roles()->where('roles.id', $viewer->id)->exists()) {
            $viewerUser->roles()->attach($viewer);
        }

        $editorUser = User::firstOrCreate(
            ['username' => 'editor'],
            [
                'name' => 'Editor User',
                'email' => 'editor@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        if (!$editorUser->roles()->where('roles.id', $editor->id)->exists()) {
            $editorUser->roles()->attach($editor);
        }

        $adminUser = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        if (!$adminUser->roles()->where('roles.id', $admin->id)->exists()) {
            $adminUser->roles()->attach($admin);
        }

        // Seed Types
        $types = [
            'Normal', 'Fire', 'Water', 'Electric', 'Grass', 'Ice',
            'Fighting', 'Poison', 'Ground', 'Flying', 'Psychic', 'Bug',
            'Rock', 'Ghost', 'Dragon', 'Dark', 'Steel', 'Fairy'
        ];

        $typeModels = [];
        foreach ($types as $typeName) {
            $typeModels[$typeName] = Type::firstOrCreate(['name' => $typeName]);
        }

        // Seed Abilities
        $abilities = [
            'Overgrow', 'Blaze', 'Torrent', 'Static', 'Lightning Rod',
            'Intimidate', 'Levitate', 'Swift Swim', 'Chlorophyll', 'Thick Fat',
            'Water Absorb', 'Volt Absorb', 'Flash Fire', 'Adaptability',
            'Technician', 'Mold Breaker', 'Multiscale', 'Magic Guard',
            'Solar Power', 'Rain Dish', 'Pressure', 'Unnerve', 'Cursed Body',
            'Inner Focus', 'Immunity', 'Cute Charm', 'Competitive', 'Moxie'
        ];

        $abilityModels = [];
        foreach ($abilities as $abilityName) {
            $abilityModels[$abilityName] = Ability::firstOrCreate(['name' => $abilityName]);
        }

        // Seed Moves
        $moves = [
            'Tackle', 'Scratch', 'Ember', 'Water Gun', 'Thunder Shock',
            'Vine Whip', 'Ice Beam', 'Thunderbolt', 'Flamethrower', 'Hydro Pump',
            'Solar Beam', 'Earthquake', 'Psychic', 'Shadow Ball', 'Dragon Claw',
            'Iron Tail', 'Aerial Ace', 'Rock Slide', 'Dark Pulse', 'Moonblast',
            'Poison Powder', 'Quick Attack', 'Sludge Bomb', 'Aura Sphere', 'Body Slam'
        ];

        $moveModels = [];
        foreach ($moves as $moveName) {
            $moveModels[$moveName] = Move::firstOrCreate(['name' => $moveName]);
        }

        // Seed Pokemons with realistic data
        $pokemons = [
            [
                'api_id' => 1,
                'name' => 'Bulbasaur',
                'height' => 7,
                'weight' => 69,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png',
                'types' => ['Grass', 'Poison'],
                'abilities' => ['Overgrow', 'Chlorophyll'],
                'moves' => ['Tackle', 'Vine Whip', 'Solar Beam', 'Poison Powder'],
            ],
            [
                'api_id' => 2,
                'name' => 'Charmander',
                'height' => 6,
                'weight' => 85,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/4.png',
                'types' => ['Fire'],
                'abilities' => ['Blaze', 'Solar Power'],
                'moves' => ['Scratch', 'Ember', 'Flamethrower', 'Dragon Claw'],
            ],
            [
                'api_id' => 3,
                'name' => 'Squirtle',
                'height' => 5,
                'weight' => 90,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/7.png',
                'types' => ['Water'],
                'abilities' => ['Torrent', 'Rain Dish'],
                'moves' => ['Tackle', 'Water Gun', 'Hydro Pump', 'Ice Beam'],
            ],
            [
                'api_id' => 4,
                'name' => 'Pikachu',
                'height' => 4,
                'weight' => 60,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png',
                'types' => ['Electric'],
                'abilities' => ['Static', 'Lightning Rod'],
                'moves' => ['Thunder Shock', 'Thunderbolt', 'Quick Attack', 'Iron Tail'],
            ],
            [
                'api_id' => 5,
                'name' => 'Charizard',
                'height' => 17,
                'weight' => 905,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/6.png',
                'types' => ['Fire', 'Flying'],
                'abilities' => ['Blaze', 'Solar Power'],
                'moves' => ['Flamethrower', 'Dragon Claw', 'Aerial Ace', 'Rock Slide'],
            ],
            [
                'api_id' => 6,
                'name' => 'Blastoise',
                'height' => 16,
                'weight' => 855,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/9.png',
                'types' => ['Water'],
                'abilities' => ['Torrent', 'Rain Dish'],
                'moves' => ['Hydro Pump', 'Ice Beam', 'Earthquake', 'Rock Slide'],
            ],
            [
                'api_id' => 7,
                'name' => 'Mewtwo',
                'height' => 20,
                'weight' => 1220,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/150.png',
                'types' => ['Psychic'],
                'abilities' => ['Pressure', 'Unnerve'],
                'moves' => ['Psychic', 'Shadow Ball', 'Aura Sphere', 'Ice Beam'],
            ],
            [
                'api_id' => 8,
                'name' => 'Gengar',
                'height' => 15,
                'weight' => 405,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/94.png',
                'types' => ['Ghost', 'Poison'],
                'abilities' => ['Cursed Body'],
                'moves' => ['Shadow Ball', 'Dark Pulse', 'Sludge Bomb', 'Thunderbolt'],
            ],
            [
                'api_id' => 9,
                'name' => 'Dragonite',
                'height' => 22,
                'weight' => 2100,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/149.png',
                'types' => ['Dragon', 'Flying'],
                'abilities' => ['Inner Focus', 'Multiscale'],
                'moves' => ['Dragon Claw', 'Aerial Ace', 'Ice Beam', 'Thunderbolt'],
            ],
            [
                'api_id' => 10,
                'name' => 'Snorlax',
                'height' => 21,
                'weight' => 4600,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/143.png',
                'types' => ['Normal'],
                'abilities' => ['Immunity', 'Thick Fat'],
                'moves' => ['Tackle', 'Earthquake', 'Rock Slide', 'Body Slam'],
            ],
            [
                'api_id' => 11,
                'name' => 'Jigglypuff',
                'height' => 5,
                'weight' => 55,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/39.png',
                'types' => ['Normal', 'Fairy'],
                'abilities' => ['Cute Charm', 'Competitive'],
                'moves' => ['Tackle', 'Moonblast', 'Psychic', 'Shadow Ball'],
            ],
            [
                'api_id' => 12,
                'name' => 'Gyarados',
                'height' => 65,
                'weight' => 2350,
                'sprite' => 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/130.png',
                'types' => ['Water', 'Flying'],
                'abilities' => ['Intimidate', 'Moxie'],
                'moves' => ['Hydro Pump', 'Ice Beam', 'Earthquake', 'Dragon Claw'],
            ],
        ];

        foreach ($pokemons as $pokemonData) {
            $moves = $pokemonData['moves'];
            $abilities = $pokemonData['abilities'];
            $types = $pokemonData['types'];
            
            unset($pokemonData['moves'], $pokemonData['abilities'], $pokemonData['types']);

            $pokemon = Pokemon::updateOrCreate(
                ['api_id' => $pokemonData['api_id']],
                $pokemonData
            );

            // Attach types
            $typeIds = [];
            foreach ($types as $typeName) {
                if (isset($typeModels[$typeName])) {
                    $typeIds[] = $typeModels[$typeName]->id;
                }
            }
            $pokemon->types()->sync($typeIds);

            // Attach abilities (create if they don't exist)
            $abilityIds = [];
            foreach ($abilities as $abilityName) {
                if (!isset($abilityModels[$abilityName])) {
                    $abilityModels[$abilityName] = Ability::firstOrCreate(['name' => $abilityName]);
                }
                $abilityIds[] = $abilityModels[$abilityName]->id;
            }
            $pokemon->abilities()->sync($abilityIds);

            // Attach moves (create if they don't exist)
            $moveIds = [];
            foreach ($moves as $moveName) {
                if (!isset($moveModels[$moveName])) {
                    $moveModels[$moveName] = Move::firstOrCreate(['name' => $moveName]);
                }
                $moveIds[] = $moveModels[$moveName]->id;
            }
            $pokemon->moves()->sync($moveIds);
        }

        // Seed Favorites - Add some favorites for existing users
        $allUsers = User::all();
        $allPokemons = Pokemon::all();

        if ($allUsers->isNotEmpty() && $allPokemons->isNotEmpty()) {
            // Viewer user favorites
            if ($viewerUser) {
                $viewerFavorites = $allPokemons->random(min(3, $allPokemons->count()));
                foreach ($viewerFavorites as $pokemon) {
                    $viewerUser->favorites()->syncWithoutDetaching([$pokemon->id]);
                }
            }

            // Editor user favorites
            if ($editorUser) {
                $editorFavorites = $allPokemons->random(min(5, $allPokemons->count()));
                foreach ($editorFavorites as $pokemon) {
                    $editorUser->favorites()->syncWithoutDetaching([$pokemon->id]);
                }
            }

            // Admin user favorites
            if ($adminUser) {
                $adminFavorites = $allPokemons->random(min(4, $allPokemons->count()));
                foreach ($adminFavorites as $pokemon) {
                    $adminUser->favorites()->syncWithoutDetaching([$pokemon->id]);
                }
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Pokemons: ' . Pokemon::count());
        $this->command->info('Types: ' . Type::count());
        $this->command->info('Abilities: ' . Ability::count());
        $this->command->info('Moves: ' . Move::count());
        $this->command->info('Users: ' . User::count());
        $this->command->info('Favorites: ' . DB::table('favorites')->count());
    }
}
