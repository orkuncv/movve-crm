<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactMeta;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class ContactMetaTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_meta_can_be_created()
    {
        // Maak een team aan
        $user = $this->createUserWithTeam();
        
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
            'type' => 'counter',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Maak een meta waarde aan
        $meta = ContactMeta::create([
            'contact_id' => $contact->id,
            'team_meta_field_id' => $metaField->id,
            'value' => null,
            'counter' => 5,
        ]);
        
        // Controleer of de meta waarde correct is aangemaakt
        $this->assertDatabaseHas('crm_contacts_meta', [
            'contact_id' => $contact->id,
            'team_meta_field_id' => $metaField->id,
            'counter' => 5,
        ]);
    }
    
    public function test_contact_can_get_meta_by_key()
    {
        // Maak een team aan
        $user = $this->createUserWithTeam();
        
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
            'type' => 'counter',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Maak een meta waarde aan
        ContactMeta::create([
            'contact_id' => $contact->id,
            'team_meta_field_id' => $metaField->id,
            'value' => null,
            'counter' => 5,
        ]);
        
        // Test de getMeta methode
        $meta = $contact->getMeta('shop_visited');
        $this->assertNotNull($meta);
        $this->assertEquals(5, $meta->counter);
    }
    
    public function test_contact_can_get_or_create_meta()
    {
        // Maak een team aan
        $user = $this->createUserWithTeam();
        
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
            'type' => 'counter',
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
            'is_active' => true,
        ]);
        
        // Test getOrCreateMeta voor een niet-bestaande meta waarde
        $meta = $contact->getOrCreateMeta($metaField);
        $this->assertNotNull($meta);
        $this->assertEquals(0, $meta->counter);
        
        // Controleer of de meta waarde in de database is aangemaakt
        $this->assertDatabaseHas('crm_contacts_meta', [
            'contact_id' => $contact->id,
            'team_meta_field_id' => $metaField->id,
            'counter' => 0,
        ]);
        
        // Verhoog de counter
        $meta->incrementCounter(3);
        
        // Test getOrCreateMeta voor een bestaande meta waarde
        $meta = $contact->getOrCreateMeta($metaField);
        $this->assertEquals(3, $meta->counter);
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
