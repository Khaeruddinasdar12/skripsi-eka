<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sawah;
use App\TransaksiSawah;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
class SawahController extends Controller
{
    // public function listsawah()
    // {
    //     // $data = Sawah::select('sawahs.*')
    //     //         ->join('transaksi_sawahs', 'sawahs.sawah_id')
    //     //         ->where('sawahs.created_by', 2)
    //     //         ->
    //     // $data = Sawah::where('created_by', 2)
    //     //     ->with('tsawahs')
    //     //     // ->with('tsawahs')
    //     //     ->get();
    //     // $data = DB::table('sawahs')
    //     //             ->select('sawahs.nama', 'transaksi_sawahs.jenis')
    //     //             ->leftJoin('transaksi_sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
    //     //             ->where('transaksi_sawahs.status', null)
    //     //             ->orWhere('transaksi_sawahs.status', 'selesai')
    //     //             ->get();
    //     $data = DB::table('transaksi_sawahs')
    //             ->select('sawahs.nama', 'transaksi_sawahs.jenis')
    //             ->rightJoin('sawahs', 'transaksi_sawahs.sawah_id', '=', 'sawahs.id')
    //             ->rightJoin('users', 'sawahs.sawah_id', '=', 'sawahs.id')
    //             ->where('')
    //             ->where('transaksi_sawahs.status', null)
    //             ->orWhere('transaksi_sawahs.status', 'selesai')
    //             ->get();
    //             return $data;
    //     $arr = [];
    //     $dts = [];
    //     foreach ($data as $dt) {
    //         $arr['id']          = $dt->id;
    //         $arr['nama']        = $dt->nama;
    //         $arr['kecamatan']   = $dt->kecamatan;
    //         $arr['kelurahan']   = $dt->kelurahan;
    //         $arr['alamat']      = $dt->alamat;
    //         $arr['titik_koordinat'] = $dt->titik_koordinat;
    //         $arr['luas_sawah']  = $dt->luas_sawah;
    //         $arr['created_at']  = $dt->created_at;
    //         if(empty($dt->tsawahs)) {
    //             $arr['status']  = 'open';
    //         } else {
    //             $arr['status']  = $dt['tsawahs']['jenis'];
    //         }
    //         array_push($dts, $arr);
    //     }
    //     return $dts;
        
    // }
    public function index() // daftar sawah petani berdasarkan id yang login
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

        $data = \App\User::find($user->id)->sawahs()->get();
        return response()->json([
                'status'    => true, 
                'message'   => 'Daftar sawah yang dimiliki '.$user->name ,
                'data'      => $data
            ]);
    }

    public function store(Request $request) // mendaftarkan sawah si petani
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
                'nama'      => 'required|string',
                'alamat_id' => 'required|numeric',
                'kecamatan' => 'required|string',
                'kelurahan' => 'required|string',
                'alamat_lengkap' =>'required|string',
                'luas_sawah' => 'required|string',
            ]);

        if($validator->fails()) {
                $message = $validator->messages()->first();
                return response()->json([
                    'status' => false,
                    'message' => $message
                ]);
        }
        $cek = Sawah::where('created_by', $user->id)->get();
        foreach ($cek as $ceks) {
            if($request->get('nama') == $ceks->nama) {
                return response()->json([
                    'status' => false,
                    'message' => 'nama sawah sudah ada'
                ]);
            }
        }
        $sawah = Sawah::create([
                'nama'      => $request->get('nama'),
                'titik_koordinat' => $request->get('titik_koordinat'),
                'alamat_id' => $request->get('alamat_id'), // id kota atau kabupaten dari tabel kotas
                'kelurahan' => $request->get('kelurahan'),
                'alamat' => $request->get('alamat_lengkap'),
                'kecamatan' => $request->get('kecamatan'),
                'created_by' => $user->id, //id user yang sedang login
                'luas_sawah' => $request->get('luas_sawah'), 
            ]);

        return response()->json([
                    'status' => true,
                    'message' => 'Berhasil mendaftarkan sawah'
                ]);

    }

    public function update(Request $request,$id) // mengedit sawah petani
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

        $sawah = Sawah::where('created_by', $user->id)->get(); //cek nama sawah
        foreach ($sawah as $ceks) {
            if($request->get('nama') == $ceks->nama) {
                return response()->json([
                    'status' => false,
                    'message' => 'nama sawah sudah ada'
                ]);
            }
        }

        $sawah = Sawah::find($id); // cek apakah id nya ada
        if ($sawah == null) {
            return response()->json([
                'status' => false, 
                'message' => 'Id sawah tidak ditemukan'
            ]);
        }

        if ($sawah->created_by != $user->id) {
            return response()->json([
                'status' => false, 
                'message' => 'Data sawah ini bukan milik Anda'
            ]);
        }

        $validator = Validator::make($request->all(), [
                'nama'      => 'required|string',
                'alamat_id' => 'required|numeric',
                'kecamatan' => 'required|string',
                'kelurahan' => 'required|string',
                'alamat_lengkap' =>'required|string',
                'luas_sawah' => 'required|string',
            ]);

        if($validator->fails()) {
                $message = $validator->messages()->first();
                return response()->json([
                    'status' => false,
                    'message' => $message
                ]);
        }

        $sawah->nama            = $request->get('nama');
        $sawah->titik_koordinat = $request->get('titik_koordinat');
        $sawah->alamat_id       = $request->get('alamat_id');
        $sawah->kelurahan       = $request->get('kelurahan');
        $sawah->alamat          = $request->get('alamat_lengkap');
        $sawah->kecamatan       = $request->get('kecamatan');
        $sawah->luas_sawah      = $request->get('luas_sawah');
        $sawah->save();

        return response()->json([
                    'status' => true,
                    'message' => 'Berhasil mengubah data sawah'
                ]);


    }

    public function delete($id) //menghapus sawah petani
    {
        if(!$user = Auth::user()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Invalid Token'
                ]);
        }

        $cek_gadai = TransaksiSawah::where('sawah_id', $id);
        $dt = $cek_gadai->get();
        // return $dt;
        // if(count($dt) == null) { 
        //     return response()->json([
        //                 'status'  => false,
        //                 'message' => 'data sawah tidak ditemukan'
        //             ]);
        // }

        if($dt != null) { //cek semua transaksi
            foreach ($dt as $hps) {
                if($hps->status == 'gadai' || $hps->status == null || $hps->status == 'selesai') {
                    if($hps->status == null) {
                        $msg = 'sedang daftar gadai';
                    } else if ($hps->status == 'selesai'){
                        $msg = 'pernah ditransaksikan (tab selesai)';    
                    } else {
                        $msg = '';
                    }
                    
                    return response()->json([
                        'status'  => false,
                        'message' => 'Tidak dapat menghapus, Sawah ini '.$msg
                    ]);
                }


            }
            $cek_gadai->delete(); //delete data di tabel gadai_sawahs
        }

        $sawah = Sawah::find($id);
        if ($sawah == null) {
            return response()->json([
                'status' => false, 
                'message' => 'Sawah tidak ditemukan'
            ]);
        }

        $sawah->delete(); //delete data di table sawahs
            return response()->json([
                'status' => true, 
                'message' => 'Berhasil menghapus sawah'
            ]);

    }

}
