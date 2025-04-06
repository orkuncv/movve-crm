<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_is_redirected_to_login_with_locale()
    {
        // Maak een verzoek naar een beveiligde pagina zonder ingelogd te zijn
        $response = $this->get('/en/crm/contacts');
        
        // Log de response status en redirect URL
        \Illuminate\Support\Facades\Log::info('Auth redirect test', [
            'status' => $response->status(),
            'redirect_url' => $response->headers->get('Location'),
        ]);
        
        // Controleer of de gebruiker wordt doorverwezen naar de login pagina met de juiste locale
        $response->assertStatus(302);
        $response->assertRedirect('/en/login');
    }
}
