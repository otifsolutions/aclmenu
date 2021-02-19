<?php

namespace OTIFSolutions\ACLMenu\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoleGroup extends Model
{
    protected $guarded = ['id'];

    public function users()
    {
        $this->hasMany(config('laravelacl.models.user'),'user_role_group_id');
    }
    public function user_roles()
    {
        return $this->belongsToMany(UserRole::class,'group_role','user_role_group_id','user_role_id');
    }
}
