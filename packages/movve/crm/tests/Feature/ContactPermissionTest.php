<?php

namespace Movve\Crm\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Movve\Crm\Models\Contact;
use Tests\TestCase;

class ContactPermissionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_unauthorized_user_cannot_access_crm(): void
    {
        $response = $this->getJson('/api/crm/contacts');

        $response->assertStatus(401);
    }

    public function test_user_without_crm_access_permission_cannot_access_crm(): void
    {
        Sanctum::actingAs($this->user, ['other:permission']);

        $response = $this->getJson('/api/crm/contacts');

        $response->assertStatus(403)
            ->assertJson(['message' => 'You do not have permission to access CRM functionality.']);
    }

    public function test_user_with_read_permission_can_view_contacts(): void
    {
        Sanctum::actingAs($this->user, ['crm:access', 'crm:read']);
        Contact::factory()->create();

        $response = $this->getJson('/api/crm/contacts');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_user_with_read_permission_cannot_create_contacts(): void
    {
        Sanctum::actingAs($this->user, ['crm:access', 'crm:read']);

        $response = $this->postJson('/api/crm/contacts', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(403)
            ->assertJson(['message' => 'You do not have the required permission for this action.']);
    }

    public function test_user_with_create_permission_can_create_contacts(): void
    {
        Sanctum::actingAs($this->user, ['crm:access', 'crm:create']);

        $response = $this->postJson('/api/crm/contacts', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Contact created successfully']);
    }

    public function test_user_with_update_permission_can_update_contacts(): void
    {
        Sanctum::actingAs($this->user, ['crm:access', 'crm:update']);
        $contact = Contact::factory()->create();

        $response = $this->putJson("/api/crm/contacts/{$contact->id}", [
            'first_name' => 'Updated Name',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Contact updated successfully']);
    }

    public function test_user_with_delete_permission_can_delete_contacts(): void
    {
        Sanctum::actingAs($this->user, ['crm:access', 'crm:delete']);
        $contact = Contact::factory()->create();

        $response = $this->deleteJson("/api/crm/contacts/{$contact->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Contact deleted successfully']);
    }

    public function test_user_with_restore_permission_can_restore_contacts(): void
    {
        Sanctum::actingAs($this->user, ['crm:access', 'crm:restore']);
        $contact = Contact::factory()->create();
        $contact->delete();

        $response = $this->postJson("/api/crm/contacts/{$contact->id}/restore");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Contact restored successfully']);
    }

    public function test_user_with_all_permissions_has_full_access(): void
    {
        Sanctum::actingAs($this->user, [
            'crm:access',
            'crm:read',
            'crm:create',
            'crm:update',
            'crm:delete',
            'crm:restore'
        ]);

        // Can list contacts
        $this->getJson('/api/crm/contacts')
            ->assertStatus(200);

        // Can create contact
        $response = $this->postJson('/api/crm/contacts', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
        ]);
        $response->assertStatus(201);
        $contactId = $response->json('data.id');

        // Can update contact
        $this->putJson("/api/crm/contacts/{$contactId}", [
            'first_name' => 'Updated',
        ])->assertStatus(200);

        // Can delete contact
        $this->deleteJson("/api/crm/contacts/{$contactId}")
            ->assertStatus(200);

        // Can restore contact
        $this->postJson("/api/crm/contacts/{$contactId}/restore")
            ->assertStatus(200);
    }
}
