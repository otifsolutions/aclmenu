<?php

namespace OTIFSolutions\ACLMenu\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = ['id'];

    public function owner(){
        return $this->belongsTo(config('laravelacl.models.user'),'user_id');
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function members(){
        return $this->hasMany(config('laravelacl.models.user'),'team_id');
    }

    public function user_roles(){
        return $this->hasMany(UserRole::class,'team_id');
    }
}
