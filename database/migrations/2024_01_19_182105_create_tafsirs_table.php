<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTafsirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tafsirs', function (Blueprint $table) {
            $table->id();
            $table->string('sura_no');
            $table->string('ayat_no');
            $table->string('jakariya_heading');
            $table->longText('jakariya_tafsir');
            $table->string('majid_heading');
            $table->longText('majid_tafsir');
            $table->string('ahsanul_heading');
            $table->longText('ahsanul_tafsir');
            $table->string('kasir_heading');
            $table->longText('kasir_tafsir');
            $table->string('other_heading');
            $table->longText('other_tafsir');
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
        Schema::dropIfExists('tafsirs');
    }
}
