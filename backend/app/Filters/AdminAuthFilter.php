<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AdminAuthFilter implements FilterInterface
{
    /**
     * @var \Config\JWT
     */
    protected $jwt;

    public function __construct()
    {
        $this->jwt = new \Config\JWT();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');

        try {
            $token = $request->getHeaderLine('Authorization');
            if (empty($token)) {
                return $response->setStatusCode(401)
                    ->setJSON(['error' => '請先登入']);
            }

            $token = str_replace('Bearer ', '', $token);
            $decoded = JWT::decode(
                $token,
                new Key($this->jwt->key, $this->jwt->algorithm)
            );

            // 檢查是否為管理員
            if ($decoded->m_role !== 'admin') {
                return $response->setStatusCode(403)
                    ->setJSON(['error' => '無權限訪問後台']);
            }

            $request->userData = $decoded;
            return $request;
        } catch (\Exception $e) {
            return $response->setStatusCode(401)
                ->setJSON(['error' => '無效的登入狀態']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}