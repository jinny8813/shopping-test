<?php

namespace App\Libraries;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property object|null $userData, $adminData
 */
class CustomRequest extends IncomingRequest
{
    public ?object $userData = null;
    public ?object $adminData = null;
}