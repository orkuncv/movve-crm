<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Movve\Crm\Models\Contact;

class CrmApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Maak een testgebruiker aan
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_list_contacts()
    {
        // Maak enkele testcontacten aan
        Contact::factory()->count(5)->create();

        // Test de API endpoint voor het ophalen van contacten
        $response = $this->actingAs($this->user)
            ->getJson('/api/contacts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'phone_number',
                        'date_of_birth',
                        'created_at',
                        'updated_at'
                    ]
                ],
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function it_can_create_a_contact()
    {
        $contactData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->date()
        ];

        $response = $this->actingAs($this->user)
            ->postJson('/api/contacts', $contactData);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'first_name' => $contactData['first_name'],
                'last_name' => $contactData['last_name'],
                'email' => $contactData['email']
            ]);

        $this->assertDatabaseHas('contacts', [
            'email' => $contactData['email']
        ]);
    }

    /** @test */
    public function it_can_show_a_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)
            ->getJson("/api/contacts/{$contact->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $contact->id,
                    'first_name' => $contact->first_name,
                    'last_name' => $contact->last_name,
                    'email' => $contact->email
                ]
            ]);
    }

    /** @test */
    public function it_can_update_a_contact()
    {
        $contact = Contact::factory()->create();
        
        $updatedData = [
            'first_name' => 'Updated',
            'last_name' => 'Name',
            'email' => 'updated@example.com'
        ];

        $response = $this->actingAs($this->user)
            ->putJson("/api/contacts/{$contact->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'first_name' => 'Updated',
                'last_name' => 'Name',
                'email' => 'updated@example.com'
            ]);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'email' => 'updated@example.com'
        ]);
    }

    /** @test */
    public function it_can_delete_a_contact()
    {
        $contact = Contact::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson("/api/contacts/{$contact->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id
        ]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_a_contact()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/contacts', [
                // Ontbrekende verplichte velden
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'email']);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $response = $this->actingAs($this->user)
            ->postJson('/api/contacts', [
                'first_name' => 'Test',
                'last_name' => 'User',
                'email' => 'not-an-email'
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_handles_localization_in_api_responses()
    {
        // Test of de API correct reageert op verschillende taalinstellingen
        $contact = Contact::factory()->create();

        // Test met Nederlandse taalinstelling
        $response = $this->actingAs($this->user)
            ->withHeaders(['Accept-Language' => 'nl'])
            ->getJson("/api/contacts/{$contact->id}");

        $response->assertStatus(200);
        
        // Test met Engelse taalinstelling
        $response = $this->actingAs($this->user)
            ->withHeaders(['Accept-Language' => 'en'])
            ->getJson("/api/contacts/{$contact->id}");

        $response->assertStatus(200);
    }
}
