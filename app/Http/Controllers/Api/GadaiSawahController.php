<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sawah;
use App\TransaksiSawah;
use Auth;
use Illuminate\Support\Facades\Validator;
use DB;
class GadaiSawahController extends Controller
{
    public function gadai() //list sawah yang sedang tergadai oleh user id
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

        $data = DB::table('transaksi_sawahs')
                ->select('transaksi_sawahs.id', 'transaksi_sawahs.periode', 'transaksi_sawahs.harga', 'transaksi_sawahs.keterangan', 'transaksi_sawahs.created_at', 'transaksi_sawahs.status_at as updated_at', 'sawahs.nama as nama_sawah', 'sawahs.alamat', 'sawahs.titik_koordinat')
                ->join('sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
                ->join('users', 'sawahs.created_by', '=', 'users.id')
                ->where('transaksi_sawahs.jenis', 'gs')
                ->where('transaksi_sawahs.status', 'gadai')
                ->where('users.id', $user->id)
                ->orderBy('transaksi_sawahs.created_at', 'desc')
                ->get();
        return response()->json([
                    'status'    => true,
                    'message'   => 'list sawah yang sedang tergadai oleh user '. $user->name,
                    'data'      => $data
                ]);
    }

    public function daftargadai() //list daftarkan sawah untuk digadai
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

        $data = DB::table('transaksi_sawahs')
                ->select('transaksi_sawahs.id', 'transaksi_sawahs.periode', 'transaksi_sawahs.harga', 'transaksi_sawahs.keterangan', 'transaksi_sawahs.created_at', 'transaksi_sawahs.status_at as updated_at', 'sawahs.nama as nama_sawah', 'sawahs.alamat', 'sawahs.titik_koordinat')
                ->join('sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
                ->join('users', 'sawahs.created_by', '=', 'users.id')
                ->where('transaksi_sawahs.jenis', 'gs')
                ->where('transaksi_sawahs.status', null)
                ->where('users.id', $user->id)
                ->orderBy('transaksi_sawahs.created_at', 'desc')
                ->get();
        return response()->json([
                    'status'    => true,
                    'message'   => 'list sawah yang sedang didaftarkan untuk digadai oleh user '. $user->name,
                    'data'      => $data
                ]);
    }

    public function riwayatgadai() //list sawah yang pernah digadai
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

        $data = DB::table('transaksi_sawahs')
                ->select('transaksi_sawahs.id', 'transaksi_sawahs.periode', 'transaksi_sawahs.harga', 'transaksi_sawahs.keterangan', 'transaksi_sawahs.created_at', 'transaksi_sawahs.status_at as updated_at', 'sawahs.nama as nama_sawah', 'sawahs.alamat', 'sawahs.titik_koordinat')
                ->join('sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
                ->join('users', 'sawahs.created_by', '=', 'users.id')
                ->where('transaksi_sawahs.jenis', 'gs')
                ->where('transaksi_sawahs.status', 'selesai')
                ->where('users.id', $user->id)
                ->orderBy('transaksi_sawahs.created_at', 'desc')
                ->get();
        return response()->json([
                    'status'    => true,
                    'message'   => 'list riwayat sawah yang pernah digadai oleh user '. $user->name,
                    'data'      => $data
                ]);
    }

    public function batalgadai() //list sawah yang dibatalkan digadai
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

        $data = DB::table('transaksi_sawahs')
                ->select('transaksi_sawahs.id', 'transaksi_sawahs.periode', 'transaksi_sawahs.harga', 'transaksi_sawahs.keterangan', 'transaksi_sawahs.created_at', 'transaksi_sawahs.status_at as updated_at', 'sawahs.nama as nama_sawah', 'sawahs.alamat', 'sawahs.titik_koordinat')
                ->join('sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
                ->join('users', 'sawahs.created_by', '=', 'users.id')
                ->where('transaksi_sawahs.jenis', 'gs')
                ->where('transaksi_sawahs.status', 'batal')
                ->where('users.id', $user->id)
                ->orderBy('transaksi_sawahs.created_at', 'desc')
                ->get();
        return response()->json([
                    'status'    => true,
                    'message'   => 'list sawah yang dibatalkan untuk digadai oleh user '. $user->name,
                    'data'      => $data
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

        if($user->petani_verified == '0') {
            return response()->json([
                'status' => false, 
                'message' => 'Akun petani belum diverifikasi'
            ]);
        }

        $validator = Validator::make($request->all(), [
                'periode' 	=> 'required|string',
                'harga'		=> 'required|numeric',
                'sawah_id' 	=> 'required|numeric',
                'sertifikat_tanah'  => 'required|image|mimes:jpeg,png,jpg|max:3072',
            ]);

        if($validator->fails()) {
                $message = $validator->messages()->first();
                return response()->json([
                    'status' => false,
                    'messsage' => $message
                ]);
        }
        $sawah_id = $request->get('sawah_id');
        $ceksawah = Sawah::find($sawah_id);
        if ($ceksawah == null) {
            return response()->json([
                'status' => false, 
                'message' => 'Id sawah tidak ditemukan'
            ]);
        }

        if($ceksawah->created_by != $user->id) {
            return response()->json([
                'status' => false, 
                'message' => 'Data sawah ini bukan milik Anda'
            ]);
        } 

        $cektransaksi = TransaksiSawah::where('sawah_id', $sawah_id)
                        ->where(function ($query) {
                            $query->where('status', null)
                                  ->orWhere('status', 'gadai');
                        })
                    ->first();
                    // return $cektransaksi;
        if($cektransaksi != null) {
            $jenistransaksi = $cektransaksi->jenis;
            if ($jenistransaksi == 'gs') {
                $jenis = 'Gadai Sawah';
            } else {
                $jenis = 'Modal Tanam';
            }

            $status = $cektransaksi->status;
            $msgstatus = 'default';
            if($status == null) {
                $msgstatus = 'Daftar';
            } else if($status == 'gadai') {
                $msgstatus = 'Gadai';
            }
            return response()->json([
                'status' => false, 
                'message' => 'Sawah ini masih dalam Transaksi '.$jenis. ' dengan status '.$msgstatus
            ]);
        }

        TransaksiSawah::create([
                'jenis'     => 'gs',
                'periode' 	=> $request->get('periode'),
                'harga' 	=> $request->get('harga'),
                'sawah_id' 	=> $request->get('sawah_id'),
            ]);

        return response()->json([
                    'status' => true,
                    'message' => 'Berhasil memohon permintaan gadai sawah, data segera diproses admin'
                ]);
    }
}
