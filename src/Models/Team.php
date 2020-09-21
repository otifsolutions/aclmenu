<?php

namespace OTIFSolutions\ACLMenu\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function owner(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function members(){
        return $this->hasMany(User::class,'team_id');
    }

    public function user_roles(){
        return $this->hasMany(UserRole::class,'team_id');
    }
}
