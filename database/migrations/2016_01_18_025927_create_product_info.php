<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('platform_id')->default('amazon.cn')->comment('amazon ebay etc');
            $table->string('name')->comment('product name');
            $table->string('type')->default('0')->comment('product type summary');
            $table->string('type_detail')->default('0')->comment('product type detail, etc, sn');
            $table->string('price')->comment('price');
            $table->string('trans_fee')->default('0')->comment('transport plus tax fee');
            $table->string('status')->default('未知')->comment('on sale or not');
            $table->string('url')->comment('原始url');
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
        Schema::drop('product_infos');
    }
}
