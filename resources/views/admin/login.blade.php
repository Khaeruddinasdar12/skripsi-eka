<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->

<head>
  <base href="../../../">
  <meta charset="utf-8" />
  <title>SayurQita</title>
  <meta name="description" content="Login page example">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!--begin::Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">

  <!--end::Fonts -->

  <!--begin::Page Custom Styles(used by this page) -->
  <link href="{{ asset('assets/css/pages/login/login-6.css') }}" rel="stylesheet" type="text/css" />

  <!--end::Page Custom Styles -->

  <!--begin::Global Theme Styles(used by all pages) -->
  <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/galung.css') }}" rel="stylesheet" type="text/css" />
  <!--end::Global Theme Styles -->

  <!--begin::Layout Skins(used by all pages) -->

  <!--end::Layout Skins -->
  <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--left kt-aside--fixed kt-page--loading">

  <!-- begin::Page loader -->

  <!-- end::Page Loader -->

  <!-- begin:: Page -->
  <div class="kt-grid kt-grid--ver kt-grid--root kt-page">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
      <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

        <div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content login-bg">
          <div class="kt-login__section">
            <div class="kt-login__block">
              <img src="{{ asset('logo-putih.png') }}" alt="logo sayurqita" class="img-fluid kt-login__title logogalung">
            </div>
          </div>
        </div>

        <div class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside">
          <div class="kt-login__wrapper">
            <div class="kt-login__container">
              <div class="kt-login__body">
                <div class="kt-login__signin">
                  <div class="kt-login__head hello">
                    <h1 class="kt-login__title">Hello,</h1>
                    <h1 class="kt-login__title">Selamat datang</h1>
                  </div>
                  <div class="kt-login__form">

                    <form class="kt-form" method="POST" action="{{ route($loginRoute) }}">
                      @csrf
                      <div class="form-group">
                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="off">
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                      </div>

                      <div class="form-group">
                        <input class="form-control form-control-last{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" placeholder="Password" name="password">
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                      </div>

                      <div class="kt-login__extra">
                        <label class="kt-checkbox">
                          <input type="checkbox" name="remember"> Remember me
                          <span></span>
                        </label>
                        <a href="javascript:;" id="kt_login_forgot">Forget Password ?</a>
                      </div>
                      <div class="kt-login__actions">
                        <button type=submit class="btn btn-brand btn-pill btn-elevate btn-galung-login">Sign In</button>
                      </div>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- end:: Page -->

  <!-- begin::Global Config(global config for global JS sciprts) -->
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
  <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/js/scripts.bundle.js') }}" type="text/javascript"></script>

  <!--end::Global Theme Bundle -->

  <!--begin::Page Scripts(used by this page) -->
  <script src="{{ asset('assets/js/pages/custom/login/login-general.js') }}" type="text/javascript"></script>

  <!--end::Page Scripts -->
</body>

<!-- end::Body -->

</html>