<?php

namespace Movve\Crm\Http\Livewire;

use Livewire\Component;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\TeamMetaField;

class ContactMetaCounter extends Component
{
    public Contact $contact;
    public string $metaKey;
    public ?TeamMetaField $metaField = null;
    public int $counter = 0;
    
    protected $listeners = ['increment-counter' => 'handleIncrementEvent'];

    public function mount(Contact $contact, string $metaKey)
    {
        $this->contact = $contact;
        $this->metaKey = $metaKey;
        
        // Debug logging
        \Illuminate\Support\Facades\Log::info('ContactMetaCounter component gemount voor contact ' . $contact->id . ' en meta key ' . $metaKey);
        
        // Haal het meta veld op voor het huidige team
        $this->metaField = TeamMetaField::where('team_id', auth()->user()->currentTeam->id)
            ->where('key', $this->metaKey)
            ->whereIn('type', ['count', 'counter']) // Ondersteun zowel 'count' als 'counter' type
            ->where('is_active', true)
            ->first();
            
        if ($this->metaField) {
            // Haal de huidige counter waarde op
            $meta = $this->contact->getMeta($this->metaKey);
            $this->counter = $meta ? $meta->counter : 0;
            \Illuminate\Support\Facades\Log::info('Initiële counter waarde: ' . $this->counter);
        } else {
            \Illuminate\Support\Facades\Log::warning('Meta veld niet gevonden bij mount voor key ' . $this->metaKey);
        }
    }
    
    public function increment()
    {
        // Debug logging
        \Illuminate\Support\Facades\Log::info('ContactMetaCounter increment aangeroepen voor contact ' . $this->contact->id . ' en meta key ' . $this->metaKey);
        
        if (!$this->metaField) {
            \Illuminate\Support\Facades\Log::warning('Meta veld niet gevonden voor key ' . $this->metaKey);
            return;
        }
        
        // Haal het meta record op of maak een nieuwe aan
        $meta = $this->contact->getOrCreateMeta($this->metaField);
        \Illuminate\Support\Facades\Log::info('Meta record opgehaald/aangemaakt: ' . $meta->id . ' met huidige counter: ' . $meta->counter);
        
        // Verhoog de counter
        $meta->incrementCounter();
        \Illuminate\Support\Facades\Log::info('Counter verhoogd naar: ' . $meta->counter);
        
        // Update de lokale counter waarde
        $this->counter = $meta->counter;
        
        $this->dispatch('meta-counter-updated', [
            'contact_id' => $this->contact->id,
            'meta_key' => $this->metaKey,
            'counter' => $this->counter
        ]);
        
        // Bevestig dat de methode volledig is uitgevoerd
        \Illuminate\Support\Facades\Log::info('ContactMetaCounter increment voltooid met nieuwe counter waarde: ' . $this->counter);
    }
    
    /**
     * Verwerk het increment-counter event dat via JavaScript wordt verzonden
     */
    public function handleIncrementEvent($data)
    {
        \Illuminate\Support\Facades\Log::info('handleIncrementEvent aangeroepen met data: ' . json_encode($data));
        
        // Controleer of de data overeenkomt met deze component
        if (isset($data['contact_id']) && isset($data['meta_key']) && 
            $data['contact_id'] == $this->contact->id && $data['meta_key'] == $this->metaKey) {
            \Illuminate\Support\Facades\Log::info('Event data komt overeen met deze component, increment aanroepen');
            $this->increment();
        }
    }

    public function render()
    {
        return view('crm::livewire.contact-meta-counter');
    }
}
