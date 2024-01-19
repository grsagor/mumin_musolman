<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('id')->primary();
            $table->string('pick_lat')->nullable();
            $table->string('pick_lng')->nullable();
            $table->string('drop_lat')->nullable();
            $table->string('drop_lng')->nullable();
            $table->string('pick_date')->nullable();
            $table->string('pick_time')->nullable();
            $table->integer('no_of_truck')->nullable();
            $table->string('load_type')->nullable();
            $table->string('note')->nullable();
            $table->string('payment_method')->nullable();
            $table->float('distance')->nullable();
            $table->float('fare')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
