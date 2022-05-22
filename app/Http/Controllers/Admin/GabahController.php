<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Gabah;
use Auth;

class GabahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) //menampilkan hal. data gabah
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = Gabah::with('admins:id,name')
            ->where('nama', 'like', '%'.$request->get('search').'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10); 
        } else {
            $data = Gabah::with('admins:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = Gabah::count();

        // return $data; // uncomment ini untuk melihat data

        return view('admin.page.gabah', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views
    }

    public function store(Request $request) //menambah data gabah
    {
        $validasi = $this->validate($request, [
            'nama'          => 'required|string',
            'harga'         => 'required|numeric'
        ]);

        $user = Gabah::create([
            'nama'  => $request->get('nama'),
            'harga' => $request->get('harga'), //per KG
            'admin_id'  => Auth::guard('admin')->user()->id
        ]);

        return redirect()->back()->with('success', 'Berhasil menambah data gabah');
    }

    public function update(Request $request, $id) //mengubah data gabah
    {
        $validasi = $this->validate($request, [
            'nama'          => 'required|string',
            'harga'         => 'required|numeric'
        ]);


        $gabah = Gabah::findOrFail($id);
        $gabah->nama    = $request->get('nama');
        $gabah->harga   = $request->get('harga');
        $gabah->admin_id = Auth::guard('admin')->user()->id;
        $gabah->save();

        return redirect()->back()->with('success', 'Berhasil mengubah data gabah');
    }

    public function delete($id) //menghapus data gabah
    {
        $data = Gabah::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Berhasil mengahapus data gabah');
    }
}
