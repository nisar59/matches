<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor')->default(0);
            $table->text('order_date')->default(now());
            $table->text('reference_no')->nullable();
            $table->integer('total_items')->default(0);
            $table->float('gross_total', 10,2)->default(0.00);
            $table->float('purchase_total',10,2)->default(0.00);
            $table->float('payment_amount',10,2)->default(0.00);
            $table->float('due',10,2)->default(0.00);
            $table->enum('payment_status',['due','paid','partial'])->default('due');
            $table->text('discount_type')->nullable();
            $table->float('discount_value',10,2)->default(0.00);
            $table->float('net_discount',10,2)->default(0.00);
            $table->text('shipping_status',['processing','pending','delivered'])->default('processing');
            $table->text('shipping_address')->nullable();
            $table->float('shipping_charges',10,2)->default(0.00);
            $table->text('shipping_detail')->nullable();
            $table->integer('added_by')->default(0);
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
        Schema::dropIfExists('purchases');
    }
}
