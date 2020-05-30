<?php

namespace OTIFSolutions\ACLMenu\Traits;

trait ACLUserTrait{
    public function user_role(){
        return $this->belongsTo('OTIFSolutions\ACLMenu\Models\UserRole');
    }
    public function group(){
        return $this->belongsTo('OTIFSolutions\ACLMenu\Models\UserRoleGroup','user_role_group_id');
    }
    public function parent_team(){
        return $this->belongsTo('OTIFSolutions\ACLMenu\Models\Team','team_id');
    }
    public function child_team(){
        return $this->hasOne('OTIFSolutions\ACLMenu\Models\Team','user_id');
    }
    public function team(){
        if ($this->isChildAccount())
            return $this->child_team();
        else
            return $this->parent_team();
    }
    public function isChildAccount(){
        return $this['team_id'] === null;
    }
    public function hasPermission($permissionTypeString = 'READ', $permission = null){
        if ($permissionTypeString == null || $permissionTypeString == '') return false;
        $permissionTypeString = strtolower($permissionTypeString);
        if ($permission !== null)
            $currentPermission = $permission;
        else
            $currentPermission = \Session::get('current_permission');
        $permissionTypeStrings = explode('|',$permissionTypeString);
        if ($this['group'] === null)
            if ($this['user_role'] === null)
                return false;
            else{
                $permissions = $this['user_role']->permissions()->where('name','LIKE','%'.$currentPermission)->get();
                if (sizeof($permissions->where('name','LIKE','manage_'.$currentPermission)) != 0) return true;
                foreach ($permissionTypeStrings as $permissionTypeString)
                    if (sizeof($permissions->where('name','LIKE',$permissionTypeString.'_'.$currentPermission)) != 0) 
                        return true;
            }
        else
            foreach($this['group']['user_roles'] as $userRole){
                $permissions = $userRole->permissions()->where('name','LIKE','%'.$currentPermission)->get();
                if (sizeof($permissions->where('name','LIKE','manage_'.$currentPermission)) != 0) return true;
                foreach ($permissionTypeStrings as $permissionTypeString)
                    if (sizeof($permissions->where('name','LIKE',$permissionTypeString.'_'.$currentPermission)) != 0) 
                        return true;
            }
        return false;
    }
    public function hasPermissionMenuItem($id){
        if ($this['group'] === null)
            if ($this['user_role'] === null)
                return false;
            else{
                $permission = $this['user_role']->permissions()->where('menu_item_id',$id)->first();
                if ($permission !== null) return true;
            }
        else
            foreach($this['group']['user_roles'] as $userRole){
                $permission = $userRole->permissions()->where('menu_item_id',$id)->first();
                if ($permission !== null) return true;
            }
        return false;
    }
}


?>