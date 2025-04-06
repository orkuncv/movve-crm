<?php

namespace Movve\Crm\Http\Livewire\Teams;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Movve\Crm\Models\TeamMetaField;

class ManageTeamMetaFields extends Component
{
    /**
     * The team instance.
     */
    public $team;

    /**
     * The meta field form state.
     */
    public $state = [
        'name' => '',
        'type' => 'count',
    ];

    /**
     * Indicates if meta field deletion is being confirmed.
     */
    public $confirmingMetaFieldDeletion = false;

    /**
     * The ID of the meta field being deleted.
     */
    public $metaFieldIdBeingDeleted = null;

    /**
     * Mount the component.
     */
    public function mount($team)
    {
        $this->team = $team;
    }

    /**
     * Get the meta fields for the team.
     */
    public function getMetaFieldsProperty()
    {
        return TeamMetaField::where('team_id', $this->team->id)
            ->orderBy('name')
            ->get();
    }



    /**
     * Create a new meta field.
     */
    public function createMetaField()
    {
        $this->resetErrorBag();

        // Valideer de invoer
        $validator = Validator::make($this->state, [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:count,field'],
        ])->validateWithBag('createMetaField');

        // Genereer een key op basis van de naam
        $key = $this->generateKeyFromName($this->state['name']);

        // Controleer of de key al bestaat voor dit team
        $exists = TeamMetaField::where('team_id', $this->team->id)
            ->where('key', $key)
            ->exists();

        if ($exists) {
            $this->addError('name', 'Er bestaat al een veld met deze naam voor dit team.');
            return;
        }

        // Maak het nieuwe meta veld aan
        TeamMetaField::create([
            'team_id' => $this->team->id,
            'name' => $this->state['name'],
            'key' => $key,
            'type' => $this->state['type'],
            'description' => '',
            'is_active' => true,
        ]);

        $this->resetState();
        $this->dispatch('saved');
    }

    /**
     * Confirm that the meta field should be deleted.
     */
    public function confirmMetaFieldDeletion($metaFieldId)
    {
        $this->confirmingMetaFieldDeletion = true;
        $this->metaFieldIdBeingDeleted = $metaFieldId;
    }

    /**
     * Delete the meta field.
     */
    public function deleteMetaField()
    {
        $metaField = TeamMetaField::findOrFail($this->metaFieldIdBeingDeleted);

        // Controleer of het meta veld bij het huidige team hoort
        if ($metaField->team_id !== $this->team->id) {
            abort(403);
        }

        $metaField->delete();

        $this->confirmingMetaFieldDeletion = false;
        $this->metaFieldIdBeingDeleted = null;

        $this->dispatch('saved');
    }
    
    /**
     * Generate a key from a name.
     */
    private function generateKeyFromName($name)
    {
        // Convert to lowercase and replace spaces with underscores
        $key = strtolower(str_replace(' ', '_', $name));
        // Remove any non-alphanumeric characters except underscores
        $key = preg_replace('/[^a-z0-9_]/', '', $key);
        
        return $key;
    }

    /**
     * Reset the meta field creation state.
     */
    private function resetState()
    {
        $this->state = [
            'name' => '',
            'type' => 'count',
        ];
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('crm::teams.manage-team-meta-fields');
    }
}
