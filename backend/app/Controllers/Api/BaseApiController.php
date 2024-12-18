<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class BaseApiController extends BaseController
{
    use ResponseTrait;

    protected function successResponse($data, $message = 'success', $code = 200)
    {
        return $this->respond([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function failResponse($message, $code = 400)
    {
        return $this->respond([
            'status' => false,
            'message' => $message,
            'code' => $code
        ], $code);
    }

    protected function failValidation($errors)
    {
        return $this->failResponse($errors, 400);
    }

    protected function failNotFound($message = '資源不存在')
    {
        return $this->failResponse($message, 404);
    }

    protected function failServer($message = '系統錯誤')
    {
        return $this->failResponse($message, 500);
    }
}