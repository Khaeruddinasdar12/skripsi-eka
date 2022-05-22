<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->bigInteger('transaksi_id')->unsigned();
            $table->bigInteger('barang_id')->unsigned();
            $table->timestamps();
            $table->foreign('transaksi_id')->references('id')->on('transaksi_barangs');
            $table->foreign('barang_id')->references('id')->on('barangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_transaksis');
    }
}
