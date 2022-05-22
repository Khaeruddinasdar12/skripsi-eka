<?php

use Illuminate\Database\Seeder;

class GabahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gabahs')->insert([
	        'nama'  => 'Ciliwung', 
	        'harga' => 6000, //per KG
	        'admin_id' 	=> 1 // rolenya admin di tabel users
		]);

		DB::table('gabahs')->insert([
	        'nama'  => 'Pera', 
	        'harga' => 5000, //per KG
	        'admin_id' 	=> 1 // rolenya admin di tabel users
		]);

		DB::table('gabahs')->insert([
	        'nama'  => 'Pulen', 
	        'harga' => 4500, //per KG
	        'admin_id' 	=> 1 // rolenya admin di tabel users
		]);
    }
}
