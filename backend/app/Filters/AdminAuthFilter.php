<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AdminAuthFilter implements FilterInterface
{
    protected $jwt;
    protected $session;
    protected $excludedPaths = [
        'admin/login',
        'admin/forgot-password',
        'admin/reset-password'
    ];

    public function __construct()
    {
        $this->jwt = new \Config\JWT();
        $this->session = service('session');
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $currentPath = $request->uri->getPath();
        $response = service('response');

        // 排除不需要驗證的路徑
        if (in_array($currentPath, $this->excludedPaths)) {
            // 生成新的 CSRF token
            $this->session->set('csrf_token', csrf_hash());
            return;
        }

        // 檢查 session 登入狀態
        if (!$this->session->get('admin_logged_in')) {
            return $response->setStatusCode(401)
                ->setJSON(['error' => '請先登入']);
        }

        // 驗證 CSRF Token (除了 API 請求外)
        if (!str_starts_with($currentPath, 'api/')) {
            $csrfToken = $request->getHeaderLine('X-CSRF-TOKEN');
            if ($csrfToken !== $this->session->get('csrf_token')) {
                return $response->setStatusCode(403)
                    ->setJSON([
                        'status' => false,
                        'message' => 'CSRF token 已過期，請重新整理頁面'
                    ]);
            }
        }

        try {
            // 驗證 JWT
            $token = $request->getHeaderLine('Authorization');
            if (empty($token)) {
                return $response->setStatusCode(401)
                    ->setJSON(['error' => '無效的登入狀態']);
            }

            $token = str_replace('Bearer ', '', $token);
            $decoded = JWT::decode(
                $token,
                new Key($this->jwt->key, $this->jwt->algorithm)
            );

            // 檢查 JWT 中的用戶資訊與 session 是否一致
            if ($decoded->admin_id !== $this->session->get('admin_id')) {
                $this->session->destroy();
                return $response->setStatusCode(401)
                    ->setJSON(['error' => '登入狀態不一致，請重新登入']);
            }

            // 檢查權限
            if ($decoded->role !== 'admin' && $decoded->role !== 'super_admin') {
                return $response->setStatusCode(403)
                    ->setJSON(['error' => '無權限訪問後台']);
            }

            // 生成新的 CSRF token
            $newCsrfToken = csrf_hash();
            $this->session->set('csrf_token', $newCsrfToken);

            // 在回應標頭中加入新的 CSRF token
            $response->setHeader('X-CSRF-TOKEN', $newCsrfToken);

            $request->adminData = $decoded;
            return $request;

        } catch (\Exception $e) {
            $this->session->destroy();
            return $response->setStatusCode(401)
                ->setJSON(['error' => '無效的登入狀態']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // 可以在這裡添加響應後的處理邏輯
    }
}