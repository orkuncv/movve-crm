<?php

namespace Movve\Crm\Observers;

use Laravel\Jetstream\Team;
use Movve\Crm\Models\TeamMetaField;

class TeamObserver
{
    /**
     * Handle the Team "created" event.
     */
    public function created(Team $team): void
    {
        // Voeg het standaard "Notities" meta veld toe aan het nieuwe team
        TeamMetaField::create([
            'team_id' => $team->id,
            'name' => 'Notities',
            'key' => 'notes',
            'type' => 'field', // Gebruik 'field' type voor tekstvelden
            'description' => 'Notities over deze contactpersoon',
            'is_active' => true,
        ]);
    }
}
