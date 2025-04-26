<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffMember extends Model
{
    use HasFactory;
    protected $fillable = ['team_id', 'name', 'subtitle'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
