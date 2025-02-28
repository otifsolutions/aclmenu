<?php

namespace OTIFSolutions\ACLMenu\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $guarded = ['id'];

    public function children() {
        return $this->hasMany(MenuItem::class,'parent_id');
    }
    public function parent() {
        return $this->belongsTo(MenuItem::class,'parent_id');
    }
    public function permissions() {
        return $this->hasMany(Permission::class,'menu_item_id');
    }
    public function user_roles()
    {
        return $this->belongsToMany(UserRole::class);
    }
}
