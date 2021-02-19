<?php

namespace OTIFSolutions\ACLMenu\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = ['id'];

    public function menu_item()
    {
        return $this->belongsTo(MenuItem::class,'menu_item_id');
    }
    public function type()
    {
        return $this->belongsTo(PermissionType::class,'permission_type_id');
    }
}
