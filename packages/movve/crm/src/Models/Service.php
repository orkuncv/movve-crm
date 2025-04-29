<?php
namespace Movve\Crm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['team_id', 'category_id', 'name', 'info', 'price', 'duration'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function staffMembers()
    {
        return $this->belongsToMany(\Movve\Crm\Models\StaffMember::class, 'service_staff_member');
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
