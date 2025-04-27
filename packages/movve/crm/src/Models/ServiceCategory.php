<?php
namespace Movve\Crm\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Movve\Crm\Models\Service;
use Movve\Crm\Models\Team;

class ServiceCategory extends Model
{
    use HasFactory;
    protected $fillable = ['team_id', 'name'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
