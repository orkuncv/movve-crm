<?php
namespace Movve\Crm\Http\Livewire;

use Livewire\Component;
use Movve\Crm\Models\Booking;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\Service;
use Movve\Crm\Models\StaffMember;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class BookingForm extends Component
{
    public $booking;
    public $team_id;
    public $staff_member_id;
    public $service_id;
    public $contact_id;
    public $start_time;
    public $end_time;
    public $comment;

    public $staffMembers = [];
    public $services = [];
    public $contacts = [];

    public $editMode = false;

    protected $rules = [
        'team_id' => 'required|exists:teams,id',
        'staff_member_id' => 'required|exists:staff_members,id',
        'service_id' => 'nullable|exists:services,id',
        'contact_id' => 'nullable|exists:crm_contacts,id',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'comment' => 'nullable|string',
    ];

    public function mount($booking = null)
    {
        $this->team_id = Auth::user()->current_team_id ?? null;
        $this->staffMembers = StaffMember::where('team_id', $this->team_id)->get();
        $this->services = Service::where('team_id', $this->team_id)->get();
        $this->contacts = Contact::where('team_id', $this->team_id)->get();

        if ($booking) {
            $this->editMode = true;
            $this->booking = $booking;
            $this->fill($booking->toArray());
        } else {
            $this->start_time = now()->format('Y-m-d\TH:i');
            $this->end_time = now()->addHour()->format('Y-m-d\TH:i');
        }
    }

    public function save()
    {
        $validated = $this->validate();
        if ($this->editMode && $this->booking) {
            $this->booking->update($validated);
            session()->flash('success', __('crm::booking.updated'));
        } else {
            Booking::create($validated);
            session()->flash('success', __('crm::booking.created'));
        }
        $this->emitUp('bookingSaved');
    }

    public function render()
    {
        return view('crm::livewire.booking-form');
    }
}
