<?php

namespace Lakshay\Permissions\Traits;

use Lakshay\Permissions\Contracts\Role;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

trait BreadGuarded
{
    /**
     * Permission initials to be used
     *
     * @return string
     */
    public static function modelName()
    {
        return 'model';
    }

    public static function getModelName()
    {
        return self::modelName();
    }

    public static function basePermissions()
    {
        return [
            'browse'    => 'browse',
            'read'      => 'read',
            'view'      => 'view',
            'edit'      => 'edit',
            'add'       => 'add',
            'delete'    => 'delete',
            'create'    => 'create',
        ];
    }

    public static function permissionTo($key)
    {
        $permissions = self::basePermissions();

        return array_key_exists($key, $permissions)
                ? $permissions[$key]
                : $key;
    }

    public static function availablePermissions()
    {
        return array_map(function ($permission) {
            return self::modelName() . " " . $permission;
        }, self::basePermissions());
    }

    /**
     * In case if Permission has not been created in the database yet.
     *
     * @return bool
     */
    private static function fallbackPermission()
    {
        return false;
    }

    /**
     * Check if the $user object has permissions to go beyond the $guard
     *
     * @param Role $user
     * @param string $guard
     * @return bool
     */
    public static function allows(Role $user, $guard = "any")
    {
        try {
            $allowed = $user->hasPermissionTo($guard . " " . self::modelName());
        } catch (PermissionDoesNotExist $e) {
            // Permission hasn't been created in database.
            $allowed = self::fallbackPermission();
        }
        return $allowed;
    }

    /**
     * Check if the $user has permission to CREATE the model this function was called from.
     *
     * @param Role $user
     * @return bool
     */
    public static function allowsCreation(Role $user)
    {
        return self::allows($user, self::permissionTo('create')) || self::allows($user, self::permissionTo('add'));
    }


    /**
     * Check if the $user has permission to ADD the model this function was called from.
     *    PS: ADD and CREATE are same, just matter of preferences.
     * @param Role $user
     * @return bool
     */
    public static function allowsAdd(Role $user)
    {
        return self::allowsCreation($user);
    }

    /**
     * Check if the $user can browse records of current model.
     *
     * @param Role $user
     * @return bool
     */
    public function allowsBrowse(Role $user)
    {
        return self::allows($user, self::permissionTo('browse'));
    }


    /**
     * Check if the $user has permission to READ the model this function was called from.
     *
     * @param Role $user
     * @return bool
     */
    public function allowsRead(Role $user)
    {
        return self::allows($user, self::permissionTo('read'));
    }


    /**
     * Check if the $user has permission to EDIT the model this function was called from.
     *
     * @param Role $user
     * @return bool
     */
    public function allowsEdit(Role $user)
    {
        return self::allows($user, self::permissionTo('edit'));
    }


    /**
     * Check if the $user has permission to DELETE the model this function was called from.
     *
     * @param Role $user
     * @return bool
     */
    public function allowsDelete(Role $user)
    {
        return self::allows($user, self::permissionTo('delete'));
    }
}
