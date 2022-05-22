<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Kota;
class ManageUserSkripsi extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) //menampilkan hal. data user
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = User::where('role', 'petani')
                ->where('name', 'like', '%'.$request->get('search').'%')
                ->where('petani_verified', '1')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $data = User::where('role', 'petani')
                ->where('petani_verified', '1')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        

        $jml = User::where('role', 'petani')
                ->where('petani_verified', '1')
                ->count(); // menghitung jumlah petani terverifikasi

        $kota = Kota::select('id', 'tipe', 'nama_kota')
                ->where('provinsi_id', 28)
                ->get();
        // return $data; // uncomment ini untuk melihat data user 

        return view('admin.page.manage-user.index', ['data' => $data, 'kota' => $kota, 'jml' => $jml]);
    }
}
