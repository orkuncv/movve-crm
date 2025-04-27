<?php

declare(strict_types=1);

namespace Movve\Crm\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use Movve\Crm\Models\Service;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function edit_route_returns_ok_for_existing_service()
    {
        $user = User::factory()->create();
        $team = Team::factory()->create();
        $user->teams()->attach($team);
        $user->current_team_id = $team->id;
        $user->save();
        $this->actingAs($user);

        $service = Service::create([
            'team_id' => $team->id,
            'name' => 'Test Service',
        ]);

        $response = $this->get("/tr/crm/services/{$service->id}/edit");
        $this->assertNotEquals(404, $response->status(), 'Edit route returned 404');
        $response->assertStatus(200);
    }
}
