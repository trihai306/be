<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['active', 'inactive', 'pending', 'block'];
        for ($i = 0; $i < 10000000; $i++) {
            DB::table('accounts')->insert([
                'name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'phone' => rand(10000000, 99999999),
                'password' => 'password',
                'cookie' => Str::random(50),
                'proxy_id' => rand(1,10),
                'status' => $status[array_rand($status)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
