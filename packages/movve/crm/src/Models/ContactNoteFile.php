<?php

namespace Movve\Crm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactNoteFile extends Model
{
    use HasFactory;

    protected $table = 'crm_contact_note_files';

    protected $fillable = [
        'contact_note_id',
        'file_path',
        'original_name',
        'mime_type',
        'size',
    ];

    public function note()
    {
        return $this->belongsTo(ContactNote::class, 'contact_note_id');
    }
}
