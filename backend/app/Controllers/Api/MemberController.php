<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

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
        $member = $this->memberModel->find($userData->m_id);

        if (!$member) {
            return $this->failNotFound('用戶不存在');
        }

        unset($member['m_password']);
        unset($member['reset_token']);
        unset($member['reset_token_expires']);
        unset($member['verification_token']);

        return $this->respond([
            'status' => true,
            'data' => $member
        ]);
    }

    // 更新個人資料
    public function update()
    {
        $userData = $this->request->userData;
        $data = $this->request->getJSON(true);

        $rules = [
            'm_name' => 'permit_empty|string|min_length[2]',
            'm_phone' => 'permit_empty|string|min_length[8]',
            'm_adress' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $allowedFields = [
            'm_name',
            'm_phone',
            'm_adress',
            'm_line',
            'm_fb'
        ];

        $updateData = array_intersect_key($data, array_flip($allowedFields));

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
        $data = $this->request->getJSON(true);

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

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
        $data = $this->request->getJSON(true);

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