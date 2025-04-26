<?php

namespace Movve\Crm\Services;

use Illuminate\Support\Facades\Auth;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactActivity;
use Movve\Crm\Models\ContactMeta;
use Movve\Crm\Models\ContactNote;

class ContactActivityLogger
{
    /**
     * Log een activiteit voor een contact.
     *
     * @param Contact $contact
     * @param string $action
     * @param string $description
     * @param array $properties
     * @return ContactActivity
     */
    public function log(Contact $contact, string $action, string $description, array $properties = []): ContactActivity
    {
        return ContactActivity::create([
            'team_id' => $contact->team_id,
            'contact_id' => $contact->id,
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'properties' => $properties,
        ]);
    }

    /**
     * Log dat een contact is aangemaakt.
     *
     * @param Contact $contact
     * @return ContactActivity
     */
    public function logCreated(Contact $contact): ContactActivity
    {
        return $this->log(
            $contact,
            'created',
            __('crm::crm.contact_created'),
            ['contact_data' => $contact->toArray()]
        );
    }

    /**
     * Log dat een contact is bijgewerkt.
     *
     * @param Contact $contact
     * @param array $oldValues
     * @param array $newValues
     * @return ContactActivity
     */
    public function logUpdated(Contact $contact, array $oldValues, array $newValues): ContactActivity
    {
        // Bereid de gewijzigde velden voor
        $changes = [];
        foreach ($newValues as $key => $value) {
            if (isset($oldValues[$key]) && $oldValues[$key] !== $value) {
                $changes[$key] = [
                    'old' => $oldValues[$key],
                    'new' => $value,
                ];
            }
        }

        return $this->log(
            $contact,
            'updated',
            __('crm::crm.contact_updated'),
            $changes
        );
    }

    /**
     * Log dat een teller is verhoogd.
     *
     * @param Contact $contact
     * @param ContactMeta $meta
     * @param int $oldValue
     * @param int $newValue
     * @return ContactActivity
     */
    public function logCounterIncremented(Contact $contact, ContactMeta $meta, int $oldValue, int $newValue): ContactActivity
    {
        $metaField = $meta->metaField;
        $metaName = $metaField ? $metaField->name : $meta->team_meta_field_id;

        return $this->log(
            $contact,
            'counter_incremented',
            __('crm::crm.counter_incremented', ['meta' => $metaName]),
            [
                'meta_id' => $meta->id,
                'meta_key' => $metaField ? $metaField->key : null,
                'counter' => [
                    'old' => $oldValue,
                    'new' => $newValue,
                ],
            ]
        );
    }

    /**
     * Log dat een notitie is toegevoegd.
     *
     * @param Contact $contact
     * @param ContactNote $note
     * @return ContactActivity
     */
    public function logNoteAdded(Contact $contact, ContactNote $note): ContactActivity
    {
        return $this->log(
            $contact,
            'note_added',
            __('crm::crm.note_added', ['title' => $note->title]),
            [
                'note_id' => $note->id,
                'note_title' => $note->title,
            ]
        );
    }

    /**
     * Log dat een contact is verwijderd.
     *
     * @param Contact $contact
     * @return ContactActivity
     */
    public function logDeleted(Contact $contact): ContactActivity
    {
        return $this->log(
            $contact,
            'deleted',
            __('crm::crm.contact_deleted'),
            ['contact_data' => $contact->toArray()]
        );
    }

    /**
     * Log dat een contact is hersteld.
     *
     * @param Contact $contact
     * @return ContactActivity
     */
    public function logRestored(Contact $contact): ContactActivity
    {
        return $this->log(
            $contact,
            'restored',
            __('crm::crm.contact_restored'),
            ['contact_data' => $contact->toArray()]
        );
    }

    /**
     * Log een API-actie voor een contact.
     *
     * @param Contact $contact
     * @param string $apiAction
     * @param array $data
     * @return ContactActivity
     */
    public function logApiAction(Contact $contact, string $apiAction, array $data = []): ContactActivity
    {
        return $this->log(
            $contact,
            'api_' . $apiAction,
            __('crm::crm.api_action', ['action' => $apiAction]),
            $data
        );
    }
}
