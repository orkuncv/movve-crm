<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\CreatesTeams;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Jetstream\Jetstream;

class CreateTeam implements CreatesTeams
{
    /**
     * Validate and create a new team for the given user.
     *
     * @param  array<string, string>  $input
     */
    public function create(User $user, array $input): Team
    {
        Gate::forUser($user)->authorize('create', Jetstream::newTeamModel());

        // Aangepaste validatie om problemen met preg_match te vermijden
        if (empty($input['name'])) {
            throw new \Illuminate\Validation\ValidationException(validator([], ['name' => 'required'], ['name.required' => 'The team name field is required.'])->errors());
        }
        
        if (!is_string($input['name'])) {
            throw new \Illuminate\Validation\ValidationException(validator([], ['name' => 'string'], ['name.string' => 'The team name must be a string.'])->errors());
        }
        
        if (strlen($input['name']) > 255) {
            throw new \Illuminate\Validation\ValidationException(validator([], ['name' => 'max:255'], ['name.max' => 'The team name may not be greater than 255 characters.'])->errors());
        }

        AddingTeam::dispatch($user);

        $user->switchTeam($team = $user->ownedTeams()->create([
            'name' => $input['name'],
            'personal_team' => false,
        ]));

        return $team;
    }
}
