
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('transaksi_code')->unique()->nullable();
            $table->string('penerima')->nullable();
            $table->string('nohp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('alamat_id')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('total')->nullable();
            $table->string('keterangan')->nullable();
            $table->enum('jenis_bayar', ['tf', 'cod']);
            $table->string('bukti')->nullable();
            $table->enum('status', ['0','1', 'batal'])->nullable();
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
        Schema::dropIfExists('transaksi_barangs');
    }
}
