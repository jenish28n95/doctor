<?php

use App\Models\Financialyear;

$f_years = Financialyear::orderBy('id', 'ASC')->get();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/AdminLTE.css')}}">

  <link rel="stylesheet" href="{{asset('css/skins/_all-skins.min.css')}}">

  <link rel="stylesheet" href="{{asset('css/googlefont.css')}}">

  <script src="{{asset('js/jquery.min.js')}}"></script>

  <link rel="stylesheet" href="{{asset('/bower_components/datatables.net-bs/css/bootstrap-datetimepicker.min.css')}}">
  <style>
    .boldclass {
      font-weight: bold;
    }

    .read-more-show {
      cursor: pointer;
      color: #ed8323;
    }

    .read-more-hide {
      cursor: pointer;
      color: #ed8323;
    }

    .hide_content {
      display: none;
    }

    .error {
      color: red;
    }

    .ck-editor__editable[role="textbox"] {
      /* editing area */
      min-height: 200px;
    }

    .ck-content .image {
      /* block images */
      max-width: 80%;
      margin: 20px auto;
    }

    /* Dropdown Menu */
    .dropdown-menu {
      border: 0px solid rgba(0, 0, 0, .15);
      -webkit-box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08) !important;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08) !important;
      font-size: 15px;
      background-color: #000;
      color: #ffffff;
    }

    .dropdown-menu ul {
      margin-top: 0px;
    }

    .dropdown-divider {
      margin: 0;
      border-top: 1px solid rgba(255, 255, 255, 0.14);
    }

    .dropdown-item {
      padding: .70rem 1.5rem;
      color: #ffffff;
    }

    .dropdown-item:hover {
      padding: .70rem 1.5rem;
      background-color: #000;
      color: #ffffff;
    }

    .dropdown-item.active,
    .dropdown-item:active {
      color: #fff;
      text-decoration: none;
      background-color: #000000;
    }

    .dropdown-toggle-nocaret:after {
      display: none
    }

    /* User Details */
    .user-profile img {
      width: 25px;
      height: 25px;
      border-radius: 50%;
      box-shadow: 0 16px 38px -12px rgba(0, 0, 0, .56), 0 4px 25px 0 rgba(0, 0, 0, .12), 0 8px 10px -5px rgba(0, 0, 0, .2);
    }

    .user-details .media .avatar img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
    }

    .user-details .media .media-body .user-title {
      font-size: 14px;
      color: #000;
      font-weight: 600;
      margin-bottom: 2px;
    }

    .user-details .media .media-body .user-subtitle {
      font-size: 13px;
      color: #232323;
      margin-bottom: 0;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>

  @yield('style')

</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    @include('includes.header')
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      @include('includes.sidebar')
      <!-- /.sidebar -->
    </aside>

    @yield('content')

    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->


  <!-- form submit when change select option -->
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'csrftoken': '{{ csrf_token() }}'
      }
    });
  </script>

  <script type="text/javascript">
    document.getElementById('financial_year').addEventListener('change', function() {
      document.getElementById('change_f_year').submit();
    });
  </script>

  <script>
    // Wait for the document to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
      var successMessage = document.getElementById('successMessage');

      if (successMessage) {
        setTimeout(function() {
          successMessage.style.display = 'none';
        }, 5000); // 5 seconds in milliseconds
      }
    });
  </script>

  <script type="text/javascript">
    $('.read-more-content').addClass('hide_content')
    $('.read-more-show, .read-more-hide').removeClass('hide_content')

    // Set up the toggle effect:
    $('.read-more-show').on('click', function(e) {
      $(this).next('.read-more-content').removeClass('hide_content');
      $(this).addClass('hide_content');
      e.preventDefault();
    });

    // Changes contributed by @diego-rzg
    $('.read-more-hide').on('click', function(e) {
      var p = $(this).parent('.read-more-content');
      p.addClass('hide_content');
      p.prev('.read-more-show').removeClass('hide_content'); // Hide only the preceding "Read More"
      e.preventDefault();
    });
  </script>

  <!-- jQuery 3 -->
  <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <!-- Morris.js charts -->
  <!-- <script src="{{asset('bower_components/raphael/raphael.min.js')}}"></script> -->
  <!-- <script src="{{asset('bower_components/morris.js/morris.min.js')}}"></script> -->
  <!-- Sparkline -->
  <!-- <script src="{{asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script> -->
  <!-- jvectormap -->
  <script src="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
  <script src="{{asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{asset('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{asset('bower_components/moment/min/moment.min.js')}}"></script>
  <script src="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <!-- datepicker -->
  <script src="{{asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
  <!-- DataTables -->
  <script src="{{asset('/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
  <!-- Slimscroll -->
  <script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
  <!-- FastClick -->
  <script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('js/adminlte.min.js')}}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="{{asset('js/pages/dashboard.js')}}"></script> -->
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('js/demo.js')}}"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script> -->

  <script src="{{asset('js/jquery.validate.min.js')}}"></script>

  <!-- datepicker -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
  <script src="{{asset('js/moment.min.js')}}"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script> -->
  <script src="{{asset('/bower_components/datatables.net/js/bootstrap-datetimepicker.min.js')}}"></script>


  @yield('script')
</body>

</html>