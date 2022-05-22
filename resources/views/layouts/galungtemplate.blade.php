<!DOCTYPE html>

<html lang="en">

<!--begin::Head-->

<head>
  <base href="">
  <meta charset="utf-8" />
  <title>SayurQita | Admin</title>
  <meta name="description" content="Updates and statistics" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link href="{{ asset('css/galung.css') }}" rel="stylesheet" type="text/css" />

  <script src="{{ asset('js/jquery-3.4.1.min.js') }}" type="text/javascript"></script>
  <script src=" {{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
  <!--begin::Fonts-->
  <!-- metronic -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
  <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- metronic -->
</head>

<!--end::Head-->

<!--begin::Body-->

<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--left kt-aside--fixed kt-page--loading">

  <div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
      <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

        @include('layouts.navbar')

        <div id="main" style="height: 100%; margin-top:30px;">
          @yield('content')
        </div>

        <footer>
          @include('layouts.footer')
        </footer>
      </div>
    </div>
  </div>

  <!--begin::Global Config(global config for global JS scripts)-->
  <script>
    var KTAppOptions = {
      "colors": {
        "state": {
          "brand": "#591df1",
          "light": "#ffffff",
          "dark": "#282a3c",
          "primary": "#5867dd",
          "success": "#34bfa3",
          "info": "#36a3f7",
          "warning": "#ffb822",
          "danger": "#fd3995"
        },
        "base": {
          "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
          "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
        }
      }
    };
  </script>

  <!-- end::Global Config -->
  <!--begin::Global Theme Bundle(used by all pages) -->
  <script src=" {{ asset('assets/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/js/scripts.bundle.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/owl.carousel.min.js') }}" type="text/javascript"></script>
  <!--begin::Page Vendors(used by this page) -->
  <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
  <script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
  <script src="{{ asset('assets/plugins/custom/gmaps/gmaps.js') }}" type="text/javascript"></script>
  <!--end::Page Vendors -->
  <!--begin::Page Scripts(used by this page) -->
  <script src="{{ asset('assets/js/pages/dashboard.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/js/pages/components/extended/bootstrap-notify.js') }}" type="text/javascript"></script>
  <!-- metronic -->

  <script>
    $(document).ready(function() {
      $('#add-admin').validate({
        rules: {
          password_confirmation: {
            equalTo: "#password"
          }
        },
        messages: {
          password_confirmation: {
            equalTo: "<p>Password yang Anda Masukan Tidak Sama</p>"
          }
        }
      });
    });
  </script>

  <!--end::Page Scripts-->
</body>

<!--end::Body-->

</html>