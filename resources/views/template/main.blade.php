<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title') | KADABRA RAGNO</title>
  <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" >
  <link href="{{asset('css/ruang-admin.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/datatables/button/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
  <style type="text/css">
    @media screen and (max-width: 600px) {
      #sidebarToggleTop{
        visibility: visible !important;
      }
    }

    #sidebarToggleTop{
      visibility: hidden;
    }

    #chartSummary {
      width: 100%;
      height: 380px;
    }

    #chartNewRegistrant{
      width: 100%;
      height: 380px;
    }

    #chartDaily{
      width: 100%;
      height: 300px;
    }

    #chartRoa{
      width: 100%;
      height: 300px;
    }

    #chartRoaLastDay{
      width: 100%;
      height: 380px;
    }

    .custom-control-label{
      font-size: 12px !important; 
    }

    div.dt-buttons {
      clear: both;
    }

    .title-dashboard{
      font-weight: bold;
      font-size: 26px !important;
    }

    #chartPrefix {
      width: 100%;
      height: 500px;
      max-width: 100%;
    }

    #chartASN {
      width: 100%;
      height: 500px;
      max-width: 100%;
    }

  </style>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-PWKW5F8');</script>
  <!-- End Google Tag Manager -->
</head>

<body id="page-top">
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PWKW5F8"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div id="wrapper">
    @include('template.header')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
         <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown no-arrow mx-1">
           <a class="d-lg-inline text-white small" href="{{$kadabra_url}}">Go To Kadabra</a>
           ||
           <a class="d-lg-inline text-white small" href="{{route('login')}}">Sign In</a>
         </li>
       </ul>
     </nav>
     <!-- Topbar -->

     <!-- Container Fluid-->
     <div class="container-fluid" id="container-wrapper">
      @yield('content')
    </div>
    <!---Container Fluid-->
  </div>
  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; <script> document.write(new Date().getFullYear()); </script> - Delivered by <b><a href="{{$kadabra_url}}">KADABRA</a></b>. Powered by <b><a href="https://idnic.net/">IDNIC</a></b>
        </span>
      </div>
    </div>
  </footer>
  <!-- Footer -->
</div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('js/ruang-admin.min.js')}}"></script>
<script src="{{asset('vendor/amchart/core.js')}}"></script>
<script src="{{asset('vendor/amchart/charts.js')}}"></script>
<script src="{{asset('vendor/amchart/plugins/forceDirected.js')}}"></script>
<script src="{{asset('vendor/amchart/themes/animated.js')}}"></script>
<script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
  let APP_URL = '{{$app_url}}';
  let API_URL = '{{$api_ris_url}}';
  let WS_URL = '{{$websocket_url}}';
</script>
@yield('userScript')
</body>

</html>