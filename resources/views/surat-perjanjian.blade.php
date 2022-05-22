<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  
</head>
<body>
  <style type="text/css">
    hr {
      display: block;
      margin-top: 0.5em;
      margin-bottom: 0.5em;
      margin-left: auto;
      margin-right: auto;
      border-style: inset;
      border-width: 1px;
      border-color: black;
    }
    .page-break {
      page-break-after: always;
    }
  </style>
  <img src="{{ asset('logo.png') }}" width="280px" height="50px">
      <br> SayurQita 
      <br> Alamat : Kadidi, Sindereng, Sul-sel
      <br> Email : sayurqita@gmail.com
      <br> No.HP : 085342661081
    
    <h4 style="text-align: center;">SURAT PERJANJIAN GADAI LAHAN</h4>
    <p>Kami yang bertandatangan di bawah ini:</p>
    <p>Nama: Apatrys Muis, S.Kom<br /> Pekerjaan: Founder SayurQita<br /> Alamat: Kadidi, Sidenreng</p>
    <p>Selanjutnya disebut pihak PERTAMA atau pemilik tanah</p>
    <p>Nama: {{$nama}}<br /> Pekerjaan: {{$pekerjaan}}<br /> Alamat: {{$alamat}} </p>
    <p>Selanjutnya disebut pihak KEDUA atau pihak yang memberi gadai</p>
    <p>Dengan surat ini, pihak PERTAMA menggadaikan tanah sawah yang terletak di {{$alamat_lahan}} kepada pihak KEDUA dalam waktu {{$periode}} terhitung mulai {{$status_at}}.</p>
    <p>Adapun nilai gadai tanah tersebut sebesar Rp {{format_uang($harga)}} yang dibayar secara tunai oleh Pihak KEDUA.</p>
    <p>Demikian perjanjian gadai tanah sawah yang dibuat secara sadar tanpa adanya paksaan dari pihak mana pun.</p>
    <p>Apabila terjadi hal di luar kesepakatan maka akan diselesaikan secara kekeluargaan.</p>
    <p>Pihak PERTAMA&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Pihak KEDUA</p>
    <br>
    <p>({{$nama}})&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;(Apatrys Muis, S.Kom)</p>
    <p>&nbsp;</p>

    <div class="page-break"></div>
    <h4 style="text-align: center;">LAMPIRAN</h4>
    <br>
    <h4 style="text-align:left;">FOTO KTP</h4>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <img src="{{ asset('storage/'. $foto_ktp) }}" style="width: 600px; height: 600px">
    
    <div class="page-break"></div>
    <h4 style="text-align:left;">SURAT PAJAK BUMI BANGUNAN</h4>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <img src="{{ asset('storage/'. $surat_pajak) }}" style="width: 600px; height: 600px">
    
    <div class="page-break"></div>
    <h4 style="text-align: left;">SERTIFIKAT TANAH</h4>
    <br>
    <img src="{{ asset('storage/'. $sertifikat_tanah) }}" style="width: 600px; height: 600px">