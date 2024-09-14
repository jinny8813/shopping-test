<?php

namespace App\Controllers\BackStage;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\StoreInfoModel;



class StoreInfoController extends BaseController
{
    use ResponseTrait;

    public function addStoreInfo()
    {
        $data = $this->request->getPost();

        $images = $this->request->getFiles();
        $s_name        = $data['name'] ?? null;
        $s_description = $data['description'] ?? null;

        if($s_name === null || $s_description === null) {
            return $this->fail("需輸入商品完整資訊", 404);
        }

        if($s_name === " " || $s_description === " ") {
            return $this->fail("需輸入商品完整資訊", 404);
        }

        $s_image = [];
        if (isset($images['image'])) {
            foreach ($images['image'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(WRITEPATH . 'backend\public\uploads\storeinfo', $newName);
                    array_push($s_image,$newName);
                }
            }
        }

        $StoreInfoModel = new StoreInfoModel();

        $values = [
            's_name'        =>  $s_name,
            's_description' =>  $s_description,
            's_image'       =>  $s_image,
        ];

        try {
            if ($StoreInfoModel->insert($values) === false) {
                $errors = $StoreInfoModel->errors();
                return $this->fail("類別插入失敗，獲取錯誤訊息(c_id須為整數或空白)", 404);
            }
        } catch (\Exception $e) {
            return $this->fail("資料庫異常", 500);
        }

        return $this->respond([
            "status" => true,
            "data"   => $values,
            "msg"    => "Created new StoreInfo"
        ]);
    }

    public function editStoreInfo($id)
    {
        $data = $this->request->getJSON(true);

        $StoreInfoModel = new StoreInfoModel();
        $verifyStoreInfoData = $StoreInfoModel->where("s_id", $id)->first();

        if($verifyStoreInfoData === null) {
            return $this->fail("查無此產品", 404);
        }

        $images = $this->request->getFiles();
        $s_name        = $data['name'] ?? null;
        $s_description = $data['description'] ?? null;

        if($s_name === null || $s_description === null) {
            return $this->fail("需輸入商品完整資訊", 404);
        }

        if($s_name === " " || $s_description === " ") {
            return $this->fail("需輸入商品完整資訊", 404);
        }

        $s_image = [];
        if (isset($images['image'])) {
            foreach ($images['image'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move(WRITEPATH . 'backend\public\uploads\storeinfo', $newName);
                    array_push($s_image,$newName);
                }
            }
        }

        $updateValues = [
            's_name'        =>  $s_name,
            's_description' =>  $s_description,
            's_image'       =>  $s_image,
        ];

        try {
            if ($StoreInfoModel->update($verifyStoreInfoData['s_id'], $updateValues) === false) {
                $errors = $StoreInfoModel->errors();
                return $this->fail("類別插入失敗，獲取錯誤訊息(c_id須為整數或空白)", 404);
            }
        } catch (\Exception $e) {
            return $this->fail("資料庫異常", 500);
        }

        return $this->respond([
            "status" => true,
            "data"   => $updateValues,
            "msg"    => "updated the StoreInfo"
        ]);
    }

    public function deleteStoreInfo($id)
    {
        $StoreInfoModel = new StoreInfoModel();
        $verifyStoreInfoData = $StoreInfoModel->where("s_id", $id)->first();

        if($verifyStoreInfoData === null) {
            return $this->fail("查無此產品", 404);
        }

        $StoreInfoModel->delete($verifyStoreInfoData['p_id']);

        return $this->respond([
            "status" => true,
            "data"   => "deleted the StoreInfo",
            "msg"    => "deleted the StoreInfo"
        ]);
    }

    public function showPerStoreInfo($id)
    {
        $StoreInfoModel = new StoreInfoModel();
        $verifyStoreInfoData = $StoreInfoModel->where("s_id", $id)->first();

        if($verifyStoreInfoData === null) {
            return $this->fail("查無此產品", 404);
        }

        return $this->respond([
            "status" => true,
            "data"   => $verifyStoreInfoData,
            "msg"    => "show the StoreInfo"
        ]);
    }
}