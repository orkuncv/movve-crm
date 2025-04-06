<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Movve\Crm\Http\Livewire\ContactMetaCounter;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactMeta;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class ContactMetaCounterTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_meta_counter_component_can_increment()
    {
        // Maak een gebruiker met team aan
        $user = \App\Models\User::factory()->withPersonalTeam()->create();
        
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
        
        // Test de Livewire component
        Livewire::test(ContactMetaCounter::class, ['contact' => $contact, 'metaKey' => 'shop_visited'])
            ->assertSet('counter', 0)
            ->call('increment')
            ->assertSet('counter', 1)
            ->call('increment')
            ->assertSet('counter', 2);
            
        // Controleer of de waarde in de database is bijgewerkt
        $meta = $contact->getMeta('shop_visited');
        $this->assertNotNull($meta);
        $this->assertEquals(2, $meta->counter);
    }
    
    public function test_contact_meta_counter_shows_correct_value()
    {
        // Maak een gebruiker met team aan
        $user = \App\Models\User::factory()->withPersonalTeam()->create();
        
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
        
        // Maak een meta waarde aan met een initiële counter waarde
        $meta = ContactMeta::create([
            'contact_id' => $contact->id,
            'team_meta_field_id' => $metaField->id,
            'counter' => 5,
        ]);
        
        // Test of de Livewire component de juiste waarde toont
        Livewire::test(ContactMetaCounter::class, ['contact' => $contact, 'metaKey' => 'shop_visited'])
            ->assertSet('counter', 5)
            ->assertSee('Shop Visits')
            ->assertSee('5');
    }
}
