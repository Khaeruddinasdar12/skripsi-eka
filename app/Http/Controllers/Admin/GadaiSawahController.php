<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\GadaiSawah;
use App\TransaksiSawah;
use Auth;

class GadaiSawahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function daftargadai(Request $request) //menampilkan hal. data mendaftarkan sawah untuk digadai 
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiSawah::where('jenis', 'gs')
            ->where('status', null)
            ->with('admins:id,name')
            ->whereHas('sawahs.users', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->get('search').'%');
            })
            ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiSawah::where('jenis', 'gs')
            ->where('status', null)
            ->with('admins:id,name')
            ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiSawah::where('jenis', 'gs')
            ->where('status', null)->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.gadai-unverif', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views

    }

    public function sedanggadai(Request $request) //menampilkan hal. data yang sedang menggadai sawahnya
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search')) {
            $data = TransaksiSawah::where('jenis', 'gs')
            ->where('status', 'gadai')
            ->with('admins:id,name')
            ->whereHas('sawahs.users',function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->get('search').'%');
            })
            ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
            ->orderBy('status_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiSawah::where('jenis', 'gs')
            ->where('status', 'gadai')
            ->with('admins:id,name')
            ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
            ->orderBy('status_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiSawah::where('jenis', 'gs')
            ->where('status', 'gadai')
            ->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.sedang-tergadai', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views

    }

    public function riwayatgadai(Request $request) //menampilkan hal. data riwayat gadai sawah
    {
        if($request->get('search') != '') {
            $data = TransaksiSawah::where('jenis', 'gs')
            ->where('status', 'selesai')
            ->with('admins:id,name')
            ->whereHas('sawahs.users',function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->get('search').'%');
            })
            ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
            ->orderBy('status_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiSawah::where('jenis', 'gs')
            ->where('status', 'selesai')
            ->with('admins:id,name')
            ->with('sawahs', 'sawahs.alamats:id,tipe,nama_kota', 'sawahs.users:id,name,email,nohp')
            ->orderBy('status_at', 'desc')
            ->paginate(10);
        }
        //mengurutkan dari terbaru ke terlama (descending)
        
        $jml = TransaksiSawah::where('jenis', 'gs')
            ->where('status', 'selesai')
            ->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.riwayat-gadai', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views

    }

    public function gadaistatus(Request $request, $id) // mengubah "daftar gadai" menjadi "sedang gadai"
    {
        $data = TransaksiSawah::findOrFail($id);
        $data->status = 'gadai';
        $data->keterangan = $request->get('keterangan');
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->status_at = \Carbon\Carbon::now();
        $data->save();
        return redirect()->back()->with('success', 'Berhasil ! Sawah ini sekarang sedang digadai');
    }

    public function selesaistatus(Request $request, $id) // mengubah "sedang gadai" menjadi "riwayat gadai" menjadi sedang gadai 
    {

        $data = TransaksiSawah::findOrFail($id);
        $data->status = 'selesai';
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->status_at = \Carbon\Carbon::now();
        $data->save();
        return redirect()->back()->with('success', 'Berhasil ! Waktu gadai sawah ini telah berakhir silakan lihat datanya pada tab Riwayat Gadai');
    }

    public function editketerangan(Request $request, $id) // edit keterangan 
    {
        $data = TransaksiSawah::findOrFail($id);
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->save();
        return redirect()->back()->with('success', 'Berhasil mengubah keterangan');
    }

    public function delgadai(Request $request, $id) // menghapus gadai yang gagal di survey 
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
        return redirect()->back()->with('success', 'Berhasil menghapus pendaftaran gadai sawah');
    }

    public function delriwayat($id) // menghapus riwayat gadai hanya superadmin, jika admin otomatis gagal 
    {
        $data = TransaksiSawah::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus riwayat gadai');
    }
}
