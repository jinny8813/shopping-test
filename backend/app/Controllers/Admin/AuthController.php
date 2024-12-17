<?php
// backend/app/Controllers/Admin/AuthController.php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use App\Libraries\CustomRequest;

/**
 * @property CustomRequest $request
 */
class AuthController extends ResourceController
{
    protected $adminModel;
    protected $adminLogModel;
    protected $session;

    public function __construct()
    {
        $this->adminModel = new \App\Models\AdminModel();
        $this->adminLogModel = new \App\Models\AdminLogModel();
        $this->session = session();
    }

    // 獲取初始 CSRF token
    public function getCsrf()
    {
        // 生成新的 CSRF token
        $newCsrfToken = csrf_hash();
        $this->session->set('csrf_token', $newCsrfToken);
        
        return $this->respond([
            'status' => true,
            'csrf_token' => $newCsrfToken
        ]);
    }

    // 管理員登入
    public function login()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        // 從 header 獲取 CSRF token
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        
        // 如果沒有 CSRF token，返回錯誤
        if (empty($csrfToken)) {
            return $this->fail('請先獲取 CSRF token');
        }
        
        // 驗證 CSRF token
        if ($csrfToken !== $this->session->get('csrf_token')) {
            return $this->fail('無效的請求');
        }

        $data = $this->request->getPost();
        
        // 驗證用戶
        $admin = $this->adminModel->where('username', $data['username'])
                                ->where('status', 'active')
                                ->first();

        if (!$admin || !password_verify($data['password'], $admin['password'])) {
            return $this->failUnauthorized('帳號或密碼錯誤');
        }

        // 生成 JWT
        $jwt = new \Config\JWT();
        $token = JWT::encode([
            'admin_id' => $admin['admin_id'],
            'username' => $admin['username'],
            'role' => $admin['role'],
            'iat' => time(),
            'exp' => time() + $jwt->expire
        ], $jwt->key, $jwt->algorithm);

        // 設置 session
        $this->session->set([
            'admin_logged_in' => true,
            'admin_id' => $admin['admin_id'],
            'admin_role' => $admin['role']
        ]);

        // 生成新的 CSRF token
        $newCsrfToken = csrf_hash();
        $this->session->set('csrf_token', $newCsrfToken);

        // 更新最後登入時間
        $this->adminModel->updateLoginTime($admin['admin_id']);

        // 記錄登入日誌
        $this->adminLogModel->logActivity(
            $admin['admin_id'],
            'login',
            '管理員登入成功'
        );
        
        return $this->respond([
            'status' => true,
            'message' => '登入成功',
            'token' => $token,
            'csrf_token' => $newCsrfToken,
            'admin' => [
                'admin_id' => $admin['admin_id'],
                'username' => $admin['username'],
                'name' => $admin['name'],
                'role' => $admin['role']
            ]
        ]);
    }

    // 管理員登出
    public function logout()
    {
        $adminData = $this->request->adminData;
        
        // 記錄登出日誌
        $this->adminLogModel->logActivity(
            $adminData->admin_id,
            'logout',
            '管理員登出'
        );

        // 清除 session
        $this->session->destroy();

        return $this->respond([
            'status' => true,
            'message' => '登出成功'
        ]);
    }

    // 獲取個人資料
    public function profile()
    {
        $adminData = $this->request->adminData;
        $admin = $this->adminModel->getSafeAdminData($adminData->admin_id);

        return $this->respond([
            'status' => true,
            'data' => $admin,
            'csrf_token' => $this->session->get('csrf_token')
        ]);
    }

    public function update($id = null)
    {
        $adminData = $this->request->adminData;
        $data = $this->request->getJSON(true);

        // 檢查是否有權限更新
        if ($id !== null && $id != $adminData->admin_id) {
            return $this->fail('無權限修改其他管理員的資料');
        }

        // 獲取當前管理員資料
        $currentAdmin = $this->adminModel->find($adminData->admin_id);
        if (!$currentAdmin) {
            return $this->failNotFound('找不到管理員資料');
        }

        // 準備更新資料
        $updateData = [];
        
        // 檢查並驗證名稱
        if (isset($data['name'])) {
            $rules['name'] = 'required|min_length[2]';
            if (!$this->validate(['name' => $rules['name']])) {
                return $this->failValidationErrors($this->validator->getErrors());
            }
            if ($data['name'] !== $currentAdmin['name']) {
                $updateData['name'] = $data['name'];
            }
        }

        // 檢查並驗證 Email
        if (isset($data['email'])) {
            $rules['email'] = 'required|valid_email';
            if (!$this->validate(['email' => $rules['email']])) {
                return $this->failValidationErrors($this->validator->getErrors());
            }
            
            // 只有當 email 有變更時才檢查是否被使用
            if ($data['email'] !== $currentAdmin['email']) {
                // 檢查 email 是否已被其他人使用
                $existingAdmin = $this->adminModel->where('email', $data['email'])
                                                ->where('admin_id !=', $adminData->admin_id)
                                                ->first();
                if ($existingAdmin) {
                    return $this->failResourceExists('此 Email 已被使用');
                }
                $updateData['email'] = $data['email'];
            }
        }

        // 檢查是否有需要更新的資料
        if (empty($updateData)) {
            return $this->respond([
                'status' => false,
                'message' => '沒有要更新的資料'
            ]);
        }

        // 更新資料
        try {
            $this->adminModel->update($adminData->admin_id, $updateData);

            // 記錄日誌
            $this->adminLogModel->logActivity(
                $adminData->admin_id,
                'update_profile',
                '更新個人資料: ' . implode(', ', array_keys($updateData))
            );

            return $this->respond([
                'status' => true,
                'message' => '個人資料更新成功',
                'data' => array_merge($currentAdmin, $updateData),
                'csrf_token' => $this->session->get('csrf_token')
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Admin Update] Error: ' . $e->getMessage());
            return $this->fail('更新資料時發生錯誤');
        }
    }

    // 修改密碼
    public function changePassword()
    {
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $adminData = $this->request->adminData;
        $data = $this->request->getJSON(true);

        $admin = $this->adminModel->find($adminData->admin_id);

        if (!password_verify($data['current_password'], $admin['password'])) {
            return $this->failValidationError('目前密碼錯誤');
        }

        $this->adminModel->update($adminData->admin_id, [
            'password' => password_hash($data['new_password'], PASSWORD_DEFAULT)
        ]);

        $this->adminLogModel->logActivity(
            $adminData->admin_id,
            'change_password',
            '修改密碼成功'
        );

        return $this->respond([
            'status' => true,
            'message' => '密碼修改成功',
            'csrf_token' => $this->session->get('csrf_token')
        ]);
    }
}