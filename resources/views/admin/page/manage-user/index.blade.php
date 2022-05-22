@extends('layouts.galungtemplate')

@section('content')

<div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
  <div class="kt-container ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        Manage User </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">
          Manage User
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
                Jumlah Data User SayurQita
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
                  Data User
                </h3>
              </div>
              <div class="kt-portlet__head-toolbar">
                <form action="{{route('verified.manage-user')}}" method="get">
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
                          <th>Nama Lengkap</th>
                          <th>Email</th>
                          <th>Foto KTP</th>
                          <th>Kelurahan / Desa</th>
                          <th>Jenis Kelamin</th>
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
                          <td colspan="8" align="center">
                            Tidak ada data untuk pencarian "{{ Request::get('search') }}"
                          </td>
                        </tr>
                      </tbody>
                      @else

                      @php $no = 1; @endphp
                      @foreach ($data as $user)
                      <tr>
                        <th scope="row">{{$no++}}</th>
                        <td>{{$user->name}} </td>
                        <td>{{$user->email}}</td>
                        <td><a href="{{asset('storage/'.$user->foto_ktp)}}"><img src="{{asset('storage/'.$user->foto_ktp)}}" width="90px" height="90px"></a></td>
                        <td>{{$user->kelurahan}}</td>
                        <td>
                          @if($user->jkel == 'P') Perempuan
                          @else Laki-laki @endif
                        </td>
                        <td>
                          <div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-default btn-icon btn-icon-md btn-sm btn-more-custom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="flaticon-more-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-table-custom fade" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-149px, 33px, 0px);">
                              <ul class="kt-nav">
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link detail-data" data-toggle="modal" data-target="#modal-detail-user" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}" data-tempat_lahir="{{$user->tempat_lahir}}" data-tanggal_lahir="{{$user->tanggal_lahir}}" data-alamat="{{$user->alamat}}" data-kecamatan="{{$user->kecamatan}}" data-kelurahan="{{$user->kelurahan}}" data-nohp="{{$user->nohp}}" data-petani_verified="{{$user->petani_verified}}" data-jkel="{{$user->jkel}}" data-rt="{{$user->rt}}" data-rw="{{$user->rw}}" data-role="{{$user->role}}" data-pekerjaan="{{$user->pekerjaan}}">
                                    <i class="kt-nav__link-icon flaticon2-indent-dots"></i>
                                    <span class="kt-nav__link-text">Detail</span>
                                  </a>
                                </li>
                                @if(Auth::guard('admin')->user()->role == 'superadmin')
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link edit-data" data-toggle="modal" data-target="#modal-edit-user" data-id="{{$user->id}}" data-name="{{$user->name}}" data-email="{{$user->email}}" data-tempat_lahir="{{$user->tempat_lahir}}" data-tanggal_lahir="{{$user->tanggal_lahir}}" data-alamat="{{$user->alamat}}" data-kecamatan="{{$user->kecamatan}}" data-kelurahan="{{$user->kelurahan}}" data-nohp="{{$user->nohp}}" data-petani_verified="{{$user->petani_verified}}" data-jkel="{{$user->jkel}}" data-rt="{{$user->rt}}" data-rw="{{$user->rw}}" data-role="{{$user->role}}" data-href="{{ route('edit.manage-user', ['id' => $user->id]) }}" data-alamat_id="{{$user->alamat_id}}" data-pekerjaan="{{$user->pekerjaan}}">
                                    <i class=" kt-nav__link-icon flaticon2-settings"></i>
                                    <span class="kt-nav__link-text">Edit</span>
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
                        </span>
                        <span class="kt-widget__desc" id="email">
                        </span>
                      </div>
                    </div>
                    <div class="kt-widget__body widget-detail">
                      <div class="kt-widget__item">
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Pekerjaan :</span>
                          <span class="kt-widget__data" id="pekerjaan"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Tempat lahir :</span>
                          <span class="kt-widget__data" id="tempat_lahir"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Tanggal lahir :</span>
                          <span class="kt-widget__data" id="tanggal_lahir"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Jenis Kelamin :</span>
                          <span class="kt-widget__data" id="jkel"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">No. Telephone :</span>
                          <span class="kt-widget__data" id="nohp"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Alamat :</span>
                          <span class="kt-widget__data" id="alamat"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Provinsi :</span>
                          <span class="kt-widget__data">Sulawesi Selatan</span>
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
                          <span class="kt-widget__label">RT :</span>
                          <span class="kt-widget__data" id="rt"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">RW :</span>
                          <span class="kt-widget__data" id="rw"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Jenis User :</span>
                          <span class="kt-widget__data" id="role"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Status :</span>
                          <span class="kt-widget__data" id="petani_verified"></span>
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

      <!-- modal edit admin -->
      <div class="modal modal-edit fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-user-cog"></i>
            </span>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              <form id="edit-user-form" action="" method="POST">
                @csrf
                <input type="hidden" value="PUT" name="_method">
                <div class="kt-scroll ps ps--active-y" data-scroll="true" data-height="500" style="height: 500px; overflow: hidden;">
                  <div class="container">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Nama Lengkap :</label>
                          <div class="kt-input-icon">
                            <input type="text" id="names" class="form-control" aria-describedby="nama" name="name" required>
                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-user"></i></span></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Email :</label>
                          <div class="kt-input-icon">
                            <input type="email" id="emails" class="form-control" placeholder="Email" aria-describedby="email" disabled="" name="email" required>
                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-envelope"></i></span></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Tempat lahir :</label>
                          <div class="kt-input-icon">
                            <input type="text" id="tempat_lahirs" class="form-control" placeholder="Tempat" aria-describedby="email" name="tempat_lahir" required>
                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-map-pin"></i></span></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Tanggal lahir :</label>
                          <div class="kt-input-icon">
                            <input class="form-control" type="date" id="tanggal_lahirs" name="tanggal_lahir" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Pekerjaan :</label>
                      <div class="kt-input-icon">
                        <input type="text" id="pekerjaans" class="form-control" name="pekerjaan" required>
                        <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-map-marked-alt"></i></span></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Alamat Lengkap :</label>
                      <div class="kt-input-icon">
                        <input type="text" id="alamats" class="form-control" name="alamat_lengkap" required>
                        <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-map-marked-alt"></i></span></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Provinsi :</label>
                      <div class="kt-input-icon">
                        <input type="text" id="provinsis" class="form-control" value="Sulawesi Selatan" aria-describedby="email" required readonly>
                        <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-map-marked-alt"></i></span></span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Kota :</label>
                          <select class="form-control" id="kotas" name="kota_id">
                            @foreach ($kota as $kotas)
                            <option value="{{$kotas->id}}">
                              {{$kotas->tipe}} {{$kotas->nama_kota}}
                            </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Kecamatan :</label>
                          <div class="kt-input-icon">
                            <input type="text" id="kecamatans" name="kecamatan" class="form-control" placeholder="Kecamatan" aria-describedby="email" required>
                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-map"></i></span></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Kelurahan / Desa :</label>
                          <div class="kt-input-icon">
                            <input type="text" id="kelurahans" class="form-control" placeholder="Kelurahan / Desa" aria-describedby="email" name="kelurahan" required>
                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-map-marker-alt "></i></span></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>No. telephone :</label>
                          <div class="kt-input-icon">
                            <input type="tel" id="nohps" class="form-control" placeholder="No. Telephone" aria-describedby="email" name="nohp" required>
                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-phone"></i></span></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Rukun Tetangga (RT) :</label>
                          <div class="kt-input-icon">
                            <input type="text" id="rts" class="form-control" aria-describedby="email" name="rt" required>
                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-map-marker"></i></span></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Rukun Warga (RW) :</label>
                          <div class="kt-input-icon">
                            <input type="text" id="rws" class="form-control" aria-describedby="email" name="rw" required>
                            <span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="fa fa-map-marker"></i></span></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-gr">
                          <label>Jenis Kelamin :</label>
                          <div class="kt-radio-inline">
                            <label class="kt-radio">
                              <input type="radio" id="L" name="jkel" value="L" required> Laki - laki
                              <span></span>
                            </label>
                            <label class="kt-radio">
                              <input type="radio" id="P" name="jkel" value="P" required> Perempuan
                              <span></span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-gr">
                          <label>Jenis User :</label>
                          <div class="kt-radio-inline">
                            <label class="kt-radio">
                              <input type="radio" id="konsumen" name="role" value="admin" required> Konsumen
                              <span></span>
                            </label>
                            <label class="kt-radio">
                              <input type="radio" id="petani" name="role" value="super admin" required> Petani
                              <span></span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="ps__rail-x" style="left: 0px; bottom: -365px;">
                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                  </div>
                  <div class="ps__rail-y" style="top: 365px; right: 0px; height: 201px;">
                    <div class="ps__thumb-y" tabindex="0" style="top: 130px; height: 71px;"></div>
                  </div>
                </div>
                <div class="row verif-form">
                  <div class="col-md-6">
                    <button type="button" class="btn close-modal" data-dismiss="modal" aria-label="Close">Cancel</button>
                  </div>

                  <div class="col-md-6">
                    <input type="submit" value="Simpan perubahan" class="btn btn-verif btn-flat">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal edit admin -->

    </div>
  </div>
</div>

<script>
  // modal detail
  $('#modal-detail-user').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var name = a.data('name')
    var email = a.data('email')
    var tempat_lahir = a.data('tempat_lahir')
    var tanggal_lahir = a.data('tanggal_lahir')
    var alamat = a.data('alamat')
    var kecamatan = a.data('kecamatan')
    var kelurahan = a.data('kelurahan')
    var pekerjaan = a.data('pekerjaan')
    var nohp = a.data('nohp')
    var petani_verified = a.data('petani_verified')
    if (petani_verified == 0) {
      var status = 'Belum terverifikasi';
    } else {
      var status = 'Terverifikasi';
    }
    var jkel = a.data('jkel')
    if (jkel == 'L') {
      var kelamin = 'Laki -laki';
    } else {
      var kelamin = 'Perempuan'
    }
    var rt = a.data('rt')
    var rw = a.data('rw')
    var role = a.data('role')

    var modal = $(this)
    modal.find('.modal-title').text('Detail ' + name)
    modal.find('.modal-body #name').text(name)
    modal.find('.modal-body #email').text(email)
    modal.find('.modal-body #tempat_lahir').text(tempat_lahir)
    modal.find('.modal-body #tanggal_lahir').text(tanggal_lahir)
    modal.find('.modal-body #alamat').text(alamat)
    modal.find('.modal-body #kecamatan').text(kecamatan)
    modal.find('.modal-body #kelurahan').text(kelurahan)
    modal.find('.modal-body #nohp').text(nohp)
    modal.find('.modal-body #petani_verified').text(status)
    modal.find('.modal-body #jkel').text(kelamin)
    modal.find('.modal-body #rt').text(rt)
    modal.find('.modal-body #rw').text(rw)
    modal.find('.modal-body #role').text(role)
    modal.find('.modal-body #pekerjaan').text(pekerjaan)
  })
  // modal detail

  // modal edit
  $('#modal-edit-user').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var href = a.data('href')
    var name = a.data('name')
    var email = a.data('email')
    var tempat_lahir = a.data('tempat_lahir')
    var tanggal_lahir = a.data('tanggal_lahir')
    var alamat = a.data('alamat')
    var alamat_id = a.data('alamat_id')
    var kecamatan = a.data('kecamatan')
    var kelurahan = a.data('kelurahan')
    var pekerjaan = a.data('pekerjaan')   
    var nohp = a.data('nohp')
    var petani_verified = a.data('petani_verified')
    if (petani_verified == 0) {
      var status = 'Belum terverifikasi';
    } else {
      var status = 'Terverifikasi';
    }
    var jkel = a.data('jkel')
    if (jkel == 'L') {
      var kelamin = 'Laki -laki';
    } else {
      var kelamin = 'Perempuan'
    }
    var rt = a.data('rt')
    var rw = a.data('rw')
    var role = a.data('role')

    var modal = $(this)
    if (jkel == 'L') {
      modal.find('.modal-body #L').attr('checked', true);
    } else {
      modal.find('.modal-body #P').attr('checked', true);
    }

    if (role == 'petani') {
      modal.find('.modal-body #petani').attr('checked', true);
    } else {
      modal.find('.modal-body #konsumen').attr('checked', true);
    }

    modal.find('.modal-title').text('Edit ' + name)
    modal.find('.modal-body #names').val(name)
    modal.find('.modal-body #emails').val(email)
    modal.find('.modal-body #tempat_lahirs').val(tempat_lahir)
    modal.find('.modal-body #tanggal_lahirs').val(tanggal_lahir)
    modal.find('.modal-body #alamats').val(alamat)
    modal.find('.modal-body #kotas').val(alamat_id)
    modal.find('.modal-body #kecamatans').val(kecamatan)
    modal.find('.modal-body #kelurahans').val(kelurahan)
    modal.find('.modal-body #nohps').val(nohp)
    modal.find('.modal-body #petani_verifieds').val(status)
    modal.find('.modal-body #rts').val(rt)
    modal.find('.modal-body #rws').val(rw)
    modal.find('.modal-body #roles').val(role)
    modal.find('.modal-body #edit-user-form').attr('action', href)
    modal.find('.modal-body #pekerjaans').val(pekerjaan)

  })
  // modal edit

  //Modal Verifikasi Akun User
  $('#modal-verif-user').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var href = a.data('href')
    var email = a.data('email')

    var modal = $(this)
    modal.find('.modal-body #verif-user-form').attr('action', href)
  })
  //End Modal Verifikasi Akun User
</script>

@endsection