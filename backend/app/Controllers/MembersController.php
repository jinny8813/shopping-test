<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use App\Models\MembersModel;
use CodeIgniter\HTTP\ResponseInterface;

class MembersController extends ResourceController
{
    protected $modelName = 'App\Models\MembersModel';
    protected $format = 'json';

    /**
     * @var \Config\JWT
     */
    protected $jwt;

    public function __construct()
    {
        $this->jwt = new \Config\JWT();
    }

    public function register()
    {
        $data = $this->request->getPost();

        $rules = [
            'm_email' => 'required|valid_email|is_unique[members.m_email]',
            'm_password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors());
        }

        $memberData = [
            'm_email' => $data['m_email'] ?? null,
            'm_password' => password_hash($data['m_password'], PASSWORD_DEFAULT),
            'm_gmail' => $data['m_gmail'] ?? null,
            'm_line' => $data['m_line'] ?? null,
            'm_fb' => $data['m_fb'] ?? null,
            'm_name' => $data['m_name'] ?? null,
            'm_phone' => $data['m_phone'] ?? null,
            'm_adress' => $data['m_adress'] ?? null,
            'm_role' => 'member'
        ];

        try {
            $this->model->insert($memberData);
            return $this->respondCreated(['message' => '註冊成功']);
        } catch (\Exception $e) {
            return $this->failServerError('註冊失敗');
        }
    }

    public function login()
    {
        $data = $this->request->getPost();
        
        $email = $data['m_email'] ?? null;
        $password = $data['m_password'] ?? null;

        if (!$email || !$password) {
            return $this->failValidationError('請提供帳號密碼');
        }

        $member = $this->model->where('m_email', $email)->first();

        if (!$member || !password_verify($password, $member['m_password'])) {
            return $this->failUnauthorized('帳號或密碼錯誤');
        }

        $payload = [
            'm_id' => $member['m_id'],
            'm_email' => $member['m_email'],
            'role' => $member['m_role'],
            'iat' => time(),
            'exp' => time() + $this->jwt->expire
        ];

        $token = JWT::encode($payload, $this->jwt->key, $this->jwt->algorithm);

        return $this->respond([
            'status' => true,
            'message' => '登入成功',
            'token' => $token,
            'user' => [
                'm_id' => $member['m_id'],
                'm_email' => $member['m_email'],
                'm_role' => $member['m_role'],
                'm_name' => $member['m_name']
            ]
        ]);
    }

    public function profile()
    {
        $userData = $this->request->userData ?? null;
        if (!$userData) {
            return $this->failUnauthorized('未授權的訪問');
        }

        $member = $this->model->find($userData->m_id);

        if (!$member) {
            return $this->failNotFound('用戶不存在');
        }

        unset($member['m_password']);
        return $this->respond([
            'status' => true,
            'data' => $member
        ]);
    }

    /**
     * Update user data
     *
     * @param int|null $id
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $userData = $this->request->userData ?? null;
        if (!$userData) {
            return $this->failUnauthorized('未授權的訪問');
        }

        $member = $this->model->find($userData->m_id);

        if (!$member) {
            return $this->failNotFound('用戶不存在');
        }

        $data = $this->request->getJSON(true);

        $allowedFields = [
            'm_gmail',
            'm_line',
            'm_fb',
            'm_name',
            'm_phone',
            'm_adress'
        ];

        $updateData = array_intersect_key($data ?? [], array_flip($allowedFields));
        $updateData = array_filter($updateData, function($value) {
            return $value !== null;
        });

        try {
            if (!empty($updateData)) {
                $this->model->update($userData->m_id, $updateData);
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

    /**
     * Delete user
     *
     * @param int|null $id
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $userData = $this->request->userData ?? null;
        if (!$userData) {
            return $this->failUnauthorized('未授權的訪問');
        }
        
        if ($userData->role !== 'admin') {
            return $this->failForbidden('沒有權限執行此操作');
        }

        try {
            if ($this->model->delete($id)) {
                return $this->respondDeleted(['message' => '刪除成功']);
            }
            return $this->failNotFound('用戶不存在');
        } catch (\Exception $e) {
            return $this->failServerError('刪除失敗');
        }
    }
}