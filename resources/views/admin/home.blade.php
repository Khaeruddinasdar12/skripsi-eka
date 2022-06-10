@extends('layouts.galungtemplate')

@section('content')

<div class="jumbotron jumbotron-fluid">
  <div class="kt-container">
    <div class="kt-subheader subheader-custom kt-grid__item" id="kt_subheader">
      <div class="kt-container ">
        <div class="kt-subheader__main">
          <h1 class="display-4">Dashboard</h1>
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
  </div>
</div>



<div class="kt-container">

  <!-- card data transaksi & gadai -->
  <div class="row content-dashboard">
    <div class="col-md-7">
      <div class="kt-portlet card-transaksi">
        <div class="kt-portlet__body">
          <h3>Data Transaksi Barang</h3>
          <div class="kt-widget5">
            <div class="kt-widget5__item">
              <div class="kt-widget5__content">
                <div class="kt-widget5__pic">
                  <img class="kt-widget7__img" src="{{ asset('img/card/transaksi-gabah.jpg') }}" alt="transaksi">
                </div>
                <div class="kt-widget5__section">
                  <p class="kt-widget5__title">
                    Jumlah Transaksi Barang <br> Yang Belum Di Verifikasi (pembeli telah mengirim bukti pembayaran)
                  </p>
                </div>
              </div>
              <div class="kt-widget5__content">
                <div class="kt-widget5__stats">
                  <span class="kt-widget5__number">{{$jmltr}} Data</span>
                </div>
                <div class="kt-widget5__stats">
                  <span class="kt-widget5__number">
                    <a href="{{-- route('index.transaksi') --}}" class="btn-label-brand btn btn-sm btn-bold">Lihat Transaksi</a>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="kt-portlet card-gadai">
        <div class="kt-portlet__body">
          <h3>Data Lahan</h3>
          <div class="kt-widget4">
            <a href="{{-- route('daftar.gadaisawah.skripsi') --}}" class="kt-widget4__item">
              <div class="kt-widget4__pic kt-widget4__pic--logo">
                <img src="{{ asset('img/card/sawah.jpg') }}" alt="gadai-sawah">
              </div>
              <div class="kt-widget4__info">
                <p class="kt-widget4__title">
                  Pengajuan Gadai
                </p>
                <p class="kt-widget4__text">
                  Lihat Detail
                </p>
              </div>
              <span class="kt-widget4__number kt-font-brand">{{ $jmlgs }} Data</span>
            </a>
            <a href="{{-- route('daftar.modaltanam.skripsi') --}}" class="kt-widget4__item">
              <div class="kt-widget4__pic kt-widget4__pic--logo">
                <img src="{{ asset('img/card/tanam.jpg') }}" alt="modal-tanam">
              </div>
              <div class="kt-widget4__info">
                <p class="kt-widget4__title">
                  Pengajuan Modal Tanam
                </p>
                <p class="kt-widget4__text">
                  Lihat Detail
                </p>
              </div>
              <span class="kt-widget4__number kt-font-brand">{{ $jmlmt }} Data</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end card data transaksi & gadai -->

</div>




<script>
  $(document).ready(function() {
    $('.loop').owlCarousel({
      center: true,
      items: 2,
      nav: true,
      loop: true,
      margin: 10,
      responsive: {
        0: {
          items: 2
        },
        600: {
          items: 4
        }
      }
    });
  });

  "use strict";
  // Class definition
  var chart = function() {

    var datapenjualan = function() {
      // PIE CHART
      new Morris.Donut({
        element: 'penjualan',
        data: [{
            label: "Transaksi Pupuk",
            value: '{{$rpupuk}}'
          },
          {
            label: "Transaksi Beras",
            value: '{{$rberas}}'
          },
          {
            label: "Transaksi Alat",
            value: '{{$ralat}}'
          },
          {
            label: "Transaksi Bibit",
            value: '{{$rbibit}}'
          }
        ],
        colors: ['#5a9ec0', '#00a5cf', '#5cc28a', '#6bca71', '#25a18e']
      });
    }

    return {
      // public functions
      init: function() {
        datapenjualan();
      }
    };
  }();

  jQuery(document).ready(function() {
    chart.init();
  });
</script>

@endsection