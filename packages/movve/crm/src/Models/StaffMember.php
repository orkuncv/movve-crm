<?php
namespace Movve\Crm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Movve\Crm\Models\Service;
use Movve\Crm\Models\Team;

class StaffMember extends Model
{
    use HasFactory;
    protected $fillable = ['team_id', 'name', 'subtitle'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_staff_member');
    }
}
