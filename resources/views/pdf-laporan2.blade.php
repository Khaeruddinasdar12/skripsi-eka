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
		<h5>Laporan Keuangan Gadai {{$bln .' '. $thn}} </h5>
	</center>
 
	<table class="table table-bordered">
                        <tr>
                          <th>No</th>
                          <th>Nama Pemohon</th>
                          <th>Jenis</th>
                          <th>Luas Lahan</th>
                          <th>Periode</th>
                          <th>Harga</th>
                        </tr>

                        @php $no = 1; $total = 0;@endphp
                        @foreach($data as $datas)
                        <tr class="table">
                          <td>{{$no++}}</td>
                          <td>{{$datas->users->name}}</td>
                          <td>Gadail Lahan</td>
                          <td>{{$datas->luas_lahan}}</td>
                          <td>{{$datas->periode}}</td>
                          <td>Rp. {{format_uang($datas->harga)}}</td>
                          @php $total = $total + $datas->harga; @endphp
                        </tr>
                        @endforeach
                        <tr>
                          <th colspan="4"></th>
                          <th>Total</th>
                          <th>Rp. {{format_uang($total)}}</th>
                        </tr>
                   
</table>
 
</body>
</html>