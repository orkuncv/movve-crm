<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use Movve\Crm\Models\Contact;
use Movve\Crm\Models\StaffMember;
use Movve\Crm\Models\ServiceCategory;

class Team extends JetstreamTeam
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }

    /**
     * Get the contacts for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the staff members for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function staffMembers()
    {
        return $this->hasMany(StaffMember::class);
    }

    /**
     * Get the service categories for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceCategories()
    {
        return $this->hasMany(ServiceCategory::class);
    }

    /**
     * Get the services for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(\App\Models\Service::class);
    }
}
