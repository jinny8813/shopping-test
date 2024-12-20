<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Api\V1\BaseApiController;
use App\Libraries\CustomRequest;

/**
 * @property CustomRequest $request
 */
class MemberController extends BaseApiController
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
            return $this->failResponse('未登入', 401);
        }

        $member = $this->memberModel->find($userData->m_id);

        if (!$member) {
            return $this->failNotFound('用戶不存在');
        }

        unset($member['m_password']);
        unset($member['reset_token']);
        unset($member['reset_token_expires']);

        return $this->successResponse($member, '取得個人資料成功', 200);
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
            return $this->failResponse('未登入', 401);
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
                return $this->successResponse('更新成功', '更新成功', 200);
            }
            return $this->successResponse('沒有要更新的資料', '沒有要更新的資料', 200);
        } catch (\Exception $e) {
            return $this->failServer('更新失敗');
        }
    }

    // 修改密碼
    public function changePassword()
    {
        $userData = $this->request->userData;
        
        if (!$userData) {
            return $this->failResponse('未登入', 401);
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

            return $this->successResponse('密碼修改成功', '密碼修改成功', 200);
        } catch (\Exception $e) {
            return $this->failServer('密碼修改失敗');
        }
    }

    // 註銷會員
    public function deactivate()
    {
        $userData = $this->request->userData;
        
        if (!$userData) {
            return $this->failResponse('未登入', 401);
        }

        $data = $this->request->getJSON(true);
        $member = $this->memberModel->find($userData->m_id);

        if (!password_verify($data['password'] ?? '', $member['m_password'])) {
            return $this->failValidationError('密碼錯誤');
        }

        try {
            // 軟刪除會員資料
            $this->memberModel->delete($userData->m_id);

            return $this->successResponse('帳號已註銷', '帳號已註銷', 200);
        } catch (\Exception $e) {
            return $this->failServer('註銷失敗');
        }
    }

    public function logout()
    {
        try {
            $userData = $this->request->userData;
            
            // 更新最後登出時間
            $this->memberModel->update($userData->m_id, [
                'last_login' => date('Y-m-d H:i:s')
            ]);

            return $this->successResponse('登出成功', '登出成功', 200);
        } catch (\Exception $e) {
            return $this->failServer('登出失敗');
        }
    }
}