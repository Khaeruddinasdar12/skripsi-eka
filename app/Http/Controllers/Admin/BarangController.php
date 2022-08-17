<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use Auth;
use App\CartTransaksi;
use QueryException;
use Exception;
class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) //menampilkan hal. data barang
    {
        // dd($request->all());
        $search = $request->get('search');
        // if($request->get('btnfilter') != '') {
        //     $search = '';
        //     unset($request['search']);
        //     unset($request['btnfilter']);
        // }
        if($request->get('filter') == '') { //filter kosong
            if($search != '') { //namun search tidak kosong
                $data = Barang::with('admins:id,name')
                        ->where('nama', 'like', '%'.$search.'%')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
            } else {
                $data = Barang::with('admins:id,name')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }
        } else { //filter tidak kosong
            if($request->get('filter') == 'alat') {
                $filter = 'alat';
            } else if ($request->get('filter') == 'sayur') {
                $filter = 'sayur';
            } else if ($request->get('filter') == 'bibit') {
                $filter = 'bibit';
            } else if ($request->get('filter') == 'pupuk') {
                $filter = 'pupuk';
            } else {
                return redirect()->back()->with('error', 'Pilih filter yang sesuai');
            }

            if($search != '') {
                $data = Barang::with('admins:id,name')
                        ->where('nama', 'like', '%'.$search.'%')
                        ->where('jenis', $filter)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
            } else {
                $data = Barang::with('admins:id,name')
                    ->orderBy('created_at', 'desc')
                    ->where('jenis', $filter)
                    ->paginate(10);
            }     
        }


        $jml = Barang::count();

        return view('admin.page.barang', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views
    }

    public function store(Request $request) //menambah data barang
    {
        $validasi = $this->validate($request, [
            'nama'      => 'required|string',
            'jenis'		=> 'required|string',
            'harga'     => 'required|numeric',
            'min_beli'  => 'required|numeric',
            'stok'      => 'required|numeric',
            'keterangan'=> 'required|string',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072'
        ]);

        $arrjenis = array('alat', 'sayur', 'bibit', 'pupuk'); 
        if(!in_array($request->get('jenis'), $arrjenis)) {
        	return redirect()->back()->with('error', 'Lu ngapain sih ?');
        }

        $data = new Barang;
        $data->nama         = $request->get('nama');
        $data->jenis        = $request->get('jenis');
        $data->harga        = $request->get('harga');
        $data->min_beli     = $request->get('min_beli');
        $data->stok         = $request->get('stok');
        $data->keterangan   = $request->get('keterangan');
        $data->admin_id     = Auth::guard('admin')->user()->id;

        $gambar = $request->file('gambar');
        if ($gambar) {
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }
        $data->save();
        return redirect()->back()->with('success', 'Berhasil menambah data barang');
    }

     public function update(Request $request, $id) //mengubah atau suplly data barang
    {
        $validasi = $this->validate($request, [
            'nama'      => 'required|string',
            'jenis'		=> 'required|string',
            'harga'     => 'required|numeric',
            'min_beli'  => 'required|numeric',
            'stok'      => 'required|numeric',
            'keterangan'=> 'required|string',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072'
        ]);

        $arrjenis = array('alat', 'sayur', 'bibit', 'pupuk'); 
	        if(!in_array($request->get('jenis'), $arrjenis)) {
	        	return redirect()->back()->with('error', 'Lu ngapain sih ?');
        }

        $data = Barang::findOrFail($id);
        $data->nama         = $request->get('nama');
        $data->jenis        = $request->get('jenis');
        $data->harga        = $request->get('harga');
        $data->min_beli     = $request->get('min_beli');
        $data->stok         = $request->get('stok');
        $data->keterangan   = $request->get('keterangan');
        $data->admin_id     = Auth::guard('admin')->user()->id;

        $gambar = $request->file('gambar');
        if ($gambar) {
            if ($data->gambar && file_exists(storage_path('app/public/' . $data->gambar))) {
                \Storage::delete('public/' . $data->gambar);
            }
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }
        $data->save();
        return redirect()->back()->with('success', 'Berhasil mengubah data barang');
    }

    public function delete($id)
    {
        try{
            $cek = CartTransaksi::where('barang_id', $id)->get();
            if($cek) {
                return redirect()->back()->with('error', 'Barang ini berada di tabel lainnya!');
            }
            $data = Barang::findOrFail($id);
            if ($data->gambar && file_exists(storage_path('app/public/' . $data->gambar))) {
                \Storage::delete('public/' . $data->gambar);
            }
            $data->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data barang');
        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }catch(QueryException $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

        
    }
}
