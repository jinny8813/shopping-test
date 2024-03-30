<?php

namespace App\Database\Migrations;

use App\Database\Migrations\Members;
use App\Database\Migrations\Products;

class initDataBase
{
    public static function initDataBase($group = "default")
    {   
        \Config\Services::migrations()->setGroup($group);
        // self::createTable($group);
        // return true;
    }

    public static function createTable($group)
    {
        (new Members(\Config\Database::forge($group)))->up();
        (new Products(\Config\Database::forge($group)))->up();
    }

    public static function deleteTables($group)
    {
        (new Members(\Config\Database::forge($group)))->down();
        (new Products(\Config\Database::forge($group)))->down();
    }
}
