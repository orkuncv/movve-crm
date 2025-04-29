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
            // Haal de juiste ID parameter uit de URL
            // Als de URL /en/crm/contacts/2 is, dan is segment(3) = 'contacts' en segment(4) = '2'
            $contactId = request()->segment(4);

            // Debug informatie
            \Log::info('ContactViewController@show aangeroepen', [
                'id_parameter' => $id, // Dit is meestal de locale parameter
                'contact_id' => $contactId, // Dit is het werkelijke contact ID
                'request_path' => request()->path(),
                'segments' => request()->segments(),
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

            // Probeer het contact op te halen met het juiste ID
            $contact = Contact::find($contactId);

            if (!$contact) {
                \Log::warning('Contact niet gevonden met ID: ' . $contactId);
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
            // Haal de juiste ID parameter uit de URL
            $contactId = request()->segment(4);
            $contact = Contact::findOrFail($contactId);
            // Controleer of het contact behoort tot het huidige team
            if ($contact->team_id != Auth::user()->currentTeam->id) {
                return redirect()
                    ->to('/' . app()->getLocale() . '/crm/contacts')
                    ->with('error', 'Je hebt geen toegang tot dit contact');
            }
            // Ophalen van meta-waarden
            $metaKeys = ['company_name', 'company_taxnumber', 'company_adress', 'company_email'];
            $meta = [];
            foreach ($metaKeys as $key) {
                $metaModel = $contact->getMeta($key);
                $meta[$key] = $metaModel ? $metaModel->value : null;
            }
            return view('crm::contacts.edit', compact('contact', 'meta'));
        } catch (\Exception $e) {
            return redirect()
                ->route('crm.contacts.index', ['locale' => app()->getLocale()])
                ->with('error', 'Contact not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $contactId = request()->segment(4);
            $contact = Contact::findOrFail($contactId);
            if ($contact->team_id != Auth::user()->currentTeam->id) {
                return redirect()->to('/' . app()->getLocale() . '/crm/contacts')
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
            // Opslaan van bedrijfsgegevens meta
            $metaKeys = ['company_name', 'company_taxnumber', 'company_adress', 'company_email'];
            dump($metaKeys);
            dump($request->all());
            foreach ($metaKeys as $key) {
                $value = $request->input($key);
                if ($value !== null) {
                    // Zoek het meta veld (TeamMetaField)
                    $metaField = \Movve\Crm\Models\TeamMetaField::where('team_id', $contact->team_id)
                        ->where('key', $key)
                        ->first();
                    if ($metaField) {
                        $metaModel = $contact->getOrCreateMeta($metaField);
                        $metaModel->value = $value;
                        $metaModel->save();
                    }
                }
            }
            return redirect()
                ->to('/' . app()->getLocale() . '/crm/contacts/' . $contact->id)
                ->with('success', 'Contact bijgewerkt');
        } catch (\Exception $e) {
            \Log::error('Exception in update methode:', [
                'id' => $id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withInput()->with('error', 'Fout bij het bijwerken van het contact');
        }
    }
}
