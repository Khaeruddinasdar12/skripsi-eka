<?php

use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// BERAS
        DB::table('barangs')->insert([ // id 1
	        'nama'  	=> 'Ketan', 
	        'jenis'		=> 'sayur',
	        'harga' 	=> 6000, //per KG
	        'min_beli' 	=> 5,
	        'stok' 		=> 25,
	        'keterangan'=> 'Beras berkualitas serius ini cika',
	        'gambar' 	=> null,
	        'admin_id' 	=> 1, //admin
	        'created_at'      => \Carbon\Carbon::now()
		]);

		DB::table('barangs')->insert([ // id 2
	        'nama'  	=> 'Pulut',
	        'jenis'		=> 'sayur', 
	        'harga' 	=> 5000, //per KG
	        'min_beli' 	=> 5, 
	        'stok' 		=> 75,  
	        'keterangan'=> 'Beras berkualitas serius ini cika',
	        'gambar' 	=> null,
	        'admin_id' 	=> 1, //admin
	        'created_at'      => \Carbon\Carbon::now()
		]);
		// END BERAS


		// ALAT
		DB::table('barangs')->insert([ // id 3
	        'nama'  	=> 'Pompa Air',
	        'jenis'		=> 'alat', 
	        'harga' 	=> 1450000, //per unit
	        'min_beli'	=> 1,
	        'stok' 		=> 3,
	        'keterangan'=> 'warna ungu',
	        'gambar' 	=> null,
	        'admin_id' 	=> 1, //admin
	        'created_at'      => \Carbon\Carbon::now()
		]);

		DB::table('barangs')->insert([ // id 5
	        'nama'  	=> 'Selang pompa Air',
	        'jenis'		=> 'alat',  
	        'harga' 	=> 1450000, //per unit
	        'min_beli'	=> 1,
	        'stok' 		=> 3,
	        'keterangan'=> '15 meter',
	        'gambar' 	=> null,
	        'admin_id' 	=> 1, //admin
	        'created_at'      => \Carbon\Carbon::now()
		]);
		// END ALAT


		// BIBIT
		DB::table('barangs')->insert([ // id 5
	        'nama'  	=> 'Situ bagendit',
	        'jenis'		=> 'bibit', 
	        'harga' 	=> 6500, // per kg
	        'min_beli'	=> 10,
	        'stok' 		=> 100,
	        'keterangan'=> 'bibit berkualitas',
	        'gambar' 	=> null,
	        'admin_id' 	=> 1, //admin
	        'created_at'      => \Carbon\Carbon::now()
		]);

		DB::table('barangs')->insert([ // id 6
	        'nama'  	=> 'Ciliwung',
	        'jenis'		=> 'bibit',  
	        'harga' 	=> 7000, // per kg
	        'min_beli'	=> 10,
	        'stok' 		=> 200,
	        'keterangan'=> 'bibit unggul',
	        'gambar' 	=> null,
	        'admin_id' 	=> 1, //admin
	        'created_at'      => \Carbon\Carbon::now()
		]);
		// END BIBIT


		// PUPUK
		DB::table('barangs')->insert([ // id 7
	        'nama'  	=> 'Urea',
	        'jenis'		=> 'pupuk', 
	        'harga' 	=> 8000, // per kg
	        'min_beli'	=> 10, 
	        'stok' 		=> 500,
	        'keterangan'=>'untuk pertumbahan padi',
	        'gambar' 	=> null,
	        'admin_id' 	=> 1, //admin
	        'created_at'      => \Carbon\Carbon::now()
		]);

		DB::table('barangs')->insert([ // id 8
	        'nama'  	=> 'Phonska',
	        'jenis'		=> 'pupuk',  
	        'harga' 	=> 110000, // per kg
	        'min_beli'	=> 10,
	        'stok' 		=> 800,
	        'keterangan'=> 'pupuk yang paling sering digunakan',
	        'gambar' 	=> null,
	        'admin_id' 	=> 1, //admin
	        'created_at'      => \Carbon\Carbon::now()
		]);
		// END PUPUK
    }
}
