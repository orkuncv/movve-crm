<?php

namespace Movve\Crm\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Zorg ervoor dat de beschikbare locales correct zijn ingesteld
        Config::set('app.available_locales', [
            'en' => 'English',
            'nl' => 'Nederlands',
            'tr' => 'Türkçe',
            'ru' => 'Русский',
        ]);
    }

    /** @test */
    public function it_sets_the_locale_from_the_url()
    {
        // Maak een gebruiker aan
        $user = User::factory()->withPersonalTeam()->create();

        // Controleer de standaard locale (Engels)
        $response = $this->actingAs($user)
            ->get('/en/crm/debug');
            
        $response->assertStatus(200);
        $response->assertSee('Current locale: en');
        $this->assertEquals('en', App::getLocale());

        // Controleer de Nederlandse locale
        $response = $this->actingAs($user)
            ->get('/nl/crm/debug');
            
        $response->assertStatus(200);
        $response->assertSee('Current locale: nl');
        $this->assertEquals('nl', App::getLocale());

        // Controleer de Turkse locale
        $response = $this->actingAs($user)
            ->get('/tr/crm/debug');
            
        $response->assertStatus(200);
        $response->assertSee('Current locale: tr');
        $this->assertEquals('tr', App::getLocale());

        // Controleer de Russische locale
        $response = $this->actingAs($user)
            ->get('/ru/crm/debug');
            
        $response->assertStatus(200);
        $response->assertSee('Current locale: ru');
        $this->assertEquals('ru', App::getLocale());
    }

    /** @test */
    public function it_remembers_the_locale_in_the_session()
    {
        // Maak een gebruiker aan
        $user = User::factory()->withPersonalTeam()->create();

        // Bezoek een pagina met Nederlandse locale
        $response = $this->actingAs($user)
            ->get('/nl/crm/debug');
            
        $response->assertStatus(200);
        $response->assertSee('Current locale: nl');
        
        // Controleer of de locale in de sessie is opgeslagen
        $this->assertEquals('nl', session('locale'));
    }
}
