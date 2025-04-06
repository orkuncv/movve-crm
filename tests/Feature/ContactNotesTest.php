<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactMeta;
use Movve\Crm\Models\TeamMetaField;
use Movve\Crm\Http\Livewire\ContactNotesEditor;
use Tests\TestCase;

class ContactNotesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

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
     * Test of het notities veld correct wordt toegevoegd aan een team.
     */
    public function test_notes_field_is_added_to_team(): void
    {
        // Controleer of het notities veld bestaat
        $this->assertDatabaseHas('crm_team_meta_fields', [
            'team_id' => $this->team->id,
            'key' => 'notes',
            'name' => 'Notities',
        ]);
    }

    /**
     * Test of de notities component correct wordt weergegeven.
     */
    public function test_notes_component_is_rendered_on_contact_page(): void
    {
        // Authenticeer de gebruiker
        $this->actingAs($this->user);

        // Bezoek de contactpagina
        $response = $this->get('/' . app()->getLocale() . '/crm/contacts/' . $this->contact->id);

        // Controleer of de pagina succesvol wordt geladen
        $response->assertStatus(200);

        // Controleer of de notities sectie aanwezig is
        $response->assertSee('Notities');
    }

    /**
     * Test of notities kunnen worden opgeslagen en opgehaald.
     */
    public function test_notes_can_be_saved_and_retrieved(): void
    {
        // Authenticeer de gebruiker
        $this->actingAs($this->user);

        // Genereer wat testnotities
        $testNotes = '<p>Dit zijn testnotities voor ' . $this->contact->full_name . '</p>';

        // Test de Livewire component
        Livewire::test(ContactNotesEditor::class, ['contact' => $this->contact])
            ->set('notes', $testNotes)
            ->call('saveNotes')
            ->assertHasNoErrors();

        // Controleer of de notities zijn opgeslagen in de database
        $this->assertDatabaseHas('crm_contacts_meta', [
            'contact_id' => $this->contact->id,
            'team_meta_field_id' => $this->notesField->id,
            'value' => $testNotes,
        ]);

        // Laad de component opnieuw en controleer of de notities correct worden geladen
        Livewire::test(ContactNotesEditor::class, ['contact' => $this->contact])
            ->assertSet('notes', $testNotes);
    }

    /**
     * Test of notities kunnen worden bijgewerkt.
     */
    public function test_notes_can_be_updated(): void
    {
        // Authenticeer de gebruiker
        $this->actingAs($this->user);

        // Maak eerst een notitie aan via de getOrCreateMeta methode
        $initialNotes = '<p>Initiële notities</p>';
        $meta = $this->contact->getOrCreateMeta($this->notesField);
        $meta->value = $initialNotes;
        $meta->save();

        // Update de notities
        $updatedNotes = '<p>Bijgewerkte notities</p>';
        Livewire::test(ContactNotesEditor::class, ['contact' => $this->contact])
            ->assertSet('notes', $initialNotes)
            ->set('notes', $updatedNotes)
            ->call('saveNotes');

        // Controleer of de notities zijn bijgewerkt in de database
        $this->assertDatabaseHas('crm_contacts_meta', [
            'contact_id' => $this->contact->id,
            'team_meta_field_id' => $this->notesField->id,
            'value' => $updatedNotes,
        ]);
    }
}
