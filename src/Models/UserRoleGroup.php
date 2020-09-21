<?php

namespace OTIFSolutions\ACLMenu\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRoleGroup extends Model
{
    public function users()
    {
        $this->hasMany(User::class,'user_role_group_id');
    }
    public function user_roles()
    {
        return $this->belongsToMany(UserRole::class,'group_role','user_role_group_id','user_role_id');
    }
}
