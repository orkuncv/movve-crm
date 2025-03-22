<?php

namespace Movve\Crm\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Validator;
use Movve\Crm\Models\Contact;
use Movve\Crm\Http\Resources\ContactResource;
use Movve\Crm\Http\Resources\ContactCollection;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index()
    {
        $contacts = Contact::paginate(15);
        return new ContactCollection($contacts);
    }

    /**
     * Store a newly created contact in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:contacts',
            'phone_number' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $contact = Contact::create($request->all());

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified contact.
     *
     * @param  \Movve\Crm\Models\Contact  $contact
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Update the specified contact in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Movve\Crm\Models\Contact  $contact
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:contacts,email,' . $contact->id,
            'phone_number' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $contact->update($request->all());

        return new ContactResource($contact);
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param  \Movve\Crm\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->noContent();
    }
}
