<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransaksiLahan;
use Auth;
class ModalTanamSkripsi extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function daftar(Request $request) //menampilkan hal. data mendaftarkan sawah untuk digadai sebagai modal tanam
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiLahan::where('jenis', 'mt')
            ->where('status', null)
            ->with('users:id,name,foto_ktp,nohp')
            ->whereHas('users',function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->get('search').'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiLahan::where('jenis', 'mt')
            ->where('status', null)
            ->with('users:id,name,foto_ktp,nohp')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiLahan::where('jenis', 'mt')
            ->where('status', null)->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.modal.daftar', ['data' => $data, 'jml' => $jml]);
    }

    public function riwayatgadai(Request $request) //menampilkan hal. data riwayat gadai sawah sebagai modal tanam
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiLahan::where('jenis', 'mt')
                ->where('status', 'selesai')
                ->with('users:id,name')
                ->with('admins:id,name,nohp,foto_ktp')
                ->whereHas('users',function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->get('search').'%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $data = TransaksiLahan::where('jenis', 'mt')
                ->where('status', 'selesai')
                ->with('admins:id,name')
                ->with('users:id,name,nohp,foto_ktp')
                ->orderBy('status_at', 'desc')
                ->paginate(10);
        }
        $jml = TransaksiLahan::where('jenis', 'mt')
            ->where('status', 'selesai')
            ->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.modal.riwayat-modal', ['data' => $data, 'jml' => $jml]);
    }

    public function gadaistatus(Request $request, $id) // mengubah "daftar gadai" menjadi "sedang gadai" modal tanam
    {
        $data = TransaksiLahan::findOrFail($id);
        $data->status = 'selesai';
        $data->keterangan = $request->get('keterangan');
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->status_at = \Carbon\Carbon::now();
        $data->save();
        return redirect()->back()->with('success', 'Berhasil ! Lahan ini tercatat sebagai riwayat modal tanam!');
    }

    public function batalkanstatus(Request $request, $id) // mengubah "daftar gadai" menjadi "sedang gadai" modal tanam
    {
        $data = TransaksiLahan::findOrFail($id);
        $data->status = 'batal';
        $data->keterangan = $request->get('keterangan');
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->status_at = \Carbon\Carbon::now();
        $data->save();
        return redirect()->back()->with('success', 'Permintaan ini telah dibatalkan!');
    }

    public function delriwayat($id) // menghapus riwayat gadai modal tanam hanya superadmin, jika admin otomatis gagal 
    {
        $data = TransaksiLahan::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus riwayat modal tanam');
    }
}
