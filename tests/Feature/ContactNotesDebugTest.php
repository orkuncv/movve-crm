<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactMeta;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class ContactNotesDebugTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Team $team;
    protected Contact $contact;
    protected TeamMetaField $notesField;

    public function setUp(): void
    {
        parent::setUp();

        // Maak een gebruiker en team aan
        $this->user = User::factory()->withPersonalTeam()->create();
        $this->team = $this->user->currentTeam;

        // Maak een contact handmatig aan
        $this->contact = new Contact([
            'team_id' => $this->team->id,
            'first_name' => 'Test',
            'last_name' => 'Contact',
            'email' => 'test@example.com',
        ]);
        $this->contact->save();

        // Zoek het bestaande notities meta veld of maak een nieuwe aan
        $this->notesField = TeamMetaField::where('team_id', $this->team->id)
            ->where('key', 'notes')
            ->first();
            
        if (!$this->notesField) {
            $this->notesField = TeamMetaField::create([
                'team_id' => $this->team->id,
                'name' => 'Notities',
                'key' => 'notes',
                'type' => 'field',
                'description' => 'Notities over deze contactpersoon',
                'is_active' => true,
            ]);
        }
    }

    /**
     * Test of notities correct worden opgeslagen en opgehaald.
     */
    public function test_notes_are_saved_and_retrieved_correctly(): void
    {
        // Authenticeer de gebruiker
        $this->actingAs($this->user);

        // Log de belangrijke IDs
        Log::info('Debug test IDs', [
            'contact_id' => $this->contact->id,
            'team_id' => $this->team->id,
            'notes_field_id' => $this->notesField->id,
        ]);

        // 1. Maak een notitie aan via getOrCreateMeta
        $testNotes = '<p>Dit zijn testnotities</p>';
        $meta = $this->contact->getOrCreateMeta($this->notesField);
        $meta->value = $testNotes;
        $meta->save();

        // Log de meta gegevens na het opslaan
        Log::info('Meta na opslaan', [
            'meta_id' => $meta->id,
            'contact_id' => $meta->contact_id,
            'team_meta_field_id' => $meta->team_meta_field_id,
            'value' => $meta->value,
        ]);

        // 2. Haal de notitie op via getMeta
        $retrievedMeta = $this->contact->getMeta('notes');
        
        // Log de opgehaalde meta gegevens
        Log::info('Opgehaalde meta', [
            'retrieved' => $retrievedMeta ? true : false,
            'meta_id' => $retrievedMeta ? $retrievedMeta->id : null,
            'contact_id' => $retrievedMeta ? $retrievedMeta->contact_id : null,
            'team_meta_field_id' => $retrievedMeta ? $retrievedMeta->team_meta_field_id : null,
            'value' => $retrievedMeta ? $retrievedMeta->value : null,
        ]);

        // Controleer of de notitie correct is opgehaald
        $this->assertNotNull($retrievedMeta, 'De notitie kon niet worden opgehaald via getMeta');
        $this->assertEquals($testNotes, $retrievedMeta->value, 'De opgehaalde notitie komt niet overeen met de opgeslagen notitie');

        // 3. Controleer of de notitie in de database staat
        $this->assertDatabaseHas('crm_contacts_meta', [
            'contact_id' => $this->contact->id,
            'team_meta_field_id' => $this->notesField->id,
            'value' => $testNotes,
        ]);
    }
}
