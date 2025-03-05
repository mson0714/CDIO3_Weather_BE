<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    protected $table = 'nguoi_dungs';
    protected $fillable = ['ho_ten', 'email', 'password', 'anh_dai_dien', 'so_dien_thoai', 'dia_diem'];
}
