<!DOCTYPE html>
<html>
<head>
	<title>Galung App</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Laporan Keuangan {{$bln .' '. $thn}} </h5>
	</center>
 
	<table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Kode Transaksi</th>
                          <th>Nama Penerima</th>
                          <th>No. Hp</th>
                          <th>Total Harga</th>
                          <th>Jenis Pembayaran</th>
                          <th>Akun</th>
                        </tr>
                      </thead>

                      <tbody>
                        @php $no = 1; @endphp
                        @foreach($data as $datas)
                        <tr>
                          <td scope="row">{{$no++}}</td>
                          <td>{{$datas->transaksi_code}}</td>
                          <td>{{$datas->penerima}}</td>
                          <td>{{$datas->nohp}}</td>
                          <td>Rp. {{format_uang($datas->total)}}</td>
                          <td>Cash On Delivery
                          </td>
                          <td>{{$datas->users->name}}</td>
                        </tr>
                        <thead>
                        <tr>
                          <td></td>
                          <td rowspan="{{ $datas->items->count() + 1}}"></td>
                          <th>nama barang</th>
                          <th>Jenis barang</th>
                          <th>harga</th>
                          <th>jumlah</th>
                          <th>subtotal</th>
                        </tr>
                        </thead>
                        @foreach($datas->items as $items)
                        <tr>
                          <td></td>
                          <td>{{$items->nama}}</td>
                          <td>{{$items->jenis}}</td>
                          <td>Rp. {{format_uang($items->harga)}}</td>
                          <td>{{$items->jumlah}}</td>
                          <td>Rp. {{format_uang($items->subtotal)}}</td>
                        </tr>
                        @endforeach
                        <tr>
                          <th colspan="4">Total</th>
                          <th>Rp. {{format_uang($datas->total)}}</th>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
 
</body>
</html>