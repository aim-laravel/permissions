<?php

namespace Lakshay\Permissions\Contracts;

interface Role
{
    public function hasPermissionTo($permission, $guardName = null): bool;
    public function hasAnyPermission(...$permissions): bool;
}
