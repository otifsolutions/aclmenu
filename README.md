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

### Steps To Use

Create user role and menu items via seeder and then create default user permissions sync seeder to sync permissions.

1. Create UserRole  ( via Seeder )

```php
 UserRole::updateOrCreate(
    ['id' => 1],[
        'name' => 'USERTYPE'
    ]);
```

`name` is user type might be ADMIN, EMPLOYEE or COSTUMER

2. Create Menu Items against User Roles.

```php
 MenuItem::updateOrCreate(
    ['id' => 1], [
        'order_number'=> 'any',
        'parent_id' => 'any',
        'icon' => 'feather icon-home',
        'name' => 'dashboard',
        'route' => '/dashboard',
         'generate_permission' => 'ALL'
     ])
     ->user_roles()
     ->sync([1]);
```

here `order_number` is the number of item that we want to show in an order and `parent_id` is id of that parent_item.

3. sync Permissions against those menu Items.

```php
{
 $userRole = UserRole::where(['name' => 'ADMIN'])->first();
 $permissions = Permission::whereIn('menu_item_id',$userRole->menu_items()->pluck('id'))->pluck('id');
 $userRole->permissions()->sync($permissions);
}
```

Run the seeders first to implement the changes

```
php artisan db:seed
```
Add following command in DatabaseSeeder after UsersTableSeeder

```
Artisan::call('aclmenu:refresh');
```
Teams Can be Created Via Seeder

### Goals


- Routes Middleware to Restrict Unauthorized User Access
- In Controller Check permission via `hasPermission` method.

✨####Permission Handling✨

- Add User role against a team e.g Manager
- Assign Permissions for that User Role.
- Team members will be created against that User Role

### details

This package is used to handle sidebar and permissions








