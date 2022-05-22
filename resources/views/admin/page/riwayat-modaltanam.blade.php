@extends('layouts.galungtemplate')

@section('content')

<div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
  <div class="kt-container ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        Modal Tanam</h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">
          Riwayat Modal Tanam
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
                Jumlah Data Modal Tanam Yang Pernah Tergadai
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
                  <img src="{{ asset('img/modaltanam.png') }}" alt="modal tanam" class="image-table-modaltanam">
                </span>
                <h3 class="kt-portlet__head-title">
                  Data Riwayat Modal Tanam
                </h3>
              </div>
              <div class="kt-portlet__head-toolbar">
                <form action="{{route('riwayat.modaltanam')}}" method="get">
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
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Penggadai</th>
                          <th>Nama Sawah</th>
                          <th>Luas Sawah</th>
                          <th>Status</th>
                          <th>Admin Yang Menangani</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      @if ($jml == 0)
                      <tbody style="text-align: center;">
                        <td colspan="8">Belum ada data</td>
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

                      @php $no = 1; @endphp
                      @foreach ($data as $gadais)
                      <!-- jika admin tersedia atau tidak -->
                      @if($gadais->admins == null)
                      @php $admin = 'Admin Telah di hapus'; @endphp
                      @else
                      @php $admin = $gadais->admins->name; @endphp
                      @endif
                      <!-- End jika admin tersedia atau tidak -->
                      <tr>
                        <th scope="row">{{$no++}}</th>
                        <td>{{$gadais -> sawahs -> users -> name}}</td>
                        <td>{{$gadais -> sawahs -> nama}}</td>
                        <td>{{$gadais -> sawahs -> luas_sawah}}</td>
                        <td>
                          <div class="btn btn-bold btn-sm btn-font-sm  btn-label-success" style="font-size: 14px;">
                            Riwayat Modal Tanam
                          </div>
                        </td>
                        <td>{{$admin}}</td>
                        <td>
                          <div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-default btn-icon btn-icon-md btn-sm btn-more-custom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="flaticon-more-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-table-custom fade" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-149px, 33px, 0px);">
                              <ul class="kt-nav">
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link detail-data" data-toggle="modal" data-target="#modal-detail-user" data-id="{{$gadais->id}}" data-email="{{$gadais->sawahs->users->email}}" data-nama-sawah="{{$gadais -> sawahs -> nama}}" data-nohp="{{$gadais->sawahs->users->nohp}}" data-keterangan="{{$gadais->keterangan}}" data-titik_koordinat="{{$gadais->sawahs->titik_koordinat}}" data-kecamatan="{{$gadais->sawahs->kecamatan}}" data-kelurahan="{{$gadais->sawahs->kelurahan}}" data-alamat="{{$gadais->sawahs->alamat}}" data-luas_sawah="{{$gadais->sawahs->luas_sawah}}" data-kota="{{$gadais->sawahs->alamats->tipe}} {{$gadais->sawahs->alamats->nama_kota}}" data-name="{{$gadais->sawahs->users->name}}" data-admin="{{$admin}}">
                                    <i class="kt-nav__link-icon flaticon2-indent-dots"></i>
                                    <span class="kt-nav__link-text">Detail</span>
                                  </a>
                                </li>
                                @if(Auth::guard('admin')->user()->role != 'superadmin')
                                <li class="kt-nav__item" style="display: none !important;">
                                  <a href="#" class="kt-nav__link hapus-data" data-toggle="modal" data-target="#modal-hapus" data-id="{{$gadais->id}}" data-href="{{ route('delriwayat.modaltanam', ['id' => $gadais->id]) }}">
                                    <i class="kt-nav__link-icon fa fa-trash-alt"></i>
                                    <span class="kt-nav__link-text">Hapus Data</span>
                                  </a>
                                </li>
                                @else
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link hapus-data" data-toggle="modal" data-target="#modal-hapus" data-id="{{$gadais->id}}" data-href="{{ route('delriwayat.modaltanam', ['id' => $gadais->id]) }}">
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
      <div class="modal fade" id="modal-detail-user" tabindex="-1" role="dialog" aria-labelledby="modal-detail-user">
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
                        <span class="kt-widget__username" id="name">
                        </span><br>
                        <span class="kt-widget__label" id="email"></span><br>
                        <span class="kt-widget__label" id="nohp"></span>
                      </div>
                    </div>
                    <div class="kt-widget__body widget-detail">
                      <div class="kt-widget__item">
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Nama Sawah :</span>
                          <span class="kt-widget__data" id="nama-sawah"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Luas Sawah :</span>
                          <span class="kt-widget__data" id="luas_sawah"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Titik Koordinat Sawah :</span>
                          <span class="kt-widget__data" id="titik_koordinat"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Provinsi :</span>
                          <span class="kt-widget__data">Sulawesi Selatan</span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Kota :</span>
                          <span class="kt-widget__data" id="kota"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Kecamatan :</span>
                          <span class="kt-widget__data" id="kecamatan"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Kelurahan / Desa :</span>
                          <span class="kt-widget__data" id="kelurahan"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Alamat :</span>
                          <span class="kt-widget__data" id="alamat"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Status :</span>
                          <span class="kt-widget__data">Riwayat Gadai</span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Admin Yang Menangani :</span>
                          <span class="kt-widget__data" id="admin"></span>
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

<script>
  // modal detail
  $('#modal-detail-user').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var email = a.data('email')
    var namasawah = a.data('nama-sawah')
    var nohp = a.data('nohp')
    var keterangan = a.data('keterangan')
    var tanggal_lahir = a.data('tanggal_lahir')
    var titik_koordinat = a.data('titik_koordinat')
    var kecamatan = a.data('kecamatan')
    var kelurahan = a.data('kelurahan')
    var alamat = a.data('alamat')
    var luas_sawah = a.data('luas_sawah')
    var kota = a.data('kota')
    var name = a.data('name')
    var admin = a.data('admin')

    var modal = $(this)
    modal.find('.modal-title').text('Detail ' + name)
    modal.find('.modal-body #name').text(name)
    modal.find('.modal-body #nama-sawah').text(namasawah)
    modal.find('.modal-body #email').text(email)
    modal.find('.modal-body #nohp').text(nohp)
    modal.find('.modal-body #luas_sawah').text(luas_sawah)
    modal.find('.modal-body #titik_koordinat').text(titik_koordinat)
    modal.find('.modal-body #kota').text(kota)
    modal.find('.modal-body #kecamatan').text(kecamatan)
    modal.find('.modal-body #kelurahan').text(kelurahan)
    modal.find('.modal-body #alamat').text(alamat)
    modal.find('.modal-body #admin').text(admin)
    modal.find('.modal-body #keterangan').text(keterangan)
  })
  // modal detail

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