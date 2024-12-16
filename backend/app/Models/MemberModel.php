<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table            = 'member';
    protected $primaryKey       = 'm_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
       'm_email', 'm_password', 'm_gmail', 'm_line', 'm_fb',
       'm_name', 'm_phone', 'm_adress', 'm_role','last_login','reset_token','reset_token_expires'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'm_email' => 'required|valid_email|is_unique[member.m_email,m_id,{m_id}]',
        'm_password' => 'required|min_length[6]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    // 檢查是否為超級管理員
    public function isSuperAdmin($adminId)
    {
        $admin = $this->select('member.*, roles.name as role_name')
                        ->join('roles', 'roles.m_role = member.m_role')
                        ->find($adminId);
        
        return $admin && $admin['role_name'] === 'super_admin';
    }
}