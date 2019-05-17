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
}
