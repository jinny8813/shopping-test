<?php
// app/Controllers/Admin/SettingController.php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseAdminController;

class SettingController extends BaseAdminController
{
    protected $settingModel;
    protected $mediaModel;
    protected $db;
    protected $uploadPath;
    protected $session;

    public function __construct()
    {
        $this->settingModel = new \App\Models\SettingModel();
        $this->mediaModel = new \App\Models\MediaModel();
        $this->db = \Config\Database::connect();
        $this->uploadPath = ROOTPATH . 'public/uploads/';
        $this->session = session();
    }

    // CKEditor 圖片上傳處理
    public function upload()
    {
        $file = $this->request->getFile('upload');
        
        if (!$file->isValid() || $file->hasMoved()) {
            return $this->failValidation('無效的檔案');
        }

        try {
            // 生成唯一檔名
            $newName = uniqid('img_') . '_' . $file->getRandomName();
            $relativePath = 'images/' . date('Y/m/d');
            $containerPath = 'uploads/' . $relativePath . '/' . $newName;
            
            // 移動檔案到 Docker 容器
            $uploadPath = $this->uploadPath . $relativePath;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $newName);

            // 儲存媒體資訊（暫時不關聯）
            $mediaData = [
                'media_type' => 'image',
                'file_name' => $newName,
                'original_name' => $file->getClientName(),
                'file_path' => $containerPath,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $mediaId = $this->mediaModel->insert($mediaData);

            // 回傳給 CKEditor
            return $this->successResponse(
                [
                    'uploaded' => true,
                    'url' => base_url($containerPath),
                    'mediaId' => $mediaId
                ],
                '檔案上傳成功',
                200
            );

        } catch (\Exception $e) {
            log_message('error', '[File Upload] Error: ' . $e->getMessage());
            return $this->fail('檔案上傳失敗');
        }
    }

    // 儲存設定內容
    public function create()
    {
        $rules = [
            'type' => 'required',
            'title' => 'required|min_length[2]',
            'content' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $this->db->transStart();

        try {
            $content = $this->request->getPost('content');
            
            // 儲存設定
            $settingData = [
                'type' => $this->request->getPost('type'),
                'title' => $this->request->getPost('title'),
                'content' => $content,
                'status' => $this->request->getPost('status') ?? 'active',
                'sort_order' => $this->request->getPost('sort_order') ?? 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $settingId = $this->settingModel->insert($settingData);

            // 更新媒體關聯
            $this->updateMediaRelations($settingId, $content);

            $this->db->transComplete();

            // 取得完整資料
            $setting = $this->settingModel->find($settingId);
            
            return $this->successResponse(
                ['setting' => $setting],
                '新增成功',
                200
            );

        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->fail('新增失敗：' . $e->getMessage());
        }
    }

    // 更新媒體關聯
    private function updateMediaRelations($settingId, $content)
    {
        // 找出內容中所有圖片的 URL
        preg_match_all('/<img[^>]+src="([^"]+)"/', $content, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $src) {
                // 取得相對路徑
                $path = str_replace(base_url(), '', $src);
                
                // 更新媒體關聯
                $this->mediaModel->where('file_path', $path)
                                ->set([
                                    'related_id' => $settingId,
                                    'related_type' => 'setting'
                                ])
                                ->update();
            }
        }
    }
}