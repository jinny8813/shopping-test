<?php

namespace App\Controllers\FrontStage;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrdersModel;
use App\Models\ProductsModel;


class OrdersController extends BaseController
{
    use ResponseTrait;

    public function testCreateOrder(){
        // $m_id = session()->get("memberdata")->m_id;

        $data = $this->request->getPost();

        // $p_id        = $data['p_id'] ?? null;

        $o_total   = $data['total'] ?? null;
        $o_status  = $data['status'] ?? null;
        $o_name    = $data['name'] ?? null;
        $o_phone   = $data['phone'] ?? null;
        $o_address = $data['address'] ?? null;

        $o_tradeNumber = uniqid();
        $o_total = 100;

        // $ordersModel = new OrdersModel();

        // $checkOrderIsExist = $orderModel->where('o_tradeNumber',$o_tradeNumber)->first();

        // if ($checkOrderIsExist) {
        //     return $this->fail("欲建立的訂單已存在", 400);
        // }

        // $productModel = new ProductModel();

        // foreach ($productArr as $product) {
        //     $checkProductReserve = $productModel->checkReserve($product->product_id, $product->amount);
        //     if (!$checkProductReserve) {
        //         return $this->fail("商品庫存不足", 400);
        //     }
        // }

        // $values = [
        //     'm_id'          =>  $m_id,
        //     'o_tradeNumber' =>  $o_tradeNumber,
        //     'o_total'       =>  $o_total,
        //     'o_status'      =>  $o_status,
        //     'o_name'        =>  $o_name,
        //     'o_phone'       =>  $o_phone,
        //     'o_address'     =>  $o_address,
        // ];
        // $ordersModel->insert($values);

        $ecPay = new EcPayController();
        $ecPay->orderPay($o_tradeNumber, $o_total);
    }

    public function createOrder(){
        // $m_id = session()->get("memberdata")->m_id;

        $data = $this->request->getPost();

        $o_status  = $data['status'] ?? null;
        $o_name    = $data['name'] ?? null;
        $o_phone   = $data['phone'] ?? null;
        $o_address = $data['address'] ?? null;
        $o_product_arr  = json_decode($data['product_arr']) ?? null;

        $o_trade_number = uniqid();
        $o_total = 0;

        $ordersModel = new OrdersModel();

        $checkOrderIsExist = $ordersModel->where('o_trade_number',$o_trade_number)->first();

        if ($checkOrderIsExist) {
            return $this->fail("欲建立的訂單已存在", 400);
        }

        $productModel = new ProductsModel();

        foreach ($o_product_arr as $product) {
            $data = $productModel->where("p_id", $product->p_id)->first();

            if ($data['p_stock'] < $product->p_amount) {
                return $this->fail("商品庫存不足", 400);
            }else{
                $o_total = $o_total + $product->p_price*$product->p_amount;
            }
        }

        $values = [
            'm_id'          =>  1,
            'o_trade_number' =>  $o_trade_number,
            'o_total'       =>  $o_total,
            'o_status'      =>  $o_status,
            'o_name'        =>  $o_name,
            'o_phone'       =>  $o_phone,
            'o_address'     =>  $o_address,
            'o_product_arr' =>  json_encode($o_product_arr)
        ];
        $ordersModel->insert($values);

        $ecPay = new EcPayController();
        $ecPay->orderPay($o_trade_number, $o_total);
    }
}