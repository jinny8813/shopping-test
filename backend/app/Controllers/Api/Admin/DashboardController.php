<?php

namespace App\Controllers\Api\Admin;

use App\Controllers\Api\Admin\BaseAdminController;
use App\Libraries\CustomRequest;

/**
 * @property CustomRequest $request
 */
class DashboardController extends BaseAdminController
{
    // protected $memberModel;
    // protected $adminModel;
    // protected $adminLogModel;
    // protected $orderModel; // 如果有訂單功能的話
    protected $session;
    
    public function __construct()
    {
        // $this->memberModel = new \App\Models\MemberModel();
        // $this->adminModel = new \App\Models\AdminModel();
        // $this->adminLogModel = new \App\Models\AdminLogModel();
        // $this->orderModel = new \App\Models\OrderModel();
        $this->session = session();
    }

    public function index()
    {
        // // 取得今日日期和本月第一天
        // $today = date('Y-m-d');
        // $monthStart = date('Y-m-01');
        
        // // 系統概覽數據
        // $overview = [
        //     'total_members' => $this->memberModel->countAllResults(),
        //     'new_members_today' => $this->memberModel
        //         ->where('DATE(created_at)', $today)
        //         ->countAllResults(),
        //     'new_members_month' => $this->memberModel
        //         ->where('created_at >=', $monthStart)
        //         ->countAllResults(),
        //     'active_admins' => $this->adminModel
        //         ->where('status', 'active')
        //         ->countAllResults(),
        // ];

        // // 會員統計
        // $memberStats = [
        //     'status_distribution' => $this->memberModel
        //         ->select('status, COUNT(*) as count')
        //         ->groupBy('status')
        //         ->findAll(),
        //     'registration_trend' => $this->getMemberRegistrationTrend(),
        // ];

        // // 最近的系統活動
        // $recentActivities = $this->adminLogModel
        //     ->select('admin_logs.*, admins.username')
        //     ->join('admins', 'admins.admin_id = admin_logs.admin_id')
        //     ->orderBy('created_at', 'DESC')
        //     ->limit(10)
        //     ->find();

        // // 在線管理員
        // $onlineAdmins = $this->adminModel
        //     ->where('last_login >', date('Y-m-d H:i:s', strtotime('-30 minutes')))
        //     ->findAll();

        // // 如果有訂單功能，可以加入訂單統計
        // /*
        // $orderStats = [
        //     'total_orders' => $this->orderModel->countAllResults(),
        //     'orders_today' => $this->orderModel
        //         ->where('DATE(created_at)', $today)
        //         ->countAllResults(),
        //     'revenue_today' => $this->orderModel
        //         ->selectSum('total_amount')
        //         ->where('DATE(created_at)', $today)
        //         ->first()['total_amount'] ?? 0,
        //     'revenue_month' => $this->orderModel
        //         ->selectSum('total_amount')
        //         ->where('created_at >=', $monthStart)
        //         ->first()['total_amount'] ?? 0,
        // ];
        // */

        // // 系統狀態
        // $systemStatus = [
        //     'php_version' => PHP_VERSION,
        //     'ci_version' => \CodeIgniter\CodeIgniter::CI_VERSION,
        //     'server_time' => date('Y-m-d H:i:s'),
        //     'memory_usage' => $this->formatBytes(memory_get_usage(true)),
        //     'disk_free_space' => $this->formatBytes(disk_free_space("/")),
        // ];

        return $this->successResponse(
            [
                'dashboard' => 'viewing dashboard',
                // 'overview' => $overview,
                // 'member_stats' => $memberStats,
                // 'recent_activities' => $recentActivities,
                // 'online_admins' => $onlineAdmins,
                // // 'order_stats' => $orderStats,
                // 'system_status' => $systemStatus,
            ],
            'viewing dashboard',
            200
        );
    }

    // // 獲取會員註冊趨勢（最近30天）
    // private function getMemberRegistrationTrend()
    // {
    //     $days = 30;
    //     $result = [];
        
    //     for ($i = $days - 1; $i >= 0; $i--) {
    //         $date = date('Y-m-d', strtotime("-$i days"));
    //         $count = $this->memberModel
    //             ->where('DATE(created_at)', $date)
    //             ->countAllResults();
                
    //         $result[] = [
    //             'date' => $date,
    //             'count' => $count
    //         ];
    //     }
        
    //     return $result;
    // }

    // // 格式化位元組
    // private function formatBytes($bytes, $precision = 2)
    // {
    //     $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
    //     $bytes = max($bytes, 0);
    //     $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    //     $pow = min($pow, count($units) - 1);
        
    //     $bytes /= pow(1024, $pow);
        
    //     return round($bytes, $precision) . ' ' . $units[$pow];
    // }

    // // 獲取特定時期的統計數據
    // public function getStatsByPeriod()
    // {
    //     $period = $this->request->getGet('period') ?? 'today';
        
    //     switch ($period) {
    //         case 'today':
    //             $startDate = date('Y-m-d');
    //             break;
    //         case 'yesterday':
    //             $startDate = date('Y-m-d', strtotime('-1 day'));
    //             break;
    //         case 'week':
    //             $startDate = date('Y-m-d', strtotime('-7 days'));
    //             break;
    //         case 'month':
    //             $startDate = date('Y-m-01');
    //             break;
    //         default:
    //             $startDate = date('Y-m-d');
    //     }

    //     $stats = [
    //         'new_members' => $this->memberModel
    //             ->where('created_at >=', $startDate)
    //             ->countAllResults(),
    //         'active_members' => $this->memberModel
    //             ->where('last_login >=', $startDate)
    //             ->countAllResults(),
    //         'system_logs' => $this->adminLogModel
    //             ->where('created_at >=', $startDate)
    //             ->countAllResults(),
    //     ];

    //     return $this->respond([
    //         'status' => true,
    //         'data' => $stats
    //     ]);
    // }
}