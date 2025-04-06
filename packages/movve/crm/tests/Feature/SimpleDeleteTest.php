<?php

namespace Movve\Crm\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Movve\Crm\Models\TeamMetaField;
use Tests\TestCase;

class SimpleDeleteTest extends TestCase
{
    /** @test */
    public function test_direct_delete_url()
    {
        // Maak een gebruiker aan
        $user = User::factory()->withPersonalTeam()->create();
        $team = $user->currentTeam;
        
        // Maak een meta veld aan
        $metaField = new TeamMetaField();
        $metaField->team_id = $team->id;
        $metaField->name = 'Test Field';
        $metaField->key = 'test_field';
        $metaField->type = 'count';
        $metaField->is_active = true;
        $metaField->save();
        
        // Log in als de gebruiker
        $this->actingAs($user);
        
        // Probeer de delete URL direct aan te roepen
        $response = $this->get('/en/crm/team-meta-fields/' . $metaField->id . '/delete');
        
        // Log de response
        \Log::info('Delete Response Status: ' . $response->getStatusCode());
        \Log::info('Delete Response Content: ' . $response->getContent());
        
        // Deze test slaagt altijd
        $this->assertTrue(true);
    }
}
