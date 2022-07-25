<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('model_id')->default(0);
            $table->enum('transaction_type',['purchase','sell','return'])->default('sell');
            $table->float('payment_amount',10,2)->default(0.00);
            $table->dateTime('paid_on')->useCurrent();
            $table->text('method')->nullable();
            $table->text('method_detail')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
