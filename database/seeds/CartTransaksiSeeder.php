<?php

use Illuminate\Database\Seeder;

class CartTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//sedang transaksi
        DB::table('cart_transaksis')->insert([
    		'nama'	=> 'pulut',
    		'jenis' => 'sayur',
    		'harga' => 5000,
    		'jumlah'=> 5,
    		'subtotal' => 25000,
    		'transaksi_id' => 1,
    		'barang_id' => 2,
    		'created_at'      => \Carbon\Carbon::now()
    	]);

    	DB::table('cart_transaksis')->insert([
    		'nama'	=> 'Pompa air',
    		'jenis' => 'alat',
    		'harga' => 1450000,
    		'jumlah'=> 1,
    		'subtotal' => 1450000,
    		'transaksi_id' => 1,
    		'barang_id' => 3,
    		'created_at'      => \Carbon\Carbon::now()
    	]);

    	DB::table('cart_transaksis')->insert([ 
    		'nama'	=> 'Pompa air',
    		'jenis' => 'alat',
    		'harga' => 1450000,
    		'jumlah'=> 3,
    		'subtotal' => 4350000,
    		'transaksi_id' => 2,
    		'barang_id' => 4,
    		'created_at'      => \Carbon\Carbon::now()
    	]);
    	//end sedang transaksi

    	//riwayat transaksi
    	DB::table('cart_transaksis')->insert([ 
    		'nama'	=> 'Ciliwung',
    		'jenis' => 'bibit',
    		'harga' => 7000,
    		'jumlah'=> 20,
    		'subtotal' => 140000,
    		'transaksi_id' => 3,
    		'barang_id' => 6,
    		'created_at'      => \Carbon\Carbon::now()
    	]);
    	//end sedang transaksi
    }
}
