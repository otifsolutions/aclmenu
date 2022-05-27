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

### Usage

1. Create User Role  ( via Seeder )

    ```php
    UserRole::updateOrCreate(
        ['id' => 1],[
           'name' => 'ADMIN'
        ]);
    ```

2. Create Menu Items for Created `UserRole`.
    ```php
    $id = UserRole::Where(['name' => 'ADMIN'])->get('id');
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
         ->sync($id);
    ```
    `$id` is id of user role that is admin.

   | Option       | type          |Description                             |
   |--------------|---------------|----------------------------------------|
   |`order_number`|  INT          |Number to show the item in sequence.    |
   | `parent_id`  |  INT          |Id of any item as a parent menu item.   |
   | `icon`       |  Varchar      |Icon of created menu item.              |
   | `name`       |  Varchar      |Show the name of created menu item.     |
   | `route`      |  Varchar      |Middleware is set on route that restrict unauthorized user access.    | 

    - `generate_permission` is `ENUM` type of granted permission to the User Role, that are
      'ALL', 'MANAGE_ONLY', 'READ_ONLY'.

   | Option      |Description                                     |
   |-------------|------------------------------------------------|
   | All         | Allow user role to create, read, update, delete.|
   | MANAGE_ONLY | Allow user role manage.                        |
   | READ_ONLY   | show that User can only read.                  | 

3. - User role and permissions are created.
   - Sync the permissions against menu items, so that user can have permissions to access the menu items.
    ```php
    {
    $userRole = UserRole::where(['name' => 'ADMIN'])->first();
    $permissions = Permission::whereIn('menu_item_id',$userRole->menu_items()->pluck('id'))->pluck('id');
    $userRole->permissions()->sync($permissions);
    }
    ```

4. Register the artisan command in database seeder after `$this->call(UsersTablesSeeder::class) ` in
   App/Database/Seeder/DatabaseSeeder file;
    ```
    Artisan::call('aclmenu:refresh');
    ```
5. Run the seeder to implement the changes
    ```
    php artisan db:seed
    ```
 #### ACLUserTrait

* __Use `OTIFSolutions\ACLMenu\Traits\ACLUserTrait` in `User` model,__
* __Following methods are used in this trait__

  | Method      | relation             | Description                                                                    |
  |-------------|----------------------|-----------------------------------------------------------------------------------|
  | user_role   |one-to-many (Inverse) |This method returns user role from `UserRole` model to which user belongs.         |
  | group       |one-to-many (Inverse) |This method returns group from `UserRoleGroup` model to which user belongs.        |
  | parent_team |one-to-many (Inverse) |This method returns parent_team from `Team` model to which it belongs.             |
  | child_team  |one-to-one            |This method returns user who created the team.     |

-  __team__

   This method returns the user who created the team or parent_team.

-  __hasPermission__
    
    * This method checks if the user has permission or not to access the page.
    * Returns `True` if condition is true otherwise return `false`. 
    * Two Attributes are passed when calling the method.
    * One is `permissionTypeString` possible values are READ, CREATE, UPDATE, or DELETE.
    * If no permissionTypeString is passed, READ is considered default.
    * Another attribute is `permission` which is the route of page.
    * In this method if no permission is passed, current permission from sessions is fetched.

-  __hasPermissionMenuItem__

    * This method checks if the user has permission or not to access the menu item.
    * Id of menu item is passed e.g. `menu_item_id`.
    * Boolean value is returned. e.g. true or false.

- __getTeamOwnerAttribute__

  This method returns team owner from the team.

### Config
*  Returns `redirect_url` if user is unauthorized e.g. `/`
*  It shows where user model exists.

### Middleware

- Middleware Handle the incoming request.
- Middleware is set on route.
- If route has permission, intended page will be returned otherwise user is redirected. e.g. `->middleware('role:/dashboard')`

### MODELS

+ __MenuItem__

  | Methode     | relation    |Description                                                                                           |          
  |-------------|-------------|--------------------------------------------------------------------------------------------------------|
  | children    | one-to-many |This method returns submenu items from `MenuItem` model. One menuitem can have one or more child items.|
  | permissions | one-to-many |This method returns list of permissions from `Permission` model. One menuitem can have one or more permissions.   |
  | user_roles  | many-To-many|This method returns list of user_roles that belong to `MenuItem`.                                       |

+ __Permission__

  | Method      | relation               |   Description                                       |
  |------------:|------------------------|-----------------------------------------------------|
  | menu_item   |  one-to-many (Inverse) |This method return menuitem from `MenuItem` model that belongs to permission. |
  | type        |  one-to-many (Inverse) |This method return permission type which belongs to permission.               |

+ __PermissionType__
    * permission types has been created through seeder.
    * These types are "READ", "CREATE", "UPDATE", "DELETE" and "MANAGE".

+ __Team__

  | Method      | relation |Description |
  |-------------|----------|--------------------------------------------------------------------------------------------------------------|
  | owner       | one-to-many(Inverse)  |This method returns user who creates the team. A team can have only one owner.                        |
  | permissions | belongToMany          |This method returns list of permissions from `Permission` model that belongs to `Team`.
  | members     | one-to-many           |This method returns list of members. A team can have one or more members.
  | user_roles  | one-to-many           |This method returns list of user_roles from `UserRole` model. Team can have one or more user roles.

+ __User Role__

  | Method       | relation  | Description                                                                                    |
  |-------------|------------------------|------------------------------------------------------------------------------------|
  | permissions |   belongsToMany        |This method returns list of `permissions` from `Permission` model that belong to user_role. |
  | menu_items  |   belongsToMany        |This method returns list of menu_items from `MenuItem` belong with user_role.  |
  | team        |   one-to-many (Inverse)|This method returns team which belongs to user role.                    |
  | users       |   one-to-many          |This method returns list of users from `User` model. A user role can one or more users.         |
  | groups      |   belongsToMany        |This method returns groups that belong to UserRoleGroup.          |

+ __UserRoleGroup__

  | Method      | relation        |Description                                                              |
  |-------------|-----------------|-------------------------------------------------------------------------|
  | users       | one-to-many     |This method returns list of users object. One user role group can have one or more users.|
  | user_roles  | belongsToMany   |This method returns list of user_roles from `UserRole` that belong with `UserRoleGroup` model.  |

  ### Teams
__Step. 1__
+  First team is created with a `user_id` when creates new user.

__Step. 2__

+ After creation of team, team owner creates user role and assign the permission to this role.
+ User role has permissions that are assigned by the owner who creates user. 

__Step. 3__
  
+ Depending on the role job, user role can assign the permissions that it has.
+ User role can access the menu items which are allowed by user who creates the user role.
+ `Permission_id` is fetched from `Permission` model to assign permission to user role.
+ When user assigns the permissions, will sync the user role.
 
__Step. 4__
+ Members can be added by using the user role.
+ When the new user is created it can do things which are assigned.

    













