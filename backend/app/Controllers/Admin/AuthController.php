<?php
// backend/app/Controllers/Admin/AuthController.php

namespace App\Controllers\Admin;

use Firebase\JWT\JWT;
use App\Libraries\CustomRequest;
use App\Controllers\Admin\BaseAdminController;

/**
 * @property CustomRequest $request
 */
class AuthController extends BaseAdminController
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

    public function getCsrf()
    {
        // 生成新的 CSRF token
        $newCsrfToken = csrf_hash();
        $this->session->set('csrf_token', $newCsrfToken);
        
        return $this->successResponse(
            ['csrf_token' => $newCsrfToken],
            'CSRF token 獲取成功',
            200
        );
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

        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        
        if (empty($csrfToken)) {
            return $this->fail('請先獲取 CSRF token');
        }
        
        if ($csrfToken !== $this->session->get('csrf_token')) {
            return $this->fail('無效的請求');
        }

        $data = $this->request->getPost();
        $admin = $this->adminModel->where('username', $data['username'])
                                ->where('status', 'active')
                                ->first();

        if (!$admin || !password_verify($data['password'], $admin['password'])) {
            return $this->failUnauthorized('帳號或密碼錯誤');
        }

        $jwt = new \Config\JWT();
        $token = JWT::encode([
            'admin_id' => $admin['admin_id'],
            'username' => $admin['username'],
            'role' => $admin['role'],
            'iat' => time(),
            'exp' => time() + $jwt->expire
        ], $jwt->key, $jwt->algorithm);

        $this->session->set([
            'admin_logged_in' => true,
            'admin_id' => $admin['admin_id'],
            'admin_role' => $admin['role']
        ]);

        $newCsrfToken = csrf_hash();
        $this->session->set('csrf_token', $newCsrfToken);

        $this->adminModel->updateLoginTime($admin['admin_id']);

        $this->adminLogModel->logActivity(
            $admin['admin_id'],
            'login',
            '管理員登入成功'
        );
        
        return $this->successResponse([
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
            ],
            '登入成功',
            200
        );
    }

    // 管理員登出
    public function logout()
    {
        $adminData = $this->request->adminData;
        
        $this->adminLogModel->logActivity(
            $adminData->admin_id,
            'logout',
            '管理員登出'
        );

        $this->session->destroy();

        return $this->successResponse(
            ['message' => '登出成功'],
            '登出成功',
            200
        );
    }

    // 獲取個人資料
    public function profile()
    {
        $adminData = $this->request->adminData;
        $admin = $this->adminModel->getSafeAdminData($adminData->admin_id);

        return $this->successResponse(
            ['data' => $admin],
            '個人資料獲取成功',
            200
        );
    }

    // 更新個人資料
    public function update($id = null)
    {
        $adminData = $this->request->adminData;
        
        if ($id !== null && $id != $adminData->admin_id) {
            return $this->failForbidden('無權限修改其他管理員的資料');
        }

        $currentAdmin = $this->adminModel->find($adminData->admin_id);
        if (!$currentAdmin) {
            return $this->failNotFound('找不到管理員資料');
        }

        $data = $this->request->getJSON(true);

        $rules = [
            'username' => 'permit_empty|min_length[3]|is_unique[admin.username]',
            'password' => 'permit_empty|min_length[6]',
            'name' => 'permit_empty',
            'email' => "permit_empty|valid_email|is_unique[admin.email,admin_id,{$id}]"
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        };

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
                $this->adminModel->update($adminData->admin_id, $updateData);
                $this->adminLogModel->logActivity(
                    $adminData->admin_id,
                    'update_profile',
                    '更新個人資料: ' . implode(', ', array_keys($updateData))
                );
        
                return $this->successResponse(
                    ['admin' => $updateData],
                    '個人資料更新成功',
                    200
                );
            }
            return $this->failResponse(
                '沒有要更新的資料',
                400
            );
        } catch (\Exception $e) {
            return $this->failServerError('更新失敗');
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

        return $this->successResponse(
            ['message' => '密碼修改成功'],
            '密碼修改成功',
            200
        );
    }
}