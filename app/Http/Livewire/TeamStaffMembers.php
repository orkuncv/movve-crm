<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\StaffMember;
use Illuminate\Support\Facades\Auth;

class TeamStaffMembers extends Component
{
    public Team $team;
    public $name = '';
    public $subtitle = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'subtitle' => 'nullable|string|max:255',
    ];

    public function addStaffMember()
    {
        $this->validate();
        $this->team->staffMembers()->create([
            'name' => $this->name,
            'subtitle' => $this->subtitle,
        ]);
        $this->reset(['name', 'subtitle']);
        $this->team->refresh();
    }

    public function removeStaffMember($id)
    {
        $this->team->staffMembers()->where('id', $id)->delete();
        $this->team->refresh();
    }

    public function render()
    {
        return view('teams.staff-members', [
            'staffMembers' => $this->team->staffMembers,
        ]);
    }
}
