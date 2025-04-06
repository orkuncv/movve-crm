<?php

namespace Movve\Crm\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Jetstream\Jetstream;
use Movve\Crm\Models\Contact;
use Tests\TestCase;

class ContactUpdateDebugTest extends TestCase
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

        // Log in als de gebruiker
        Auth::login($this->user);
    }

    /** @test */
    public function it_can_update_contact_via_controller()
    {
        Log::info('Start test: it_can_update_contact_via_controller');
        
        // Bereid de update data voor
        $updateData = [
            'first_name' => 'Updated',
            'last_name' => 'Name',
            'email' => 'updated@example.com',
            'phone_number' => '123456789',
            'date_of_birth' => '1990-01-01',
        ];
        
        // Stuur een PUT verzoek naar de update route
        $response = $this->put('/'.app()->getLocale().'/crm/contacts/'.$this->contact->id, $updateData);
        
        // Log de response status en inhoud voor debugging
        Log::info('Update response', [
            'status' => $response->status(),
            'content' => $response->content(),
        ]);
        
        // Controleer of de redirect correct is
        $response->assertRedirect('/'.app()->getLocale().'/crm/contacts/'.$this->contact->id);
        
        // Ververs het contact uit de database
        $this->contact->refresh();
        
        // Log de contact gegevens na update
        Log::info('Contact na update', [
            'contact' => $this->contact->toArray(),
        ]);
        
        // Controleer of de gegevens zijn bijgewerkt
        $this->assertEquals('Updated', $this->contact->first_name);
        $this->assertEquals('Name', $this->contact->last_name);
        $this->assertEquals('updated@example.com', $this->contact->email);
        $this->assertEquals('123456789', $this->contact->phone_number);
        $this->assertEquals('1990-01-01', $this->contact->date_of_birth->format('Y-m-d'));
    }

    /** @test */
    public function it_can_view_edit_form()
    {
        Log::info('Start test: it_can_view_edit_form');
        
        // Bezoek de edit pagina
        $response = $this->get('/'.app()->getLocale().'/crm/contacts/'.$this->contact->id.'/edit');
        
        // Log de response status en inhoud voor debugging
        Log::info('Edit page response', [
            'status' => $response->status(),
            'content' => substr($response->content(), 0, 500), // Eerste 500 karakters
        ]);
        
        // Controleer of de pagina succesvol wordt geladen
        $response->assertStatus(200);
        
        // Controleer of het formulier aanwezig is
        $response->assertSee('method="POST"');
        $response->assertSee('@method(\'PUT\')');
        $response->assertSee('action="/'.app()->getLocale().'/crm/contacts/'.$this->contact->id.'"');
    }

    /** @test */
    public function it_logs_form_submission_details()
    {
        Log::info('Start test: it_logs_form_submission_details');
        
        // Bereid de update data voor
        $updateData = [
            'first_name' => 'Debug',
            'last_name' => 'Test',
            'email' => 'debug@example.com',
            'phone_number' => '987654321',
            'date_of_birth' => '1995-05-05',
        ];
        
        // Log de request details
        Log::info('Update request details', [
            'method' => 'PUT',
            'url' => '/'.app()->getLocale().'/crm/contacts/'.$this->contact->id,
            'data' => $updateData,
            'contact_id' => $this->contact->id,
        ]);
        
        // Stuur een PUT verzoek naar de update route met debug headers
        $response = $this->withHeaders([
            'X-Debug-Test' => 'true',
        ])->put('/'.app()->getLocale().'/crm/contacts/'.$this->contact->id, $updateData);
        
        // Log de volledige response voor debugging
        Log::info('Complete update response', [
            'status' => $response->status(),
            'headers' => $response->headers->all(),
            'content' => $response->content(),
        ]);
    }
}
