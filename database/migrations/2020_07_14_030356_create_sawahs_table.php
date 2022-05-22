<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSawahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sawahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('titik_koordinat')->nullable();
            $table->integer('alamat_id');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('alamat'); //alamat lengkap
            $table->integer('created_by');
            $table->string('luas_sawah');
            // $table->string('jenis_bibit');
            // $table->string('jenis_pupuk');
            // $table->string('periode_tanam');
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
        Schema::dropIfExists('sawahs');
    }
}
