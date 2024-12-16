<?php
// backend/app/Models/AdminLogModel.php

namespace App\Models;

use CodeIgniter\Model;

class AdminLogModel extends Model
{
    protected $table = 'admin_logs';
    protected $primaryKey = 'log_id';
    protected $allowedFields = [
        'admin_id',
        'action',
        'description',
        'ip_address'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = false;

    // 記錄管理員操作
    public function logActivity($adminId, $action, $description)
    {
        return $this->insert([
            'admin_id' => $adminId,
            'action' => $action,
            'description' => $description,
            'ip_address' => service('request')->getIPAddress()
        ]);
    }

    // 獲取管理員的最近操作記錄
    public function getAdminRecentLogs($adminId, $limit = 10)
    {
        return $this->where('admin_id', $adminId)
                   ->orderBy('created_at', 'DESC')
                   ->limit($limit)
                   ->find();
    }

    // 獲取所有日誌（帶分頁）
    public function getAllLogs($page = 1, $perPage = 20)
    {
        return $this->select('admin_logs.*, admin.username, admin.name')
                   ->join('admin', 'admin.admin_id = admin_logs.admin_id')
                   ->orderBy('created_at', 'DESC')
                   ->paginate($perPage, 'default', $page);
    }
}