<?php

namespace App\Controllers\Api\Admin;

use App\Controllers\Api\Admin\BaseAdminController;
use App\Libraries\CustomRequest;

/**
 * @property CustomRequest $request
 */
class MemberController extends BaseAdminController
{
    protected $memberModel;
    protected $adminLogModel;
    protected $session;

    public function __construct()
    {
        $this->memberModel = new \App\Models\MemberModel();
        $this->adminLogModel = new \App\Models\AdminLogModel();
        $this->session = session();
    }

    // 獲取會員列表
    public function index()
    {
        // $search = $this->request->getGet('search');
        // $status = $this->request->getGet('status');

        $members = $this->memberModel->select('m_id, m_email, m_name, m_phone, m_adress, last_login, created_at')
                                    ->findAll();

        $adminData = $this->request->adminData;
        $this->adminLogModel->insert([
            'admin_id' => $adminData->admin_id,
            'action' => 'view_members',
            'description' => 'Viewed members list',
            'ip_address' => $this->request->getIPAddress()
        ]);

        return $this->successResponse(
            ['members' => $members],
            '會員列表',
            200
        );
    }

    // 獲取會員詳情
    public function show($id = null)
    {
        $member = $this->memberModel->find($id);

        if (!$member) {
            return $this->failNotFound('會員不存在');
        }

        // 移除敏感資訊
        unset($member['m_password']);
        unset($member['reset_token']);
        unset($member['reset_token_expires']);

        // // 獲取會員的訂單統計
        // $orderStats = $this->db->table('orders')
        //     ->select('COUNT(*) as total_orders, SUM(total_amount) as total_spent')
        //     ->where('m_id', $id)
        //     ->get()
        //     ->getRow();

        // $member['order_stats'] = $orderStats;

        $adminData = $this->request->adminData;
        $this->adminLogModel->insert([
            'admin_id' => $adminData->admin_id,
            'action' => 'view_member',
            'description' => "Viewed member details: ID {$id}",
            'ip_address' => $this->request->getIPAddress()
        ]);

        return $this->successResponse(
            ['member' => $member],
            '會員詳情',
            200
        );
    }

    // 更新會員資料
    public function update($id = null)
    {
        if (!$this->memberModel->find($id)) {
            return $this->failNotFound('會員不存在');
        }

        $rules = [
            'm_name' => 'permit_empty|string|min_length[2]',
            'm_phone' => 'permit_empty|string|min_length[8]',
            'm_address' => 'permit_empty|string',
        ];

        if (!$this->validate($rules)) {
            return $this->failResponse($this->validator->getErrors(), 400);
        }

        $data = $this->request->getJSON(true);
        
        // 只更新允許的欄位
        $allowedFields = ['m_name', 'm_phone', 'm_address'];
        $updateData = array_intersect_key($data, array_flip($allowedFields));

        try {
            $this->memberModel->update($id, $updateData);

            $adminData = $this->request->adminData;
            $this->adminLogModel->insert([
                'admin_id' => $adminData->admin_id,
                'action' => 'update_member',
                'description' => "Updated member: ID {$id}",
                'ip_address' => $this->request->getIPAddress()
            ]);

            $member = $this->memberModel->find($id);

            // 移除敏感資訊
            unset($member['m_password']);
            unset($member['reset_token']);
            unset($member['reset_token_expires']);

            return $this->successResponse(
                ['member' => $member],
                '會員資料更新成功',
                200
            );
        } catch (\Exception $e) {
            return $this->failServer('更新失敗');
        }
    }

    // 刪除會員（軟刪除）
    public function delete($id = null)
    {
        if (!$this->memberModel->find($id)) {
            return $this->failNotFound('會員不存在');
        }

        try {
            $this->memberModel->delete($id);

            $adminData = $this->request->adminData;
            $this->adminLogModel->insert([
                'admin_id' => $adminData->admin_id,
                'action' => 'delete_member',
                'description' => "Deleted member: ID {$id}",
                'ip_address' => $this->request->getIPAddress()
            ]);

            return $this->successResponse(
                '會員刪除成功',
                '會員刪除成功',
                200
            );
        } catch (\Exception $e) {
            return $this->failServer('刪除失敗');
        }
    }

    // 會員統計資料
    public function statistics()
    {
        $stats = [
            'total' => $this->memberModel->countAll(),
            'active' => $this->memberModel->where('status', 'active')->countAllResults(),
            'inactive' => $this->memberModel->where('status', 'inactive')->countAllResults(),
            'banned' => $this->memberModel->where('status', 'banned')->countAllResults(),
            'new_this_month' => $this->memberModel
                ->where('created_at >=', date('Y-m-01'))
                ->countAllResults(),
        ];

        return $this->successResponse(
            ['stats' => $stats],
            '會員統計資料',
            200
        );
    }

    // 匯出會員資料
    public function export()
    {
        // 獲取會員資料
        $members = $this->memberModel
            ->select('m_id, m_email, m_name, m_phone, status, created_at')
            ->findAll();

        // 建立 CSV
        $filename = 'members_' . date('Y-m-d_His') . '.csv';
        $file = fopen('php://temp', 'r+');

        // 寫入 CSV 標題
        fputcsv($file, ['ID', 'Email', 'Name', 'Phone', 'Status', 'Created At']);

        // 寫入資料
        foreach ($members as $member) {
            fputcsv($file, [
                $member['m_id'],
                $member['m_email'],
                $member['m_name'],
                $member['m_phone'],
                $member['status'],
                $member['created_at']
            ]);
        }

        // 記錄操作日誌
        $adminData = $this->request->adminData;
        $this->adminLogModel->insert([
            'admin_id' => $adminData->admin_id,
            'action' => 'export_members',
            'description' => 'Exported members data',
            'ip_address' => $this->request->getIPAddress()
        ]);

        // 設定 response header
        rewind($file);
        $csv = stream_get_contents($file);
        fclose($file);

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($csv);
    }
}