<?php

namespace Movve\Crm\Observers;

use Movve\Crm\Models\ContactMeta;
use Movve\Crm\Services\ContactActivityLogger;

class ContactMetaObserver
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

    // We slaan de updating methode over om te voorkomen dat oldValues aan het model wordt toegevoegd
    // Dit veroorzaakte een SQL fout omdat Laravel probeerde oldValues in de database op te slaan

    /**
     * Handle het "updated" event voor het contact meta model.
     *
     * @param  \Movve\Crm\Models\ContactMeta  $meta
     * @return void
     */
    public function updated(ContactMeta $meta)
    {
        // Gebruik getOriginal() om de originele waarden te krijgen
        $original = $meta->getOriginal();
        
        // Als de counter is verhoogd, log dit als een activiteit
        if (isset($original['counter']) && $meta->counter > $original['counter']) {
            $contact = $meta->contact;
            if ($contact) {
                $this->activityLogger->logCounterIncremented(
                    $contact,
                    $meta,
                    $original['counter'],
                    $meta->counter
                );
            }
        }
    }
}
