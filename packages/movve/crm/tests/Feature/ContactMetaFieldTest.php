<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactMeta;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class ContactMetaFieldTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_team_meta_field()
    {
        // Maak een gebruiker met team aan
        $user = $this->createUserWithTeam();
        
        // Authenticeer de gebruiker
        $this->actingAs($user);
        
        // Maak een meta veld direct aan via het model om te testen of de database werkt
        $directField = TeamMetaField::create([
            'team_id' => $user->currentTeam->id,
            'name' => 'Direct Field',
            'key' => 'direct_field',
            'type' => 'count',
            'description' => 'Aangemaakt via het model',
            'is_active' => true,
        ]);
        
        // Controleer of het direct aangemaakte veld bestaat
        $this->assertDatabaseHas('crm_team_meta_fields', [
            'team_id' => $user->currentTeam->id,
            'name' => 'Direct Field',
            'key' => 'direct_field',
        ]);
        
        // Nu proberen we een veld aan te maken via de controller
        // Gebruik withoutMiddleware om CSRF bescherming te omzeilen in de test
        $response = $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
            ->post('/' . app()->getLocale() . '/crm/team-meta-fields', [
                'team_id' => $user->currentTeam->id,
                'name' => 'Shop Visits',
                'type' => 'count',
                'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            ]);
        
        // Log de response status en content voor debugging
        \Illuminate\Support\Facades\Log::info('Response status: ' . $response->status());
        \Illuminate\Support\Facades\Log::info('Response content: ' . $response->content());
        
        // Controleer of het meta veld is aangemaakt
        $this->assertDatabaseHas('crm_team_meta_fields', [
            'team_id' => $user->currentTeam->id,
            'name' => 'Shop Visits',
        ]);
    }
    
    public function test_can_increment_contact_meta_counter()
    {
        // Maak een gebruiker met team aan
        $user = $this->createUserWithTeam();
        
        // Authenticeer de gebruiker
        $this->actingAs($user);
        
        // Maak een contact aan
        $contact = Contact::create([
            'team_id' => $user->currentTeam->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '0612345678',
        ]);
        
        // Maak een meta veld aan
        $metaField = TeamMetaField::create([
            'team_id' => $user->currentTeam->id,
            'name' => 'Shop Visits',
            'key' => 'shop_visited',
            'type' => 'count',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Test de test route voor het incrementeren van een meta waarde
        $response = $this->get('/' . app()->getLocale() . '/crm/test/increment-meta/' . $contact->id . '/shop_visited');
        
        // Controleer of de meta waarde is geïncrementeerd
        $meta = $contact->getMeta('shop_visited');
        $this->assertNotNull($meta);
        $this->assertEquals(1, $meta->counter);
        
        // Incrementeer nog een keer
        $response = $this->get('/' . app()->getLocale() . '/crm/test/increment-meta/' . $contact->id . '/shop_visited');
        
        // Controleer of de meta waarde is geïncrementeerd
        $meta = $contact->fresh()->getMeta('shop_visited');
        $this->assertNotNull($meta);
        $this->assertEquals(2, $meta->counter);
    }
    
    public function test_contact_meta_values_are_stored_correctly()
    {
        // Maak een gebruiker met team aan
        $user = $this->createUserWithTeam();
        
        // Authenticeer de gebruiker
        $this->actingAs($user);
        
        // Maak een contact aan
        $contact = Contact::create([
            'team_id' => $user->currentTeam->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '0612345678',
        ]);
        
        // Maak een meta veld aan
        $metaField = TeamMetaField::create([
            'team_id' => $user->currentTeam->id,
            'name' => 'Shop Visits',
            'key' => 'shop_visited',
            'type' => 'count',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Maak een meta waarde aan
        $meta = ContactMeta::create([
            'contact_id' => $contact->id,
            'team_meta_field_id' => $metaField->id,
            'counter' => 5,
        ]);
        
        // Controleer of de meta waarde correct is opgeslagen
        $this->assertDatabaseHas('crm_contacts_meta', [
            'contact_id' => $contact->id,
            'team_meta_field_id' => $metaField->id,
            'counter' => 5,
        ]);
        
        // Controleer of de meta waarde correct wordt opgehaald
        $retrievedMeta = $contact->getMeta('shop_visited');
        $this->assertNotNull($retrievedMeta);
        $this->assertEquals(5, $retrievedMeta->counter);
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
