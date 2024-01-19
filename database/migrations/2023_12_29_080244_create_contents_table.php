<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('creator_id')->nullable();
            $table->string('category_id')->nullable();
            $table->longText('description')->nullable();
            $table->float('amount')->nullable();
            $table->string('discount_type')->nullable();
            $table->float('discount_amount')->nullable();
            $table->integer('is_free')->nullable();
            $table->longText('images')->nullable();
            $table->longText('videos')->nullable();
            $table->text('tags')->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('publish_time')->useCurrent();
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
        Schema::dropIfExists('contents');
    }
}
