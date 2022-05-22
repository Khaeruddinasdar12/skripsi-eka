<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api) {
    $api->get('test', function() {
         return 1;
    });
});
    
	Route::get('provinsi', 'Api\AlamatController@provinsi');
	Route::get('kabupaten/{id}', 'Api\AlamatController@kabupaten');
	Route::post('register', 'Api\UserController@register');
    Route::post('login', 'Api\UserController@login');
    
    Route::get('gabah-all', 'Api\GabahController@index'); //semua data gabah (no header)
    Route::get('beras', 'Api\BerasController@index'); //semua data beras (no header)
    Route::get('sayur', 'Api\SayurController@index'); //semua data sayur (no header)
    Route::get('alat', 'Api\AlatController@index'); //semua data alat (no header)
    Route::get('bibit-pupuk', 'Api\DataBibitPupukController@index'); //semua data bibit-pupuk (no header)
    // Route::get('tsawah', 'Api\SawahController@listsawah'); // data sawah berdasarkan id yang login (tes)

    // Route::get('add-cart/{id}', 'Api\TransaksiBarangController@addcart');

    Route::group(['middleware' => ['auth:api']], function() {
        Route::get('user', 'Api\UserController@detail');
        Route::post('edit-user', 'Api\UserController@update');


        // MODAL TANAM CONTROLLER SKRIPSI
        Route::post('modal-tanam-skripsi', 'Api\ModalTanamSkripsi@store'); // post mendaftarkan sawah untuk digadai modal tanam

        Route::get('list-daftar-modal-tanam-skripsi', 'Api\ModalTanamSkripsi@index'); // list sawah yang sedang didaftar modal tanam oleh user id
        Route::get('list-batal-modal-tanam-skripsi', 'Api\ModalTanamSkripsi@batal'); // list sawah yang batal modal tanam oleh user id
        Route::get('list-riwayat-modal-tanam-skripsi', 'Api\ModalTanamSkripsi@riwayat'); // list sawah yang sedang tergadai modal tanam oleh user id

        // END MODAL TANAM CONTROLLER SKRIPSI


        // GADAI LAHAN CONTROLLER SKRIPSI
        Route::post('gadai-lahan-skripsi', 'Api\GadaiLahanSkripsi@store'); // post mendaftarkan sawah untuk digadai modal tanam

        Route::get('list-daftar-gadai-lahan-skripsi', 'Api\GadaiLahanSkripsi@index'); // list sawah yang sedang tergadai oleh user id
        Route::get('list-sedang-gadai-lahan-skripsi', 'Api\GadaiLahanSkripsi@gadai'); // list sawah yang sedang tergadai oleh user id
        Route::get('list-batal-gadai-lahan-skripsi', 'Api\GadaiLahanSkripsi@batal'); // list sawah yang batal oleh user id
        Route::get('list-riwayat-gadai-lahan-skripsi', 'Api\GadaiLahanSkripsi@riwayat'); // list sawah riwayat tergadai oleh user id

        // END GADAI LAHAN CONTROLLER SKRIPSI

        // TRANSAKSI
        Route::post('add-cart/{id}', 'Api\TransaksiBarangController@addcart');
        Route::post('checkout/{id}', 'Api\TransaksiBarangController@checkout');
        Route::get('cart', 'Api\TransaksiBarangController@cart');
        Route::post('edit-cart/{id}', 'Api\TransaksiBarangController@edit');
        Route::post('delete-cart/{id}', 'Api\TransaksiBarangController@delete');
        Route::post('upload-bukti/{id}', 'Api\TransaksiBarangController@uploadBukti');

        Route::get('belum-bayar', 'Api\TransaksiBarangController@belumBayar');
        Route::get('proses-belanja', 'Api\TransaksiBarangController@proses');
        Route::get('riwayat-belanja', 'Api\TransaksiBarangController@riwayat');
        Route::get('batal-belanja', 'Api\TransaksiBarangController@batal');
        // END TRANSAKSI

        // BERAS
        Route::post('beras-store/{id}', 'Api\BerasController@store'); // post beli beras
        
        Route::get('transaksi-beras', 'Api\BerasController@transaksi');
        Route::get('riwayat-transaksi-beras', 'Api\BerasController@riwayat');
        Route::get('batal-transaksi-beras', 'Api\BerasController@batal');
        // END BERAS


        // ALAT
        Route::post('alat-store/{id}', 'Api\AlatController@store'); // post beli alat
        
        Route::get('transaksi-alat', 'Api\AlatController@transaksi');
        Route::get('riwayat-transaksi-alat', 'Api\AlatController@riwayat');
        Route::get('batal-transaksi-alat', 'Api\AlatController@batal');
        // END ALAT


        // BIBIT
        Route::post('bibit-store/{id}', 'Api\BibitController@store'); // post beli bibit
        
        Route::get('transaksi-bibit', 'Api\BibitController@transaksi');
        Route::get('riwayat-transaksi-bibit', 'Api\BibitController@riwayat');
        Route::get('batal-transaksi-bibit', 'Api\BibitController@batal');
        // END BIBIT


        // PUPUK
        Route::post('pupuk-store/{id}', 'Api\PupukController@store'); // post beli pupuk
        
        Route::get('transaksi-pupuk', 'Api\PupukController@transaksi');
        Route::get('riwayat-transaksi-pupuk', 'Api\PupukController@riwayat');
        Route::get('batal-transaksi-pupuk', 'Api\PupukController@batal');
        // END PUPUK


        // GABAH
        Route::post('gabah-store/{id}', 'Api\GabahController@store');
        
        Route::get('transaksi-gabah', 'Api\GabahController@transaksi');
        Route::get('riwayat-transaksi-gabah', 'Api\GabahController@riwayat');
        Route::get('batal-transaksi-gabah', 'Api\GabahController@batal');
        // GABAH


        // SAWAH CONTROLLER 
        Route::get('sawah', 'Api\SawahController@index'); // data sawah berdasarkan id yang login
        Route::post('sawah', 'Api\SawahController@store'); // mendaftarkan sawah berdasarkan id yang login
        Route::post('edit-sawah/{id}', 'Api\SawahController@update'); //edit sawah berdasarkan id sawah (tidak bisa edit jika data terdapat di table lain)
        Route::post('delete-sawah/{id}', 'Api\SawahController@delete'); //hapus sawah berdasarkan id sawah
        // END SAWAH CONTROLLER


        // MODAL TANAM CONTROLLER
        Route::post('modal-tanam', 'Api\ModalTanamController@store'); // post mendaftarkan sawah untuk digadai modal tanam

        Route::get('list-sedang-gadai-modal-tanam', 'Api\ModalTanamController@gadai'); // list sawah yang sedang tergadai modal tanam oleh user id
        Route::get('list-daftar-modal-tanam', 'Api\ModalTanamController@daftargadai'); //list daftarkan sawah untuk modal tanam
        Route::get('list-riwayat-modal-tanam', 'Api\ModalTanamController@riwayatgadai'); //list sawah yang pernah digadai modal tanam
        Route::get('list-batal-modal-tanam', 'Api\ModalTanamController@batalgadai'); //list sawah yang dibatalkan digadai modal tanam
        // END MODAL TANAM CONTROLLER 


        // GADAI SAWAH
        Route::post('gadai-sawah', 'Api\GadaiSawahController@store'); // post mendaftarkan sawah untuk digadai

        Route::get('list-sedang-gadai-sawah', 'Api\GadaiSawahController@gadai'); // list sawah yang sedang tergadai oleh user id
        Route::get('list-daftar-gadai-sawah', 'Api\GadaiSawahController@daftargadai'); //list daftarkan sawah untuk digadai
        Route::get('list-riwayat-gadai-sawah', 'Api\GadaiSawahController@riwayatgadai'); //list sawah yang pernah digadai
        Route::get('list-batal-gadai-sawah', 'Api\GadaiSawahController@batalgadai'); //list sawah yang dibatalkan digadai
        // END GADAI SAWAH





    });
