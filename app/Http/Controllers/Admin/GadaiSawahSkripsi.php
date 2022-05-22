<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransaksiLahan;
use Auth;
use PDF;
use Redirect;
use Storage;

class GadaiSawahSkripsi extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function daftar(Request $request) //menampilkan hal. data mendaftarkan lahan untuk digadai 
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiLahan::where('jenis', 'gs')
            ->where('status', null)
            ->with('users:id,name,foto_ktp,nohp')
            ->whereHas('users', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->get('search').'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiLahan::where('jenis', 'gs')
            ->where('status', null)
            ->with('users:id,name,foto_ktp,nohp')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiLahan::where('jenis', 'gs')
            ->where('status', null)->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.gadai.daftar', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views

    }

    public function sedanggadai(Request $request) //menampilkan hal. data yang sedang menggadai sawahnya
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search')) {
            $data = TransaksiLahan::where('jenis', 'gs')
            ->where('status', 'gadai')
            ->with('admins:id,name')
            ->with('users:id,name,nohp')
            ->whereHas('users',function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->get('search').'%');
            })
            ->orderBy('status_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiLahan::where('jenis', 'gs')
            ->where('status', 'gadai')
            ->with('admins:id,name')
            ->with('users:id,name,nohp')
            ->orderBy('status_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiLahan::where('jenis', 'gs')
            ->where('status', 'gadai')
            ->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.gadai.sedang-tergadai', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views

    }

    public function riwayatgadai(Request $request) //menampilkan hal. data riwayat gadai sawah
    {
        if($request->get('search') != '') {
            $data = TransaksiLahan::where('jenis', 'gs')
            ->where('status', 'selesai')
            ->with('admins:id,name')
            ->with('users:id,name,nohp')
            ->whereHas('users',function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->get('search').'%');
            })
            ->paginate(10);
        } else {
            $data = TransaksiLahan::where('jenis', 'gs')
            ->where('status', 'selesai')
            ->with('admins:id,name')
            ->with('users:id,name,nohp')
            ->orderBy('status_at', 'desc')
            ->paginate(10);
        }
        //mengurutkan dari terbaru ke terlama (descending)
        
        $jml = TransaksiLahan::where('jenis', 'gs')
            ->where('status', 'selesai')
            ->count();

        // return $data; // uncomment ini untuk melihat data 
        return view('admin.page.gadai.riwayat-gadai', ['data' => $data, 'jml' => $jml]); //struktur folder di folder views

    }

    public function gadaistatus(Request $request, $id) // mengubah "daftar gadai" menjadi "sedang gadai" modal tanam
    {
        $data = TransaksiLahan::with('users')->findOrFail($id);
        // return $data;
        $data->status = 'gadai';
        $data->keterangan = $request->get('keterangan');
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->status_at = \Carbon\Carbon::now();
        
            // $pdfData = $data->users;
            // return $pdfData;
        // $user = User
        $pdf = PDF::loadView('surat-perjanjian', [
                'nama' => $data->users->name,
                'foto_ktp'  => $data->users->foto_ktp,
                'pekerjaan' => $data->users->pekerjaan,
                'alamat'    => $data->users->alamat,
                'surat_pajak' => $data->surat_pajak,
                'sertifikat_tanah' => $data->sertifikat_tanah,
                'alamat_lahan'  => $data->alamat,
                'periode'   => $data->periode,
                'status_at' => $data->status_at,
                'harga'     => $data->harga, 
            ])->setOptions(['defaultFont' => 'sans-serif']);
            
        $pdf->setOptions(['isPhpEnabled' => true,'isRemoteEnabled' => true]);

        $filename = 'surat-perjanjian-ID'.$data->id;
        
        Storage::put('public/pdf/'.$filename.'.pdf', $pdf->output());
        $data->surat_perjanjian = 'pdf/'.$filename.'.pdf';
        $data->save();

        return redirect()->back()->with('success', 'Berhasil Gadai Lahan !');
    }

    public function selesaistatus(Request $request, $id) // mengubah "sedang gadai" menjadi "riwayat gadai" menjadi sedang gadai 
    {

        $data = TransaksiLahan::findOrFail($id);
        $data->status = 'selesai';
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->status_at = \Carbon\Carbon::now();
        $data->save();
        return redirect()->back()->with('success', 'Berhasil ! Waktu gadai sawah ini telah berakhir silakan lihat datanya pada tab Riwayat Gadai');
    }

    public function editketerangan(Request $request, $id) // edit keterangan 
    {
        $data = TransaksiLahan::findOrFail($id);
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->save();
        return redirect()->back()->with('success', 'Berhasil mengubah keterangan');
    }

    public function delgadai(Request $request, $id) // menghapus gadai yang gagal di survey 
    {
        $data = TransaksiLahan::findOrFail($id);
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->status_at = \Carbon\Carbon::now();
        $data->status = 'batal';
        $data->save();
        return redirect()->back()->with('success', 'Berhasil menghapus pendaftaran gadai sawah');
    }

    public function delriwayat($id) // menghapus riwayat gadai hanya superadmin, jika admin otomatis gagal 
    {
        $data = TransaksiLahan::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus riwayat gadai');
    }
}
