<?php

use Illuminate\Database\Seeder;

class SawahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// untuk gadai sawah
        DB::table('sawahs')->insert([ // id 1
        	'nama'	=> 'sawah 1',
	        'alamat_id'  => 87, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Barebbo',
	        'kelurahan' 	=> 'Desa Kampuno',
	        'alamat' => 'Kampuno, Desa Kampuno Kec. Barebbo Kab. Bone',
	        'created_by'=> 2, //dari tabel user role petani (dari seeder)
	        'luas_sawah'	=> '20 Ha'
	        // 'jenis_bibit'	=> 'ciliwung',
	        // 'jenis_pupuk'	=> 'phonska',
	        // 'periode_tanam'		=> '3 bulan'
		]);

		DB::table('sawahs')->insert([ // id 2
			'nama'	=> 'sawah 2',
	        'alamat_id'  => 87, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Barebbo',
	        'kelurahan' 	=> 'Desa Talungeng',
	        'alamat' => 'Galung, Desa Talungeng Kec. Barebbo Kab. Bone',
	        'created_by'=> 2, //dari tabel user role petani (dari seeder)
	        'luas_sawah'	=> '50 Ha'
	        // 'jenis_bibit'	=> 'ciliwung',
	        // 'jenis_pupuk'	=> 'phonska',
	        // 'periode_tanam'		=> '3 bulan'
		]);

		DB::table('sawahs')->insert([ // id 3
			'nama'	=> 'sawah 3',
	        'alamat_id'  => 87, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Barebbo',
	        'kelurahan' 	=> 'Desa Lampoko',
	        'alamat' => 'Lampoko, Desa Lampoko Kec. Barebbo Kab. Bone',
	        'created_by'=> 2, //dari tabel user role petani (dari seeder)
	        'luas_sawah'	=> '80 Ha'
	        // 'jenis_bibit'	=> 'ciliwung',
	        // 'jenis_pupuk'	=> 'phonska',
	        // 'periode_tanam'		=> '3 bulan'
		]);

		DB::table('sawahs')->insert([ // id 4
			'nama'	=> 'sawah 4',
	        'alamat_id'  => 87, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Barebbo',
	        'kelurahan' 	=> 'Desa Sugiale',
	        'alamat' => 'Ale, Desa Sugiale Kec. Barebbo Kab. Bone',
	        'created_by'=> 2, //dari tabel user role petani (dari seeder)
	        'luas_sawah'	=> '38 Ha'
	        // 'jenis_bibit'	=> 'ciliwung',
	        // 'jenis_pupuk'	=> 'phonska',
	        // 'periode_tanam'		=> '3 bulan'
		]);
		// end untuk gadai sawah

		// untuk modal tanam
		DB::table('sawahs')->insert([ // id 5
			'nama'	=> 'sawah 5',
	        'alamat_id'  => 87, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Barebbo',
	        'kelurahan' 	=> 'Desa Panyili',
	        'alamat' => 'Panyili, Desa Panyili Kec. Barebbo Kab. Bone',
	        'created_by'=> 2, //dari tabel user role petani (dari seeder)
	        'luas_sawah'	=> '40 Ha'
	        // 'jenis_bibit'	=> 'ciliwung',
	        // 'jenis_pupuk'	=> 'phonska',
	        // 'periode_tanam'		=> '3 bulan'
		]);

		DB::table('sawahs')->insert([ // id 6
			'nama'	=> 'sawah 6',
	        'alamat_id'  => 87, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Barebbo',
	        'kelurahan' 	=> 'Desa Apala',
	        'alamat' => 'Apala, Desa Apala Kec. Barebbo Kab. Bone',
	        'created_by'=> 2, //dari tabel user role petani (dari seeder)
	        'luas_sawah'	=> '20 Ha'
	        // 'jenis_bibit'	=> 'ciliwung',
	        // 'jenis_pupuk'	=> 'phonska',
	        // 'periode_tanam'		=> '3 bulan'
		]);

		DB::table('sawahs')->insert([ // id 7
			'nama'	=> 'sawah 7',
	        'alamat_id'  => 87, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Barebbo',
	        'kelurahan' 	=> 'Desa Lamuru',
	        'alamat' => 'Lamuru, Desa Lamuru Kec. Barebbo Kab. Bone',
	        'created_by'=> 2, //dari tabel user role petani (dari seeder)
	        'luas_sawah'	=> '25 Ha'
	        // 'jenis_bibit'	=> 'ciliwung',
	        // 'jenis_pupuk'	=> 'phonska',
	        // 'periode_tanam'		=> '3 bulan'
		]);

		DB::table('sawahs')->insert([ // id 7
			'nama'	=> 'sawah 8',
	        'alamat_id'  => 87, //id kabupaten bone dari tabel Kotas
	        'kecamatan' => 'Kec. Ponre',
	        'kelurahan' 	=> 'Desa Salebba',
	        'alamat' => 'Salebba, Desa Lamuru Kec. Ponre Kab. Bone',
	        'created_by'=> 2, //dari tabel user role petani (dari seeder)
	        'luas_sawah'	=> '43 Ha'
	        // 'jenis_bibit'	=> 'ciliwung',
	        // 'jenis_pupuk'	=> 'phonska',
	        // 'periode_tanam'		=> '3 bulan'
		]);
		// end untuk modal tanam
    }
}
