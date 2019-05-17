<?php

namespace OTIFSolutions\ACLMenu\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    public function children() {
        return $this->hasMany('OTIFSolutions\ACLMenu\Models\MenuItem','parent_id');
    }
    
    public function permissions() {
        return $this->hasMany('OTIFSolutions\ACLMenu\Models\Permission','menu_item_id');
    }
    public function user_roles()
    {
        return $this->belongsToMany('OTIFSolutions\ACLMenu\Models\UserRole');
    }
}
