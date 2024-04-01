<?php

namespace App\Controllers\FrontStage;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CartItemsModel;



class CartItemsController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return $this->respond([
            "status" => true,
            "data"   => "View CartItems",
            "msg"    => "View CartItems"
        ]);
    }

    public function showCartItems()
    {
        $m_id = session()->get("memberdata")->m_id;

        $cartItemsModel = new CartItemsModel();
        $cartItemsData = $cartItemsModel->where('m_id',$m_id)->findAll();

        return $this->respond([
            "status" => true,
            "data"   => $cartItemsData,
            "msg"    => "Show all cartItems"
        ]);
    }

    public function addCartItem()
    {
        $data = $this->request->getPost();

        $m_id = session()->get("memberdata")->m_id;

        $p_id        = $data['p_id'] ?? null;
        $ci_quantity = $data['quantity'] ?? null;


        if($p_id === null || $ci_quantity === null) {
            return $this->fail("需輸入商品完整資訊", 404);
        }

        if($p_id === " " || $ci_quantity === " ") {
            return $this->fail("需輸入商品完整資訊", 404);
        }


        $cartItemsModel = new CartItemsModel();

        $values = [
            'm_id'         =>  $m_id,
            'p_id'         =>  $p_id,
            'ci_quantity'  =>  $ci_quantity,
        ];
        $cartItemsModel->insert($values);

        return $this->respond([
            "status" => true,
            "data"   => $values,
            "msg"    => "add new product"
        ]);
    }

    public function editCartItem($id)
    {
        $data = $this->request->getJSON(true);

        $m_id = session()->get("memberdata")->m_id;

        $cartItemsModel = new CartItemsModel();
        $verifyCartItemsData = $cartItemsModel->where("ci_id", $id)->first();

        if($verifyCartItemsData === null) {
            return $this->fail("查無此產品", 404);
        }

        if($m_id != $verifyCartItemsData['ci_id']['m_id']){
            return $this->fail("沒有修改權限", 404);
        }

        $ci_quantity   = $data['quantity'] ?? null;

        if($ci_quantity <= 0){
            $cartItemsModel->delete($verifyCartItemsData['ci_id']);

            return $this->respond([
                "status" => true,
                "data"   => "deleted the cart item",
                "msg"    => "deleted the cart item"
            ]);
        }else{
            $updateValues = [
                'ci_quantity'        =>  $ci_quantity,
            ];
            $cartItemsModel->update($verifyCartItemsData['ci_id'], $updateValues);
    
            return $this->respond([
                "status" => true,
                "data"   => $updateValues,
                "msg"    => "updated the cart item"
            ]);
        }
    }

    public function deleteCartItem($id)
    {
        $m_id = session()->get("memberdata")->m_id;

        $cartItemsModel = new CartItemsModel();
        $verifyCartItemsData = $cartItemsModel->where("ci_id", $id)->first();

        if($verifyCartItemsData === null) {
            return $this->fail("查無此產品", 404);
        }

        if($m_id != $verifyCartItemsData['ci_id']['m_id']){
            return $this->fail("沒有刪除權限", 404);
        }

        $cartItemsModel->delete($verifyCartItemsData['ci_id']);

        return $this->respond([
            "status" => true,
            "data"   => "deleted the cart item",
            "msg"    => "deleted the cart item"
        ]);
    }
}