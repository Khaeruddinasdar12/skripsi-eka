<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Provinsi;
use App\Kota;
class AlamatController extends Controller
{
    public function provinsi()
    {
    	$data = Provinsi::all();
    	return response()->json([
                'status' => true, 
                'message' => 'Semua Provinsi', 
                'data' => $data
            ]);
    }

    public function kabupaten($id)
    {
    	$provinsi = Provinsi::findOrFail($id);
    	$data = Kota::where('provinsi_id', $id)->select('id', 'tipe', 'nama_kota')->get();
    	return response()->json([
                'status' => true, 
                'message' => 'Daftar kabupaten atau kota dari provinsi '. $provinsi->nama_provinsi . ' (id ' . $provinsi->id .')',
                'data' => $data
            ]);
    }
}
