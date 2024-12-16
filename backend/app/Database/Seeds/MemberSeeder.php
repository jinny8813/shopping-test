<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'm_email' => 'test1@example.com',
                'm_password' => password_hash('123456', PASSWORD_DEFAULT),
                'm_gmail' => 'test1@gmail.com',
                'm_line' => 'line_id_1',
                'm_fb' => 'fb_id_1',
                'm_name' => '測試會員一',
                'm_phone' => '0912345678',
                'm_adress' => '台北市信義區信義路五段5號',
                'm_role' => 'member',
                'last_login' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'm_email' => 'test2@example.com',
                'm_password' => password_hash('123456', PASSWORD_DEFAULT),
                'm_gmail' => 'test2@gmail.com',
                'm_line' => 'line_id_2',
                'm_fb' => 'fb_id_2',
                'm_name' => '測試會員二',
                'm_phone' => '0923456789',
                'm_adress' => '台北市大安區忠孝東路三段3號',
                'm_role' => 'member',
                'last_login' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'm_email' => 'test3@example.com',
                'm_password' => password_hash('123456', PASSWORD_DEFAULT),
                'm_gmail' => 'test3@gmail.com',
                'm_line' => 'line_id_3',
                'm_fb' => 'fb_id_3',
                'm_name' => '測試會員三',
                'm_phone' => '0934567890',
                'm_adress' => '台北市中山區南京東路一段1號',
                'm_role' => 'member',
                'last_login' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'm_email' => 'test4@example.com',
                'm_password' => password_hash('123456', PASSWORD_DEFAULT),
                'm_gmail' => null,
                'm_line' => null,
                'm_fb' => null,
                'm_name' => '測試會員四',
                'm_phone' => '0945678901',
                'm_adress' => '台北市松山區民生東路四段4號',
                'm_role' => 'member',
                'last_login' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'm_email' => 'test5@example.com',
                'm_password' => password_hash('123456', PASSWORD_DEFAULT),
                'm_gmail' => 'test5@gmail.com',
                'm_line' => 'line_id_5',
                'm_fb' => 'fb_id_5',
                'm_name' => '測試會員五',
                'm_phone' => '0956789012',
                'm_adress' => '台北市內湖區成功路五段5號',
                'm_role' => 'member',
                'last_login' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 month')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ]
        ];

        $this->db->table('member')->insertBatch($data);
    }
}