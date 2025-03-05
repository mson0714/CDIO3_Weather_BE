<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $fillable = ['ho_ten', 'email', 'so_dien_thoai', 'tinh_trang', 'is_admin', 'password'];
}
