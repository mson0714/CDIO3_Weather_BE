<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;

class NguoiDungController extends Controller
{
    public function dangNhapGG(Request $request){

        $user = NguoiDung::where('email', $request->email)->first();
        if($user){
            return response()->json([
                'status' => 1,
                'message' => 'Đăng nhập thành công',
            ]);
        }else{
            $khachHang = NguoiDung::create([
                'email' => $request->email,
                'ho_ten' => $request->ho_ten,
                'anh_dai_dien' => $request->anh_dai_dien,
                'tinh_trang' => 1,
                'password' => '123456',
                'is_admin' => 0,
            ]);
            return response()->json([
                'status' => 1,
                'message' => 'Đăng nhập thành công',
            ]);
        }
    }
}
