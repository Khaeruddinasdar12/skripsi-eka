@extends('layouts.galungtemplate')

@section('content')

<div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
  <div class="kt-container ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        Gabah </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">
          Data Gabah
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
                Jumlah Data Gabah Keseluruhan
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
                  <img src="{{ asset('img/gabah.png') }}" alt="gabah" class="image-table-gabah">
                </span>
                <h3 class="kt-portlet__head-title">
                  Data Gabah
                </h3>
              </div>
              <div class="kt-portlet__head-toolbar">
                <form action="{{route('index.gabah')}}" method="get">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" @if(Request::get('search')=='' ) placeholder="cari" @else value="{{Request::get('search')}}" @endif>
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="submit">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
                <span class="border-right"></span>
                <div class="kt-portlet__head-actions">
                  <a href="#" class="btn btn-clean btn-icon btn-icon-md btn-tambah-data" data-toggle="modal" data-target="#modal-tambah-beras">
                    <i class="flaticon2-add"></i>
                  </a>
                </div>
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
                          <th>Nama / jenis Gabah</th>
                          <th>Harga</th>
                          <th>Admin Yang Menangani</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      @if ($jml == 0)
                      <tbody style="text-align: center;">
                        <td colspan="5">Belum ada data</td>
                      </tbody>
                      @else
                      <tbody>
                        @if($data->isEmpty())
                        <tr>
                          <td colspan="5" align="center">
                            Tidak ada data untuk pencarian "{{ Request::get('search') }}"
                          </td>
                        </tr>
                      </tbody>
                      @else
                      @php $no = 1; @endphp
                      @foreach ($data as $gabah)
                      <tr>
                        <th scope="row">{{$no++}}</th>
                        <td>{{$gabah -> nama}}</td>
                        <td>Rp.{{format_uang($gabah -> harga)}}</td>
                        <td>{{$gabah -> admins -> name}}</td>
                        <td>
                          <div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-default btn-icon btn-icon-md btn-sm btn-more-custom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="flaticon-more-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-table-custom fade" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-149px, 33px, 0px);">
                              <ul class="kt-nav">
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link edit-data" data-toggle="modal" data-target="#modal-edit-data" data-id="{{$gabah->id}}" data-nama="{{$gabah->nama}}" data-harga="{{$gabah->harga}}" data-admin_name="{{$gabah->admins->name}}" data-href="{{ route('update.gabah', ['id' => $gabah->id]) }}">
                                    <i class=" kt-nav__link-icon flaticon2-settings"></i>
                                    <span class="kt-nav__link-text">Edit Data</span>
                                  </a>
                                </li>
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link hapus-data" data-toggle="modal" data-target="#modal-hapus" data-id="{{$gabah->id}}" data-href="{{ route('delete.gabah', ['id' => $gabah->id]) }}">
                                    <i class="kt-nav__link-icon fa fa-trash-alt"></i>
                                    <span class="kt-nav__link-text">Hapus data</span>
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
      </div>

      <!-- modal tambah admin -->
      <div class="modal modal-add fade" id="modal-tambah-beras" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-user-plus"></i>
            </span>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Data Gabah</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('store.gabah') }}" method="POST">
                @csrf
                <input type="hidden" value="POST" name="_method">

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group ">
                      <label>Nama Gabah</label>
                      <input type="text" class="form-control" placeholder="Masukkan nama gabah" name="nama" id="generalSearch" required>
                    </div>

                    <div class="form-group ">
                      <label>Harga</label>
                      <input type="text" class="form-control" placeholder="Masukkan harga gabah" name="harga" id="rupiah" required>
                    </div>

                  </div>
                </div>

                <div class="row verif-form">
                  <div class="col-md-6">
                    <button type="button" class="btn close-modal" data-dismiss="modal" aria-label="Close">Cancel</button>
                  </div>

                  <div class="col-md-6">

                    <input type="submit" value="Tambah Data" class="btn btn-verif btn-flat">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal tambah admin -->

      <!-- modal edit data -->
      <div class="modal modal-edit fade" id="modal-edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-user-plus"></i>
            </span>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="POST" id="edit-beras">
                @csrf
                <input type="hidden" value="PUT" name="_method">

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group ">
                      <label>Nama Gabah</label>
                      <input type="text" class="form-control" name="nama" id="namas" required>
                    </div>

                    <div class="form-group ">
                      <label>Harga</label>
                      <input type="text" class="form-control" name="harga" id="hargas" required>
                    </div>
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
      <!-- end modal edit data -->

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
  // modal edit
  $('#modal-edit-data').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var nama = a.data('nama')
    var harga = a.data('harga')
    var admin_name = a.data('admin_name')
    var href = a.data('href')

    var modal = $(this)
    modal.find('.modal-title').text('Edit Gabah ' + nama)
    modal.find('.modal-body #namas').val(nama)
    modal.find('.modal-body #hargas').val(harga)
    modal.find('.modal-body #admin_names').val(admin_name)
    modal.find('.modal-body #edit-beras').attr('action', href)
  })
  // modal edit

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