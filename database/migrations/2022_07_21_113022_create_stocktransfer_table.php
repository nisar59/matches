<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocktransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocktransfer', function (Blueprint $table) {
            $table->id();
            $table->dateTime('transfer_date')->useCurrent();
            $table->text('transfer_reference_no')->nullable();
            $table->integer('transfer_quantity')->default(0);
            $table->float('transfer_charges',10,2)->default(0.00);
            $table->text('transfer_note')->nullable();
            $table->enum('shipping_status',['processing','pending','delivered'])->default('processing');
            $table->float('transfer_total',10,2)->default(0.00);
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
        Schema::dropIfExists('stocktransfer');
    }
}
