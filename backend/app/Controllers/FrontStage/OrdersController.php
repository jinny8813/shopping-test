<?php

namespace App\Controllers\FrontStage;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrdersModel;



class OrdersController extends BaseController
{
    use ResponseTrait;

    public function createOrder{
        $m_id = session()->get("memberdata")->m_id;

        $data = $this->request->getPost();

        // $p_id        = $data['p_id'] ?? null;

        $o_total   = $data['total'] ?? null;
        $o_status  = $data['status'] ?? null;
        $o_name    = $data['name'] ?? null;
        $o_phone   = $data['phone'] ?? null;
        $o_address = $data['address'] ?? null;

        $o_tradeNumber = uniqid();

        $ordersModel = new OrdersModel();

        $checkOrderIsExist = $orderModel->where('o_tradeNumber',$o_tradeNumber)->first();

        if ($checkOrderIsExist) {
            return $this->fail("欲建立的訂單已存在", 400);
        }

        // $productModel = new ProductModel();

        // foreach ($productArr as $product) {
        //     $checkProductReserve = $productModel->checkReserve($product->product_id, $product->amount);
        //     if (!$checkProductReserve) {
        //         return $this->fail("商品庫存不足", 400);
        //     }
        // }

        $values = [
            'm_id'          =>  $m_id,
            'o_tradeNumber' =>  $o_tradeNumber,
            'o_total'       =>  $o_total,
            'o_status'      =>  $o_status,
            'o_name'        =>  $o_name,
            'o_phone'       =>  $o_phone,
            'o_address'     =>  $o_address,
        ];
        $ordersModel->insert($values);

        $ecPay = new EcPayController();
        $ecPay->orderPay($o_tradeNumber);
    }
}