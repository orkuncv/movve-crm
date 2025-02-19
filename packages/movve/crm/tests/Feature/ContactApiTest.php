<?php

namespace Movve\Crm\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Movve\Crm\Models\Contact;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_contacts(): void
    {
        Contact::factory()->count(3)->create();

        $response = $this->getJson('/api/crm/contacts');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_can_search_contacts(): void
    {
        Contact::factory()->create(['first_name' => 'John']);
        Contact::factory()->create(['first_name' => 'Jane']);

        $response = $this->getJson('/api/crm/contacts?search=John');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_can_create_contact(): void
    {
        $contactData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone_number' => '1234567890',
            'date_of_birth' => '1990-01-01',
        ];

        $response = $this->postJson('/api/crm/contacts', $contactData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Contact created successfully',
                'data' => $contactData,
            ]);

        $this->assertDatabaseHas('crm_contacts', $contactData);
    }

    public function test_cannot_create_contact_with_duplicate_email(): void
    {
        Contact::factory()->create(['email' => 'john@example.com']);

        $response = $this->postJson('/api/crm/contacts', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_can_show_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->getJson("/api/crm/contacts/{$contact->id}");

        $response->assertStatus(200)
            ->assertJson(['id' => $contact->id]);
    }

    public function test_can_update_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->putJson("/api/crm/contacts/{$contact->id}", [
            'first_name' => 'Updated Name',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Contact updated successfully',
                'data' => ['first_name' => 'Updated Name'],
            ]);

        $this->assertDatabaseHas('crm_contacts', [
            'id' => $contact->id,
            'first_name' => 'Updated Name',
        ]);
    }

    public function test_can_delete_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->deleteJson("/api/crm/contacts/{$contact->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Contact deleted successfully']);

        $this->assertSoftDeleted('crm_contacts', ['id' => $contact->id]);
    }

    public function test_can_restore_contact(): void
    {
        $contact = Contact::factory()->create();
        $contact->delete();

        $response = $this->postJson("/api/crm/contacts/{$contact->id}/restore");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Contact restored successfully']);

        $this->assertDatabaseHas('crm_contacts', ['id' => $contact->id]);
    }
}
