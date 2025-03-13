<?php

namespace App\Http\Controllers;

use App\Models\NguoiDung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NguoiDungController extends Controller
{
    public function dangNhapGG(Request $request){

        $user = NguoiDung::where('email', $request->email)->first();
        if($user){
            $khachHang = NguoiDung::create([
                'email' => $request->email,
                'ho_ten' => $request->ho_ten,
                'anh_dai_dien' => $request->anh_dai_dien,
                'tinh_trang' => 1,
                'password' => '123456',
                'is_admin' => 0,
                'tinh_trang' => 1

            ]);
            return response()->json([
                'status' => 1,

                'message' => 'Đăng nhập thành công',
            ]);
        }else{



            return response()->json([
                'status' => 1,
                'message' => 'Đăng nhập thành công',
            ]);
        }
    }
    public function dangKy(Request $request){
        $check_mail = NguoiDung::where('email', $request->email)->first();
        if($check_mail) {
            return response()->json([
                'status' => false,
                'message' => "Email đã tồn tại trong hệ thống!"
            ]);
        } else {
                NguoiDung::create([
                'ho_ten' => $request->ho_ten,
                'email' => $request->email,
                'password'  => bcrypt($request->password),
                'so_dien_thoai' => $request->so_dien_thoai,
                'dia_diem' => $request->dia_diem,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Đăng kí tài khoản thành công!"
            ]);
        }
    }
    public function dangNhap(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $nguoiDung = NguoiDung::where('email', $request->email)->first();

        if ($nguoiDung && Hash::check($request->password, $nguoiDung->password)) {
            // Authenticate the user
            Auth::login($nguoiDung);

            // Generate token
            $token = $nguoiDung->createToken('token_khach_hang')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Đăng nhập thành công',
                'token' => $token,
                'user' => $nguoiDung
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Đăng nhập thất bại',
            ]);
        }
    }

}
