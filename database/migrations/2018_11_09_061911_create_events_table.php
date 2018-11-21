<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tanggal');
            $table->string('tempat');
            $table->string('penanggung_jawab');
            $table->string('judul');
            $table->string('kota');
            $table->string('deskripsi');
            $table->integer('id_pmi')->unsigned()->index();
            $table->foreign('id_pmi')->references('id')->on('pmis');
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
        Schema::dropIfExists('events');
    }
}
