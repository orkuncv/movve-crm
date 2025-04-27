<?php
namespace App\Livewire;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ServicesManager extends Component
{
    public $showingCreateServiceModal = false;
    public $name;
    public $info;
    public $price;
    public $duration;
    public $category_id;
    public $staff_member_ids = [];
    public $categories = [];
    public $staffMembers = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'info' => 'nullable|string',
        'price' => 'nullable|numeric|min:0',
        'duration' => 'nullable|integer|min:1',
        'category_id' => 'nullable|exists:service_categories,id',
        'staff_member_ids' => 'array',
        'staff_member_ids.*' => 'exists:staff_members,id',
    ];

    protected $listeners = ['openServiceModal' => 'openModal'];

    public function mount()
    {
        $team = Auth::user()->currentTeam;
        $this->categories = ServiceCategory::where('team_id', $team->id)->get();
        if ($this->categories->count() === 0) {
            $default = ServiceCategory::create([
                'team_id' => $team->id,
                'name' => 'Algemeen',
            ]);
            $this->categories = collect([$default]);
        }
        $this->staffMembers = $team->staffMembers;
    }

    public function createService()
    {
        $this->validate();
        $service = Service::create([
            'team_id' => Auth::user()->currentTeam->id,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'info' => $this->info,
            'price' => $this->price,
            'duration' => $this->duration,
        ]);
        $service->staffMembers()->sync($this->staff_member_ids);
        $this->reset(['showingCreateServiceModal', 'name', 'info', 'price', 'duration', 'category_id', 'staff_member_ids']);
        $this->emit('serviceAdded');
    }

    public function openModal()
    {
        $this->showingCreateServiceModal = true;
    }

    public function render()
    {
        return view('livewire.services-manager');
    }
}
