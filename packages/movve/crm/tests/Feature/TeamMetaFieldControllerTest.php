<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class TeamMetaFieldControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_team_meta_fields_index()
    {
        // Maak een gebruiker met team aan
        $user = $this->createUserWithTeam();
        
        // Maak een meta veld aan voor het team
        TeamMetaField::create([
            'team_id' => $user->currentTeam->id,
            'name' => 'Shop Visits',
            'key' => 'shop_visited',
            'type' => 'counter',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Maak een request naar de index pagina
        $response = $this->actingAs($user)
            ->get('/' . app()->getLocale() . '/crm/team-meta-fields');
        
        // Controleer of de pagina succesvol geladen wordt
        $response->assertStatus(200);
        
        // Controleer of de meta veld naam op de pagina staat
        $response->assertSee('Shop Visits');
    }
    
    public function test_user_can_create_team_meta_field()
    {
        // Maak een gebruiker met team aan
        $user = $this->createUserWithTeam();
        
        // Maak een request naar de create pagina
        $response = $this->actingAs($user)
            ->get('/' . app()->getLocale() . '/crm/team-meta-fields/create');
        
        // Controleer of de pagina succesvol geladen wordt
        $response->assertStatus(200);
        
        // Maak een POST request om een meta veld aan te maken
        $response = $this->actingAs($user)
            ->post('/' . app()->getLocale() . '/crm/team-meta-fields', [
                'name' => 'Customer Age',
                'key' => 'customer_age',
                'type' => 'counter',
                'description' => 'Leeftijd van de klant',
            ]);
        
        // Controleer of we worden doorgestuurd naar de index pagina
        $response->assertRedirect('/' . app()->getLocale() . '/crm/team-meta-fields');
        
        // Controleer of het meta veld is aangemaakt in de database
        $this->assertDatabaseHas('crm_team_meta_fields', [
            'team_id' => $user->currentTeam->id,
            'name' => 'Customer Age',
            'key' => 'customer_age',
        ]);
    }
    
    public function test_user_can_edit_team_meta_field()
    {
        // Maak een gebruiker met team aan
        $user = $this->createUserWithTeam();
        
        // Maak een meta veld aan voor het team
        $metaField = TeamMetaField::create([
            'team_id' => $user->currentTeam->id,
            'name' => 'Shop Visits',
            'key' => 'shop_visited',
            'type' => 'counter',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Maak een request naar de edit pagina
        $response = $this->actingAs($user)
            ->get('/' . app()->getLocale() . '/crm/team-meta-fields/' . $metaField->id . '/edit');
        
        // Controleer of de pagina succesvol geladen wordt
        $response->assertStatus(200);
        
        // Controleer of de huidige waarden op de pagina staan
        $response->assertSee('Shop Visits');
        
        // Maak een PUT request om het meta veld bij te werken
        $response = $this->actingAs($user)
            ->put('/' . app()->getLocale() . '/crm/team-meta-fields/' . $metaField->id, [
                'name' => 'Store Visits',
                'description' => 'Aantal keer dat de klant de store heeft bezocht',
                'is_active' => true,
            ]);
        
        // Controleer of we worden doorgestuurd naar de index pagina
        $response->assertRedirect('/' . app()->getLocale() . '/crm/team-meta-fields');
        
        // Controleer of het meta veld is bijgewerkt in de database
        $this->assertDatabaseHas('crm_team_meta_fields', [
            'id' => $metaField->id,
            'name' => 'Store Visits',
            'description' => 'Aantal keer dat de klant de store heeft bezocht',
        ]);
    }
    
    public function test_user_can_delete_team_meta_field()
    {
        // Maak een gebruiker met team aan
        $user = $this->createUserWithTeam();
        
        // Maak een meta veld aan voor het team
        $metaField = TeamMetaField::create([
            'team_id' => $user->currentTeam->id,
            'name' => 'Shop Visits',
            'key' => 'shop_visited',
            'type' => 'counter',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Maak een DELETE request om het meta veld te verwijderen
        $response = $this->actingAs($user)
            ->delete('/' . app()->getLocale() . '/crm/team-meta-fields/' . $metaField->id);
        
        // Controleer of we worden doorgestuurd naar de index pagina
        $response->assertRedirect('/' . app()->getLocale() . '/crm/team-meta-fields');
        
        // Controleer of het meta veld is verwijderd uit de database
        $this->assertDatabaseMissing('crm_team_meta_fields', [
            'id' => $metaField->id,
        ]);
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
