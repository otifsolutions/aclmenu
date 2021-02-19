<?php

namespace OTIFSolutions\ACLMenu\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $guarded = ['id'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    public function menu_items()
    {
        return $this->belongsToMany(MenuItem::class);
    }
    public function team(){
        return $this->belongsTo(Team::class,'team_id');
    }
    public function users(){
        return $this->hasMany(config('laravelacl.models.user'),'user_role_id');
    }
    public function groups()
    {
        return $this->belongsToMany(UserRoleGroup::class,'group_role','user_role_id','user_role_group_id');
    }
}
