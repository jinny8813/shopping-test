<?php

namespace App\Controllers;

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

    public function renderProductPage()
    {
        $productsModel = new ProductsModel();
        $productsData = $productsModel->findAll();

        return $this->respond([
            "status" => true,
            "data"   => $productsData,
            "msg"    => "View ProductPage"
        ]);
    }

    public function AddProduct()
    {
        $data = $this->request->getPost();

        $p_name        = $data['name'] ?? null;
        $p_description = $data['description'] ?? null;
        $p_price       = $data['price'] ?? null;
        $p_stock       = $data['stock'] ?? null;
        $p_image       = $data['image'] ;
        $p_type        = $data['type'] ?? null;

        if($p_name === null || $p_description === null || $p_price === null || $p_stock === null || $p_type === null) {
            return $this->fail("需輸入商品完整資訊", 404);
        }

        if($p_name === " " || $p_description === " " || $p_price === " " || $p_stock === " " || $p_type === " ") {
            return $this->fail("需輸入商品完整資訊", 404);
        }


        $productsModel = new ProductsModel();

        $values = [
            'p_name'        =>  $p_name,
            'p_description' =>  $p_description,
            'p_price'       =>  $p_price,
            'p_stock'       =>  $p_stock,
            'p_image'       =>  $p_image,
            'p_type'        =>  $p_type,
        ];
        $productsModel->insert($values);

        return $this->respond([
            "status" => true,
            "data"   => $values,
            "msg"    => "Add new product"
        ]);
    }
}