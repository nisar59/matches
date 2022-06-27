<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_products', function (Blueprint $table) {
            $table->id();
            $table->text('purchase_order_id')->nullable();
            $table->text('warehousesandshops_id')->nullable();
            $table->text('type')->nullable();
            $table->text('product_name')->nullable();
            $table->text('unit_cost')->nullable();
            $table->text('quantity')->nullable();
            $table->text('available_quantity')->nullable();
            $table->text('total_product_cost')->nullable();
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
        Schema::dropIfExists('purchased_products');
    }
}
