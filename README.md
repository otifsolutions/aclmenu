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
        'order_number'=> 'any',
        'parent_id' => 'any',
        'icon' => 'feather icon-home',
        'name' => 'chart',
        'route' => '/chart',
         'generate_permission' => 'ALL'
     ])
     ->user_roles()
     ->sync([1]);
```

| Option       | type          |Description                         |
|-------------:|--------------:|-----------------------------------:|
|`order_number`|  INT          |number to show the item in sequence,|
| `parent_id`  |  INT          |We use it to add any item as a sub menu of parent item
| `icon`       |  Varchar      |icon of created menu item.          |
| `name`       |  Varchar      |show the name of created menu item.          |
| `route`      |  Varchar      |middleware route to Restrict Unauthorized User Access        | 

- `generate_permission` is `ENUM` type of granted permission to the User Role, that are
  'ALL', 'MANAGE_ONLY', 'READ_ONLY'.

| Option      |Description                                     |
|------------:|-----------------------------------------------:|
| All         | Allow user role to create, read, update, delete|
| MANAGE_ONLY | Allow user role manage.                        |
| READ_ONLY   | show that User can only read.                            | 

3. Sync Permissions against Menu Items.

```php
{
 $userRole = UserRole::where(['name' => 'ADMIN'])->first();
 $permissions = Permission::whereIn('menu_item_id',$userRole->menu_items()->pluck('id'))->pluck('id');
 $userRole->permissions()->sync($permissions);
}

```

4. #### ACLUserTrait

* Use `ACLUserTrait` in `App/Models/User`,
* ACLUserTrait has all User Roles, Teams and Groups.
* The user role may be an Admin or owner.
* It checks If user role or user role of a group has permission of menu item, it will be returned otherwise not return.
* ACLUserTrait fetches all the described attributes when we use the trait in `User` model

5. Register the artisan command in database seeder after `$this->call(UsersTablesSeeder::class) ` in
   App/Database/Seeder/DatabaseSeeder file;

```
Artisan::call('aclmenu:refresh');
```

6. Run the seeder to implement the changes

```
php artisan db:seed
```
### Middleware

- Middleware Handle an incoming request.
- If user role or group role is has permission or is authenticated, user is redirected to the homepage.
- If user role or group role is has not permissions, it will be redirected to the dashboard.
- Middleware parameters are specified when defining the route by separating the middleware name and parameters with a
  colon `:`
  e.g. `->middleware('role:chart')`.
- Get or set the middlewares attached to the route, the middleware will Restrict Unauthorized User Access.

### MODELS

+ MenuItem
    * MenuItem model on-to-Many relation with the child item and permissions,
    * One MenuItem can have more than one child items and permissions.
    * MenuItem Model also define a many-to-many inverse relationship to allow a UserRole to access all MenuItems.

+ User Role
    * Create user
    * Assign the role to created user e.g. Admin
    * User Role belongs to many `MenuItem` and `Permission` and `groups` models

+ Team
    *
    * Team `hasMany`relationship with  `UserRole` model.
    * Team member may be parent or child user that is owner or newly added user respectively.
    * A team may have more than one member.
    * Team may have more than one permission.
+ UserRoleGroup
    * Group has one-to-many relation with users and many-to-many relation with `User Role`

+ Permission
  * In Controller Check permission using `hasPermission` method.
      ```
      Auth::user()->hasPermission('');
      ```
  * Assign Permissions for created User Role.
  * Permission belongs to `PermissionType` and one menuItem has many permissions .
+ PermissionType
  * permission types has been created through seeder.
  * Permission types are "READ", "CREATE", "UPDATE", "DELETE" and "MANAGE".









