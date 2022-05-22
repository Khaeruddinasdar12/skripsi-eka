<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('pekerjaan');
            $table->integer('alamat_id'); 
            $table->string('alamat'); //alamat lengkap
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('foto_ktp')->nullable();
            $table->string('nohp');
            $table->enum('petani_verified', [0, 1]);
            $table->enum('jkel', ['L', 'P']);
            $table->string('rt');
            $table->string('rw');
            $table->enum('role', ['konsumen', 'petani']);
            $table->integer('verified_by')->nullable();
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
        Schema::dropIfExists('users');
    }
}
