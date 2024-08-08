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

        if($c_parent_id == 0) {
            $c_parent_id = null;
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
            return $this->fail("資料庫異常", 500);
        }

        $categoriesData = $categoriesModel->findAll();
        $structuredCategories = $this->buildCategoryTree($categoriesData);

        return $this->respond([
            "status" => true,
            "data"   => $structuredCategories,
            "msg"    => "Created new Category"
        ]);
    }

    public function editCategory($id)
    {
        $data = $this->request->getJSON(true);

        $categoriesModel = new CategoriesModel();
        $verifyCategoryData = $categoriesModel->where("c_id", $id)->first();

        if($verifyCategoryData === null) {
            return $this->fail("查無此商品分類", 404);
        }

        $c_name        = $data['name'] ?? null;
        $c_parent_id   = $data['parent_id'] ?? null;

        if($c_name === null || $c_parent_id === null) {
            return $this->fail("需輸入類別完整資訊", 404);
        }

        if($c_name === " " || $c_parent_id === " ") {
            return $this->fail("需輸入類別完整資訊", 404);
        }

        if($c_parent_id == 0) {
            $c_parent_id = null;
        }

        $updateValues = [
            'c_name'        =>  $c_name,
            'c_parent_id'   =>  $c_parent_id,
        ];

        try {
            if ($categoriesModel->update($verifyCategoryData['c_id'], $updateValues) === false) {
                $errors = $categoriesModel->errors();
                return $this->fail("類別插入失敗，獲取錯誤訊息(parent_id須為整數或空白)", 404);
            }
        } catch (\Exception $e) {
            return $this->fail("資料庫異常", 500);
        }

        $categoriesData = $categoriesModel->findAll();
        $structuredCategories = $this->buildCategoryTree($categoriesData);

        return $this->respond([
            "status" => true,
            "data"   => $structuredCategories,
            "msg"    => "updated the Category"
        ]);
    }

    public function deleteCategory($id)
    {
        $categoriesModel = new CategoriesModel();
        $verifyCategoryData = $categoriesModel->where("c_id", $id)->first();

        if($verifyCategoryData === null) {
            return $this->fail("查無此商品分類", 404);
        }

        try {
            // 開始事務處理
            $categoriesModel->db->transBegin();

            // 遞迴刪除父類別及其所有子類別
            $this->deleteCategoryRecursively($categoriesModel, $id);

            // 提交事務
            if ($categoriesModel->db->transStatus() === false) {
                $categoriesModel->db->transRollback();

                return $this->fail("刪除失敗", 500);
            } else {
                $categoriesModel->db->transCommit();

                $categoriesData = $categoriesModel->findAll();
                $structuredCategories = $this->buildCategoryTree($categoriesData);
                
                return $this->respond([
                    "status" => true,
                    "data"   => $structuredCategories,
                    "msg"    => "updated the Category"
                ]);
            }
        } catch (\Exception $e) {
            $categoriesModel->db->transRollback();
            return $this->fail("刪除失敗(資料庫異常)", 500);
        }
    }

    private function buildCategoryTree(array $categories, $parentId = null)
    {
        $branch = [];

        foreach ($categories as $category) {
            if ($category['c_parent_id'] === $parentId) {
                $children = $this->buildCategoryTree($categories, $category['c_id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $branch[] = $category;
            }
        }

        return $branch;
    }

    private function deleteCategoryRecursively($model, $parentId)
    {
        $children = $model->where('c_parent_id', $parentId)->findAll();

        foreach ($children as $child) {
            $this->deleteCategoryRecursively($model, $child['c_id']);
        }

        $model->delete($parentId);
    }
}