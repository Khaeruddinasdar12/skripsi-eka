<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\TransaksiBarang;
use App\Barang;

class TransaksiBibitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) //menampilkan hal. data transaksi bibit
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiBarang::
            where(function ($query) use ($request) {
                            $query->whereHas('barangs', function ($query) use($request){
                                    $query->where('jenis', 'bibit')
                                ->where('status', '0');
                            })->whereHas('users', function ($query) use($request){
                                $query->where('name', 'like', '%'.$request->get('search').'%');
                            });
            })
            ->with('users:id,name,email,nohp', 'barangs:id,nama,gambar')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        } else {
            $data = TransaksiBarang::whereHas('barangs', function ($query) {
                $query->where('jenis', 'bibit')->where('status', '0');
            })
            ->with('users:id,name,email,nohp', 'barangs:id,nama,gambar')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiBarang::whereHas('barangs', function ($query) {
            $query->where('jenis', 'bibit')->where('status', '0');
        })
            ->count();

        // return $data; //uncomment ini untuk melihat data

        return view('admin.page.transaksibibit', ['data' => $data, 'jml' => $jml]);
    }

    public function riwayat(Request $request) //menampilkan hal. data riwayat transaksi bibit
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiBarang::
            where(function ($query) use ($request) {
                            $query->whereHas('barangs', function ($query) use($request){
                                    $query->where('jenis', 'bibit')
                                ->where('status', '1');
                            })->whereHas('users', function ($query) use($request){
                                $query->where('name', 'like', '%'.$request->get('search').'%');
                            });
            })
            ->with('users:id,name,email,nohp', 'barangs:id,nama,gambar', 'admins:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10); 
        } else {
            $data = TransaksiBarang::whereHas('barangs', function ($query) {
                $query->where('jenis', 'bibit')->where('status', '1');
            })
            ->with('users:id,name,email,nohp', 'barangs:id,nama,gambar', 'admins:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiBarang::whereHas('barangs', function ($query) {
            $query->where('jenis', 'bibit')->where('status', '1');
        })
            ->count();

        // return $data; //uncomment ini untuk melihat data

        return view('admin.page.riwayat-bibit', ['data' => $data, 'jml' => $jml]);
    }

    public function status($id) // mengubah status pembelian bibit menjadi riwayat
    {
        $data = TransaksiBarang::findOrFail($id);
        // if ($data->jenis_bayar == 'tf') {
        //     if ($data->bukti == null) {
        //         return redirect()->back()->with('error', 'Pembeli belum mengirim bukti transfer');
        //     }
        // }
        $jml = $data->jumlah; // jumlah pesanan bibit yang dipesan
        $bibit = Barang::findOrFail($data->barang_id);
        if ($bibit->jenis != 'bibit') {
            return redirect()->back()->with('error', 'Oops ! Ngapain bre ?');
        }
        $stok = $bibit->stok;

        if ($jml > $stok) {
            return redirect()->back()->with('error', 'Stok bibit ' . $bibit->nama . ' tidak cukup. stok tersedia ' . $bibit->stok);
        }
        $bibit->stok = $bibit->stok - $jml;
        $bibit->save();
        $data->status   = '1';
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->save();

        return redirect()->back()->with('success', 'Transaksi bibit ' . $bibit->nama . ' dengan jumlah ' . $jml . ' kg berhasil');
    }

    public function delete(Request $request, $id) // menghapus data transaksi bibit
    {
        $data = TransaksiBarang::findOrFail($id);
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->status = 'batal';
        $data->save();
        return redirect()->back()->with('success', 'Pesanan bibit dihapus');
    }

    public function deleteBySuperadmin($id) // menghapus data transaksi bibit (riwayat Transaksi by superadmin)
    {
        $data = TransaksiBarang::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Riwayat transaksi bibit telah dihapus');
    }
}
