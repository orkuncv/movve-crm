<?php

namespace Movve\Crm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactMeta extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crm_contacts_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'contact_id',
        'team_meta_field_id',
        'value',
        'counter',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'counter' => 'integer',
    ];

    /**
     * Get the contact that owns this meta value.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the team meta field that defines this meta value.
     */
    public function teamMetaField(): BelongsTo
    {
        return $this->belongsTo(TeamMetaField::class);
    }

    /**
     * Increment the counter value.
     */
    public function incrementCounter(int $amount = 1): self
    {
        $this->counter += $amount;
        $this->save();
        
        return $this;
    }
}
