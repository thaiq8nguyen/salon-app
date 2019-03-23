<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSquareReceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('square_receipt_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('square_receipt_id')->unsigned();
            $table->foreign('square_receipt_id')->references('id')->on('square_receipts');
            $table->bigInteger('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->decimal('amount', 6, 2)->default(0.0);
            $table->string('memo', 256)->nullable();
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
        Schema::dropIfExists('square_receipt_items');
    }
}
