<?php

namespace Movve\Crm\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\ContactNote;
use Movve\Crm\Models\ContactNoteFile;
use Movve\Crm\Models\TeamMetaField;

class ContactNotesEditor extends Component
{
    use WithFileUploads;

    public Contact $contact;
    public string $newNoteContent = '';
    public string $newNoteTitle = '';
    public $newNoteFiles = [];

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

            // Bestanden opslaan
            if (!empty($this->newNoteFiles)) {
                foreach ($this->newNoteFiles as $file) {
                    $path = $file->store('contact_notes', 'public');
                    ContactNoteFile::create([
                        'contact_note_id' => $note->id,
                        'file_path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            Log::info('ContactNotesEditor note created', [
                'note_id' => $note->id,
                'contact_id' => $note->contact_id,
                'team_id' => $note->team_id,
                'title' => $note->title,
                'content_length' => strlen($note->content),
                'files_count' => count($this->newNoteFiles),
            ]);

            // Reset de input velden
            $this->newNoteContent = '';
            $this->newNoteTitle = '';
            $this->newNoteFiles = [];

            session()->flash('success', 'Notitie toegevoegd.');
            $this->emit('noteAdded');
        } catch (\Exception $e) {
            Log::error('ContactNotesEditor error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Fout bij opslaan notitie.');
        }
    }

    public function render()
    {
        return view('crm::livewire.contact-notes-editor', [
            'notes' => $this->contact->notes()->get(),
        ]);
    }
}
