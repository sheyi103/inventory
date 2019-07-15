<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->unsignedInteger('customer_id')->index();
            $table->double('amount');
            $table->integer('purpose');
            $table->string('invoice')->nullable();
            $table->string('token')->nullable();
            $table->text('receiver')->nullable();
            $table->integer('payment_type')->nullable();
            $table->integer('payment_mode')->nullable();
            //$table->string('bank_id')->nullable();
            $table->string('bank_account_id')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('mobile_banking_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('sale_transactions');
    }
}
