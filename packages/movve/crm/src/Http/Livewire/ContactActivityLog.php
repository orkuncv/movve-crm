<?php

namespace Movve\Crm\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Movve\Crm\Models\Contact;

class ContactActivityLog extends Component
{
    public Contact $contact;
    public int $limit = 10;
    public bool $showAll = false;
    
    public function mount(Contact $contact)
    {
        $this->contact = $contact;
        
        Log::info('ContactActivityLog mount', [
            'contact_id' => $contact->id,
            'activities_count' => $contact->activities()->count(),
        ]);
    }
    
    public function loadMore()
    {
        $this->limit += 10;
    }
    
    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll;
        
        if ($this->showAll) {
            $this->limit = 1000; // Een hoog getal om praktisch alle activiteiten te tonen
        } else {
            $this->limit = 10;
        }
    }
    
    public function render()
    {
        return view('crm::livewire.contact-activity-log', [
            'activities' => $this->contact->activities()
                ->with('user') // Eager load de gebruiker voor betere prestaties
                ->limit($this->limit)
                ->get(),
            'totalCount' => $this->contact->activities()->count(),
        ]);
    }
}
