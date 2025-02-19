<?php

namespace Movve\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Movve\Crm\Models\Contact;

class ContactViewController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::query()
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

        Contact::create($validated);

        return redirect()
            ->route('crm.contacts.index')
            ->with('success', 'Contact created successfully');
    }

    public function show(Contact $contact)
    {
        return view('crm::contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('crm::contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
        ]);

        $contact->update($validated);

        return redirect()
            ->route('crm.contacts.show', $contact)
            ->with('success', 'Contact updated successfully');
    }
}
