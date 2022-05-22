<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\TransaksiLahan;
use Carbon\Carbon;
class GadaiLahanSkripsi extends Controller
{
	public function index() // list daftar gadai lahan
	{
		if(!$user = Auth::user()) {
			return response()->json([
				'status'    => false,
				'message'   => 'Invalid Token'
			]);
		}

		$data = TransaksiLahan::select('id', 'kode', 'periode', 'harga', 'sertifikat_tanah', 'surat_pajak', 'kecamatan', 'kelurahan', 'alamat', 'titik_koordinat', 'luas_lahan', 'keterangan', 'surat_perjanjian', 'created_at', 'updated_at')
				->where('user_id', $user->id)
				->where('jenis', 'gs')
				->where('status', null)
				->orderBy('created_at', 'desc')
				->get();
		
		return response()->json([
			'status' => true,
			'message' => 'List Gadai Lahan sedang di daftar',
			'data'	=> $data
		]);
	}

	public function gadai() // list sedang gadai lahan
	{
		if(!$user = Auth::user()) {
			return response()->json([
				'status'    => false,
				'message'   => 'Invalid Token'
			]);
		}

		$data = TransaksiLahan::select('id', 'kode', 'periode', 'harga', 'sertifikat_tanah', 'surat_pajak', 'kecamatan', 'kelurahan', 'alamat', 'titik_koordinat', 'luas_lahan', 'keterangan', 'surat_perjanjian', 'created_at', 'updated_at')
				->where('user_id', $user->id)
				->where('jenis', 'gs')
				->where('status', 'gadai')
				->orderBy('created_at', 'desc')
				->get();
		
		return response()->json([
			'status' => true,
			'message' => 'List Gadai Lahan yang sedang berlangsung',
			'data'	=> $data
		]);
	}

	public function riwayat() // list riwayat gadai lahan
	{
		if(!$user = Auth::user()) {
			return response()->json([
				'status'    => false,
				'message'   => 'Invalid Token'
			]);
		}

		$data = TransaksiLahan::select('id', 'kode', 'periode', 'harga', 'sertifikat_tanah', 'surat_pajak', 'kecamatan', 'kelurahan', 'alamat', 'titik_koordinat', 'luas_lahan', 'keterangan', 'surat_perjanjian', 'created_at', 'updated_at')
				->where('user_id', $user->id)
				->where('jenis', 'gs')
				->where('status', 'selesai')
				->orderBy('created_at', 'desc')
				->get();
		
		return response()->json([
			'status' => true,
			'message' => 'List Riwayat Gadai Lahan',
			'data'	=> $data
		]);
	}

	public function batal() //list batal gadai lahan
	{
		if(!$user = Auth::user()) {
			return response()->json([
				'status'    => false,
				'message'   => 'Invalid Token'
			]);
		}

		$data = TransaksiLahan::select('id', 'kode', 'periode', 'harga', 'sertifikat_tanah', 'surat_pajak', 'kecamatan', 'kelurahan', 'alamat', 'titik_koordinat', 'luas_lahan', 'keterangan', 'created_at', 'updated_at')
				->where('user_id', $user->id)
				->where('jenis', 'gs')
				->where('status', 'batal')
				->orderBy('created_at', 'desc')
				->get();
		// return $data;
		return response()->json([
			'status' => true,
			'message' => 'List Batal Gadai Lahan ',
			'data'	=> $data
		]);
	}

	public function store(Request $request)
	{
		if(!$user = Auth::user()) {
			return response()->json([
				'status'    => false,
				'message'   => 'Invalid Token'
			]);
		}

		$validator = Validator::make($request->all(), [
			'periode'       => 'required|string',
			'kecamatan'     => 'required|string',
			'kelurahan'     => 'required|string',
			'alamat'      => 'required|string',
			'luas_lahan'    => 'required|string',
			'harga'       => 'required|numeric',
			'sertifikat_tanah'  => 'required|image|mimes:jpeg,png,jpg|max:3072',
			'surat_pajak'   => 'required|image|mimes:jpeg,png,jpg|max:3072',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status'   => false,
				'message'  => $message
			]);
		}

		if($user->foto_ktp == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Lengkapi profil Anda, pastikan KTP Anda sama dengan nama Anda'
			]);
		}

		$sertifikat_tanah = $request->file('sertifikat_tanah');
		if ($sertifikat_tanah) {
			$sertifikat_tanah_path = $sertifikat_tanah->store('gambar', 'public');
		}

		$surat_pajak = $request->file('surat_pajak');
		if ($surat_pajak) {
			$surat_pajak_path = $surat_pajak->store('gambar', 'public');
		}
        
        $time = Carbon::now();
        $kode = 'INV-GL'.$time->format('Y').$time->format('m').$time->format('d').$time->format('H').$time->format('i').$time->format('s').$user->id;


		TransaksiLahan::create([
		    'kode'      => $kode,
			'jenis'     => 'gs',
			'periode'   => $request->get('periode'),
			'harga'   => $request->get('harga'),
			'kecamatan' => $request->get('kecamatan'),
			'kelurahan' => $request->get('kelurahan'),
			'alamat'  => $request->get('alamat'),
			'luas_lahan' => $request->get('luas_lahan'),
			'titik_koordinat' => $request->get('titik_koordinat'),
			'sertifikat_tanah'  => $sertifikat_tanah_path,
			'surat_pajak'     => $surat_pajak_path,
			'user_id'   => $user->id,

		]);

		return response()->json([
			'status' => true,
			'message' => 'Berhasil mengajukan gadai lahan'
		]);
	}
}
