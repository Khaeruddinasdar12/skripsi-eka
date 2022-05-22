<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\TransaksiGabah;
use App\Gabah;
use DB;
use Auth;
class GabahController extends Controller
{
	public function index(Request $request)
	{  
        if($request->sort == 'a-z') {
            $data = Gabah::select('id', 'nama', 'harga')
            ->orderBy('nama', 'asc')
            ->paginate(8);
        } else if($request->sort == 'z-a') {
            $data = Gabah::select('id', 'nama', 'harga')
            ->orderBy('nama', 'desc')
            ->paginate(8);
        } else if($request->sort == 'murah-mahal') {
            $data = Gabah::select('id', 'nama', 'harga')
            ->orderBy('harga', 'asc')
            ->paginate(8);
        } else if($request->sort == 'mahal-murah') {
            $data = Gabah::select('id', 'nama', 'harga')
            ->orderBy('harga', 'desc')
            ->paginate(8);
        } else {
            $data = Gabah::select('id', 'nama', 'harga')
            ->orderBy('created_at', 'desc')
            ->paginate(8);
        }
		
		return response()->json([
            'status' => true,
            'message' => 'data gabah (per 8 data)',
            'data'  => $data->items(),
            'current_page' => $data->currentPage(),
            'first_page_url' => $data->url(1),
            'from' => $data->firstItem(),
            'last_page' => $data->lastPage(),

            'last_page_url' => $data->url($data->lastPage()) ,
            'next_page_url' => $data->nextPageUrl(),
            'path'  => $data->path(),
            'per_page' => $data->perPage(),
            'prev_page_url' => $data->previousPageUrl(),
            'to' => $data->count(),
            'total' => $data->total()
        ]);
	}

    public function store(Request $request, $id)
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
                'waktu_jemput'  => 'date_format:Y-m-d H:i:s',
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

        $gabah = Gabah::find($id);
        if ($gabah == null) {
            return response()->json([
                'status' => false, 
                'message' => 'Id gabah tidak ditemukan'
            ]);
        }


        $sawah = TransaksiGabah::create([
                'jumlah' 	=> $request->get('jumlah'),
                'harga' 	=> $gabah->harga,
                'alamat' 	=> $request->get('alamat_lengkap'),
                'kecamatan' => $request->get('kecamatan'),
                'kelurahan' => $request->get('kelurahan'),
                'waktu_jemput'  => $request->get('waktu_jemput'),
                'keterangan'=> $request->get('keterangan'),
                'status'	=> '0',
                'jenis_bayar' => 'cod',
                'gabah_id'	=> $gabah->id,
                'user_id'	=> $user->id,

            ]);

        return response()->json([
                    'status' => true,
                    'message' => 'Berhasil mengirim permintaan pembelian gabah ! segera diproses.'
                ]);
    }

    public function transaksi() // sedang transaksi gabah user
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

        $data = DB::table('transaksi_gabahs')
                ->select('transaksi_gabahs.id', 'transaksi_gabahs.jumlah', 'transaksi_gabahs.harga', 'transaksi_gabahs.alamat', 'transaksi_gabahs.kecamatan', 'transaksi_gabahs.kelurahan', 'transaksi_gabahs.keterangan', 'transaksi_gabahs.waktu_jemput', 'gabahs.nama as nama_gabah', 'transaksi_gabahs.created_at', 'transaksi_gabahs.updated_at')
                ->join('gabahs', 'transaksi_gabahs.gabah_id', '=', 'gabahs.id')
                ->where('transaksi_gabahs.status', '0')
                ->where('transaksi_gabahs.user_id', $user->id)
                ->orderBy('transaksi_gabahs.created_at', 'desc')
                ->get();

        return response()->json([
                    'status'    => true,
                    'message'   => 'Sedang transaksi gabah oleh user id '.$user->name,
                    'data'      => $data
                ]);
    }

    public function riwayat() // riwayat transaksi gabah user
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

        $data = DB::table('transaksi_gabahs')
                ->select('transaksi_gabahs.id', 'transaksi_gabahs.jumlah', 'transaksi_gabahs.harga', 'transaksi_gabahs.alamat', 'transaksi_gabahs.kecamatan', 'transaksi_gabahs.kelurahan', 'transaksi_gabahs.keterangan', 'transaksi_gabahs.waktu_jemput', 'gabahs.nama as nama_gabah', 'transaksi_gabahs.created_at', 'transaksi_gabahs.updated_at' )
                ->join('gabahs', 'transaksi_gabahs.gabah_id', '=', 'gabahs.id')
                ->where('transaksi_gabahs.status', '1')
                ->where('transaksi_gabahs.user_id', $user->id)
                ->orderBy('transaksi_gabahs.created_at', 'desc')
                ->get();

        return response()->json([
                    'status'    => true,
                    'message'   => 'Riwayat transaksi gabah oleh user id '.$user->name,
                    'data'      => $data
                ]);
    }

    public function batal() // riwayat transaksi gabah user
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

        $data = DB::table('transaksi_gabahs')
                ->select('transaksi_gabahs.id', 'transaksi_gabahs.jumlah', 'transaksi_gabahs.harga', 'transaksi_gabahs.alamat', 'transaksi_gabahs.kecamatan', 'transaksi_gabahs.kelurahan', 'transaksi_gabahs.keterangan', 'transaksi_gabahs.waktu_jemput', 'gabahs.nama as nama_gabah', 'transaksi_gabahs.created_at', 'transaksi_gabahs.updated_at')
                ->join('gabahs', 'transaksi_gabahs.gabah_id', '=', 'gabahs.id')
                ->where('transaksi_gabahs.status', 'batal')
                ->where('transaksi_gabahs.user_id', $user->id)
                ->orderBy('transaksi_gabahs.created_at', 'desc')
                ->get();

        return response()->json([
                    'status'    => true,
                    'message'   => 'Transaksi gabah yang dibatalkan (user id '.$user->name.')',
                    'data'      => $data
                ]);
    }
}
