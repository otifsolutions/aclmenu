# aclmenu

### Requirements
```
PHP 5 > 5.3.0
```
```
Laravel > 5.0
```

### How to install the library

Install via Composer

__Using Composer (Recommended)__

Either run the following command in the root directory of your project:

```
 composer require otifsolutions/aclmenu
```

### Steps

1. Create User Role  ( via Seeder )

    ```php
    UserRole::updateOrCreate(
        ['id' => 1],[
           'name' => 'ADMIN'
        ]);
    ```

2. Create Menu Items for Created `UserRole`.
    ```php
    MenuItem::updateOrCreate(
     ['id' => 1], [
         'order_number'=> 1,
         'parent_id' => null,
         'icon' => 'feather icon-home',
         'name' => 'dashboard',
         'route' => '/dashboard',
         'generate_permission' => 'ALL'
      ])
         ->user_roles()
         ->sync([1]);
    ```

   | Option       | type          |Description                             |
   |-------------:|--------------:|---------------------------------------:|
   |`order_number`|  INT          |Number to show the item in sequence,    |
   | `parent_id`  |  INT          |Id of any item as a parent menu item    |
   | `icon`       |  Varchar      |Icon of created menu item.              |
   | `name`       |  Varchar      |Show the name of created menu item.     |
   | `route`      |  Varchar      |Middleware is set on route that restrict unauthorized user access    | 

    - `generate_permission` is `ENUM` type of granted permission to the User Role, that are
      'ALL', 'MANAGE_ONLY', 'READ_ONLY'.

   | Option      |Description                                     |
   |------------:|-----------------------------------------------:|
   | All         | Allow user role to create, read, update, delete|
   | MANAGE_ONLY | Allow user role manage.                        |
   | READ_ONLY   | show that User can only read.                  | 

3. Sync Permissions against Menu Items.

    ```php
    {
    $userRole = UserRole::where(['name' => 'ADMIN'])->first();
    $permissions = Permission::whereIn('menu_item_id',$userRole->menu_items()->pluck('id'))->pluck('id');
    $userRole->permissions()->sync($permissions);
    }
    ```
4. #### ACLUserTrait

* Use `OTIFSolutions\ACLMenu\Traits\ACLUserTrait` in `User` model,
* Following methods are used in this trait 
  
  | Method       | relation               | Description                                                                    |
  |------------:|---------------------:|-----------------------------------------------------------------------------------:|
  | user_role   |One To Many (Inverse) | |
  | group       |One To Many (Inverse) | |
  | parent_team |One To Many (Inverse) | |
  | child_team  |One To Many           | |
  
-  __team__ 
  
     This method is used to find the child or parent account
-  __hasPermission__
  
    This method is used to check the user has permission or not to access the page. 

-  __hasPermissionMenuItem__

    Check the user has permission or not to access the menu item.

5. Register the artisan command in database seeder after `$this->call(UsersTablesSeeder::class) ` in
   App/Database/Seeder/DatabaseSeeder file;
    ```
    Artisan::call('aclmenu:refresh');
    ```
6.

* In Controller Check permission using `hasPermission` method.
    ```
    Auth::user()->hasPermission('');
    ```

7. Run the seeder to implement the changes
    ```
    php artisan db:seed
    ```
###config
* Using this file user is redirected to the dashboard e.g. `/`
* It shows that where user model is exist

### Middleware

- Middleware Handle an incoming request.
- If request is coming from authenticated user, it will be redirected to the dashboard otherwise redirected to the
  homepage. e.g. `->middleware('role:chart')`

### MODELS

+ __MenuItem__

  | Methode       | relation    |Description                                                                                           |          
  |------------:|------------:|-------------------------------------------------------------------------------------------------------:|
  | children    | one-to-many |Using this method submenu items can be accessed. One menuitem can have one or more than one child items.|
  | permissions | one-to-many |Using this method permission can be accessed. One menuitem can have one or more than one permissions.   |
  | user_roles  | many To Many|This method tells how many user_roles belongs with this menuitem.                                       |

+ __Permission__

  | Method      | relation               |   Description                                       |
  |------------:|-----------------------:|----------------------------------------------------:|
  | menu_item   |  One To Many (Inverse) |This method tells which menuitem belong with permissions |
  | type        |  One To Many (Inverse) |Tells which permission type it belongs               |

+ PermissionType
    * permission types has been created through seeder.
    * These types are "READ", "CREATE", "UPDATE", "DELETE" and "MANAGE".

+ __Team__

  | Method      | relation |Description                                     |
  |------------:|--------:|-----------------------:|
  | owner       | One To Many (Inverse) |This method tells which user belongs with team  |
  | permissions | belongToMany          |This method tells how permissions can be accessed by the teams
  | members     | One To Many           |Using this method members can be fetched from `members` table. A team can have one or more than one members.
  | user_roles  | One To Many           |Using this method user roles can be fetched from `user_roles` table. Team can have one or  more than one user roles

+ __User Role__

  | Method       | relation  | Description                                                                    |
  |------------:|-------:|-----------------------------------------------------------------------------------:|
  | permissions |   belongsToMany        |This method tells how many permissions belong with this `user_role` |
  | menu_items  |   belongsToMany        |This method tells how many menu_items belong with this `user_role`  |
  | team        |   One To Many (Inverse)|Tells which user role belongs with team                        |
  | users       |   One To Many          |Using this method users can be accessed from `users` table. a user role can one or more than one users.         |
  | groups      |   belongsToMany        |This method tells how many groups a user role can have            |

+ __UserRoleGroup__

  | Method      | relation            |Description                                                               |
  |------------:|---------------------:|------------------------------------------------------------------------:|
  | users       | One To Many          |Users can be fetched from `users` table using this method. One user role group can have many users|
  | user_roles  |  belongsToMany       |This method tells how many user roles belong with this `UserRoleGroup`.  |











