<?php

namespace Movve\Crm\Observers;

use Illuminate\Support\Facades\Auth;
use Movve\Crm\Models\Contact;
use Movve\Crm\Services\ContactActivityLogger;

class ContactObserver
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
     * Handle het "created" event voor het contact model.
     *
     * @param  \Movve\Crm\Models\Contact  $contact
     * @return void
     */
    public function created(Contact $contact)
    {
        $this->activityLogger->logCreated($contact);
    }

    // We slaan de updating methode over om te voorkomen dat oldValues aan het model wordt toegevoegd
    // Dit veroorzaakte een SQL fout omdat Laravel probeerde oldValues in de database op te slaan

    /**
     * Handle het "updated" event voor het contact model.
     *
     * @param  \Movve\Crm\Models\Contact  $contact
     * @return void
     */
    public function updated(Contact $contact)
    {
        // Gebruik getOriginal() om de originele waarden te krijgen
        // en getDirty() om te controleren of er iets is gewijzigd
        if ($contact->isDirty()) {
            $this->activityLogger->logUpdated(
                $contact,
                $contact->getOriginal(),
                $contact->getAttributes()
            );
        }
    }

    /**
     * Handle het "deleted" event voor het contact model.
     *
     * @param  \Movve\Crm\Models\Contact  $contact
     * @return void
     */
    public function deleted(Contact $contact)
    {
        $this->activityLogger->logDeleted($contact);
    }

    /**
     * Handle het "restored" event voor het contact model.
     *
     * @param  \Movve\Crm\Models\Contact  $contact
     * @return void
     */
    public function restored(Contact $contact)
    {
        $this->activityLogger->logRestored($contact);
    }
}
