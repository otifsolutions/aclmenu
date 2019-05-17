<?php

namespace OTIFSolutions\ACLMenu\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'permission_type_id', 'menu_item_id'];
    
    public function menu_item()
    {
        return $this->belongsTo('OTIFSolutions\ACLMenu\Models\MenuItem','menu_item_id');
    }
    public function type()
    {
        return $this->belongsTo('OTIFSolutions\ACLMenu\Models\PermissionType','permission_type_id');
    }
}
