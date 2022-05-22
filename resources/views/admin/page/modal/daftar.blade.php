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
          Belum Diverifikasi
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
                Jumlah Data Modal Tanam Yang Belum Terverifikasi
              </h5>
              <h4 class=" mt-3" style="font-weight: 800;">
                {{$jml}} Data
              </h4>

            </div>
          </div>
        </div>

        <!-- table -->
        <div class="col-md-10">
          <div class="kt-portlet admin-portlet">
            <div class="kt-portlet__head">
              <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                  <img src="{{ asset('img/modaltanam.png') }}" alt="modal tanam" class="image-table-modaltanam">
                </span>
                <h3 class="kt-portlet__head-title">
                  Data Modal Tanam Yang Belum Diverifikasi
                </h3>
              </div>
              <div class="kt-portlet__head-toolbar">
                <form action="{{route('daftar.modaltanam.skripsi')}}" method="get">
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
                          <th>Kode</th>
                          <th>Nama Pemohon</th>
                          <th>Jenis Bibit</th>
                          <th>Jenis Pupuk</th>
                          <th>Foto KTP</th>
                          <th>Sertifikat Tanah</th>
                          <th>Surat Pajak</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      @if ($jml == 0)
                      <tbody style="text-align: center;">
                        <td colspan="10">Belum ada data</td>
                      </tbody>
                      @else
                      <tbody>
                        @if($data->isEmpty())
                        <tr>
                          <td colspan="10" align="center">
                            Tidak ada data untuk pencarian "{{ Request::get('search') }}"
                          </td>
                        </tr>
                      </tbody>
                      @else

                      @php $no = 1; @endphp
                      @foreach ($data as $datas)
                      <tr>
                        <th scope="row">{{$no++}}</th>
                        <td>{{$datas->kode}}</td>
                        <td>{{$datas->users->name}}</td>
                        <td>{{$datas->jenis_bibit}}</td>
                        <td>{{$datas->jenis_pupuk}}</td>
                        <td><a href="{{asset('storage/'.$datas->users->foto_ktp)}}"><img src="{{asset('storage/'.$datas->users->foto_ktp)}}" width="90px" height="90px"></a></td>
                        <td><a href="{{asset('storage/'.$datas->sertifikat_tanah)}}"><img src="{{asset('storage/'.$datas->sertifikat_tanah)}}" width="90px" height="90px"></a></td>
                        <td><a href="{{asset('storage/'.$datas->surat_pajak)}}"><img src="{{asset('storage/'.$datas->surat_pajak)}}" width="90px" height="90px"></a></td>
                        <td>
                          <div class="btn btn-bold btn-sm btn-font-sm  btn-label-danger" style="font-size: 14px;">
                            Belum Terverifikasi
                          </div>
                        </td>
                        <td>
                          <div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-default btn-icon btn-icon-md btn-sm btn-more-custom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="flaticon-more-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-table-custom fade" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-149px, 33px, 0px);">
                              <ul class="kt-nav">
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link detail-data" data-toggle="modal" data-target="#modal-detail-user" data-id="{{$datas->id}}" data-name="{{$datas->users->name}}" data-email="{{$datas->users->email}}" data-nohp="{{$datas->users->nohp}}" data-keterangan="{{$datas->keterangan}}" data-kecamatan="{{$datas->kecamatan}}" data-kelurahan="{{$datas->kelurahan}}" data-alamat="{{$datas->alamat}}" data-luas_sawah="{{$datas->luas_lahan}}" data-titik_koordinat="{{$datas->titik_koordinat}}" data-jenis_bibit="{{$datas->jenis_bibit}}" data-jenis_pupuk="{{$datas->jenis_pupuk}}">
                                    <i class="kt-nav__link-icon flaticon2-indent-dots"></i>
                                    <span class="kt-nav__link-text">Detail</span>
                                  </a>
                                </li>
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link verif-data" data-toggle="modal" data-target="#modal-verif-gadai" data-id="{{$datas->id}}" data-name="{{$datas->users->name}}" data-keterangan="{{$datas->keterangan}}" data-href="{{ route('gadaistatus.modaltanam.skripsi', ['id' => $datas->id]) }}">
                                    <i class="kt-nav__link-icon flaticon2-check-mark"></i>
                                    <span class="kt-nav__link-text">Verifikasi</span>
                                  </a>
                                </li>
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link hapus-data" data-toggle="modal" data-target="#modal-hapus" data-id="{{$datas->id}}" data-href="{{ route('batalkan.modaltanam.skripsi', ['id' => $datas->id]) }}">
                                    <i class="kt-nav__link-icon fa fa-trash-alt"></i>
                                    <span class="kt-nav__link-text">Hapus Data</span>
                                  </a>
                                </li>
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
        <!-- end table -->
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
                          <span class="kt-widget__label">Titik Koordinat Lahan :</span>
                          <span class="kt-widget__data" id="titik_koordinat"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Provinsi :</span>
                          <span class="kt-widget__data">Sulawesi Selatan</span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Jenis Bibit :</span>
                          <span class="kt-widget__data" id="jenis_bibit"></span>
                        </div>
                        <div class="kt-widget__contact">
                          <span class="kt-widget__label">Jenis Pupuk :</span>
                          <span class="kt-widget__data" id="jenis_pupuk"></span>
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
                          <span class="kt-widget__data">Belum Terverifikasi</span>
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
      <div class="modal modal-verif fade" id="modal-verif-gadai" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-info"></i>
            </span>

            <div class="modal-body">
              <form action="" method="POST" id="verif-gadai-form">
                @csrf
                <input type="hidden" value="PUT" name="_method">
                <h3>Verifikasi Modal Tanam?</h3>
                <p>Pastikan sawah yang akan di verifikasi</p>
                <p>telah di survei terlebih dahulu</p>



                <div class="form-group">

                  <label for="exampleTextarea">Tambahkan keterangan :</label>
                  <textarea class="form-control" id="keterangans" name="keterangan" rows="3" style="margin-top: 0px; margin-bottom: 0px; height: 97px; resize: none" required></textarea>
                </div>

                <div class="row verif-form">
                  <div class="col-md-6">
                    <button type="button" class="btn close-modal" data-dismiss="modal" aria-label="Close">Cancel</button>
                  </div>

                  <div class="col-md-6">

                    <input type="submit" value="Verifikasi" class="btn btn-verif btn-flat">
                  </div>
                </div>
            </div>
            </form>
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
                <input type="hidden" value="PUT" name="_method">
                <div class="form-group">
                  <label for="exampleTextarea">Tambahkan keterangan :</label>
                  <textarea class="form-control" name="keterangan" rows="3" style="margin-top: 0px; margin-bottom: 0px; height: 97px; resize: none" required>Mohon maaf sawah Anda tidak memenuhi kriteria sistem.</textarea>
                </div>
                <div class="row verif-form">
                  <div class="col-md-6">
                    <button type="button" class="btn close-modal" data-dismiss="modal" aria-label="Close">Cancel</button>
                  </div>

                  <div class="col-md-6">
                    @csrf
                    <input type="submit" value="Submit" class="btn btn-verif btn-flat">
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

<script>
  // modal detail
  $('#modal-detail-user').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var email = a.data('email')
    var nohp = a.data('nohp')
    var jenis_bibit = a.data('jenis_bibit')
    var jenis_pupuk = a.data('jenis_pupuk')
    var keterangan = a.data('keterangan')
    var titik_koordinat = a.data('titik_koordinat')
    var kecamatan = a.data('kecamatan')
    var kelurahan = a.data('kelurahan')
    var alamat = a.data('alamat')
    var luas_sawah = a.data('luas_sawah')
    var jenis_bibit = a.data('jenis_bibit')
    var jenis_pupuk = a.data('jenis_pupuk')
    var periode_tanam = a.data('periode_tanam')
    var kota = a.data('kota')
    var name = a.data('name')
    var maps = 'https://www.google.com/maps/?q='

    var modal = $(this)
    modal.find('.modal-title').text('Detail ' + name)
    modal.find('.modal-body #email').text(email)
    modal.find('.modal-body #nohp').text(nohp)
    modal.find('.modal-body #name').text(name)
    modal.find('.modal-body #jenis_bibit').text(jenis_bibit)
    modal.find('.modal-body #jenis_pupuk').text(jenis_pupuk)
    modal.find('.modal-body #luas_sawah').text(luas_sawah)
    modal.find('.modal-body #jenis_bibit').text(jenis_bibit)
    modal.find('.modal-body #jenis_pupuk').text(jenis_pupuk)
    modal.find('.modal-body #periode_tanam').text(periode_tanam)
    modal.find('.modal-body #titik_koordinat').html('<a target="_blank" href="'+maps+titik_koordinat+'">Lihat maps</a>')
    modal.find('.modal-body #kota').text(kota)
    modal.find('.modal-body #kecamatan').text(kecamatan)
    modal.find('.modal-body #kelurahan').text(kelurahan)
    modal.find('.modal-body #alamat').text(alamat)
    modal.find('.modal-body #keterangan').text(keterangan)
  })
  // modal detail

  //Modal Verifikasi gadai
  $('#modal-verif-gadai').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var keterangan = a.data('keterangan')
    var href = a.data('href')

    var modal = $(this)
    modal.find('.modal-body #keterangans').text(keterangan)
    modal.find('.modal-body #verif-gadai-form').attr('action', href)
  })
  //End Modal Verifikasi gadai

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