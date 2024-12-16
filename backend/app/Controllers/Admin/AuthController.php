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

    public function __construct()
    {
        $this->adminModel = new \App\Models\AdminModel();
        $this->adminLogModel = new \App\Models\AdminLogModel();
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

        $data = $this->request->getPost();

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
            'data' => $admin
        ]);
    }

     /**
     * 更新資料
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function update($id = null)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $adminData = $this->request->adminData;
        $data = $this->request->getJSON(true);

        // 檢查 email 是否已被其他人使用
        $existingAdmin = $this->adminModel->where('email', $data['email'])
                                        ->where('admin_id !=', $adminData->admin_id)
                                        ->first();
        if ($existingAdmin) {
            return $this->failResourceExists('此 Email 已被使用');
        }

        $this->adminModel->update($adminData->admin_id, [
            'name' => $data['name'],
            'email' => $data['email']
        ]);

        // 記錄日誌
        $this->adminLogModel->logActivity(
            $adminData->admin_id,
            'update_profile',
            '更新個人資料'
        );

        return $this->respond([
            'status' => true,
            'message' => '個人資料更新成功'
        ]);
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
            'message' => '密碼修改成功'
        ]);
    }
}