<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'media_id';
    protected $allowedFields = [
        'related_id',
        'related_type',
        'media_type',
        'file_name',
        'original_name',
        'file_path',
        'file_type',
        'file_size',
        'video_url',
        'thumbnail_path'
    ];
    protected $useTimestamps = true;
}