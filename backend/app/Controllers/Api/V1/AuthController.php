<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Api\V1\BaseApiController;
use Firebase\JWT\JWT;

class AuthController extends BaseApiController
{
    protected $memberModel;
    protected $jwt;
    protected $email;

    public function __construct()
    {
        $this->memberModel = new \App\Models\MemberModel();
        $this->jwt = new \Config\JWT();
        $this->email = \Config\Services::email();
    }

    // 註冊
    public function register()
    {
        $rules = [
            'm_email' => 'required|valid_email|is_unique[member.m_email]',
            'm_password' => 'required|min_length[6]',
            'm_password_confirm' => 'required|matches[m_password]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = $this->request->getPost();
        
        $memberData = [
            'm_email' => $data['m_email'],
            'm_password' => password_hash($data['m_password'], PASSWORD_DEFAULT),
            'm_name' => $data['m_name'] ?? null,
            'm_phone' => $data['m_phone'] ?? null,
            'm_gmail' => $data['m_gmail'] ?? null,
            'm_line' => $data['m_line'] ?? null,
            'm_fb' => $data['m_fb'] ?? null,
            'm_adress' => $data['m_adress'] ?? null,
            'm_role' => 'member'
        ];

        try {
            $this->memberModel->insert($memberData);
            return $this->successResponse('註冊成功', '註冊成功', 200);
        } catch (\Exception $e) {
            return $this->failServer('註冊失敗');
        }
    }

    // 登入
    public function login()
    {
        $data = $this->request->getPost();
        
        $email = $data['m_email'] ?? null;
        $password = $data['m_password'] ?? null;

        if (!$email || !$password) {
            return $this->failValidationError('請提供帳號密碼');
        }

        $member = $this->memberModel->where('m_email', $email)->first();

        if (!$member) {
            return $this->failNotFound('帳號不存在');
        }

        if (!password_verify($password, $member['m_password'])) {
            return $this->failResponse('密碼錯誤', 401);
        }

        // 生成 JWT
        $token = $this->generateJWT($member);

        // 更新最後登入時間
        $this->memberModel->update($member['m_id'], [
            'last_login' => date('Y-m-d H:i:s')
        ]);

        return $this->successResponse([
            'jwt_token' => $token,
            'user' => [
                'm_id' => $member['m_id'],
                'm_email' => $member['m_email'],
                'm_name' => $member['m_name']
            ]
        ], '登入成功', 200);
    }

    // 忘記密碼
    public function forgotPassword()
    {
        $email = $this->request->getPost('m_email');

        if (!$email) {
            return $this->failValidationError('請提供電子郵件');
        }

        $member = $this->memberModel->where('m_email', $email)->first();

        if (!$member) {
            return $this->failNotFound('此電子郵件未註冊');
        }

        // 生成重設密碼 token
        $resetToken = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->memberModel->update($member['m_id'], [
            'reset_token' => $resetToken,
            'reset_token_expires' => $expiry
        ]);

        // 發送重設密碼郵件
        $this->sendResetPasswordEmail($email, $resetToken);

        return $this->successResponse('重設密碼連結已發送至您的信箱', '重設密碼連結已發送至您的信箱', 200);
    }

    // 重設密碼
    public function resetPassword()
    {
        $rules = [
            'token' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('new_password');

        $member = $this->memberModel
            ->where('reset_token', $token)
            ->where('reset_token_expires >', date('Y-m-d H:i:s'))
            ->first();

        if (!$member) {
            return $this->failNotFound('無效或過期的重設連結');
        }

        // 更新密碼
        $this->memberModel->update($member['m_id'], [
            'm_password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expires' => null
        ]);

        return $this->successResponse('密碼重設成功', '密碼重設成功', 200);
    }

    // 產生 JWT
    private function generateJWT($member)
    {
        $payload = [
            'm_id' => $member['m_id'],
            'm_email' => $member['m_email'],
            'm_role' => $member['m_role'],
            'iat' => time(),
            'exp' => time() + $this->jwt->expire
        ];

        return JWT::encode($payload, $this->jwt->key, $this->jwt->algorithm);
    }

    // 發送重設密碼郵件
    private function sendResetPasswordEmail($email, $token)
    {
        $resetUrl = site_url("reset-password?token={$token}");

        $emailService = \Config\Services::email();

        // 設定會自動從 .env 讀取
        $emailService->initialize([
            'mailType' => 'html' // 可以發送 HTML 格式郵件
        ]);
        
        $emailService->setFrom(getenv('email.fromEmail'), getenv('email.fromName'));
        $emailService->setTo($email);
        $emailService->setSubject('重設密碼');
        
        // HTML 格式的郵件內容
        $message = "
        <h2>重設密碼請求</h2>
        <p>您好，</p>
        <p>我們收到了您的重設密碼請求。請點擊下方連結重設密碼：</p>
        <p><a href='{$resetUrl}'>{$resetUrl}</a></p>
        <p>此連結將在一小時後失效。</p>
        <p>如果這不是您發起的請求，請忽略此郵件。</p>
        ";

        $emailService->setMessage($message);

        try {
            $emailService->send();
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Email sending failed: ' . $e->getMessage());
            return false;
        }
    }
}