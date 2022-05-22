<?php

use Illuminate\Database\Seeder;

class TransaksiSawahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// GADAI SAWAH

			DB::table('transaksi_sawahs')->insert([ // mendaftarkan sawahnya untuk di gadai (id 1)
	        	'jenis'		=> 'gs',
	        	'periode'	=> '1 tahun',
	        	'harga'		=> '50000000',
	        	'admin_id'  => null,
	        	'sawah_id'  => 1,
	        	'status' 	=> null,
	        	'keterangan'=> '',
	        	'created_at'      => \Carbon\Carbon::now()
			]);

			DB::table('transaksi_sawahs')->insert([ // batal sawahnya untuk di gadai (id 2)
				'jenis'		=> 'gs',
	            'periode'   => '1 tahun',
	            'harga'     => '38000000',
	            'admin_id'  => 1, //batal by role admin
	            'sawah_id'  => 2,
	            'status'    => 'batal',
	            'keterangan'=> '',
	            'created_at'      => \Carbon\Carbon::now()
	        ]);

	        DB::table('transaksi_sawahs')->insert([ // Sedang gadai (id 3)
	        	'jenis'		=> 'gs',
	        	'periode'	=> '1 tahun',
	        	'harga'		=> '20000000',
	        	'admin_id'  => 1, //verified by role admin
	        	'sawah_id'  => 3,
	        	'status' 	=> 'gadai',
	        	'keterangan'=> 'Surat pajak telah diterima oleh pihak Galung App',
	        	'created_at'      => \Carbon\Carbon::now()
			]);

	        DB::table('transaksi_sawahs')->insert([ // riwayat gadai (id 4)
	            'jenis'		=> 'gs',
	            'periode'   => '1 tahun',
	            'harga'     => '80000000',
	            'admin_id'  => 1, //verified by role admin
	            'sawah_id'  => 4,
	            'status'    => 'selesai',
	            'keterangan'=> 'Tergadai tanpa masalah',
	            'created_at'      => \Carbon\Carbon::now()
	        ]);
        // END GADAI SAWAH



	    // MODAL TANAM
	        DB::table('transaksi_sawahs')->insert([ // mendaftarkan sebagai modal tanam (id 5)
	            'jenis'		=> 'mt',
	            'sawah_id'  => 5,
	            'status'    => null,
	            'keterangan'=> 'daftar modal tanam',
	            'jenis_bibit'	=> 'ciliwung',
		        'jenis_pupuk'	=> 'phonska',
		        'periode_tanam'	=> '3 bulan',
		        'created_at'      => \Carbon\Carbon::now()
	        ]);

	        DB::table('transaksi_sawahs')->insert([ //  tergadai modal tanam (id 6)
	            'jenis'		=> 'mt',
	            'admin_id'  => 1, //verified by role admin
	            'sawah_id'  => 6,
	            'status'    => 'gadai',
	            'keterangan'=> 'sedang modal tanam',
	            'jenis_bibit'	=> 'situ bagendit',
		        'jenis_pupuk'	=> 'urea',
		        'periode_tanam'	=> '3 bulan',
		        'created_at'      => \Carbon\Carbon::now()
	        ]);

	        DB::table('transaksi_sawahs')->insert([ //  tergadai modal tanam (id 6)
	            'jenis'		=> 'mt',
	            'admin_id'  => 1, //verified by role admin
	            'sawah_id'  => 7,
	            'status'    => 'selesai',
	            'keterangan'=> 'selesai/keterangan modal tanam',
	            'jenis_bibit'	=> 'barelle',
	        	'jenis_pupuk'	=> 'urea plus',
	        	'periode_tanam'	=> '3 bulan',
	        	'created_at'      => \Carbon\Carbon::now()
	        ]);

	        DB::table('transaksi_sawahs')->insert([ //  tergadai modal tanam (id 6)
	            'jenis'		=> 'mt',
	            'admin_id'  => 1, //verified by role admin
	            'sawah_id'  => 8,
	            'status'    => 'batal',
	            'keterangan'=> 'dibatalkan karena tidak memenuhi kriteria sistem',
	            'jenis_bibit'	=> 'barelle',
	        	'jenis_pupuk'	=> 'urea plus',
	        	'periode_tanam'	=> '3 bulan',
	        	'created_at'      => \Carbon\Carbon::now()
	        ]);
	    // END MODAL TANAM
        
    }
}
