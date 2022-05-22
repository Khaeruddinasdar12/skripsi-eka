<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\ModalTanam;
use App\TransaksiSawah;
use Auth;

class ModalTanamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function daftargadai(Request $request) //menampilkan hal. data mendaftarkan sawah untuk digadai sebagai modal tanam
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiSawah::where('jenis', 'mt')
            ->where('status', null)
            ->whereHas('sawahs.users',function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->get('search').'%');
            })
            ->select('id', 'keterangan', 'sawah_id')
            ->with('admins:id,name')
            ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiSawah::where('jenis', 'mt')
            ->where('status', null)
            ->select('id', 'keterangan', 'sawah_id')
            ->with('admins:id,name')
            ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiSawah::where('jenis', 'mt')
            ->where('status', null)->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.modaltanam-unverif', ['data' => $data, 'jml' => $jml]);
    }

    public function sedanggadai(Request $request) //menampilkan hal. data yang sedang menggadai sawahnya sebagai modal tanam
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiSawah::where('jenis', 'mt')
                ->where('status', 'gadai')
                ->whereHas('sawahs.users',function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->get('search').'%');
                })
                ->select('id', 'keterangan', 'sawah_id')
                ->with('admins:id,name')
                ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $data = TransaksiSawah::where('jenis', 'mt')
                ->where('status', 'gadai')
                ->select('id', 'keterangan', 'admin_id', 'sawah_id')
                ->with('admins:id,name')
                ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
                ->orderBy('status_at', 'desc')
                ->paginate(10);
        }
        $jml = TransaksiSawah::where('jenis', 'mt')
            ->where('status', 'gadai')
            ->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.modaltanam-verif', ['data' => $data, 'jml' => $jml]);
    }

    public function riwayatgadai(Request $request) //menampilkan hal. data riwayat gadai sawah sebagai modal tanam
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiSawah::where('jenis', 'mt')
                ->where('status', 'selesai')
                ->whereHas('sawahs.users',function ($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->get('search').'%');
                })
                ->select('id', 'keterangan', 'sawah_id')
                ->with('admins:id,name')
                ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $data = TransaksiSawah::where('jenis', 'mt')
                ->where('status', 'selesai')
                ->select('id', 'keterangan', 'admin_id', 'sawah_id')
                ->with('admins:id,name')
                ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
                ->orderBy('status_at', 'desc')
                ->paginate(10);
        }
        $jml = TransaksiSawah::where('jenis', 'mt')
            ->where('status', 'selesai')
            ->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.riwayat-modaltanam', ['data' => $data, 'jml' => $jml]);
    }

    public function gadaistatus(Request $request, $id) // mengubah "daftar gadai" menjadi "sedang gadai" modal tanam
    {
        $data = TransaksiSawah::findOrFail($id);
        $data->status = 'gadai';
        $data->keterangan = $request->get('keterangan');
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->status_at = \Carbon\Carbon::now();
        $data->save();
        return redirect()->back()->with('success', 'Berhasil ! Sawah ini sekarang sedang digadai sebagai modal tanam');
    }

    public function selesaistatus(Request $request, $id) // mengubah "sedang gadai" menjadi "riwayat gadai" menjadi sedang gadai modal tanam
    {

        $data = TransaksiSawah::findOrFail($id);
        $data->status = 'selesai';
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->status_at = \Carbon\Carbon::now();
        $data->save();
        return redirect()->back()->with('success', 'Berhasil ! Modal tanam telah selesai silakan lihat datanya pada tab Riwayat Modal Tanam');
    }

    public function editketerangan(Request $request, $id) // edit keterangan modal tanam
    {
        $data = TransaksiSawah::findOrFail($id);
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->save();
        return redirect()->back()->with('success', 'Berhasil mengubah keterangan');
    }

    public function delgadai(Request $request, $id) // menghapus modal tanam (sebelum verif) 
    {
        $data = TransaksiSawah::findOrFail($id);
        // if ($data->status == 'gadai' || $data->status == 'selesai') {
        //     return redirect()->back()->with('error', 'Data ingin dihapus dengan cara yang tidak semestinya, status in DB');
        // }
        // $data->delete();
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->status_at = \Carbon\Carbon::now();
        $data->status = 'batal';
        $data->save();
        return redirect()->back()->with('success', 'Berhasil menghapus pendaftaran modal tanam');
    }

    public function delriwayat($id) // menghapus riwayat gadai modal tanam hanya superadmin, jika admin otomatis gagal 
    {
        $data = TransaksiSawah::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus riwayat modal tanam');
    }
}
