<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->delete();
        DB::table('admins')->truncate();
        DB::table('admins')->insert([
            [
                'ho_ten' => 'Admin',
                'email' => 'trinhminhson2004@gmail.com',
                'so_dien_thoai' => '0357572879',
                'tinh_trang' => 1,
                'is_admin' => 1,
                'password' => bcrypt('123456'),
            ],

            [
                'ho_ten' => 'Nguyễn Văn A',
                'email' => 'nguyenvana@gmail.com',
                'so_dien_thoai' => '0123456789',
                'tinh_trang' => 1,
                'is_admin' => 0,
                'password' => bcrypt('123456'),
            ],

        ]);
    }
}
