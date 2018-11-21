<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeroesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->bigInteger('nik')->unique();
            $table->bigInteger('telepon');
            $table->string('jenis_kelamin');
            $table->string('tanggal_lahir');
            $table->string('kota');
            $table->string('alamat');
            $table->string('foto');
            $table->string('jumlah_donor')->nullable();
            $table->string('no_pmi')->nullable();
            $table->string('gol_darah')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('heroes');
    }
}
