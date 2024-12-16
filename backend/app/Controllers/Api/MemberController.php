<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\CustomRequest;

/**
 * @property CustomRequest $request
 */
class MemberController extends ResourceController
{
    protected $memberModel;

    public function __construct()
    {
        $this->memberModel = new \App\Models\MemberModel();
    }

    // 獲取個人資料
    public function profile()
    {
        $userData = $this->request->userData;
        
        if (!$userData) {
            return $this->failUnauthorized('未登入');
        }

        $member = $this->memberModel->find($userData->m_id);

        if (!$member) {
            return $this->failNotFound('用戶不存在');
        }

        unset($member['m_password']);
        unset($member['reset_token']);
        unset($member['reset_token_expires']);

        return $this->respond([
            'status' => true,
            'data' => $member
        ]);
    }

    /**
     * 更新會員資料
     * @param int|null $id
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function update($id = null)
    {
        $userData = $this->request->userData;
        
        if (!$userData) {
            return $this->failUnauthorized('未登入');
        }

        // 確保只能更新自己的資料
        if ($id !== null && $id != $userData->m_id) {
            return $this->failForbidden('無權限修改他人資料');
        }

        $data = $this->request->getJSON(true);

        $rules = [
            'm_name' => 'permit_empty|string|min_length[2]',
            'm_phone' => 'permit_empty|string|min_length[8]',
            'm_adress' => 'permit_empty|string',
            'm_gmail' => 'permit_empty|valid_email',
            'm_line' => 'permit_empty|string',
            'm_fb' => 'permit_empty|string'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $allowedFields = [
            'm_name',
            'm_phone',
            'm_adress',
            'm_gmail',
            'm_line',
            'm_fb'
        ];

        $updateData = array_intersect_key($data ?? [], array_flip($allowedFields));
        $updateData = array_filter($updateData, function($value) {
            return $value !== null;
        });

        try {
            if (!empty($updateData)) {
                $this->memberModel->update($userData->m_id, $updateData);
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

    // 修改密碼
    public function changePassword()
    {
        $userData = $this->request->userData;
        
        if (!$userData) {
            return $this->failUnauthorized('未登入');
        }

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->request->getJSON(true);
        $member = $this->memberModel->find($userData->m_id);

        if (!password_verify($data['current_password'], $member['m_password'])) {
            return $this->failValidationError('目前密碼錯誤');
        }

        try {
            $this->memberModel->update($userData->m_id, [
                'm_password' => password_hash($data['new_password'], PASSWORD_DEFAULT)
            ]);

            return $this->respond([
                'status' => true,
                'message' => '密碼修改成功'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('密碼修改失敗');
        }
    }

    // 註銷會員
    public function deactivate()
    {
        $userData = $this->request->userData;
        
        if (!$userData) {
            return $this->failUnauthorized('未登入');
        }

        $data = $this->request->getJSON(true);
        $member = $this->memberModel->find($userData->m_id);

        if (!password_verify($data['password'] ?? '', $member['m_password'])) {
            return $this->failValidationError('密碼錯誤');
        }

        try {
            // 軟刪除會員資料
            $this->memberModel->delete($userData->m_id);

            return $this->respond([
                'status' => true,
                'message' => '帳號已註銷'
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('註銷失敗');
        }
    }
}