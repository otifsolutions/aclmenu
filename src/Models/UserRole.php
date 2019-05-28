<?php

namespace OTIFSolutions\ACLMenu\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public function permissions()
    {
        return $this->belongsToMany('OTIFSolutions\ACLMenu\Models\Permission');
    }
    public function menu_items()
    {
        return $this->belongsToMany('OTIFSolutions\ACLMenu\Models\MenuItem');
    }
    public function team(){
        return $this->belongsTo('OTIFSolutions\ACLMenu\Models\Team','team_id');
    }
    public function users(){
        return $this->hasMany('App\User','user_role_id');
    }
    public function groups()
    {
        return $this->belongsToMany('OTIFSolutions\ACLMenu\Models\UserRoleGroup','group_role','user_role_id','user_role_group_id');
    }
}
