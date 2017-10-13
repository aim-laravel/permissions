<?php

namespace Lakshay\Permissions\Exceptions;

use Exception;

class PermissionDeniedException extends Exception
{
    /**
     * Create a new Permission Denial exception.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($message = 'Permission Denied.')
    {
        parent::__construct($message);
    }
}
