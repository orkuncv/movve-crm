<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Movve\Crm\Models\ContactNote;
use Movve\Crm\Models\ContactNoteFile;

class ContactNoteFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Voeg voor elke bestaande notitie een dummy-bestand toe (alleen als voorbeeld)
        foreach (ContactNote::all() as $note) {
            ContactNoteFile::create([
                'contact_note_id' => $note->id,
                'file_path' => 'dummy/example.pdf',
                'original_name' => 'example.pdf',
                'mime_type' => 'application/pdf',
                'size' => 12345,
            ]);
        }
    }
}
