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
            $table->id();

            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');


            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');


            $table->unsignedBigInteger('sub_category_id');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');


            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('rating')->default(0);
            $table->integer('price')->default(80);
            $table->integer('discount_price')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_toprated')->default(0);
            $table->tinyInteger('is_discount')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'id']);
            $table->index(['vendor_id', 'is_active']);
            $table->index(['category_id', 'is_active']);
            $table->index(['brand_id', 'is_active']);

            $table->fullText('name');
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
