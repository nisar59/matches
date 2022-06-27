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
            $table->text('vendor')->nullable();
            $table->text('order_date')->nullable();
            $table->text('reference_no')->nullable();
            $table->text('total_items')->nullable();
            $table->text('gross_total')->nullable();
            $table->text('purchase_total')->nullable();
            $table->text('payment_amount')->nullable();
            $table->text('due')->nullable();
            $table->text('payment_status')->nullable();
            $table->text('discount_type')->nullable();
            $table->text('discount_value')->nullable();
            $table->text('net_discount')->nullable();
            $table->text('shipping_status')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('shipping_charges')->nullable();
            $table->text('shipping_detail')->nullable();
            $table->text('added_by')->nullable();
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
