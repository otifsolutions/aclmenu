<?php

namespace OTIFSolutions\ACLMenu\Modals;

use Illuminate\Database\Eloquent\Model;

class UserRoleGroup extends Model
{
    public function users()
    {
        $this->hasMany('App\User','user_role_group_id');
    }
    public function user_roles()
    {
        return $this->belongsToMany('OTIFSolutions\ACLMenu\Models\UserRole','group_role','user_role_group_id','user_role_id');
    }
}
