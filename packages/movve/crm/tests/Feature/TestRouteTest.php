<?php

namespace Movve\Crm\Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestRouteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_access_test_route()
    {
        // Maak een gebruiker en een team aan
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        // Zorg ervoor dat we ingelogd zijn als deze gebruiker
        $this->actingAs($user);

        // Bezoek de test route
        $response = $this->get('/en/crm/test-team/' . $team->id);

        // Controleer of de pagina succesvol geladen wordt
        $response->assertStatus(200);
        $response->assertSee('Test route werkt!');
    }

    /** @test */
    public function user_can_access_team_meta_fields_page_with_direct_url()
    {
        // Maak een gebruiker en een team aan
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        // Zorg ervoor dat we ingelogd zijn als deze gebruiker
        $this->actingAs($user);

        // Bezoek de team meta fields pagina met een directe URL
        $response = $this->get('/en/crm/teams/' . $team->id . '/meta-fields');

        // Controleer of de pagina succesvol geladen wordt
        $response->assertStatus(200);
    }
}
