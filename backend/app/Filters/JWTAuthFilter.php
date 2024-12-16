<?php
// app/Filters/JWTAuthFilter.php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Config\Services;
use stdClass;

class JWTAuthFilter implements FilterInterface
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
        $response = Services::response();

        try {
            $token = $request->getHeaderLine('Authorization');
            if (empty($token)) {
                return $response->setStatusCode(401)
                    ->setJSON(['error' => 'Token not found']);
            }

            $token = str_replace('Bearer ', '', $token);
            
            // 使用新的解碼方式
            $decoded = JWT::decode(
                $token,
                new Key($this->jwt->key, $this->jwt->algorithm)
            );

            if (!empty($arguments) && !in_array($decoded->role, $arguments)) {
                return $response->setStatusCode(403)
                    ->setJSON(['error' => 'Unauthorized access']);
            }

            $request->userData = $decoded;
            
            return $request;
        } catch (ExpiredException $e) {
            return $response->setStatusCode(401)
                ->setJSON(['error' => 'Token expired']);
        } catch (\Exception $e) {
            return $response->setStatusCode(401)
                ->setJSON(['error' => 'Invalid token']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}