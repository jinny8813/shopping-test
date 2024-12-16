<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\CustomRequest;

/**
 * @property CustomRequest $request
 */
class AdminController extends ResourceController
{
    protected $adminModel;
    protected $adminLogModel;

    public function __construct()
    {
        $this->adminModel = new \App\Models\AdminModel();
        $this->adminLogModel = new \App\Models\AdminLogModel();
    }

    // 獲取管理員列表
    public function index()
    {
        $adminData = $this->request->adminData;
        
        // 檢查權限
        if (!$this->adminModel->isSuperAdmin($adminData->admin_id)) {
            return $this->failForbidden('無權限執行此操作');
        }

        $admins = $this->adminModel->select('admin_id, username, name, email, role, status, last_login, created_at')
                                 ->findAll();

        return $this->respond([
            'status' => true,
            'data' => $admins
        ]);
    }

    // 新增管理員
    public function create()
    {
        $adminData = $this->request->adminData;
        
        // 檢查權限
        if (!$this->adminModel->isSuperAdmin($adminData->admin_id)) {
            return $this->failForbidden('無權限執行此操作');
        }

        $rules = [
            'username' => 'required|min_length[3]|is_unique[admin.username]',
            'password' => 'required|min_length[6]',
            'name' => 'required',
            'email' => 'required|valid_email|is_unique[admin.email]',
            'role' => 'required|in_list[admin]' // 只允許創建一般管理員
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->request->getPost();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['status'] = 'active';

        $this->adminModel->insert($data);


        $this->adminLogModel->logActivity(
            $adminData->admin_id,
            'create_admin',
            "創建新管理員: {$data['username']}"
        );
    
        return $this->respondCreated([
            'status' => true,
            'message' => '管理員新增成功'
        ]);
    }

    // 獲取管理員詳情
    public function show($id = null)
    {
        $admin = $this->adminModel->getSafeAdminData($id);

        if (!$admin) {
            return $this->failNotFound('管理員不存在');
        }

        return $this->respond([
            'status' => true,
            'data' => $admin
        ]);
    }

    // 更新管理員資料
    public function update($id = null)
    {
        $adminData = $this->request->adminData;
        
        // 檢查權限
        if ($id != $adminData->admin_id && !$this->adminModel->isSuperAdmin($adminData->admin_id)) {
            return $this->failForbidden('無權限執行此操作');
        }

        $data = $this->request->getJSON(true);

        $rules = [
            'username' => 'permit_empty|min_length[3]|is_unique[admin.username]',
            'password' => 'permit_empty|min_length[6]',
            'name' => 'permit_empty',
            'email' => "permit_empty|valid_email|is_unique[admin.email,admin_id,{$id}]",
            'role' => 'permit_empty|in_list[admin]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $allowedFields = [
            'username',
            'password',
            'name',
            'email'
        ];

        $updateData = array_intersect_key($data ?? [], array_flip($allowedFields));
        $updateData = array_filter($updateData, function($value) {
            return $value !== null;
        });

        try {
            if (!empty($updateData)) {
                $this->adminModel->update($id, $data);
                $this->adminLogModel->logActivity(
                    $adminData->admin_id,
                    'update_admin',
                    "更新管理員資料: ID {$id}"
                );
        
                return $this->respond([
                    'status' => true,
                    'message' => '更新成功'
                ]);
            }
            return $this->respond([
                'status' => false,
                'message' => '沒有要更新的資料'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('更新失敗');
        }
    }

    // 刪除管理員
    public function delete($id = null)
    {
        $adminData = $this->request->adminData;
        
        // 檢查權限
        if (!$this->adminModel->isSuperAdmin($adminData->admin_id)) {
            return $this->failForbidden('無權限執行此操作');
        }

        // 不能刪除自己
        if ($id == $adminData->admin_id) {
            return $this->failForbidden('不能刪除自己的帳號');
        }

        // 檢查是否為超級管理員
        if ($this->adminModel->isSuperAdmin($id)) {
            return $this->failForbidden('不能刪除超級管理員帳號');
        }

        $this->adminModel->delete($id);

        $this->adminLogModel->logActivity(
            $adminData->admin_id,
            'delete_admin',
            "刪除管理員: ID {$id}"
        );

        return $this->respondDeleted([
            'status' => true,
            'message' => '刪除成功'
        ]);
    }

    // 獲取操作日誌
    public function logs()
    {
        $page = $this->request->getGet('page') ?? 1;
        $limit = $this->request->getGet('limit') ?? 20;

        $logs = $this->adminLogModel->getAllLogs($page, $limit);

        return $this->respond([
            'status' => true,
            'data' => $logs,
            'pager' => [
                'current_page' => $page,
                'total_pages' => ceil($this->adminLogModel->countAllResults() / $limit)
            ]
        ]);
    }
}