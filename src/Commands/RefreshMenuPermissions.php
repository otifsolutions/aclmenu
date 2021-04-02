<?php

namespace OTIFSolutions\ACLMenu\Commands;

use Illuminate\Console\Command;

use OTIFSolutions\ACLMenu\Models\MenuItem;
use OTIFSolutions\ACLMenu\Models\Permission;
use OTIFSolutions\ACLMenu\Models\PermissionType;

class RefreshMenuPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aclmenu:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database seeds for init data.';
    
    /**
     * Private Variables globally used within functions
     * 
     */
    
    private $cPermission;
    private $rPermission;
    private $uPermission;
    private $dPermission;
    private $mPermission;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Private Seeders
     * 
     * @return void
     */
    private function PermissionTypeTableSeeder(){
        $this->cPermission = PermissionType::updateOrCreate(['name' => 'CREATE']);
        $this->rPermission = PermissionType::updateOrCreate(['name' => 'READ']);
        $this->uPermission = PermissionType::updateOrCreate(['name' => 'UPDATE']);
        $this->dPermission = PermissionType::updateOrCreate(['name' => 'DELETE']);
        $this->mPermission = PermissionType::updateOrCreate(['name' => 'MANAGE']);
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->PermissionTypeTableSeeder();
        $menuItems = MenuItem::all();
        foreach($menuItems as $menuItem){
            if ($menuItem['generate_permission'] == 'ALL'){
                Permission::upsert([
                        ['name' => 'create'.str_replace('/','_',strtolower($menuItem['route'])), 'permission_type_id' => $this->cPermission['id'], 'menu_item_id' => $menuItem['id']],
                        ['name' => 'read'.str_replace('/','_',strtolower($menuItem['route'])), 'permission_type_id' => $this->rPermission['id'], 'menu_item_id' => $menuItem['id']],
                        ['name' => 'update'.str_replace('/','_',strtolower($menuItem['route'])), 'permission_type_id' => $this->uPermission['id'], 'menu_item_id' => $menuItem['id']],
                        ['name' => 'delete'.str_replace('/','_',strtolower($menuItem['route'])), 'permission_type_id' => $this->dPermission['id'], 'menu_item_id' => $menuItem['id']],
                    ],['permission_type_id','menu_item_id'],['name']
                );
            }
            elseif ($menuItem['generate_permission'] == 'MANAGE_ONLY')
                Permission::updateOrCreate(['permission_type_id' => $this->mPermission['id'], 'menu_item_id' => $menuItem['id']],['name' => 'manage'.str_replace('/','_',strtolower($menuItem['route']))]);
            else
                Permission::updateOrCreate(['permission_type_id' => $this->mPermission['id'], 'menu_item_id' => $menuItem['id']],['name' => 'read'.str_replace('/','_',strtolower($menuItem['route']))]);
        }
    }
    
}
