<?php

namespace App\Controllers\BackStage;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CategoriesModel;



class CategoriesController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return $this->respond([
            "status" => true,
            "data"   => "View Categories",
            "msg"    => "View Categories"
        ]);
    }

    public function showCategories()
    {
        $categoriesModel = new CategoriesModel();
        $categoriesData = $categoriesModel->findAll();

        $structuredCategories = $this->buildCategoryTree($categoriesData);

        return $this->respond([
            "status" => true,
            "data"   => $structuredCategories,
            "msg"    => "Show all Categories"
        ]);
    }

    public function addCategory()
    {
        $data = $this->request->getPost();

        $c_name        = $data['name'] ?? null;
        $c_parent_id   = $data['parent_id'] ?? null;

        if($c_name === null || $c_parent_id === null) {
            return $this->fail("需輸入類別完整資訊", 404);
        }

        if($c_name === " " || $c_parent_id === " ") {
            return $this->fail("需輸入類別完整資訊", 404);
        }

        $categoriesModel = new CategoriesModel();

        $values = [
            'c_name'        =>  $c_name,
            'c_parent_id'   =>  $c_parent_id,
        ];

        try {
            if ($categoriesModel->insert($values) === false) {
                $errors = $categoriesModel->errors();
                return $this->fail("類別插入失敗，獲取錯誤訊息(parent_id須為整數或空白)", 404);
            }
        } catch (\Exception $e) {
            return $this->fail("資料庫異常)", 500);
        }

        $categoriesData = $categoriesModel->findAll();
        $structuredCategories = $this->buildCategoryTree($categoriesData);

        return $this->respond([
            "status" => true,
            "data"   => $structuredCategories,
            "msg"    => "Created new Category"
        ]);
    }

    // public function editProduct($id)
    // {
    //     $data = $this->request->getJSON(true);

    //     $productsModel = new ProductsModel();
    //     $verifyProductData = $productsModel->where("p_id", $id)->first();

    //     if($verifyProductData === null) {
    //         return $this->fail("查無此產品", 404);
    //     }

    //     $p_name        = $data['name'] ?? null;
    //     $p_description = $data['description'] ?? null;
    //     $p_price       = $data['price'] ?? null;
    //     $p_stock       = $data['stock'] ?? null;
    //     $p_image       = $data['image'] ;
    //     $p_type        = $data['type'] ?? null;

    //     if($p_name === null || $p_description === null || $p_price === null || $p_stock === null || $p_type === null) {
    //         return $this->fail("需輸入商品完整資訊", 404);
    //     }

    //     if($p_name === " " || $p_description === " " || $p_price === " " || $p_stock === " " || $p_type === " ") {
    //         return $this->fail("需輸入商品完整資訊", 404);
    //     }


    //     $productsModel = new ProductsModel();

    //     $updateValues = [
    //         'p_name'        =>  $p_name,
    //         'p_description' =>  $p_description,
    //         'p_price'       =>  $p_price,
    //         'p_stock'       =>  $p_stock,
    //         'p_image'       =>  $p_image,
    //         'p_type'        =>  $p_type,
    //     ];
    //     $productsModel->update($verifyProductData['p_id'], $updateValues);

    //     return $this->respond([
    //         "status" => true,
    //         "data"   => $updateValues,
    //         "msg"    => "updated the product"
    //     ]);
    // }

    // public function deleteProduct($id)
    // {
    //     $productsModel = new ProductsModel();
    //     $verifyProductData = $productsModel->where("p_id", $id)->first();

    //     if($verifyProductData === null) {
    //         return $this->fail("查無此產品", 404);
    //     }

    //     $productsModel->delete($verifyProductData['p_id']);

    //     return $this->respond([
    //         "status" => true,
    //         "data"   => "deleted the product",
    //         "msg"    => "deleted the product"
    //     ]);
    // }

    private function buildCategoryTree(array $categories, $parentId = null)
    {
        $branch = [];

        foreach ($categories as $category) {
            if ($category['c_parent_id'] == $parentId) {
                $children = $this->buildCategoryTree($categories, $category['c_id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $branch[] = $category;
            }
        }

        return $branch;
    }
}