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
            $table->text('name')->nullable();
            $table->text('sku')->nullable();
            $table->text('pricing_unit')->nullable();
            $table->text('price')->nullable();
            $table->text('category')->nullable();
            $table->text('alert_quantity')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('margin')->nullable();
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
