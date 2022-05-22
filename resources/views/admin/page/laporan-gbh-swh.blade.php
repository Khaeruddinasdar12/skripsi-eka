@extends('layouts.galungtemplate')

@section('content')

<div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
  <div class="kt-container ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        Laporan </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="{{route('index.laporan')}}" class="kt-subheader__breadcrumbs-link">
          Laporan
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
    <!-- alert section -->
    @include('admin.page.alert')
    <!-- end alert section -->
    <div class="col-md-12">

      <div data-notify="container" class="alert alert-success m-alert animated bounce alert-win" role="alert" data-notify-position="top-center" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 10000; top: 100px; left: 0px; right: 0px; animation-iteration-count: 1;">
        <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 100002;" data-notify="dismiss" data-dismiss="alert" aria-label="Close"></button>
        <span data-notify="message">Tekan tombol Reload terlebih dahulu sebelum convert PDF atau Excel !!</span>
        <a href="#" target="_blank" data-notify="url"></a>
      </div>

      <div class="kt-portlet admin-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
              <i class="fa fa-file-signature"></i>
            </span>
            <h3 class="kt-portlet__head-title">
              Laporan Keuangan Gadai {{$bulan}} {{Request::get('tahun')}}
            </h3>
          </div>

          <div class="kt-portlet__head-toolbar action">
            <form accept="{{route('index.laporan2')}}" method="get">
              <select class="form-control-sm" name="jumlah">
                <option value="100" @if(Request::get('jumlah')=='100' ) {{"selected"}} @endif>100</option>
                <option value="50" @if(Request::get('jumlah')=='50' ) {{"selected"}} @endif>50</option>
                <option value="10" @if(Request::get('jumlah')=='10' ) {{"selected"}} @endif>10</option>
              </select>
              <select class="form-control-sm" name="tahun">
                <option value="">pilih tahun</option>
                @foreach($tahun as $tahuns)
                <option value="{{$tahuns->year}}" @if(Request::get('tahun')==$tahuns->year) {{"selected"}} @endif > {{$tahuns->year}} </option>
                @endforeach
              </select>
              <select class="form-control-sm" name="bulan">
                <option value="">pilih bulan</option>
                <option value="1" @if(Request::get('bulan')=='1' ) {{"selected"}} @endif>Januari</option>
                <option value="2" @if(Request::get('bulan')=='2' ) {{"selected"}} @endif>Februari</option>
                <option value="3" @if(Request::get('bulan')=='3' ) {{"selected"}} @endif>Maret</option>
                <option value="4" @if(Request::get('bulan')=='4' ) {{"selected"}} @endif>April</option>
                <option value="5" @if(Request::get('bulan')=='5' ) {{"selected"}} @endif>Mei</option>
                <option value="6" @if(Request::get('bulan')=='6' ) {{"selected"}} @endif>Juni</option>
                <option value="7" @if(Request::get('bulan')=='7' ) {{"selected"}} @endif>Juli</option>
                <option value="8" @if(Request::get('bulan')=='8' ) {{"selected"}} @endif>Agustus</option>
                <option value="9" @if(Request::get('bulan')=='9' ) {{"selected"}} @endif>September</option>
                <option value="10" @if(Request::get('bulan')=='10' ) {{"selected"}} @endif>Oktober</option>
                <option value="11" @if(Request::get('bulan')=='11' ) {{"selected"}} @endif>November</option>
                <option value="12" @if(Request::get('bulan')=='12' ) {{"selected"}} @endif>Desember</option>
              </select>

              <span class="border-right"></span>

              <button type="submit" class="reload-laporan">
                <i class="fas fa-sync-alt"></i>
              </button>
            </form>

            <span class="border-right"></span>

            <div class="dropdown dropdown-inline">

              <button type="button" class="btn btn-clean btn-icon download-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-cloud-download-alt"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(39px, 39px, 0px);">
                <ul class="kt-nav">
                  <li class="kt-nav__item">
                    <div>
                      <form class="kt-nav__link" action="{{route('index.laporan2')}}" method="get">
                        <input type="hidden" name="bulan" value="{{Request::get('bulan')}}">
                        <input type="hidden" name="transaksi" value="{{Request::get('transaksi')}}">
                        <input type="hidden" name="tahun" value="{{Request::get('tahun')}}">
                        <input type="hidden" name="jenis" value="pdf">
                        <button>
                          <i class="kt-nav__link-icon fas fa-file-pdf"></i>
                          <span class="kt-nav__link-text">PDF</span>
                        </button>
                      </form>
                    </div>
                  </li>
                  <li class="kt-nav__item">
                    <div>
                      <form class="kt-nav__link" action="{{route('index.laporan2')}}" method="get">
                        <input type="hidden" name="bulan" value="{{Request::get('bulan')}}">
                        <input type="hidden" name="transaksi" value="{{Request::get('transaksi')}}">
                        <input type="hidden" name="tahun" value="{{Request::get('tahun')}}">
                        <input type="hidden" name="jenis" value="excel">
                        <button>
                          <i class="kt-nav__link-icon fas fa-file-excel"></i>
                          <span class="kt-nav__link-text">Excel</span>
                        </button>
                      </form>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>

        </div>
        <div class="kt-portlet__body">
              <div class="kt-section">
                <div class="kt-section__content">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Pemohon</th>
                          <th>Jenis</th>
                          <th>Luas Lahan</th>
                          <th>Periode</th>
                          <th>Harga</th>
                        </tr>
                      </thead>

                      <tbody>
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
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

      </div>
    </div>
  </div>
</div>
@endsection