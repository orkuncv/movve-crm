<?php

namespace Movve\Crm\Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class TeamMetaFieldDeleteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_delete_team_meta_field_via_delete_route()
    {
        // Maak een gebruiker en een team aan
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        // Maak een meta veld aan voor dit team
        $metaField = TeamMetaField::create([
            'team_id' => $team->id,
            'name' => 'Test Meta Field',
            'key' => 'test_meta_field',
            'type' => 'count',
            'description' => '',
            'is_active' => true,
        ]);

        // Zorg ervoor dat we ingelogd zijn als deze gebruiker
        $this->actingAs($user);

        // Test de delete route
        $response = $this->get('/en/crm/team-meta-fields/' . $metaField->id . '/delete');

        // Controleer of de redirect succesvol is
        $response->assertStatus(302);

        // Controleer of het meta veld soft deleted is
        $this->assertSoftDeleted('crm_team_meta_fields', [
            'id' => $metaField->id
        ]);
    }

    /** @test */
    public function user_can_delete_team_meta_field_via_destroy_route()
    {
        // Maak een gebruiker en een team aan
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;

        // Maak een meta veld aan voor dit team
        $metaField = TeamMetaField::create([
            'team_id' => $team->id,
            'name' => 'Test Meta Field',
            'key' => 'test_meta_field',
            'type' => 'count',
            'description' => '',
            'is_active' => true,
        ]);

        // Zorg ervoor dat we ingelogd zijn als deze gebruiker
        $this->actingAs($user);

        // Test de destroy route
        $response = $this->delete('/en/crm/team-meta-fields/' . $metaField->id);

        // Controleer of de redirect succesvol is
        $response->assertStatus(302);

        // Controleer of het meta veld soft deleted is
        $this->assertSoftDeleted('crm_team_meta_fields', [
            'id' => $metaField->id
        ]);
    }

    /** @test */
    public function debug_route_information()
    {
        // Maak een gebruiker en een team aan
        $user = User::factory()->withPersonalTeam()->create();
        
        // Zorg ervoor dat we ingelogd zijn als deze gebruiker
        $this->actingAs($user);
        
        // Haal alle routes op en log ze
        $routes = \Route::getRoutes();
        $teamMetaFieldRoutes = [];
        
        foreach ($routes as $route) {
            if (strpos($route->uri, 'team-meta-fields') !== false) {
                $teamMetaFieldRoutes[] = [
                    'uri' => $route->uri,
                    'methods' => $route->methods,
                    'name' => $route->getName(),
                    'action' => $route->getActionName(),
                ];
            }
        }
        
        // Log de routes
        \Log::info('Team Meta Field Routes:', $teamMetaFieldRoutes);
        
        // Deze test slaagt altijd
        $this->assertTrue(true);
    }
}
