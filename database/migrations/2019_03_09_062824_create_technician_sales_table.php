<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnicianSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('technician_id')->unsigned();
            $table->foreign('technician_id')->references('id')->on('technicians');
            $table->date('date');
            $table->decimal('sale_amount', 6, 2)->default(0.0);
            $table->decimal('tip_amount', 6, 2)->default(0.0);
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
        Schema::dropIfExists('technician_sales');
    }
}
