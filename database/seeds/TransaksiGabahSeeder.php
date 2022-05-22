<?php

use Illuminate\Database\Seeder;

class TransaksiGabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaksi_gabahs')->insert([
        	'jumlah'	=> 400,
	        'harga'  	=> 6000, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Barebbo',
	        'kelurahan' 	=> 'Desa Kampuno',
	        'alamat' => 'Kampuno, Desa Kampuno Kec. Barebbo Kab. Bone',
	        'user_id'=> 2, //dari tabel user role petani (dari seeder)
	        'keterangan' => 'saya mau cepat gabah saya kak oke ?',
	        'jenis_bayar' => 'cod',
	        'status' => '0',
	        'gabah_id' => 1,
	        'created_at'      => \Carbon\Carbon::now()
		]);

		DB::table('transaksi_gabahs')->insert([
        	'jumlah'	=> 380,
	        'harga'  	=> 6000, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Bulutempe',
	        'kelurahan' 	=> 'Desa Sugiale',
	        'alamat' => 'Sugiale, Desa Sugiale Kec. Bulutempe Kab. Pare-pare',
	        'user_id'=> 2, //dari tabel user role petani (dari seeder)
	        'keterangan' => 'saya punya gabah untuk di jual kak',
	        'jenis_bayar' => 'cod',
	        'status' => '0',
	        'gabah_id' => 1,
	        'created_at'      => \Carbon\Carbon::now()
		]);

		//riwayat transaksi Gabah
		DB::table('transaksi_gabahs')->insert([
        	'jumlah'	=> 500,
	        'harga'  	=> 4000,
	        'kecamatan' => 'Kec. Bulutempe',
	        'kelurahan' 	=> 'Desa Sugiale',
	        'alamat' => 'Sugiale, Desa Sugiale Kec. Bulutempe Kab. Pare-pare',
	        'user_id'=> 2, //dari tabel user role petani (dari seeder)
	        'keterangan' => 'senang bertransaksi gabah',
	        'jenis_bayar' => 'cod',
	        'status' => '1',
	        'gabah_id' => 1,
	        'admin_id' => 1,
	        'created_at'      => \Carbon\Carbon::now()
		]);

		//batal transaksi Gabah
		DB::table('transaksi_gabahs')->insert([
        	'jumlah'	=> 200,
	        'harga'  	=> 3500,
	        'kecamatan' => 'Kec. Bulutempe',
	        'kelurahan' 	=> 'Desa Sugiale',
	        'alamat' => 'Sugiale, Desa Sugiale Kec. Bulutempe Kab. Pare-pare',
	        'user_id'=> 2, //dari tabel user role petani (dari seeder)
	        'keterangan' => 'batal bertransaksi gabah hmm',
	        'jenis_bayar' => 'cod',
	        'status' => 'batal',
	        'gabah_id' => 1,
	        'admin_id' => 1,
	        'created_at'      => \Carbon\Carbon::now()
		]);
    }
}
