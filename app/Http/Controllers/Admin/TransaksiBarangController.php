<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransaksiBarang;
use App\CartTransaksi;
use App\Barang;
use Auth;

class TransaksiBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request) //list sedang transaksi
    {
        if ($request->get('search') != '') {
            $data = TransaksiBarang::where('status', '0')
                ->whereNotNull('bukti')
                ->select('id', 'transaksi_code', 'penerima', 'nohp', 'alamat', 'kecamatan', 'kelurahan', 'rt', 'rw', 'total', 'keterangan', 'user_id', 'bukti')
                ->with('users:id,name,nohp')
                ->with('items:id,nama,jenis,harga,jumlah,subtotal,transaksi_id')
                ->where('transaksi_code', 'like', '%' . $request->get('search') . '%')
                ->where('bukti', '!=', null)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $data = TransaksiBarang::where('status', '0')
                ->whereNotNull('bukti')
                ->select('id', 'transaksi_code', 'penerima', 'nohp', 'alamat', 'kecamatan', 'kelurahan', 'rt', 'rw', 'total', 'keterangan', 'user_id', 'bukti')
                ->with('users:id,name,nohp')
                ->with('items:id,nama,jenis,harga,jumlah,subtotal,transaksi_id')
                ->where('bukti', '!=', null)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        $jml = TransaksiBarang::where('status', '0')
            ->whereNotNull('bukti')
            ->count();
        // return $data;
        return view('admin.page.transaksi', ['data' => $data, 'jml' => $jml]);
    }

    public function riwayat(Request $request) //list sedang transaksi
    {
        if ($request->get('search') != '') {
            $data = TransaksiBarang::where('status', '1')
                ->select('id', 'transaksi_code', 'penerima', 'nohp', 'alamat', 'kecamatan', 'kelurahan', 'rt', 'rw', 'total', 'keterangan', 'user_id')
                ->with('users:id,name,nohp')
                ->with('items:id,nama,jenis,harga,jumlah,subtotal,transaksi_id')
                ->where('transaksi_code', 'like', '%' . $request->get('search') . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $data = TransaksiBarang::where('status', '1')
                ->select('id', 'transaksi_code', 'penerima', 'nohp', 'alamat', 'kecamatan', 'kelurahan', 'rt', 'rw', 'total', 'keterangan', 'user_id')
                ->with('users:id,name,nohp')
                ->with('items:id,nama,jenis,harga,jumlah,subtotal,transaksi_id')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        $jml = TransaksiBarang::where('status', '1')
            ->count();
        // return $data;
        return view('admin.page.riwayat-transaksi', ['data' => $data, 'jml' => $jml]);
    }

    public function status($id) // mengubah status transaksi menjadi terproses(verif->keriwayat)
    {
        $data = TransaksiBarang::findOrFail($id);

        $item = CartTransaksi::select('barang_id', 'jumlah')->where('transaksi_id', $id)->get();
        $i = 0;
        foreach ($item as $items) {
            $dt[$i] = Barang::findOrFail($items->barang_id);
            $jmlitem[$i] = $items->jumlah;
            if ($dt[$i]['stok'] > $jmlitem) {
                return redirect()->back()->with('error', 'Stok barang ' . $dt[$i]['nama'] . ' tidak cukup. stok tersedia ' . $dt[$i]['stok'] . '. jumlah pesanan pelanggan ' . $items->jumlah);
            }
            $i++;
        }
        $a = 0;
        foreach ($dt as $update) {
            $update->stok = $update->stok - $jmlitem[$a++];
            $update->save();
        }

        $data->status = '1';
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->save();
        return redirect()->back()->with('success', 'Transaksi dengan kode ' . $data->transaksi_code . ' berhasil');
    }

    public function delete(Request $request, $id) // mengahapus transaksi (membatalkan)
    {
        $data = TransaksiBarang::findOrFail($id);
        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->keterangan = $request->get('keterangan');
        $data->status = 'batal';
        $data->save();
        return redirect()->back()->with('success', 'Transaksi ' . $data->transaksi_code . ' dibatalkan');
    }
}
