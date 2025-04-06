<?php

namespace Movve\Crm\Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class TeamMetaFieldsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_access_team_meta_fields_page()
    {
        // Maak een gebruiker en een team aan
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        // Zorg ervoor dat we ingelogd zijn als deze gebruiker
        $this->actingAs($user);

        // Bezoek de team meta fields pagina
        $response = $this->get('/en/crm/teams/' . $team->id . '/meta-fields');

        // Controleer of de pagina succesvol geladen wordt
        $response->assertStatus(200);
        $response->assertSee('Meta Velden');
    }

    /** @test */
    public function user_cannot_access_team_meta_fields_page_for_team_they_dont_belong_to()
    {
        // Maak twee gebruikers aan, elk met een eigen team
        $user1 = User::factory()->withPersonalTeam()->create();
        $user2 = User::factory()->withPersonalTeam()->create();

        // Zorg ervoor dat we ingelogd zijn als user1
        $this->actingAs($user1);

        // Probeer de team meta fields pagina van user2's team te bezoeken
        $response = $this->get('/en/crm/teams/' . $user2->currentTeam->id . '/meta-fields');

        // Controleer of we een 403 of 404 krijgen
        $response->assertStatus(403);
    }

    /** @test */
    public function team_meta_fields_are_displayed_on_the_page()
    {
        // Maak een gebruiker en een team aan
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        // Maak een meta field aan voor dit team
        $metaField = TeamMetaField::create([
            'team_id' => $team->id,
            'name' => 'Test Meta Field',
            'type' => 'text',
            'required' => false,
        ]);

        // Zorg ervoor dat we ingelogd zijn als deze gebruiker
        $this->actingAs($user);

        // Bezoek de team meta fields pagina
        $response = $this->get('/en/crm/teams/' . $team->id . '/meta-fields');

        // Controleer of de pagina succesvol geladen wordt en het meta field bevat
        $response->assertStatus(200);
        $response->assertSee('Test Meta Field');
    }
}
