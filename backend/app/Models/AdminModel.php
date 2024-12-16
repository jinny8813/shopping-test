<?php
// backend/app/Models/AdminModel.php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    protected $allowedFields = [
        'username',
        'password',
        'name',
        'email',
        'role',
        'status',
        'last_login'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // 驗證規則
    protected $validationRules = [
        'username' => 'required|min_length[3]|is_unique[admin.username,admin_id,{admin_id}]',
        'email'    => 'required|valid_email|is_unique[admin.email,admin_id,{admin_id}]',
        'name'     => 'required|min_length[2]',
        'password' => 'required|min_length[6]',
        'role'     => 'required|in_list[super_admin,admin]',
        'status'   => 'required|in_list[active,inactive]'
    ];

    // 驗證訊息
    protected $validationMessages = [
        'username' => [
            'required' => '請輸入帳號',
            'min_length' => '帳號至少需要3個字元',
            'is_unique' => '此帳號已被使用'
        ],
        'email' => [
            'required' => '請輸入Email',
            'valid_email' => '請輸入有效的Email格式',
            'is_unique' => '此Email已被使用'
        ]
    ];

    // 檢查是否為超級管理員
    public function isSuperAdmin($adminId)
    {
        $admin = $this->find($adminId);
        return $admin && $admin['role'] === 'super_admin';
    }

    // 更新最後登入時間
    public function updateLoginTime($adminId)
    {
        return $this->update($adminId, [
            'last_login' => date('Y-m-d H:i:s')
        ]);
    }

    // 獲取活躍管理員列表
    public function getActiveAdmins()
    {
        return $this->where('status', 'active')
                   ->findAll();
    }

    // 安全地獲取管理員資料（排除敏感資訊）
    public function getSafeAdminData($adminId)
    {
        $admin = $this->find($adminId);
        if ($admin) {
            unset($admin['password']);
        }
        return $admin;
    }
}