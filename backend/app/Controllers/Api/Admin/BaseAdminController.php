<?php

namespace App\Controllers\Api\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class BaseAdminController extends BaseController
{
    use ResponseTrait;
    
    protected function successResponse($data, $message = 'success', $code = 200)
    {
        return $this->respond([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'csrf_token' => $this->session->get('csrf_token')
        ], $code);
    }

    protected function failResponse($message, $code = 400, $needRelogin = false)
    {
        return $this->respond([
            'status' => false,
            'message' => $message,
            'code' => $code,
            'need_relogin' => $needRelogin,
            'csrf_token' => $this->session->get('csrf_token')
        ], $code);
    }

    protected function failValidation($errors)
    {
        return $this->failResponse($errors, 400);
    }

    protected function failUnauthorized($message = '未授權的存取')
    {
        return $this->failResponse($message, 401, true);
    }

    protected function failForbidden($message = '禁止的存取')
    {
        return $this->failResponse($message, 403);
    }

    protected function failNotFound($message = '資源不存在')
    {
        return $this->failResponse($message, 404);
    }

    protected function failServer($message = '伺服器錯誤')
    {
        return $this->failResponse($message, 500);
    }
}