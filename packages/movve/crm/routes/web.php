<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Movve\Crm\Http\Controllers\ContactViewController;
use Movve\Crm\Http\Controllers\TeamMetaFieldController;
use Movve\Crm\Http\Controllers\TestController;
use Movve\Crm\Http\Controllers\TimetableController;

Route::group([
    'prefix' => '{locale}/crm',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => ['web', 'crm.auth', 'crm.locale']
], function () {
    // Debug route
    Route::get('/debug', function() {
        return 'CRM routes loaded. Current locale: ' . app()->getLocale();
    });
    
    // Verwijder test routes en ongebruikte routes

    // Contact routes - let op de volgorde is belangrijk!
    Route::get('/contacts', [ContactViewController::class, 'index'])->name('crm.contacts.index');
    Route::get('/contacts/create', [ContactViewController::class, 'create'])->name('crm.contacts.create');
    Route::post('/contacts', [ContactViewController::class, 'store'])->name('crm.contacts.store');
    
    // Specifieke routes voor show, edit en update met id parameter
    // Zorg ervoor dat de show route vóór de edit route komt (belangrijk voor route matching)
    Route::get('/contacts/{id}', [ContactViewController::class, 'show'])->name('crm.contacts.show')->where('id', '[0-9]+');
    Route::get('/contacts/{id}/edit', [ContactViewController::class, 'edit'])->name('crm.contacts.edit')->where('id', '[0-9]+');
    
    // Accepteer zowel PUT als POST requests voor updates (sommige browsers ondersteunen geen PUT)
    Route::match(['put', 'post'], '/contacts/{id}', [ContactViewController::class, 'update'])->name('crm.contacts.update')->where('id', '[0-9]+');
    
    // Team Meta Fields routes - alleen de essentiële routes behouden
    Route::post('/team-meta-fields', [TeamMetaFieldController::class, 'store'])->name('crm.team-meta-fields.store');
    Route::delete('/team-meta-fields/{id}', [TeamMetaFieldController::class, 'destroy'])->name('crm.team-meta-fields.destroy')->where('id', '[0-9]+');
    // Alternatieve route voor verwijderen via GET methode (voor directe links)
    Route::get('/team-meta-fields/{id}/delete', [TeamMetaFieldController::class, 'destroy'])->name('crm.team-meta-fields.delete')->where('id', '[0-9]+');
    
    // Test route voor het aanmaken van een meta veld
    Route::get('/test/create-meta-field', function () {
        $team = auth()->user()->currentTeam;
        $metaField = \Movve\Crm\Models\TeamMetaField::create([
            'team_id' => $team->id,
            'name' => 'Shop Visited',
            'key' => 'shop_visited',
            'type' => 'counter',
            'is_active' => true,
            'description' => 'Aantal keer dat de klant de winkel heeft bezocht',
        ]);
        return redirect()->back()->with('success', 'Test meta veld aangemaakt: ' . $metaField->name);
    });
    

    
    // Test routes voor het bijwerken van contacten
    Route::get('/test/edit-contact/{id}', function ($locale, $id) {
        $contact = \Movve\Crm\Models\Contact::findOrFail($id);
        
        // Controleer of het contact behoort tot het huidige team
        if ($contact->team_id != auth()->user()->currentTeam->id) {
            return redirect()
                ->to('/' . app()->getLocale() . '/crm/contacts')
                ->with('error', 'Je hebt geen toegang tot dit contact');
        }
        
        return view('crm::contacts.test-form', compact('contact'));
    });
    
    Route::post('/test/update-contact/{id}', function ($locale, $id, \Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Log::info('Test update contact route aangeroepen', [
            'id' => $id,
            'request_data' => $request->all(),
        ]);
        
        try {
            $contact = \Movve\Crm\Models\Contact::findOrFail($id);
            
            // Controleer of het contact behoort tot het huidige team
            if ($contact->team_id != auth()->user()->currentTeam->id) {
                return redirect()
                    ->to('/' . app()->getLocale() . '/crm/contacts')
                    ->with('error', 'Je hebt geen toegang tot dit contact');
            }
            
            $validated = $request->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'phone_number' => ['nullable', 'string', 'max:255'],
                'date_of_birth' => ['nullable', 'date'],
            ]);
            
            // Sla de oude waarden op, maar voeg ze NIET toe aan de $validated array
            $oldValues = $contact->getAttributes();
            
            // Log de gevalideerde data
            \Illuminate\Support\Facades\Log::info('Gevalideerde data voor update', [
                'contact_id' => $id,
                'validated_data' => $validated,
            ]);
            
            // Update het contact met alleen de gevalideerde velden
            $result = $contact->update($validated);
            
            \Illuminate\Support\Facades\Log::info('Test update contact resultaat', [
                'contact_id' => $id,
                'update_result' => $result ? 'success' : 'failed',
                'old_values' => $oldValues,
                'new_values' => $contact->getAttributes(),
            ]);
            
            if ($result) {
                return redirect()
                    ->to('/' . app()->getLocale() . '/crm/contacts/' . $contact->id)
                    ->with('success', 'Contact bijgewerkt via test route');
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Fout bij het bijwerken van het contact');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Exception in test update contact route:', [
                'id' => $id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Fout bij het bijwerken van het contact: ' . $e->getMessage());
        }
    });
    
    // Test route voor het incrementeren van een contact meta waarde
    Route::get('/test/increment-meta/{contact_id}/{meta_key}', function ($locale, $contact_id, $meta_key) {
        \Illuminate\Support\Facades\Log::info('Increment meta route aangeroepen', [
            'contact_id' => $contact_id,
            'meta_key' => $meta_key
        ]);
        
        try {
            $contact = \Movve\Crm\Models\Contact::findOrFail($contact_id);
            $metaField = \Movve\Crm\Models\TeamMetaField::where('team_id', auth()->user()->currentTeam->id)
                ->where('key', $meta_key)
                ->whereIn('type', ['count', 'counter'])
                ->where('is_active', true)
                ->firstOrFail();
                
            $meta = $contact->getOrCreateMeta($metaField);
            $meta->incrementCounter();
            
            \Illuminate\Support\Facades\Log::info('Meta counter geïncrementeerd', [
                'contact_id' => $contact_id,
                'meta_key' => $meta_key,
                'new_value' => $meta->counter
            ]);
            
            // Return JSON response voor de AJAX call
            return response()->json([
                'success' => true,
                'counter' => $meta->counter,
                'message' => 'Meta waarde geïncrementeerd'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Fout bij incrementeren meta counter', [
                'error' => $e->getMessage(),
                'contact_id' => $contact_id,
                'meta_key' => $meta_key
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Fout bij incrementeren meta counter: ' . $e->getMessage()
            ], 500);
        }
    });
    
    // Timetable route
    Route::get('/timetable', [TimetableController::class, 'index'])->name('crm.timetable.index');

});

// Fallback redirect voor niet-gelokaliseerde routes
Route::get('/crm/{any}', function () {
    return redirect('/' . app()->getLocale() . '/crm/' . request()->path());
})->where('any', '.*');
