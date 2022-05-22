<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiLahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_lahans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->enum('jenis', ['mt', 'gs']);
            $table->string('periode')->nullable();
            $table->integer('harga')->nullable();
            $table->enum('status', ['gadai', 'selesai', 'batal'])->nullable();
            $table->string('jenis_bibit')->nullable();
            $table->string('jenis_pupuk')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('sertifikat_tanah')->nullable();
            $table->string('surat_pajak')->nullable();
            $table->string('surat_perjanjian')->nullable();
            $table->datetime('status_at')->nullable();
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('alamat');
            $table->string('titik_koordinat')->nullable();
            $table->string('luas_lahan');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('admin_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('admin_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_lahans');
    }
}
