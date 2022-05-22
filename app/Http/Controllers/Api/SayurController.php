<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
class SayurController extends Controller
{
    public function index(Request $request) //menampilkan daftar sayur (tanpa header)
	{
        if($request->sort == 'a-z') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar', 'created_at')
            ->where('jenis', 'sayur')
            ->orderBy('nama', 'asc')
            ->paginate(8);
        } else if($request->sort == 'z-a') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'sayur')
            ->orderBy('nama', 'desc')
            ->paginate(8);
        } else if($request->sort == 'murah-mahal') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'sayur')
            ->orderBy('harga', 'asc')
            ->paginate(8);
        } else if($request->sort == 'mahal-murah') {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar')
            ->where('jenis', 'sayur')
            ->orderBy('harga', 'desc')
            ->paginate(8);
        } else {
            $data = Barang::select('id', 'nama', 'harga', 'min_beli', 'stok', 'keterangan', 'gambar', 'created_at')
            ->where('jenis', 'sayur')
            ->orderBy('created_at', 'desc')
            ->paginate(8);
        }
        
        return response()->json([
            'status' => true,
            'message' => 'data sayur (per 8 data)',
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
}
