<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class JWT extends BaseConfig
{
    /**
     * @var string
     */
    public $key;

    /**
     * @var string
     */
    public $algorithm = 'HS256';

    /**
     * @var int
     */
    public $expire = 3600;

    public function __construct()
    {
        parent::__construct();
        $this->key = getenv('JWT_SECRET_KEY') ?: 'shopping_secret_key';
    }
}