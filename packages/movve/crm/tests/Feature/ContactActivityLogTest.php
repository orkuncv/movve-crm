<?php

namespace Movve\Crm\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Jetstream;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactActivity;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class ContactActivityLogTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $team;
    protected $contact;

    public function setUp(): void
    {
        parent::setUp();

        // Maak een gebruiker aan
        $this->user = User::factory()->withPersonalTeam()->create();
        $this->team = $this->user->currentTeam;

        // Maak een contact aan
        $this->contact = Contact::create([
            'team_id' => $this->team->id,
            'first_name' => 'Test',
            'last_name' => 'Contact',
            'email' => 'test@example.com',
        ]);

        // Maak een meta veld aan voor bezoeken
        TeamMetaField::create([
            'team_id' => $this->team->id,
            'name' => 'Bezoeken',
            'key' => 'visits',
            'type' => 'counter',
            'is_active' => true,
        ]);

        // Log in als de gebruiker
        Auth::login($this->user);
    }

    /** @test */
    public function it_logs_activity_when_contact_is_created()
    {
        // Maak een nieuw contact aan
        $contact = Contact::create([
            'team_id' => $this->team->id,
            'first_name' => 'New',
            'last_name' => 'Contact',
            'email' => 'new@example.com',
        ]);

        // Controleer of er een activiteit is gelogd
        $activity = ContactActivity::where('contact_id', $contact->id)
            ->where('action', 'created')
            ->first();

        $this->assertNotNull($activity);
        $this->assertEquals($this->user->id, $activity->user_id);
        $this->assertEquals('created', $activity->action);
        $this->assertEquals('Contact aangemaakt', $activity->description);
    }

    /** @test */
    public function it_logs_activity_when_contact_is_updated()
    {
        // Update het contact
        $this->contact->update([
            'first_name' => 'Updated',
            'email' => 'updated@example.com',
        ]);

        // Controleer of er een activiteit is gelogd
        $activity = ContactActivity::where('contact_id', $this->contact->id)
            ->where('action', 'updated')
            ->first();

        $this->assertNotNull($activity);
        $this->assertEquals($this->user->id, $activity->user_id);
        $this->assertEquals('updated', $activity->action);
        $this->assertEquals('Contact bijgewerkt', $activity->description);
        
        // Controleer of de gewijzigde velden zijn opgeslagen
        $changes = json_decode($activity->properties, true);
        $this->assertArrayHasKey('first_name', $changes);
        $this->assertEquals('Test', $changes['first_name']['old']);
        $this->assertEquals('Updated', $changes['first_name']['new']);
        $this->assertArrayHasKey('email', $changes);
        $this->assertEquals('test@example.com', $changes['email']['old']);
        $this->assertEquals('updated@example.com', $changes['email']['new']);
    }

    /** @test */
    public function it_logs_activity_when_counter_is_incremented()
    {
        // Haal het meta veld op
        $metaField = TeamMetaField::where('team_id', $this->team->id)
            ->where('key', 'visits')
            ->first();

        // Maak een meta record aan voor het contact
        $meta = $this->contact->getOrCreateMeta($metaField);
        $meta->counter = 0;
        $meta->save();

        // Verhoog de teller
        $meta->counter += 1;
        $meta->save();

        // Controleer of er een activiteit is gelogd
        $activity = ContactActivity::where('contact_id', $this->contact->id)
            ->where('action', 'counter_incremented')
            ->first();

        $this->assertNotNull($activity);
        $this->assertEquals($this->user->id, $activity->user_id);
        $this->assertEquals('counter_incremented', $activity->action);
        $this->assertEquals('Bezoeken +1', $activity->description);
        
        // Controleer of de wijziging is opgeslagen
        $changes = json_decode($activity->properties, true);
        $this->assertArrayHasKey('counter', $changes);
        $this->assertEquals(0, $changes['counter']['old']);
        $this->assertEquals(1, $changes['counter']['new']);
        $this->assertEquals('visits', $changes['meta_key']);
    }

    /** @test */
    public function it_logs_activity_when_note_is_added()
    {
        // Maak een notitie aan voor het contact
        $note = $this->contact->notes()->create([
            'team_id' => $this->team->id,
            'title' => 'Test Notitie',
            'content' => 'Dit is een test notitie',
        ]);

        // Controleer of er een activiteit is gelogd
        $activity = ContactActivity::where('contact_id', $this->contact->id)
            ->where('action', 'note_added')
            ->first();

        $this->assertNotNull($activity);
        $this->assertEquals($this->user->id, $activity->user_id);
        $this->assertEquals('note_added', $activity->action);
        $this->assertEquals('Notitie toegevoegd: Test Notitie', $activity->description);
        
        // Controleer of de notitie ID is opgeslagen
        $properties = json_decode($activity->properties, true);
        $this->assertEquals($note->id, $properties['note_id']);
    }

    /** @test */
    public function it_shows_activity_log_on_contact_page()
    {
        // Maak wat activiteiten aan
        ContactActivity::create([
            'team_id' => $this->team->id,
            'contact_id' => $this->contact->id,
            'user_id' => $this->user->id,
            'action' => 'created',
            'description' => 'Contact aangemaakt',
            'properties' => json_encode([]),
        ]);

        ContactActivity::create([
            'team_id' => $this->team->id,
            'contact_id' => $this->contact->id,
            'user_id' => $this->user->id,
            'action' => 'updated',
            'description' => 'Contact bijgewerkt',
            'properties' => json_encode(['first_name' => ['old' => 'Old', 'new' => 'New']]),
        ]);

        // Bezoek de contact pagina
        $response = $this->get('/'.app()->getLocale().'/crm/contacts/'.$this->contact->id);

        // Controleer of de activiteiten worden getoond
        $response->assertStatus(200);
        $response->assertSee('Contact aangemaakt');
        $response->assertSee('Contact bijgewerkt');
    }
}
