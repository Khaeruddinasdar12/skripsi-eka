@extends('layouts.galungtemplate')

@section('content')

<div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
  <div class="kt-container col-md-8">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        Profile </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link">
          Edit Profile
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

<div class="kt-container col-md-8">
  <div class="row justify-content-center">
      <!-- alert section -->
      @include('admin.page.alert')
      <!-- end alert section -->

      <div class="card card-body">
              <form action="{{route('update.profile')}}" method="POST">
                @csrf
                <input type="hidden" value="PUT" name="_method">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label>Nama Lengkap</label>
                      <input type="text" class="form-control" placeholder="Masukkan nama lengkap" name="name" value="{{ Auth::guard('admin')->user()->name }}" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                        <div class="form-group ">
                          <label>Email</label>
                          <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label>Password Baru</label>
                      <input type="password" class="form-control" placeholder="passowrd baru" name="password">
                    </div>
                  </div>
                  <div class="col-md-6">
                        <div class="form-group ">
                          <label>Konfirmasi Password</label>
                          <input type="password" class="form-control" placeholder="konfirmasi password" name="password_confirmation">
                        </div>
                    </div>
                </div>
                
                  <div class="col-md-12">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Cancel</button>
                    <button type="submit" class="btn btn-success btn-flat btn-sm float-right" >Submit</button>
                  </div>
                  <br>
              </form>
            </div>
    </div>
  </div>

@endsection