<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sawah;
use App\TransaksiSawah;
use Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class ModalTanamController extends Controller
{
    public function gadai() //list sawah yang sedang tergadai modal tanam oleh user id
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
                ->select('transaksi_sawahs.id', 'transaksi_sawahs.periode_tanam', 'transaksi_sawahs.jenis_pupuk', 'transaksi_sawahs.jenis_bibit', 'transaksi_sawahs.keterangan', 'transaksi_sawahs.created_at', 'transaksi_sawahs.status_at as updated_at', 'sawahs.nama as nama_sawah', 'sawahs.alamat', 'sawahs.titik_koordinat')
                ->join('sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
                ->join('users', 'sawahs.created_by', '=', 'users.id')
                ->where('transaksi_sawahs.jenis', 'mt')
                ->where('transaksi_sawahs.status', 'gadai')
                ->where('users.id', $user->id)
                ->orderBy('transaksi_sawahs.created_at', 'desc')
                ->get();
        return response()->json([
                    'status'    => true,
                    'message'   => 'list sawah yang sedang tergadai modal tanam oleh user '. $user->name,
                    'data'      => $data
                ]);
    }

    public function daftargadai() //list daftarkan sawah untuk modal tanam
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
                ->select('transaksi_sawahs.id', 'transaksi_sawahs.periode_tanam', 'transaksi_sawahs.jenis_pupuk', 'transaksi_sawahs.jenis_bibit', 'transaksi_sawahs.keterangan', 'transaksi_sawahs.created_at', 'transaksi_sawahs.status_at as updated_at', 'sawahs.nama as nama_sawah', 'sawahs.alamat', 'sawahs.titik_koordinat')
                ->join('sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
                ->join('users', 'sawahs.created_by', '=', 'users.id')
                ->where('transaksi_sawahs.jenis', 'mt')
                ->where('transaksi_sawahs.status', null)
                ->where('users.id', $user->id)
                ->orderBy('transaksi_sawahs.created_at', 'desc')
                ->get();
        return response()->json([
                    'status'    => true,
                    'message'   => 'list sawah yang sedang didaftarkan modal tanam oleh user '. $user->name,
                    'data'      => $data
                ]);
    }

    public function riwayatgadai() //list sawah yang pernah digadai modal tanam
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
                ->select('transaksi_sawahs.id', 'transaksi_sawahs.periode_tanam', 'transaksi_sawahs.jenis_pupuk', 'transaksi_sawahs.jenis_bibit', 'transaksi_sawahs.keterangan', 'transaksi_sawahs.created_at', 'transaksi_sawahs.status_at as updated_at', 'sawahs.nama as nama_sawah', 'sawahs.alamat', 'sawahs.titik_koordinat')
                ->join('sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
                ->join('users', 'sawahs.created_by', '=', 'users.id')
                ->where('transaksi_sawahs.jenis', 'mt')
                ->where('transaksi_sawahs.status', 'selesai')
                ->where('users.id', $user->id)
                ->orderBy('transaksi_sawahs.created_at', 'desc')
                ->get();
        return response()->json([
                    'status'    => true,
                    'message'   => 'list riwayat sawah yang pernah digadai modal tanam oleh user '. $user->name,
                    'data'      => $data
                ]);
    }

    public function batalgadai() //list sawah yang dibatalkan digadai modal tanam
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
                ->select('transaksi_sawahs.id', 'transaksi_sawahs.periode_tanam', 'transaksi_sawahs.jenis_pupuk', 'transaksi_sawahs.jenis_bibit', 'transaksi_sawahs.keterangan', 'transaksi_sawahs.created_at', 'transaksi_sawahs.status_at as updated_at', 'sawahs.nama as nama_sawah', 'sawahs.alamat', 'sawahs.titik_koordinat')
                ->join('sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
                ->join('users', 'sawahs.created_by', '=', 'users.id')
                ->where('transaksi_sawahs.jenis', 'mt')
                ->where('transaksi_sawahs.status', 'batal')
                ->where('users.id', $user->id)
                ->orderBy('transaksi_sawahs.created_at', 'desc')
                ->get();
        return response()->json([
                    'status'    => true,
                    'message'   => 'list sawah yang dibatalkan untuk digadai modal tanam oleh user '. $user->name,
                    'data'      => $data
                ]);
    }

    public function store(Request $request) // post mendaftarkan sawah untuk digadai modal tanam
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
                'periode_tanam' 	=> 'required|string',
                'jenis_bibit'		=> 'required|string',
                'jenis_pupuk'		=> 'required|string',
                'sawah_id' 			=> 'required|numeric',
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

        $gambar = $request->file('sertifikat_tanah');
        if ($gambar) {
            $gambar_path = $gambar->store('gambar', 'public');
        }

        TransaksiSawah::create([
                'jenis'     => 'mt',
                'periode_tanam' => $request->get('periode_tanam'),
                'jenis_pupuk' 	=> $request->get('jenis_pupuk'),
                'jenis_bibit'	=> $request->get('jenis_bibit'),
                'sawah_id' 		=> $request->get('sawah_id'),
                'sertifikat_tanah' => $gambar_path,
            ]);

        return response()->json([
                    'status' => true,
                    'message' => 'Berhasil memohon permintaan modal tanam, data segera diproses admin'
                ]);
    }
}
