<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountFB;

class AccountFBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tạo 10 bản ghi giả định
        for ($i = 0; $i < 999; $i++) {
            $data = [
                'user_id' => rand(1, 100),
                'fb_id' => 'fb_' . rand(1000, 9999),
                'name' => 'User ' . ($i+1),
                'email' => 'user' . ($i+1) . '@example.com',
                'phone' => '0396130621',
                'password' => 'password',
                'cookie' => '',
                'token' => ''
            ];
            AccountFB::create($data);
        }
    }
}
