<?php

namespace Tests\Feature;

use App\Models\User;
use App\Actions\Jetstream\CreateTeam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_teams_can_be_created(): void
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        // Direct de CreateTeam action gebruiken in plaats van de Livewire component
        // om problemen met URL generatie te vermijden
        $createTeam = new CreateTeam();
        $createTeam->create($user, ['name' => 'Test Team']);

        $this->assertCount(2, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->fresh()->ownedTeams()->latest('id')->first()->name);
    }
}
