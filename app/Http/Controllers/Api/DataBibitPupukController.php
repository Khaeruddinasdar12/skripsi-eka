<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
class DataBibitPupukController extends Controller
{
    public function index(Request $request) //menampilkan daftar Pupuk (tanpa header)
	{  
        if($request->sort == 'a-z') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'pupuk')
            ->orWhere('jenis', 'bibit')
            ->orderBy('nama', 'asc')
            ->paginate(8);
        } else if($request->sort == 'z-a') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'pupuk')
            ->orWhere('jenis', 'bibit')
            ->orderBy('nama', 'desc')
            ->paginate(8);
        } else if($request->sort == 'murah-mahal') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'pupuk')
            ->orWhere('jenis', 'bibit')
            ->orderBy('harga', 'asc')
            ->paginate(8);
        } else if($request->sort == 'mahal-murah') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'pupuk')
            ->orWhere('jenis', 'bibit')
            ->orderBy('harga', 'desc')
            ->paginate(8);
        } else {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'pupuk')
            ->orWhere('jenis', 'bibit')
            ->orderBy('created_at', 'desc')
            ->paginate(8);
        }
        
		return response()->json([
            'status' => true,
            'message' => 'data bibit & pupuk (per 8 data)',
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

		// return response()->json([
  //                   'status' => true,
  //                   'message' => 'Semua data bibit-pupuk (per 8 data)',
  //                   'data'	=> $data
  //               ]);
	}
}
