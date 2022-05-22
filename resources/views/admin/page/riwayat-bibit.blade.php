@extends('layouts.galungtemplate')

@section('content')

<div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
  <div class="kt-container ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        Penjualan </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">
          Bibit
        </a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">
          Riwayat Transaksi Bibit
        </a>
      </div>
    </div>
    <div class="kt-subheader__toolbar">
      <div class="kt-subheader__wrapper">
        <a href="#" class="btn kt-subheader__btn-daterange" id="kt_dashboard_daterangepicker">
          <span class="kt-subheader__btn-daterange-title" id="kt_dashboard_daterangepicker_title">Today</span>&nbsp;
          <span class="kt-subheader__btn-daterange-date" id="kt_dashboard_daterangepicker_date">Aug
            16
          </span>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="kt-container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <!-- alert section -->
      @include('admin.page.alert')
      <!-- end alert section -->
      <div class="row">
        <div class="col-md-2">
          <div class="kt-portlet kt-iconbox--animate-faster" data-margin-top="100px">
            <div class="kt-portlet__body">
              <h5 style="color: #222;">
                Jumlah Data Riwayat Transaksi Bibit Yang Tersedia
              </h5>
              <h4 class="mt-3" style="font-weight: 800;">
                {{$jml}} Data
              </h4>

            </div>
          </div>
        </div>

        <div class="col-md-10">
          <div class="kt-portlet admin-portlet">
            <div class="kt-portlet__head">
              <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                  <i class="flaticon-avatar"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                  Data Riwayat Transaksi Bibit
                </h3>
              </div>
              <div class="kt-portlet__head-toolbar">
                <form action="{{route('riwayat.tbibit')}}" method="get">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="cari">
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="submit">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="kt-portlet__body">
              <div class="kt-section">
                <div class="kt-section__content">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Pembeli</th>
                          <th>Nama Bibit</th>
                          <th>Jumlah Bibit</th>
                          <th>Total Harga</th>
                          <th>Jenis Pembayaran</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      @if ($jml == 0)
                      <tbody style="text-align: center;">
                        <td colspan="7">Belum ada data</td>
                      </tbody>
                      @else
                      <tbody>
                        @php $no = 1; @endphp
                        @foreach ($data as $riwayat)
                        @php
                        $total = (($riwayat -> jumlah)*($riwayat -> harga));
                        @endphp

                        <!-- Mengganti nama jenis bayar untuk detail -->
                        @if($riwayat->jenis_bayar == 'cod')
                        @php $pembayaran = 'Cash On Delivery (cod)'; @endphp
                        @else
                        @php $pembayaran = 'Transfer Bank'; @endphp
                        @endif
                        <!-- End Mengganti nama jenis bayar untuk detail -->
                        <tr>
                          <th scope="row">{{$no++}}</th>
                          <td>{{$riwayat -> users -> name}}</td>
                          <td>{{$riwayat -> barangs -> nama}}</td>
                          <td>{{$riwayat -> jumlah}} Kg</td>
                          <td>Rp.{{format_uang($total)}}</td>
                          <td>
                            @if($riwayat->jenis_bayar == 'cod')
                            Cash On Delivery
                            @else
                            @if($riwayat->bukti == null)
                            <button type="button" class="btn btn-bold btn-proses-bayar btn-sm">Bukti Pembayaran Belum Ada</button>
                            @else
                            <button type="button" class="btn btn-bold btn-bukti btn-sm" data-toggle="modal" data-target="#buktipembayaran"> Lihat Bukti Pembayaran</button>
                            @endif
                            @endif
                          </td>
                          <td>
                            <div class="dropdown dropdown-inline">
                              <a href="#" class="btn btn-default btn-icon btn-icon-md btn-sm btn-more-custom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="flaticon-more-1"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right dropdown-table-custom fade" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-149px, 33px, 0px);">
                                <ul class="kt-nav">
                                  <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link detail-data" data-toggle="modal" data-target="#modal-detail-bibit" data-id="{{$riwayat->id}}" data-jumlah="{{$riwayat->jumlah}}" data-harga="Rp.{{format_uang($riwayat->harga)}}" data-total="Rp.{{format_uang($total)}}" data-alamat="{{$riwayat->alamat}}" data-kecamatan="{{$riwayat->kecamatan}}" data-kelurahan="{{$riwayat->kelurahan}}" data-keterangan="{{$riwayat->keterangan}}" data-jenis_bayar="{{$pembayaran}}" data-users-name="{{$riwayat->users->name}}" data-users-email="{{$riwayat->users->email}}" data-users-nohp="{{$riwayat->users->nohp}}" data-beras-nama="{{$riwayat->barangs->nama}}">
                                      <i class="kt-nav__link-icon flaticon2-indent-dots"></i>
                                      <span class="kt-nav__link-text">Detail</span>
                                    </a>
                                  </li>
                                  <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link detail-data" data-toggle="modal" data-target="#modal-detail-gambar" data-id="{{$riwayat->id}}" data-image="{{asset('storage/'.$riwayat->barangs->gambar)}}" data-beras-nama="{{$riwayat->barangs->nama}}">
                                      <i class=" kt-nav__link-icon fa fa-eye"></i>
                                      <span class="kt-nav__link-text">Lihat Gambar Alat</span>
                                    </a>
                                  </li>
                                  @if(Auth::guard('admin')->user()->role != 'superadmin')
                                  <li class="kt-nav__item" style="display: none !important;">
                                    <a href="#" class="kt-nav__link hapus-data" data-toggle="modal" data-target="#modal-hapus" data-id="{{$riwayat->id}}" data-href="{{ route('deleteriwayat.tbibit', ['id' => $riwayat->id]) }}">
                                      <i class="kt-nav__link-icon fa fa-trash-alt"></i>
                                      <span class="kt-nav__link-text">Hapus Data</span>
                                    </a>
                                  </li>
                                  @else
                                  <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link hapus-data" data-toggle="modal" data-target="#modal-hapus" data-id="{{$riwayat->id}}" data-href="{{ route('deleteriwayat.tbibit', ['id' => $riwayat->id]) }}">
                                      <i class="kt-nav__link-icon fa fa-trash-alt"></i>
                                      <span class="kt-nav__link-text">Hapus Data</span>
                                    </a>
                                  </li>
                                  @endif
                                </ul>
                              </div>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                      @endif
                    </table>
                    {{$data->links()}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- modal buktipembayaran -->
      <div class="modal fade" id="buktipembayaran" tabindex="-1" role="dialog" aria-labelledby="modal-detail-user">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Bukti Transfer</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body detail-modal" style="padding-top: 10px;">
              <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                <div class="kt-portlet__body kt-portlet__body--fit kt-portlet__body--unfill">
                  <div class="kt-widget19__pic kt-portlet-fit--top kt-portlet-fit--sides">
                    <img src="{{ asset('img/test.JPG') }}" alt="" id="image">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- modal buktipembayaran-->

      <!-- modal detail user -->
      <div class="modal fade" id="modal-detail-bibit" tabindex="-1" role="dialog" aria-labelledby="modal-detail-user">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body detail-modal">
              <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body">

                  <!--begin::Widget -->
                  <div class="kt-widget kt-widget--user-profile-2">
                    <div class="kt-widget__head">
                      <div class="kt-widget__media">
                        <img class="kt-hidden" src="assets/media/users/100_1.jpg" alt="image">
                        <div class="kt-widget__pic kt-widget__pic--info kt-font-info kt-font-boldest  kt-hidden-">
                          A D
                        </div>
                      </div>
                      <div class="kt-widget__info">
                        <span class="kt-widget__username" id="usersnames">
                        </span>
                        <span class="kt-widget__desc" id="email">
                        </span>
                        <span class="kt-widget__desc" id="nohp">
                        </span>
                      </div>
                    </div>
                    <div class="kt-widget__body widget-detail">
                      <div class="kt-widget__item">
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Nama Bibit Yang Dibeli :</span>
                          <span class="kt-widget__data" id="berasnamas"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Jumlah Bibit Yang Dibeli :</span>
                          <span class="kt-widget__data" id="jumlahs"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Harga Satuan :</span>
                          <span class="kt-widget__data" id="hargas"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Total Harga :</span>
                          <span class="kt-widget__data" id="totals"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Alamat :</span>
                          <span class="kt-widget__data" id="alamats"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Kecamatan :</span>
                          <span class="kt-widget__data" id="kecamatans"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Kelurahan :</span>
                          <span class="kt-widget__data" id="kelurahans"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Jenis Bayar :</span>
                          <span class="kt-widget__data" id="jenisbayars"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Keterangan :</span>
                          <span class="kt-widget__data" id="keterangans"></span>
                        </div>

                      </div>
                    </div>
                  </div>

                  <!--end::Widget -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- modal detail user -->

      <div class="modal fade" id="modal-detail-gambar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Bibit Yang Dibeli</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body detail-modal" style="padding-top: 10px;">
              <div class="kt-portlet kt-portlet--height-fluid kt-widget19">
                <div class="kt-portlet__body kt-portlet__body--fit kt-portlet__body--unfill">
                  <div class="kt-widget19__pic kt-portlet-fit--top kt-portlet-fit--sides">
                    <img src="" alt="" id="image">
                    <h3 class="kt-widget19__title kt-font-light" id="berasnamass"></h3>
                    <div class="kt-widget19__shadow"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- modal hapus -->
      <div class="modal modal-hapus fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-trash-alt"></i>
            </span>
            <div class="modal-body">
              <h3>Hapus Data?</h3>
              <p>Data yang telah di hapus tidak dapat</p>
              <p>dikembalikan lagi</p>

              <div class="row verif-form">
                <div class="col-md-6">
                  <button type="button" class="btn close-modal" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>

                <div class="col-md-6">
                  <form action="" method="POST" id="hapus-data">
                    @csrf
                    <input type="hidden" value="delete" name="_method">

                    <input type="submit" value="Hapus data" class="btn btn-verif btn-flat">

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal hapus -->

    </div>
  </div>
</div>

<script type="text/javascript">
  function tampilkanPreview(gambar, idpreview) {
    //membuat objek gambar
    var gb = gambar.files;
    //loop untuk merender gambar
    for (var i = 0; i < gb.length; i++) {
      //bikin variabel
      var gbPreview = gb[i];
      var imageType = /image.*/;
      var preview = document.getElementById(idpreview);
      var reader = new FileReader();
      if (gbPreview.type.match(imageType)) {
        //jika tipe data sesuai
        preview.file = gbPreview;
        reader.onload = (function(element) {
          return function(e) {
            element.src = e.target.result;
          };
        })(preview);
        //membaca data URL gambar
        reader.readAsDataURL(gbPreview);
      } else {
        //jika tipe data tidak sesuai
        alert("Type file tidak sesuai. Khusus image.");
      }
    }
  }

  // modal detail
  $('#modal-detail-bibit').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var jumlah = a.data('jumlah')
    var harga = a.data('harga')
    var alamat = a.data('alamat')
    var kecamatan = a.data('kecamatan')
    var kelurahan = a.data('kelurahan')
    var keterangan = a.data('keterangan')
    var jenis_bayar = a.data('jenis_bayar')
    var usersname = a.data('users-name')
    var usersemail = a.data('users-email')
    var usersnohp = a.data('users-nohp')
    var berasnama = a.data('beras-nama')
    var total = a.data('total')

    var modal = $(this)
    modal.find('.modal-title').text('Detail Transaksi ' + usersname)
    modal.find('.modal-body #usersnames').text('Pembeli : ' + usersname)
    modal.find('.modal-body #email').text(usersemail)
    modal.find('.modal-body #nohp').text(usersnohp)
    modal.find('.modal-body #jumlahs').text(jumlah + ' Kg')
    modal.find('.modal-body #hargas').text(harga)
    modal.find('.modal-body #alamats').text(alamat)
    modal.find('.modal-body #kecamatans').text(kecamatan)
    modal.find('.modal-body #kelurahans').text(kelurahan)
    modal.find('.modal-body #keterangans').text(keterangan)
    modal.find('.modal-body #jenisbayars').text(jenis_bayar)
    modal.find('.modal-body #berasnamas').text(berasnama)
    modal.find('.modal-body #totals').text(total)

  })
  // modal detail

  // modal gambar
  $('#modal-detail-gambar').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var berasnama = a.data('beras-nama')
    var image = a.data('image')

    var modal = $(this)
    modal.find('.modal-body #berasnamass').text(berasnama)
    modal.find('.modal-body #image').attr('src', image)

  })
  // modal gambar

  //Modal hapus
  $('#modal-hapus').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var href = a.data('href')

    var modal = $(this)
    modal.find('.modal-body #hapus-data').attr('action', href)
  })
  //End Modal hapus
</script>

@endsection