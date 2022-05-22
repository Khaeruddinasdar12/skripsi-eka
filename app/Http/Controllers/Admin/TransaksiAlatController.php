<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\TransaksiBarang;
use App\Barang;

class TransaksiAlatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) //menampilkan hal. data transaksi
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiBarang::
            where(function ($query) use ($request) {
                            $query->whereHas('barangs', function ($query) use($request){
                                    $query->where('jenis', 'alat')
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
                    $query->where('jenis', 'alat')->where('status', '0');
                })
            ->with('users:id,name,email,nohp', 'barangs:id,nama,gambar')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiBarang::whereHas('barangs', function ($query) {
                    $query->where('jenis', 'alat')->where('status', '0');
                })
            ->count();

        // return $data; //uncomment ini untuk melihat data

        return view('admin.page.transaksialat', ['data' => $data, 'jml' => $jml]);
    }

    public function riwayat(Request $request) //menampilkan hal. data riwayat transaksi alat
    {
        //mengurutkan dari terbaru ke terlama (descending)
        if($request->get('search') != '') {
            $data = TransaksiBarang::
            where(function ($query) use ($request) {
                            $query->whereHas('barangs', function ($query) use($request){
                                    $query->where('jenis', 'alat')
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
                    $query->where('jenis', 'alat')->where('status', '1');
                })
            ->with('users:id,name,email,nohp', 'barangs:id,nama,gambar', 'admins:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }
        
        $jml = TransaksiBarang::whereHas('barangs', function ($query) {
                    $query->where('jenis', 'alat')->where('status', '1');
                })
            ->count();

        // return $data; //uncomment ini untuk melihat data

        return view('admin.page.riwayat-alat', ['data' => $data, 'jml' => $jml]);
    }

    public function status($id) // mengubah status pembelian alat menjadi riwayat
    {
        $data = TransaksiBarang::findOrFail($id);
        // if ($data->jenis_bayar == 'tf') {
        //     if ($data->bukti == null) {
        //         return redirect()->back()->with('error', 'Pembeli belum mengirim bukti transfer');
        //     }
        // }
        $jml = $data->jumlah; // jumlah pesanan alat yang dipesan
        $alat = Barang::findOrFail($data->barang_id);
            if($alat->jenis != 'alat') {
                return redirect()->back()->with('error', 'Oops ! Ngapain bre ?');
            }

        $stok = $alat->stok;

        if ($jml > $stok) {
            return redirect()->back()->with('error', 'Stok alat tani' . $alat->nama . ' tidak cukup. stok tersedia ' . $alat->stok);
        }
        $alat->stok = $alat->stok - $jml;
        $alat->save();


        $data->status   = '1';
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->save();

        return redirect()->back()->with('success', 'Transaksi alat ' . $alat->nama . ' dengan jumlah ' . $jml . ' unit berhasil');
    }

    public function delete(Request $request, $id) // menghapus data transaksi alat belum verif
    {
        $data = TransaksiBarang::findOrFail($id);
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->status = 'batal';
        $data->save();
        return redirect()->back()->with('success', 'Pesanan alat tani dihapus');
    }

    public function deleteBySuperadmin($id) // menghapus data transaksi alat (riwayat Transaksi by superadmin)
    {
        $data = TransaksiBarang::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('success', 'Riwayat transaksi alat telah dihapus');
    }
}
