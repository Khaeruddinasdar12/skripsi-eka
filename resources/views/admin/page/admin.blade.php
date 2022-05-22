@extends('layouts.galungtemplate')

@section('content')

<div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
  <div class="kt-container ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        Manage Admin </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="{{ route('index.manage-admin') }}" class="kt-subheader__breadcrumbs-link">
          Manage Admin
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
                Jumlah Admin Keseluruhan
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
                  Data Admin
                </h3>
              </div>
              <div class="kt-portlet__head-toolbar">
                <form action="{{route('index.manage-admin')}}" method="get">
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
                  <a href="#" class="btn btn-clean btn-icon btn-icon-md btn-tambah-data" data-toggle="modal" data-target="#modal-tambah-admin">
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
                          <th>Nama</th>
                          <th>Email</th>
                          <th>Role</th>
                          @if(Auth::guard('admin')->user()->role == 'superadmin')
                          <th>Action</th>
                          @endif
                        </tr>
                      </thead>
                      @if ($jml == 0)
                      <tbody style="text-align: center;">
                        <td colspan="5">Belum ada data</td>
                      </tbody>
                      @else
                      <tbody>
                        @if($admin->isEmpty())
                        <tr>
                          <td colspan="5" align="center">
                            Tidak ada data untuk pencarian "{{ Request::get('search') }}"
                          </td>
                        </tr>
                      </tbody>
                      @else

                      @php $no = 1; @endphp
                      @foreach ($admin as $datas)
                      <tr>
                        <th scope="row">{{$no++}}</th>
                        <td>{{$datas -> name}}</td>
                        <td>{{$datas -> email}}</td>
                        <td>{{$datas -> role}}</td>
                        @if(Auth::guard('admin')->user()->role == 'superadmin')
                        <td>
                          <div class="dropdown dropdown-inline">
                            <a href="#" class="btn btn-default btn-icon btn-icon-md btn-sm btn-more-custom" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="flaticon-more-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-table-custom fade" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-149px, 33px, 0px);">
                              <ul class="kt-nav">
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link edit-data" data-toggle="modal" data-target="#modal-edit-admin" data-nama="{{$datas->name}}" data-email="{{$datas->email}}" data-role="{{$datas->role}}" data-href="{{ route('update.manage-admin', ['id' => $datas->id]) }}">
                                    <i class="kt-nav__link-icon flaticon2-settings"></i>
                                    <span class="kt-nav__link-text">Edit</span>
                                  </a>
                                </li>
                                <li class="kt-nav__item">
                                  <a href="#" class="kt-nav__link hapus-data" data-toggle="modal" data-target="#modal-hapus" data-id="{{$datas->id}}" data-href="{{ route('delete.manage-admin', ['id' => $datas->id]) }}">
                                    <i class="kt-nav__link-icon flaticon2-rubbish-bin-delete-button"></i>
                                    <span class="kt-nav__link-text">Hapus</span>
                                  </a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </td>
                        @endif
                      </tr>
                      @endforeach
                      </tbody>
                      @endif
                      @endif
                    </table>
                    {{$admin->links()}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- modal tambah admin -->
      <div class="modal modal-add fade" id="modal-tambah-admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-user-plus"></i>
            </span>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Data Admin</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('store.manage-admin') }}" method="POST" id="add-admin">
                @csrf
                <input type="hidden" value="POST" name="_method">

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <i class="flaticon-avatar kt-font-brand"></i></span></div>
                    <input type="text" class="form-control" placeholder="Nama Admin" name="name" aria-describedby="nama" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-email kt-font-brand"></i></span></div>
                    <input type="email" class="form-control" placeholder="Email" name="email" aria-describedby="email" required>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" id="password1"><i class="flaticon2-lock kt-font-brand"></i></span></div>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password" aria-describedby="password1" required>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text" id="password2"><i class="flaticon2-lock kt-font-brand"></i></span></div>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="ulangi password" id="pass2" aria-describedby="password2" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Role :</label>
                  <div class="col-md-6">
                    <div class="kt-checkbox-inline">
                      <label class="kt-radio kt-radio--bold kt-radio--success mr-4">
                        <input type="radio" name="role" value="admin" checked required> Admin
                        <span></span>
                      </label>
                      <label class="kt-radio kt-radio--bold kt-radio--success">
                        <input type="radio" name="role" value="super admin" required> Super Admin
                        <span></span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="button-add">
                  <button type="submit" class="btn btn-add">Tambah data</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal tambah admin -->

      <!-- modal edit admin -->
      <div class="modal modal-edit fade" id="modal-edit-admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <span class="modal-icon">
              <i class="fa fa-user-cog"></i>
            </span>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data Admin</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              <form id="form-edit" method="post">
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">
                        <i class="flaticon-avatar kt-font-brand"></i></span></div>
                    <input type="text" class="form-control" placeholder="Nama Admin" aria-describedby="nama" id="nama" name="name" required>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text" ><i class="flaticon2-email kt-font-brand"></i></span></div>
                    <input type="email" class="form-control" placeholder="Email" aria-describedby="email" id="email" disabled="">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-2 col-form-label">Role :</label>
                  <div class="col-md-6">
                    <div class="kt-checkbox-inline">
                      <label class="kt-radio kt-radio--bold kt-radio--success mr-4">
                        <input type="radio" name="role" value="admin" id="roleadmin" required> Admin
                        <span></span>
                      </label>
                      <label class="kt-radio kt-radio--bold kt-radio--success">
                        <input type="radio" name="role" value="superadmin" id="rolesuperadmin" required> Super Admin
                        <span></span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="button-edit">
                  <button type="submit" class="btn btn-edit">Ubah data</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal edit admin -->

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
  //Modal hapus
  $('#modal-hapus').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var href = a.data('href')

    var modal = $(this)
    modal.find('.modal-body #hapus-data').attr('action', href)
  })
  //End Modal hapus


  $('#modal-edit-admin').on('show.bs.modal', function(event) {
    var a = $(event.relatedTarget)
    var href = a.data('href')
    var nama = a.data('nama')
    var email = a.data('email')
    var role = a.data('role')

    var modal = $(this)

    if(role == 'admin') {
      modal.find('.modal-body #roleadmin').attr('checked', true)
    } else {
      modal.find('.modal-body #rolesuperadmin').attr('checked', true)
    }
    modal.find('.modal-body #form-edit').attr('action', href)
    modal.find('.modal-body #nama').val(nama)
    modal.find('.modal-body #email').val(email)
  })
</script>

@endsection