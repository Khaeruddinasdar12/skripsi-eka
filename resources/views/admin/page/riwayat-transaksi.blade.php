@extends('layouts.galungtemplate')

@section('content')
<script type="text/javascript">
  $(document).ready(function() {
    $(".tutupi").hide(2000);
  });

  function det(no) {
    $(".detail-keranjang" + no).toggle('slow');
    // }
  }
</script>

<div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
  <div class="kt-container ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        Barang </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">
          Riwayat Transaksi Barang
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
                Jumlah Riwayat Transaksi Barang
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
                  <img src="{{ asset('img/transaksi.png') }}" alt="transaksi" class="image-table-transaksi">
                </span>
                <h3 class="kt-portlet__head-title">
                  Data Riwayat Transaksi Barang
                </h3>
              </div>
              <div class="kt-portlet__head-toolbar">
                <form action="{{route('riwayat.transaksi')}}" method="get">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" @if(Request::get('search')=='' ) placeholder="cari" @else value="{{Request::get('search')}}" @endif>
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
                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Kode Transaksi</th>
                          <th>Nama Pembeli</th>
                          <th>No. Hp</th>
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
                        @if($data->isEmpty())
                        <tr>
                          <td colspan="7" align="center">
                            Tidak ada data untuk pencarian "{{ Request::get('search') }}"
                          </td>
                        </tr>
                      </tbody>
                      @else

                      @php $no = 0; @endphp
                      @foreach($data as $datas)
                      <tr>

                        <td>
                          <div class="btn btn-default btn-icon btn-icon-md btn-sm btn-detail" onclick="det({{$no}})">
                            <i class="fa fa-angle-right"></i>
                          </div>
                        </td>
                        <td>{{$datas->transaksi_code}}</td>
                        <td>{{$datas->penerima}}</td>
                        <td>{{$datas->nohp}}</td>
                        <td>Rp. {{format_uang($datas->total)}}</td>
                        <td>Cash On Delivery
                        </td>
                        <td>
                          <div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-default btn-icon btn-icon-md btn-sm btn-more-custom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="flaticon-more-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-table-custom fade" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-149px, 33px, 0px);">
                              <ul class="kt-nav">
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link detail-data" data-toggle="modal" data-target="#modal-detail-beras" data-id="{{$datas->id}}" data-code="{{$datas->transaksi_code}}" data-penerima="{{$datas->penerima}}" data-nohp="{{$datas->nohp}}" data-alamat="{{$datas->alamat}}" data-kelurahan="{{$datas->kelurahan}}" data-kecamatan="{{$datas->kecamatan}}" data-rt="{{$datas->rt}}" data-rw="{{$datas->rw}}" data-total="{{$datas->total}}" data-ket="{{$datas->keterangan}}">
                                    <i class="kt-nav__link-icon flaticon2-indent-dots"></i>
                                    <span class="kt-nav__link-text">Detail</span>
                                  </a>
                                </li>
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link verif-data" data-toggle="modal" data-target="#modal-pembelian" data-href="{{route('status.transaksi', ['id' => $datas->id])}}">
                                    <i class="kt-nav__link-icon flaticon2-check-mark"></i>
                                    <span class="kt-nav__link-text">Verifikasi Pembelian</span>
                                  </a>
                                </li>
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link hapus-data" data-toggle="modal" data-target="#modal-hapus" data-href="{{route('delete.transaksi', ['id' => $datas->id])}}">
                                    <i class="kt-nav__link-icon fa fa-trash-alt"></i>
                                    <span class="kt-nav__link-text">Batalkan</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr class="detail-keranjang{{$no}} tutupi">
                        <td></td>
                        <td>nama barang</td>
                        <td>Jenis barang</td>
                        <td>harga</td>
                        <td>jumlah</td>
                        <td>subtotal</td>
                      </tr>
                      @foreach($datas->items as $items)
                      <tr class="detail-keranjang{{$no}} tutupi">
                        <td></td>
                        <td>{{$items->nama}}</td>
                        <td>{{$items->jenis}}</td>
                        <td>Rp. {{format_uang($items->harga)}}</td>
                        <td>{{$items->jumlah}}</td>
                        <td>Rp. {{format_uang($items->subtotal)}}</td>
                      </tr>
                      @endforeach
                      @php $no++ @endphp
                      @endforeach
                      </tbody>
                      @endif
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

      <!-- modal detail user -->
      <div class="modal fade" id="modal-detail-beras" tabindex="-1" role="dialog" aria-labelledby="modal-detail-user">
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
                        </span><br>
                        <span class="kt-widget__label" id="email"></span><br>
                        <span class="kt-widget__label" id="nohp"></span>
                      </div>
                    </div>
                    <div class="kt-widget__body widget-detail">
                      <div class="kt-widget__item">

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Total Harga Pembelian :</span>
                          <span class="kt-widget__data" id="total"></span>
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
                          <span class="kt-widget__label">Rt :</span>
                          <span class="kt-widget__data" id="rt"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Rw :</span>
                          <span class="kt-widget__data" id="rw"></span>
                        </div>

                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Keterangan :</span>
                          <span class="kt-widget__data" id="keterangan"></span>
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

      <!-- modal verifikasi -->
      <div class="modal modal-verif fade" id="modal-pembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-info"></i>
            </span>
            <div class="modal-body">
              <h3>Verifikasi Pembelian?</h3>
              <p>Verifikasi pembelian hanya dapat di lakukan satu kali</p>
              <p>dan tidak dapat di batalkan</p>

              <div class="row verif-form">
                <div class="col-md-6">
                  <button type="button" class="btn close-modal" data-dismiss="modal" aria-label="Close">Cancel</button>
                </div>

                <div class="col-md-6">
                  <form action="" method="POST" id="verif-pembelian">
                    @csrf
                    <input type="hidden" value="PUT" name="_method">

                    <input type="submit" value="Verifikasi" class="btn btn-verif btn-flat">

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal verifikasi -->

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
              <form action="" method="POST" id="hapus-data">
                <div class="form-group">
                  <label for="exampleTextarea">Tambahkan keterangan :</label>
                  <textarea class="form-control" name="keterangan" rows="3" style="margin-top: 0px; margin-bottom: 0px; height: 97px; resize: none" required>Mohon maaf pembelian alat tidak dapat kami proses.</textarea>
                </div>
                <div class="row verif-form">
                  <div class="col-md-6">
                    <button type="button" class="btn close-modal" data-dismiss="modal" aria-label="Close">Cancel</button>
                  </div>

                  <div class="col-md-6">
                    <form action="" method="POST" id="hapus-data">
                      @csrf
                      <input type="hidden" value="delete" name="_method">

                      <input type="submit" value="Hapus data" class="btn btn-verif btn-flat">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal hapus -->

    </div>
  </div>
</div>

<script type="text/javascript">
  // modal detail
  $('#modal-detail-beras').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var code = a.data('code')
    var penerima = a.data('penerima')
    var nohp = a.data('nohp')
    var alamat = a.data('alamat')
    var kelurahan = a.data('kelurahan')
    var kecamatan = a.data('kecamatan')
    var rt = a.data('rt')
    var rw = a.data('rw')
    var total = a.data('total')
    var ket = a.data('ket')

    var modal = $(this)
    modal.find('.modal-title').text('Detail Transaksi ' + code)
    modal.find('.modal-body #usersnames').text('Pembeli : ' + penerima)
    modal.find('.modal-body #nohp').text(nohp)
    modal.find('.modal-body #total').text('Rp : ' + total)
    modal.find('.modal-body #alamats').text(alamat)
    modal.find('.modal-body #kecamatans').text(kecamatan)
    modal.find('.modal-body #kelurahans').text(kelurahan)
    modal.find('.modal-body #rt').text(rt)
    modal.find('.modal-body #rw').text(rw)
    modal.find('.modal-body #keterangan').text(ket)

  })
  // modal detail

  //Modal Verifikasi
  $('#modal-pembelian').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var href = a.data('href')

    var modal = $(this)
    modal.find('.modal-body #verif-pembelian').attr('action', href)
  })
  //End Modal Verifikasi

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