<?php

namespace App\Controllers\BackStage;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrdersModel;

class OrdersController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return $this->respond([
            "status" => true,
            "data"   => "View product",
            "msg"    => "View product"
        ]);
    }

    public function showOrders()
    {
        $ordersModel = new OrdersModel();
        $ordersData = $ordersModel->findAll();

        return $this->respond([
            "status" => true,
            "data"   => $ordersData,
            "msg"    => "Show all products"
        ]);
    }

    public function editOrder($id){
        // $m_id = session()->get("memberdata")->m_id;

        $data = $this->request->getJSON(true);

        $o_status  = $data['status'] ?? null;

        $ordersModel = new OrdersModel();
        $verifyOrderData = $ordersModel->where("o_id", $id)->first();

        if($verifyOrderData === null) {
            return $this->fail("查無此訂單", 404);
        }

        $updateValues = [
            'o_status'  =>  $o_status,
        ];

        try {
            if ($ordersModel->update($verifyOrderData['o_id'], $updateValues) === false) {
                $errors = $ordersModel->errors();
                return $this->fail("沒有資料要更新", 404);
            }
        } catch (\Exception $e) {
            return $this->fail("資料庫異常", 500);
        }

        return $this->respond([
            "status" => true,
            "data"   => "updated the order",
            "msg"    => "updated the order"
        ]);
    }

    public function deleteOrder($id)
    {
        $ordersModel = new OrdersModel();
        $verifyOrderData = $ordersModel->where("o_id", $id)->first();

        if($verifyOrderData === null) {
            return $this->fail("查無此訂單", 404);
        }

        $ordersModel->delete($verifyOrderData['o_id']);

        return $this->respond([
            "status" => true,
            "data"   => "deleted the order",
            "msg"    => "deleted the order"
        ]);
    }

    public function showPerOrder($id)
    {
        $ordersModel = new OrdersModel();
        $verifyOrderData = $ordersModel->where("o_id", $id)->first();

        if($verifyOrderData === null) {
            return $this->fail("查無此訂單", 404);
        }

        return $this->respond([
            "status" => true,
            "data"   => $verifyOrderData,
            "msg"    => "show the order"
        ]);
    }
}