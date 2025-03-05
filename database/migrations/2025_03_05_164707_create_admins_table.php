<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // Add primary key
            $table->string('ho_ten'); // Họ và tên nhân viên
            $table->string('email')->unique(); // Email duy nhất
            $table->string('so_dien_thoai')->nullable(); //
            $table->tinyInteger('tinh_trang')->default(1);
            $table->tinyInteger('is_admin')->default(0);
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
