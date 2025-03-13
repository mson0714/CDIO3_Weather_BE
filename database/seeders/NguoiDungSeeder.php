<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NguoiDungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nguoi_dungs')->insert([
            'ho_ten' => 'nguoidung1',
            'email' => 'nguoidung1@example.com',
            'password' => '123456', // Use Hash for secure password
            'so_dien_thoai' => '0123456789',
            'dia_diem' => 'Hà Nội',
            'tinh_trang' => 1,
            'is_admin' => 0,

        ]);

        // Add more users if needed
    }
}
