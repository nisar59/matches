<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->text('expense_category')->nullable();
            $table->text('reference_no')->nullable();
            $table->dateTime('expense_date')->useCurrent();
            $table->enum('payment_status',['due','paid','partial','expense'])->default('due');
            $table->float('amount',10,2)->default(0.00);
            $table->float('paid',10,2)->default(0.00);
            $table->float('due',10,2)->default(0.00);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
