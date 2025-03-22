<?php

namespace App\Traits\JetStream;

use Laravel\Jetstream\Jetstream;

trait HasNoPersonalTeams
{

    /**
     * Determine if the user owns the given team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function ownsTeam($team)
    {
        // return $this->id == $team->user_id;
        return $this->id == optional($team)->user_id;
    }

    /**
     * Determine if the given team is the current team.
     *
     * @param  mixed  $team
     * @return bool
     */
    public function isCurrentTeam($team)
    {
        // return $team->id === $this->currentTeam->id;
        return optional($team)->id === $this->currentTeam->id;
    }

    /**
     * Determine if the user is assigned to any teams.
     *
     * @return bool
     */
    public function belongsToAnyTeam()
    {
        return (bool) optional($this->teams)->isNotEmpty();
    }
}
