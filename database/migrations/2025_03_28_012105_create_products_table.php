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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name', 100);
            $table->string('product_image');
            
            // Sử dụng foreignId nhưng thêm tham số chỉ định khóa ngoại
            $table->foreignId('categories_id')
                ->constrained('categories', 'categories_id')
                ->onDelete('cascade');

            $table->double('product_price')->default(0);
            $table->integer('quantity_store')->default(0)->comment('số lượng con trong kho');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};