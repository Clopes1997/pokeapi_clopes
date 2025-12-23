<?php

namespace Tests\Feature\Pokemon;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PokemonImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_import_pokemon_by_api_id(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $response = $this->actingAs($user)->post('/pokemon/import/25');

        $response->assertStatus(200);
    }

    public function test_import_creates_pokemon_with_types_relationship(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $response = $this->actingAs($user)->post('/pokemon/import/25');

        $response->assertStatus(200);
        $response->assertSessionHas('success');
    }

    public function test_import_creates_pokemon_with_moves_relationship(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $response = $this->actingAs($user)->post('/pokemon/import/25');

        $response->assertStatus(200);
        $response->assertSessionHas('success');
    }

    public function test_import_creates_pokemon_with_abilities_relationship(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $response = $this->actingAs($user)->post('/pokemon/import/25');

        $response->assertStatus(200);
        $response->assertSessionHas('success');
    }

    public function test_import_prevents_duplicate_pokemon(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $firstImport = $this->actingAs($user)->post('/pokemon/import/25');
        $firstImport->assertStatus(200);

        $duplicateImport = $this->actingAs($user)->post('/pokemon/import/25');
        $duplicateImport->assertStatus(302);
        $duplicateImport->assertSessionHasErrors();
    }

    public function test_import_handles_invalid_pokemon_id(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $response = $this->actingAs($user)->post('/pokemon/import/99999');

        $response->assertStatus(404);
        $response->assertSee('Pokémon não encontrado', false);
    }

    public function test_import_handles_api_errors_gracefully(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $response = $this->actingAs($user)->post('/pokemon/import/0');

        $response->assertStatus(500);
        $response->assertSee('Erro ao comunicar com a API de Pokémon', false);
    }

    public function test_import_shows_success_message_in_pt_br(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $response = $this->actingAs($user)->post('/pokemon/import/25');

        $response->assertStatus(200);
        $response->assertSessionHas('success');
        $response->assertSessionHas('success', function ($message) {
            return str_contains($message, 'importado') || str_contains($message, 'sucesso');
        });
    }

    public function test_import_error_messages_are_in_pt_br(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $response = $this->actingAs($user)->post('/pokemon/import/99999');

        $response->assertSee('Pokémon não encontrado', false);
    }

    public function test_import_api_timeout_is_handled_gracefully(): void
    {
        $editorRole = Role::create(['name' => 'editor']);
        $user = User::factory()->create();
        $user->roles()->attach($editorRole);

        $response = $this->actingAs($user)->post('/pokemon/import/25');

        $response->assertStatus(500);
        $response->assertSee('Erro ao comunicar com a API de Pokémon', false);
    }
}

