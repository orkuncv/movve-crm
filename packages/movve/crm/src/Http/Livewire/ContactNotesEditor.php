<?php

namespace Movve\Crm\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactNote;
use Movve\Crm\Models\TeamMetaField;

class ContactNotesEditor extends Component
{
    public Contact $contact;
    public string $newNoteContent = '';
    public string $newNoteTitle = '';
    
    public function mount(Contact $contact)
    {
        $this->contact = $contact;
        
        Log::info('ContactNotesEditor mount', [
            'contact_id' => $contact->id,
            'notes_count' => $contact->notes()->count(),
        ]);
    }
    
    public function createNote()
    {
        Log::info('ContactNotesEditor createNote', [
            'contact_id' => $this->contact->id,
            'title_length' => strlen($this->newNoteTitle),
            'content_length' => strlen($this->newNoteContent),
        ]);
        
        // Valideer de input
        if (empty($this->newNoteContent)) {
            session()->flash('error', 'Notitie inhoud is verplicht.');
            return;
        }
        
        try {
            // Maak een nieuwe notitie aan
            $note = new ContactNote([
                'contact_id' => $this->contact->id,
                'team_id' => auth()->user()->currentTeam->id,
                'content' => $this->newNoteContent,
                'title' => $this->newNoteTitle ?: ('Notitie ' . now()->format('d-m-Y H:i')),
            ]);
            
            $note->save();
            
            Log::info('ContactNotesEditor note created', [
                'note_id' => $note->id,
                'contact_id' => $note->contact_id,
                'team_id' => $note->team_id,
                'title' => $note->title,
                'content_length' => strlen($note->content),
            ]);
            
            // Reset de input velden
            $this->newNoteContent = '';
            $this->newNoteTitle = '';
            
            // Toon een success message
            session()->flash('success', 'Notitie toegevoegd.');
            
            // Ververs de pagina om de nieuwe notitie te tonen
            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            Log::error('Error creating note', [
                'error' => $e->getMessage(),
                'contact_id' => $this->contact->id,
            ]);
            
            session()->flash('error', 'Fout bij het maken van de notitie: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('crm::livewire.contact-notes-editor', [
            'notes' => $this->contact->notes()->get(),
        ]);
    }
}
