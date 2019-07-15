<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCcLoanDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_loan_deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('loan_id')->index();
            $table->date('withdraw_date');
            $table->date('deposit_date');
            $table->double('amount');
            $table->double('interest_rate')->nullable();
            $table->double('interest')->nullable();
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
        Schema::dropIfExists('cc_loan_deposits');
    }
}
