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
            $table->integer('purchase_order_id')->default(0);
            $table->integer('warehousesandshops_id')->default(0);
            $table->enum('type',['purchase','transferred'])->default('purchase');
            $table->text('product_name')->nullable();
            $table->float('unit_cost',10,2)->default(0);
            $table->integer('quantity')->default(0);
            $table->integer('available_quantity')->default(0);
            $table->integer('transfer_quantity')->default(0);
            $table->integer('sold_quantity')->default(0);
            $table->float('total_product_cost',10,2)->default(0.00);
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
