<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class NguoiDung extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'nguoi_dungs'; // Adjust if your table name is different

    protected $fillable = [
        'ho_ten',
        'email',
        'password',
        'anh_dai_dien',
        'so_dien_thoai',
        'dia_diem',
        'tinh_trang',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
