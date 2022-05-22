<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Barang;
use App\TransaksiBarang;
use Auth;
use DB;
class BibitController extends Controller
{

	public function store(Request $request, $id) //proses pembelian bibit
	{
		if(!$user = Auth::user()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Invalid Token'
                ]);
        }

        if($user->petani_verified == '0') {
            return response()->json([
                'status' => false, 
                'message' => 'Akun petani belum diverifikasi'
            ]);
        }

        $validator = Validator::make($request->all(), [
                'jumlah' 		=> 'required|string',
                // 'waktu_jemput'  => 'date_format:Y-m-d H:i:s',
                'alamat_lengkap'=> 'required|string',
                'kecamatan' 	=> 'required|string',
                'kelurahan'		=> 'required|string',
            ]);

        if($validator->fails()) {
                $message = $validator->messages()->first();
                return response()->json([
                    'status' => false,
                    'messsage' => $message
                ]);
        }

        $bibit = Barang::find($id);
        if ($bibit == null) {
            return response()->json([
                'status' => false, 
                'message' => 'Id bibit tidak ditemukan'
            ]);
        }

        if($bibit->min_beli > $request->get('jumlah')) { //cek minimal pembelian
        	return response()->json([
                'status' => false, 
                'message' => 'Minimal pembelian '.$bibit->min_beli.' kg'
            ]);
        }

        if($bibit->stok < $request->get('jumlah')) { //cek stok
        	return response()->json([
                'status' => false, 
                'message' => 'Stok tidak cukup. stok tersedia '.$bibit->stok.' kg'
            ]);
        }

        $data = TransaksiBarang::create([
                'jumlah' 	=> $request->get('jumlah'),
                'harga' 	=> $bibit->harga,
                'alamat' 	=> $request->get('alamat_lengkap'),
                'kecamatan' => $request->get('kecamatan'),
                'kelurahan' => $request->get('kelurahan'),
                // 'waktu_jemput'  => $request->get('waktu_jemput'),
                'keterangan'=> $request->get('keterangan'),
                'status'	=> '0',
                'jenis_bayar' => 'cod',
                'barang_id'	=> $bibit->id,
                'user_id'	=> $user->id,

            ]);

        return response()->json([
                    'status' => true,
                    'message' => 'Berhasil mengirim permintaan pembelian bibit ! segera diproses.'
                ]);

	}

	public function transaksi() // sedang transaksi bibit user
    {
        if(!$user = Auth::user()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Invalid Token'
                ]);
        }

        if($user->petani_verified == '0') {
            return response()->json([
                'status' => false, 
                'message' => 'Akun petani belum diverifikasi'
            ]);
        }

        $data = DB::table('transaksi_barangs')
                ->select('transaksi_barangs.id', 'transaksi_barangs.jumlah', 'transaksi_barangs.harga', 'transaksi_barangs.alamat', 'transaksi_barangs.kecamatan', 'transaksi_barangs.kelurahan', 'transaksi_barangs.keterangan', 'barangs.nama as nama_bibit', 'transaksi_barangs.created_at' )
                ->join('barangs', 'transaksi_barangs.barang_id', '=', 'barangs.id')
                ->where('transaksi_barangs.status', '0')
                ->where('transaksi_barangs.user_id', $user->id)
                ->orderBy('transaksi_barangs.created_at', 'desc')
                ->get();

        return response()->json([
                    'status'    => true,
                    'message'   => 'Sedang transaksi bibit oleh user id '.$user->name,
                    'data'      => $data
                ]);
    }

    public function riwayat() // riwayat transaksi bibit user
    {
        if(!$user = Auth::user()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Invalid Token'
                ]);
        }

        if($user->petani_verified == '0') {
            return response()->json([
                'status' => false, 
                'message' => 'Akun petani belum diverifikasi'
            ]);
        }

        $data = DB::table('transaksi_barangs')
                ->select('transaksi_barangs.id', 'transaksi_barangs.jumlah', 'transaksi_barangs.harga', 'transaksi_barangs.alamat', 'transaksi_barangs.kecamatan', 'transaksi_barangs.kelurahan', 'transaksi_barangs.keterangan', 'barangs.nama as nama_bibit', 'transaksi_barangs.created_at' )
                ->join('barangs', 'transaksi_barangs.barang_id', '=', 'barangs.id')
                ->where('transaksi_barangs.status', '1')
                ->where('transaksi_barangs.user_id', $user->id)
                ->orderBy('transaksi_barangs.created_at', 'desc')
                ->get();

        return response()->json([
                    'status'    => true,
                    'message'   => 'Riwayat transaksi bibit oleh user id '.$user->name,
                    'data'      => $data
                ]);
    }

    public function batal() // transaksi bibit user yang dibatalkan
    {
        if(!$user = Auth::user()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Invalid Token'
                ]);
        }

        if($user->petani_verified == '0') {
            return response()->json([
                'status' => false, 
                'message' => 'Akun petani belum diverifikasi'
            ]);
        }

        $data = DB::table('transaksi_barangs')
                ->select('transaksi_barangs.id', 'transaksi_barangs.jumlah', 'transaksi_barangs.harga', 'transaksi_barangs.alamat', 'transaksi_barangs.kecamatan', 'transaksi_barangs.kelurahan', 'transaksi_barangs.keterangan', 'barangs.nama as nama_bibit', 'transaksi_barangs.created_at' )
                ->join('barangs', 'transaksi_barangs.barang_id', '=', 'barangs.id')
                ->where('transaksi_barangs.status', 'batal')
                ->where('transaksi_barangs.user_id', $user->id)
                ->orderBy('transaksi_barangs.created_at', 'desc')
                ->get();

        return response()->json([
                    'status'    => true,
                    'message'   => 'Transaksi bibit oleh user id '.$user->name. ' yang dibatalkan',
                    'data'      => $data
                ]);
    }
}
