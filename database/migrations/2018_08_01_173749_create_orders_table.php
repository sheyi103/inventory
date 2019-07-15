<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('workOrder_id');
            $table->unsignedInteger('customer_id')->index();
            $table->unsignedInteger('product_id')->index();
            $table->date('date');
            $table->text('details')->nullable();
            $table->string('quantity')->nullable();
            $table->string('remaining')->nullable();
            $table->double('rate')->nullable();
            $table->double('vat')->nullable();
            $table->double('amount')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
