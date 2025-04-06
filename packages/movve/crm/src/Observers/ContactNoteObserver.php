<?php

namespace Movve\Crm\Observers;

use Movve\Crm\Models\ContactNote;
use Movve\Crm\Services\ContactActivityLogger;

class ContactNoteObserver
{
    /**
     * De ContactActivityLogger service.
     *
     * @var \Movve\Crm\Services\ContactActivityLogger
     */
    protected $activityLogger;

    /**
     * Maak een nieuwe observer instantie aan.
     *
     * @param \Movve\Crm\Services\ContactActivityLogger $activityLogger
     * @return void
     */
    public function __construct(ContactActivityLogger $activityLogger)
    {
        $this->activityLogger = $activityLogger;
    }

    /**
     * Handle het "created" event voor het contact note model.
     *
     * @param  \Movve\Crm\Models\ContactNote  $note
     * @return void
     */
    public function created(ContactNote $note)
    {
        $contact = $note->contact;
        if ($contact) {
            $this->activityLogger->logNoteAdded($contact, $note);
        }
    }
}
