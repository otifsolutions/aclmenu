<?php

namespace OTIFSolutions\ACLMenu\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function owner(){
        return $this->belongsTo('App\User','user_id');
    }
    
    public function permissions(){
        return $this->belongsToMany('OTIFSolutions\ACLMenu\Models\Permission');
    }
    
    public function members(){
        return $this->hasMany('App\User','team_id');
    }
    
    public function user_roles(){
        return $this->hasMany('OTIFSolutions\ACLMenu\Models\UserRole','team_id');
    }
}
