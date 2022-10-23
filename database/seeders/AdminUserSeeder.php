<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // テストユーザーの登録
        $param = [
            'name' => 'admin',
            'email' => 'example@test.com',
            'password' => Hash::make('password'),
        ];
        $adminUser = new AdminUser;
        $adminUser->fill($param)->save();
    }
}
