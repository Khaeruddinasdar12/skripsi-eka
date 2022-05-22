<?php

use Illuminate\Database\Seeder;

class TransaksiLahan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//GADAI SAWAH
        DB::table('transaksi_lahans')->insert([ // mendaftarkan sawahnya untuk di gadai (id 1)
	        	'jenis'		=> 'gs',
	        	'periode'	=> '1 tahun',
	        	'harga'		=> '50000000',
	        	'user_id'	=> 2,
	        	'status' 	=> null,
	        	'keterangan'=> '',
	        	'kecamatan'	=> 'Mare',
	        	'kelurahan' => 'Macege',
	        	'alamat'	=> 'Kel. Macege, Kec. Mare, Kab. Sidrap',
	        	'luas_lahan'=> '25 Ha',
	        	'admin_id'  => null,
	        	'created_at'      => \Carbon\Carbon::now()
			]);

        // MODAL TANAM
        DB::table('transaksi_lahans')->insert([ // mendaftarkan sawahnya untuk di gadai (id 1)
	        	'jenis'		=> 'mt',
	        	'user_id'	=> 2,
	        	'status' 	=> null,
	        	'jenis_bibit'=> 'Ciliwung',
	        	'jenis_pupuk'=> 'Phonska & Urea',
	        	'keterangan'=> '',
	        	'kecamatan'	=> 'Barebbo',
	        	'kelurahan' => 'Macege',
	        	'alamat'	=> 'Kel. Macege, Kec. Barebbo, Kab. Sidrap',
	        	'luas_lahan'=> '40 Ha',
	        	'admin_id'  => null,
	        	'created_at'      => \Carbon\Carbon::now()
			]);
    }
}
