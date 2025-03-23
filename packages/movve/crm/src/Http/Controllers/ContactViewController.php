<?php

namespace Movve\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Jetstream;
use Movve\Crm\Models\Contact;

class ContactViewController extends Controller
{
    public function index(Request $request)
    {
        // Haal het huidige team op
        $team = Jetstream::newTeamModel()->find($request->user()->currentTeam->id);
        
        $contacts = Contact::query()
            ->where('team_id', $team->id) // Filter op team_id
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('crm::contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('crm::contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
        ]);

        // Voeg team_id toe aan de gevalideerde data
        $validated['team_id'] = $request->user()->currentTeam->id;

        Contact::create($validated);

        return redirect()
            ->route('crm.contacts.index', ['locale' => app()->getLocale()])
            ->with('success', 'Contact created successfully');
    }

    public function show($id)
    {
        try {
            // Debug informatie
            \Log::info('ContactViewController@show aangeroepen', [
                'id' => $id,
                'type' => gettype($id),
                'request_path' => request()->path(),
                'locale' => app()->getLocale()
            ]);
            
            // Controleer of de database tabel bestaat
            if (!\Schema::hasTable('crm_contacts')) {
                \Log::error('Tabel crm_contacts bestaat niet');
                return redirect()
                    ->to('/' . app()->getLocale() . '/crm/contacts')
                    ->with('error', 'Database tabel voor contacten bestaat niet');
            }
            
            // Controleer of er contacten in de database staan
            $count = Contact::count();
            \Log::info('Aantal contacten in database: ' . $count);
            
            // Probeer het contact op te halen
            $contact = Contact::find($id);
            
            if (!$contact) {
                \Log::warning('Contact niet gevonden met ID: ' . $id);
                return redirect()
                    ->to('/' . app()->getLocale() . '/crm/contacts')
                    ->with('error', 'Contact niet gevonden');
            }
            
            // Controleer of het contact behoort tot het huidige team
            if ($contact->team_id != Auth::user()->currentTeam->id) {
                \Log::warning('Contact behoort niet tot het huidige team: ' . $id);
                return redirect()
                    ->to('/' . app()->getLocale() . '/crm/contacts')
                    ->with('error', 'Je hebt geen toegang tot dit contact');
            }
            
            \Log::info('Contact gevonden', ['contact' => $contact->toArray()]);
            return view('crm::contacts.show', compact('contact'));
        } catch (\Exception $e) {
            \Log::error('Exception in show methode:', [
                'id' => $id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->to('/' . app()->getLocale() . '/crm/contacts')
                ->with('error', 'Fout bij ophalen contact: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            
            // Controleer of het contact behoort tot het huidige team
            if ($contact->team_id != Auth::user()->currentTeam->id) {
                return redirect()
                    ->to('/' . app()->getLocale() . '/crm/contacts')
                    ->with('error', 'Je hebt geen toegang tot dit contact');
            }
            
            return view('crm::contacts.edit', compact('contact'));
        } catch (\Exception $e) {
            return redirect()
                ->route('crm.contacts.index', ['locale' => app()->getLocale()])
                ->with('error', 'Contact not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $contact = Contact::findOrFail($id);
            
            // Controleer of het contact behoort tot het huidige team
            if ($contact->team_id != Auth::user()->currentTeam->id) {
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

            $contact->update($validated);

            return redirect()
                ->to('/' . app()->getLocale() . '/crm/contacts/' . $contact->id)
                ->with('success', 'Contact updated successfully');
        } catch (\Exception $e) {
            return redirect()
                ->to('/' . app()->getLocale() . '/crm/contacts')
                ->with('error', 'Contact not found.');
        }
    }
}
