<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaction_id')->unsigned();
            $table->bigInteger('account_id')->unsigned();
            $table->decimal('amount', 6, 2)->default(0.0);
            $table->string('memo', 256)->nullable();
            $table->string('reference', 256)->nullable();
            $table->timestamps();
        });

        Schema::table('transaction_items', function ($table) {
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_items');
    }
}
