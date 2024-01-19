<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruckTypeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truck_type_details', function (Blueprint $table) {
            $table->id();
            $table->string('truck_type_id')->nullable();
            $table->string('load_type')->nullable();
            $table->float('rent_amount')->nullable();
            $table->string('rent_amount_per')->nullable();
            $table->float('driver_charge')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('truck_type_details');
    }
}
