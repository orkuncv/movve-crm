<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Jetstream;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class TeamMetaFieldTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_meta_field_can_be_created()
    {
        // Maak een team aan
        $user = $this->createUserWithTeam();
        
        // Maak een meta veld aan
        $metaField = TeamMetaField::create([
            'team_id' => $user->currentTeam->id,
            'name' => 'Shop Visits',
            'key' => 'shop_visited',
            'type' => 'counter',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Controleer of het meta veld correct is aangemaakt
        $this->assertDatabaseHas('crm_team_meta_fields', [
            'team_id' => $user->currentTeam->id,
            'name' => 'Shop Visits',
            'key' => 'shop_visited',
        ]);
        
        // Controleer de relatie met het team
        $this->assertEquals($user->currentTeam->id, $metaField->team_id);
    }
    
    public function test_team_meta_field_belongs_to_team()
    {
        // Maak een team aan
        $user = $this->createUserWithTeam();
        
        // Maak een meta veld aan
        $metaField = TeamMetaField::create([
            'team_id' => $user->currentTeam->id,
            'name' => 'Shop Visits',
            'key' => 'shop_visited',
            'type' => 'counter',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Controleer de relatie met het team
        $this->assertNotNull($metaField->team);
        $this->assertEquals($user->currentTeam->id, $metaField->team->id);
    }
    
    /**
     * Helper functie om een gebruiker met team aan te maken
     */
    private function createUserWithTeam()
    {
        $user = \App\Models\User::factory()->withPersonalTeam()->create();
        
        return $user;
    }
}
