<?php

namespace App\Libraries;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * @property object|null $userData
 */
class CustomRequest extends IncomingRequest
{
    public ?object $userData = null;
}