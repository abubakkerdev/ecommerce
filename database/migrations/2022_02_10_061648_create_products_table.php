<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('product_desc');
            $table->text('short_desc');
            $table->string('product_brand');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('product_price');
            $table->integer('discount')->nullable();
            $table->integer('after_discount')->nullable();
            $table->text('product_preview');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
