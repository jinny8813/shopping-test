<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'setting_id';
    protected $allowedFields = [
        'type',
        'title',
        'content',
        'status',
        'sort_order'
    ];
    protected $useTimestamps = true;
}