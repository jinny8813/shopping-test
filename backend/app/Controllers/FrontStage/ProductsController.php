<?php

namespace App\Controllers\FrontStage;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductsModel;



class ProductsController extends BaseController
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

    public function showProducts()
    {
        $productsModel = new ProductsModel();
        $productsData = $productsModel->findAll();

        return $this->respond([
            "status" => true,
            "data"   => $productsData,
            "msg"    => "Show all products"
        ]);
    }

    public function showPerProduct($id)
    {
        $productsModel = new ProductsModel();
        $verifyProductData = $productsModel->where("p_id", $id)->first();

        if($verifyProductData === null) {
            return $this->fail("查無此產品", 404);
        }

        return $this->respond([
            "status" => true,
            "data"   => $verifyProductData,
            "msg"    => "show the product"
        ]);
    }
}