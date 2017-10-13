<?php
namespace Lakshay\Permissions\Traits;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

trait RoleCreate
{
    public function setupRole($model = 'posts', $title = 'writer')
    {
        $role = Role::create(['name' => "{$model} {$title}"]);
        $permissions = BreadGuarded::basePermissions();

        $created = [];
        foreach ($permissions as $permission) {
            $created[] =
                Permission::create(['name' => "{$permission} {$model}"])->name;
        }

        $role->givePermissionTo($created);

        return $role->name;
    }
}
