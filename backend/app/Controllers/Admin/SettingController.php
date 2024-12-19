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

    // 設定列表
    public function index()
    {
        try {
            // 獲取查詢參數
            $type = $this->request->getGet('type');
            $status = $this->request->getGet('status');
            $page = $this->request->getGet('page') ?? 1;
            $limit = $this->request->getGet('limit') ?? 10;
            
            // 建立查詢
            $query = $this->settingModel->select('
                settings.*, 
                GROUP_CONCAT(media.file_path) as image_paths,
                GROUP_CONCAT(media.media_id) as media_ids
            ')
            ->join('media', 'media.related_id = settings.setting_id AND media.related_type = "setting"', 'left')
            ->groupBy('settings.setting_id');

            // 加入條件篩選
            if ($type) {
                $query->where('settings.type', $type);
            }
            if ($status) {
                $query->where('settings.status', $status);
            }

            // 排序
            $query->orderBy('settings.sort_order', 'ASC')
                ->orderBy('settings.created_at', 'DESC');

            // 分頁
            $total = $query->countAllResults(false);
            $settings = $query->limit($limit, ($page - 1) * $limit)->find();

            // 處理圖片路徑
            foreach ($settings as &$setting) {
                if ($setting['image_paths']) {
                    $paths = explode(',', $setting['image_paths']);
                    $mediaIds = explode(',', $setting['media_ids']);
                    $setting['images'] = array_map(function($path, $id) {
                        return [
                            'media_id' => $id,
                            'url' => base_url($path)
                        ];
                    }, $paths, $mediaIds);
                } else {
                    $setting['images'] = [];
                }
                unset($setting['image_paths']);
                unset($setting['media_ids']);
            }

            return $this->successResponse([
                'settings' => $settings,
                'pagination' => [
                    'current_page' => (int)$page,
                    'total_pages' => ceil($total / $limit),
                    'total_items' => $total,
                    'limit' => (int)$limit
                ]
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Settings List] Error: ' . $e->getMessage());
            return $this->failServer('獲取設定列表失敗');
        }
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

    public function show($id = null)
    {
        try {
            if (!$id) {
                return $this->failValidation('未提供設定 ID');
            }

            // 獲取設定資料與相關圖片
            $setting = $this->settingModel->select('
                settings.*, 
                GROUP_CONCAT(media.file_path) as image_paths,
                GROUP_CONCAT(media.media_id) as media_ids
            ')
            ->join('media', 'media.related_id = settings.setting_id AND media.related_type = "setting"', 'left')
            ->groupBy('settings.setting_id')
            ->find($id);

            if (!$setting) {
                return $this->failNotFound('設定不存在');
            }

            // 處理圖片路徑
            if ($setting['image_paths']) {
                $paths = explode(',', $setting['image_paths']);
                $mediaIds = explode(',', $setting['media_ids']);
                $setting['images'] = array_map(function($path, $id) {
                    return [
                        'media_id' => $id,
                        'url' => base_url($path)
                    ];
                }, $paths, $mediaIds);
            } else {
                $setting['images'] = [];
            }
            unset($setting['image_paths']);
            unset($setting['media_ids']);

            return $this->successResponse([
                'setting' => $setting
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Setting Detail] Error: ' . $e->getMessage());
            return $this->failServer('獲取設定詳情失敗');
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