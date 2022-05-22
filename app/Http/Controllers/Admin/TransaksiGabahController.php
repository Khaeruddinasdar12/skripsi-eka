<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransaksiGabah;
use Auth;
use App\Gabah;

class TransaksiGabahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) //menampilkan hal. data transaksi gabah
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiGabah::where('status', '0')
            ->where(function ($query) use ($request) {
                            $query->whereHas('users', function ($query) use($request){
                                $query->where('name', 'like', '%'.$request->get('search').'%');
                            })->orWhereHas('gabahs', function ($query) use($request){
                                $query->where('nama', 'like', '%'.$request->get('search').'%');
                            });
            })
            ->with('users:id,name,email,nohp', 'gabahs:id,nama')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiGabah::where('status', '0')
            ->with('users:id,name,email,nohp', 'gabahs:id,nama')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiGabah::where('status', '0')
            ->count();

        // return $data; //uncomment ini untuk melihat data

        return view('admin.page.transaksigabah', ['data' => $data, 'jml' => $jml]);
    }

    public function riwayat(Request $request) //menampilkan hal. data riwayat transaksi gabah
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiGabah::where('status', '1')
            ->where(function ($query) use ($request) {
                            $query->whereHas('users', function ($query) use($request){
                                $query->where('name', 'like', '%'.$request->get('search').'%');
                            })->orWhereHas('gabahs', function ($query) use($request){
                                $query->where('nama', 'like', '%'.$request->get('search').'%');
                            });
            })
            ->with('users:id,name,email,nohp', 'gabahs:id,nama')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiGabah::where('status', '1')
            ->with('users:id,name,email,nohp', 'gabahs:id,nama', 'admins:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiGabah::where('status', '1')
            ->count();

        // return $data; //uncomment ini untuk melihat data

        return view('admin.page.riwayat-gabah', ['data' => $data, 'jml' => $jml]);
    }

    public function status($id) // mengubah status pembelian gabah menjadi riwayat
    {
        $data = TransaksiGabah::findOrFail($id);
        // if ($data->jenis_bayar == 'tf') {
        //     if ($data->bukti == null) {
        //         return redirect()->back()->with('error', 'Pembeli belum mengirim bukti transfer');
        //     }
        // }
        $data->status   = '1';
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->save();

        return redirect()->back()->with('success', 'Transaksi gabah dengan jumlah ' . $data->jumlah . ' kg berhasil');
    }

    public function delete($id) // menghapus data transaksi gabah
    {
        $data = TransaksiGabah::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Pesanan gabah dihapus');
    }

    public function batal(Request $request, $id) // menghapus data transaksi gabah
    {
        $data = TransaksiGabah::findOrFail($id);
        $data->keterangan = $request->get('keterangan');
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->status = 'batal';
        $data->save();
        return redirect()->back()->with('success', 'Pesanan gabah dihapus');
    }

    public function deleteBySuperadmin($id) // menghapus data transaksi gabah (riwayat Transaksi by superadmin)
    {
        $data = TransaksiGabah::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Riwayat transaksi gabah telah dihapus');
    }
}
