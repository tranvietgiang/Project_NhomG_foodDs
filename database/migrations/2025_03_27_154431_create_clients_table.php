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
        Schema::create('clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->unique();
            $table->string('client_name', 50)->index(); //index() giúp tăng tốc độ truy vấn trên các cột mà bạn thường xuyên tìm kiếm, sắp xếp hoặc lọc dữ liệu.
            $table->string('client_phone', 15)->unique();
            $table->string('client_address');
            $table->enum('client_gender', ['Nam', 'Nu']);
            $table->string('client_address_detail')->nullable(); // Cho phép NULL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};