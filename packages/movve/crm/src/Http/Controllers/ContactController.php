<?php

namespace Movve\Crm\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Movve\Crm\Http\Requests\StoreContactRequest;
use Movve\Crm\Http\Requests\UpdateContactRequest;
use Movve\Crm\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index(Request $request): JsonResponse
    {
        $contacts = Contact::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate($request->input('per_page', 15));

        return response()->json($contacts);
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(StoreContactRequest $request): JsonResponse
    {
        $contact = Contact::create($request->validated());

        return response()->json([
            'message' => 'Contact created successfully',
            'data' => $contact
        ], 201);
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact): JsonResponse
    {
        \Log::info('Contact in show method:', ['contact' => $contact->toArray()]);
        return response()->json($contact);
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact): JsonResponse
    {
        $contact->update($request->validated());

        return response()->json([
            'message' => 'Contact updated successfully',
            'data' => $contact
        ]);
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact): JsonResponse
    {
        $contact->delete();

        return response()->json([
            'message' => 'Contact deleted successfully'
        ]);
    }

    /**
     * Restore a soft-deleted contact.
     */
    public function restore(int $id): JsonResponse
    {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->restore();

        return response()->json([
            'message' => 'Contact restored successfully',
            'data' => $contact
        ]);
    }
}
