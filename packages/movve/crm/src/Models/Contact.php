<?php

namespace Movve\Crm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Jetstream\Team;
use Movve\Crm\Models\TeamMetaField;

class Contact extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\ContactFactory::new();
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crm_contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'uuid',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'date_of_birth',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the contact's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the team that owns the contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get all meta values for this contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(ContactMeta::class);
    }
    
    /**
     * Get all notes for this contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(ContactNote::class)->orderBy('created_at', 'desc');
    }
    
    /**
     * Get all activities for this contact.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities(): HasMany
    {
        return $this->hasMany(ContactActivity::class)->orderBy('created_at', 'desc');
    }
    
    /**
     * Get a specific meta value by meta field key.
     *
     * @param string $key
     * @return \Movve\Crm\Models\ContactMeta|null
     */
    public function getMeta(string $key)
    {
        // Haal eerst het meta veld op
        $metaField = TeamMetaField::where('team_id', $this->team_id)
            ->where('key', $key)
            ->first();
            
        if (!$metaField) {
            return null;
        }
        
        // Haal de meta waarde op met een directe query
        return $this->metas()
            ->where('team_meta_field_id', $metaField->id)
            ->first();
    }
    
    /**
     * Get or create a meta value for this contact.
     *
     * @param \Movve\Crm\Models\TeamMetaField $metaField
     * @return \Movve\Crm\Models\ContactMeta
     */
    public function getOrCreateMeta(TeamMetaField $metaField): ContactMeta
    {
        $meta = $this->metas()
            ->where('team_meta_field_id', $metaField->id)
            ->first();
            
        if (!$meta) {
            $meta = $this->metas()->create([
                'team_meta_field_id' => $metaField->id,
                'value' => null,
                'counter' => 0,
            ]);
        }
        
        return $meta;
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($contact) {
            $contact->uuid = (string) Str::uuid();
        });
    }
}
