<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

Auth::routes([
	'register' => false,
	'login' => false,
]);
Route::get('/pdf', 'HomeController@pdf');

Route::get('/surat-perjanjian',  function() {
    $pdf = PDF::loadView('surat-perjanjian')->setOptions(['defaultFont' => 'sans-serif']);
    return $pdf->stream('pdf.pdf');
	return view('surat-perjanjian');
});

Route::get('/admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');
Route::post('/logout', 'LoginController@logout')->name('admin.logout');


Route::prefix('admin')->namespace('Admin')->group(function () {
	Route::get('/', 'DashboardController@index')->name('admin.home');
	Route::get('/edit-profile', 'DashboardController@indexprofile')->name('index.profile');
	Route::put('/edit-profile', 'DashboardController@updateprofile')->name('update.profile');

	// MENU LAPORAN
	Route::get('laporan', 'Laporan@laporan')->name('index.laporan');
	Route::get('laporan-pdf', 'Laporan@pdf')->name('pdf.laporan');
	Route::get('laporan-sawah-gabah', 'Laporan@laporan2')->name('index.laporan2');
	// END MENU LAPORAN


	// GADAI LAHAN SKRIPSI
	Route::get('daftar-gadai-lahan', 'GadaiSawahSkripsi@daftar')->name('daftar.gadaisawah.skripsi'); //menampilkan hal. data mendaftarkan sawah untuk digadai 
	Route::get('sedang-gadai-lahan', 'GadaiSawahSkripsi@sedanggadai')->name('sedang.gadaisawah.skripsi'); //menampilkan hal. data yang sedang menggadai sawahnya
	Route::get('riwayat-gadai-lahan', 'GadaiSawahSkripsi@riwayatgadai')->name('riwayat.gadaisawah.skripsi'); //menampilkan hal. data riwayat gadai sawah


	Route::put('gadai-lahan-gadai-status/{id}', 'GadaiSawahSkripsi@gadaistatus')->name('gadaistatus.gadaisawah.skripsi'); // mengubah "daftar gadai" menjadi "sedang gadai"
	Route::put('gadai-lahan-selesai-status/{id}', 'GadaiSawahSkripsi@selesaistatus')->name('selesaistatus.gadaisawah.skripsi'); // mengubah "sedang gadai" menjadi "riwayat gadai"
	Route::put('gadai-lahan-edit-keterangan/{id}', 'GadaiSawahSkripsi@editketerangan')->name('editketerangan.gadaisawah.skripsi'); // edit keterangan 

	Route::post('gadai-lahan-hapus-gadai/{id}', 'GadaiSawahSkripsi@delgadai')->name('delgadai.gadaisawah.skripsi'); // menghapus gadai yang gagal di survey 
	Route::delete('gadai-lahan-hapus-riwayat/{id}', 'GadaiSawahSkripsi@delriwayat')->name('delriwayat.gadaisawah.skripsi')->middleware('CekAdmin'); // menghapus riwayat gadai hanya 
	// END GADAI LAHAN SKRIPSI


	// MODAL TANAM SKRIPSI
	Route::get('daftar-modal-tanam', 'ModalTanamSkripsi@daftar')->name('daftar.modaltanam.skripsi'); //menampilkan hal. data mendaftarkan sawah untuk digadai 
	Route::get('riwayat-modal-tanam', 'ModalTanamSkripsi@riwayatgadai')->name('riwayat.modaltanam.skripsi'); //menampilkan hal. data riwayat gadai sawah


	Route::put('mt-gadai-status/{id}', 'ModalTanamSkripsi@gadaistatus')->name('gadaistatus.modaltanam.skripsi'); // mengubah "daftar gadai" menjadi "sedang gadai"
	Route::put('mt-batalkan-status/{id}', 'ModalTanamSkripsi@batalkanstatus')->name('batalkan.modaltanam.skripsi'); // mengubah "daftar gadai" menjadi "batal"
	Route::delete('mt-hapus-riwayat/{id}', 'ModalTanamSkripsi@delriwayat')->name('delriwayat.modaltanam.skripsi')->middleware('CekAdmin'); // menghapus riwayat gadai hanya 
	// END MODAL TANAM SKRIPSI


	// MANAGE USER SKRIPSI
	Route::get('manage-user', 'ManageUserSkripsi@index')->name('verified.manage-user.skripsi'); //menampilkan hal. data user petani terverifikasi
	// END MANAGE USER SKRIPSI


	//TRANSAKSI
	Route::get('transaksi-barang', 'TransaksiBarangController@index')->name('index.transaksi');//list sedang transaksi
	Route::get('riwayat-transaksi-barang', 'TransaksiBarangController@riwayat')->name('riwayat.transaksi');//list sedang transaksi

	Route::put('transaksi-barang-status/{id}', 'TransaksiBarangController@status')->name('status.transaksi'); // mengubah status transaksi menjadi terproses(verif->keriwayat)
	Route::delete('transaksi-barang-delete/{id}', 'TransaksiBarangController@delete')->name('delete.transaksi'); // mengahapus transaksi (membatalkan)
	//END TRANSAKSI


	//DATA BARANG
	Route::get('data-barang', 'BarangController@index')->name('index.barang');//menampilkan data-data barang
	Route::post('data-barang', 'BarangController@store')->name('store.barang');//menginput data-data barang
	Route::put('data-barang/{id}', 'BarangController@update')->name('update.barang');//mengubah data-data barang
	Route::delete('data-barang/{id}', 'BarangController@delete')->name('delete.barang');//menghapus data-data barang
	//END DATA BARANG


	// RUTE MENU BIBIT & TRANSAKSI BIBIT
	// 1. Menu Bibit
	Route::get('bibit', 'BibitController@index')->name('index.bibit'); //menampilkan hal. data bibit
	Route::post('bibit', 'BibitController@store')->name('store.bibit'); //menambah data bibit
	Route::put('bibit/{id}', 'BibitController@update')->name('update.bibit'); //mengubah data bibit
	Route::delete('bibit/{id}', 'BibitController@delete')->name('delete.bibit'); //menghapus data bibit

	// 2. Menu Transaksi Bibit
	Route::get('transaksi-bibit', 'TransaksiBibitController@index')->name('index.tbibit'); //menampilkan hal. data transaksi bibit
	Route::get('riwayat-transaksi-bibit', 'TransaksiBibitController@riwayat')->name('riwayat.tbibit'); //menampilkan hal. data riwayat transaksi gabah
	Route::put('transaksi-bibit-status/{id}', 'TransaksiBibitController@status')->name('status.tbibit'); // mengubah status pembelian bibit menjadi riwayat
	Route::post('transaksi-bibit-delete/{id}', 'TransaksiBibitController@delete')->name('delete.tbibit'); // menghapus data transaksi bibit
	Route::delete('transaksi-bibit-delete-riwayat/{id}', 'TransaksiBibitController@deleteBySuperadmin')->name('deleteriwayat.tbibit')->middleware('CekAdmin'); // menghapus data transaksi bibit (riwayat Transaksi by superadmin)
	// END RUTE MENU BIBIT & TRANSAKSI BIBIT


	// RUTE MENU PUPUK & TRANSAKSI PUPUK
	// 1. Menu Pupuk
	Route::get('pupuk', 'PupukController@index')->name('index.pupuk'); //menampilkan hal. data pupuk
	Route::post('pupuk', 'PupukController@store')->name('store.pupuk'); //menambah data pupuk
	Route::put('pupuk/{id}', 'PupukController@update')->name('update.pupuk'); //mengubah data pupuk
	Route::delete('pupuk/{id}', 'PupukController@delete')->name('delete.pupuk'); //menghapus data pupuk

	// 2. Menu Transaksi Pupuk
	Route::get('transaksi-pupuk', 'TransaksiPupukController@index')->name('index.tpupuk'); //menampilkan hal. data transaksi pupuk
	Route::get('riwayat-transaksi-pupuk', 'TransaksiPupukController@riwayat')->name('riwayat.tpupuk'); //menampilkan hal. data riwayat transaksi pupuk
	Route::put('transaksi-pupuk-status/{id}', 'TransaksiPupukController@status')->name('status.tpupuk'); // mengubah status pembelian pupuk menjadi riwayat
	Route::post('transaksi-pupuk-delete/{id}', 'TransaksiPupukController@delete')->name('delete.tpupuk'); // menghapus data transaksi pupuk
	Route::delete('transaksi-pupuk-delete-riwayat/{id}', 'TransaksiPupukController@deleteBySuperadmin')->name('deleteriwayat.tpupuk')->middleware('CekAdmin'); // menghapus data transaksi pupuk (riwayat Transaksi by superadmin)
	// END RUTE MENU PUPUK & TRANSAKSI PUPUK


	// RUTE MENU ALAT
	// 1. Menu Alat
	Route::get('alat', 'AlatController@index')->name('index.alat'); //menampilkan hal. data alat
	Route::post('alat', 'AlatController@store')->name('store.alat'); //menambah data alat
	Route::put('alat/{id}', 'AlatController@update')->name('update.alat'); //mengubah data alat
	Route::delete('alat/{id}', 'AlatController@delete')->name('delete.alat'); //menghapus data alat

	// 2. Menu Transaksi Alat
	Route::get('transaksi-alat', 'TransaksiAlatController@index')->name('index.talat'); //menampilkan hal. data transaksi
	Route::get('riwayat-transaksi-alat', 'TransaksiAlatController@riwayat')->name('riwayat.talat'); //menampilkan hal. data riwayat transaksi alat
	Route::put('transaksi-alat-status/{id}', 'TransaksiAlatController@status')->name('status.talat'); // mengubah status pembelian alat menjadi riwayat
	Route::post('transaksi-alat-delete/{id}', 'TransaksiAlatController@delete')->name('delete.talat'); // menghapus data transaksi alat belum verif
	Route::delete('transaksi-alat-delete-riwayat/{id}', 'TransaksiAlatController@deleteBySuperadmin')->name('deleteriwayat.talat')->middleware('CekAdmin'); // menghapus data transaksi alat (riwayat Transaksi by superadmin)
	// END RUTE MENU ALAT


	// RUTE MENU BERAS & TRANSAKSI BERAS
	// 1. Menu Beras
	Route::get('beras', 'BerasController@index')->name('index.beras'); //menampilkan hal. data beras
	Route::post('beras', 'BerasController@store')->name('store.beras'); //menambah data beras
	Route::put('beras/{id}', 'BerasController@update')->name('update.beras'); //mengubah atau suplly data beras
	Route::delete('beras/{id}', 'BerasController@delete')->name('delete.beras'); //menghapus data beras

	// 2. Menu Transaksi Beras dan Riwayat Transaksi Beras
	Route::get('transaksi-beras', 'TransaksiBerasController@index')->name('index.tberas'); //menampilkan hal. data transaksi beras
	Route::get('riwayat-transaksi-beras', 'TransaksiBerasController@riwayat')->name('riwayat.tberas'); //menampilkan hal. data riwayat transaksi beras
	Route::put('transaksi-beras-status/{id}', 'TransaksiBerasController@status')->name('status.tberas'); // mengubah status pembelian beras menjadi riwayat
	Route::post('transaksi-beras-delete/{id}', 'TransaksiBerasController@delete')->name('delete.tberas'); // menghapus data transaksi beras
	Route::delete('transaksi-beras-delete-riwayat/{id}', 'TransaksiBerasController@deleteBySuperadmin')->name('deleteriwayat.tberas')->middleware('CekAdmin'); // menghapus data transaksi beras (riwayat Transaksi by superadmin)
	// END RUTE MENU BERAS & TRANSAKSI BERAS


	// RUTE MENU MANAGE ADMIN
	Route::get('manage-admin', 'AdminController@index')->name('index.manage-admin'); //menampilkan hal. data admin

	Route::post('manage-admin', 'AdminController@store')->name('store.manage-admin')->middleware('CekAdmin'); // // input data admin, hanya untuk superadmin, jika admin otomatis gagal
	Route::put('manage-admin/{id}', 'AdminController@update')->name('update.manage-admin')->middleware('CekAdmin'); // // edit data admin, hanya untuk superadmin, jika admin otomatis gagal
	Route::delete('manage-admin/{id}', 'AdminController@delete')->name('delete.manage-admin')->middleware('CekAdmin'); // // delete data admin, hanya untuk superadmin, jika admin otomatis gagal
	// END RUTE MANAGE ADMIN


	// RUTE MENU MANAGE USER
	Route::get('manage-user-konsumen', 'UserController@konsumen')->name('konsumen.manage-user'); //menampilkan hal. data user konsumen
	Route::get('manage-user-petani-verified', 'UserController@verified')->name('verified.manage-user'); //menampilkan hal. data user petani terverifikasi
	Route::get('manage-user-petani-unverified', 'UserController@unverified')->name('unverified.manage-user'); //menampilkan hal. data user petani belum terverifikasi

	Route::put('manage-user/verified/{id}', 'UserController@buttonverified')->name('buttonverified.manage-user'); // rute untuk verified user
	Route::put('manage-user/edit/{id}', 'UserController@update')->name('edit.manage-user')->middleware('CekAdmin'); // rute untuk edit user, hanya untuk superadmin, jika admin otomatis gagal

	Route::delete('manage-user/delete/{id}', 'UserController@delete')->name('delete.manage-user'); // menghapus petani yang tidak terverifikasi
	// END RUTE MANAGE USER

	Route::namespace('Auth')->group(function () {

		//Login Routes

		Route::post('/login', 'LoginController@login');
		Route::post('/logout', 'LoginController@logout')->name('admin.logout');

		//Forgot Password Routes
		Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
		Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

		//Reset Password Routes
		Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');
		Route::post('/password/reset', 'ResetPasswordController@reset')->name('admin.password.update');
	});
});
