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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('css/skins/_all-skins.min.css')}}">

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
  <link rel="stylesheet" href="{{asset('css/googlefont.css')}}">


  <!-- trinymce  -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
  <script src="{{asset('js/jquery.min.js')}}"></script>

  <!-- <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script> -->
  <!-- <script>
    $(function() {
      CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
        toolbar: {
          items: [
            'exportPDF', 'exportWord', '|',
            'findAndReplace', 'selectAll', '|',
            'heading', '|',
            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
            'bulletedList', 'numberedList', 'todoList', '|',
            'outdent', 'indent', '|',
            'undo', 'redo',
            '-',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
            'alignment', '|',
            'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
            'textPartLanguage', '|',
            'sourceEditing'
          ],
          shouldNotGroupWhenFull: true
        },
        // language: 'es',
        list: {
          properties: {
            styles: true,
            startIndex: true,
            reversed: true
          }
        },
        heading: {
          options: [{
              model: 'paragraph',
              title: 'Paragraph',
              class: 'ck-heading_paragraph'
            },
            {
              model: 'heading1',
              view: 'h1',
              title: 'Heading 1',
              class: 'ck-heading_heading1'
            },
            {
              model: 'heading2',
              view: 'h2',
              title: 'Heading 2',
              class: 'ck-heading_heading2'
            },
            {
              model: 'heading3',
              view: 'h3',
              title: 'Heading 3',
              class: 'ck-heading_heading3'
            },
            {
              model: 'heading4',
              view: 'h4',
              title: 'Heading 4',
              class: 'ck-heading_heading4'
            },
            {
              model: 'heading5',
              view: 'h5',
              title: 'Heading 5',
              class: 'ck-heading_heading5'
            },
            {
              model: 'heading6',
              view: 'h6',
              title: 'Heading 6',
              class: 'ck-heading_heading6'
            }
          ]
        },
        placeholder: 'Welcome to CKEditor 5!',
        fontFamily: {
          options: [
            'default',
            'Arial, Helvetica, sans-serif',
            'Courier New, Courier, monospace',
            'Georgia, serif',
            'Lucida Sans Unicode, Lucida Grande, sans-serif',
            'Tahoma, Geneva, sans-serif',
            'Times New Roman, Times, serif',
            'Trebuchet MS, Helvetica, sans-serif',
            'Verdana, Geneva, sans-serif'
          ],
          supportAllValues: true
        },
        fontSize: {
          options: [10, 12, 14, 'default', 18, 20, 22],
          supportAllValues: true
        },
        htmlSupport: {
          allow: [{
            name: /.*/,
            attributes: true,
            classes: true,
            styles: true
          }]
        },

        htmlEmbed: {
          showPreviews: true
        },
        link: {
          decorators: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://',
            toggleDownloadable: {
              mode: 'manual',
              label: 'Downloadable',
              attributes: {
                download: 'file'
              }
            }
          }
        },
        mention: {
          feeds: [{
            marker: '@',
            feed: [
              '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
              '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
              '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
              '@sugar', '@sweet', '@topping', '@wafer'
            ],
            minimumCharacters: 1
          }]
        },

        removePlugins: [
          // 'ExportPdf',
          // 'ExportWord',
          'CKBox',
          'CKFinder',
          'EasyImage',
          // 'Base64UploadAdapter',
          'RealTimeCollaborativeComments',
          'RealTimeCollaborativeTrackChanges',
          'RealTimeCollaborativeRevisionHistory',
          'PresenceList',
          'Comments',
          'TrackChanges',
          'TrackChangesData',
          'RevisionHistory',
          'Pagination',
          'WProofreader',
          'MathType'
        ]
      });
    });
  </script> -->



  <!-- datepicker -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"> -->
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

    <header class="main-header">
      <!-- Logo -->
      <a href="/admin/dashboard" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>P</b>RA</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Pramukh</b></span>
        @if(Session::has('setfinancialyear'))
        {{Session::get('setfinancialyear')}}
        @endif
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        @if(Session::has('setfinancialyear'))
        <span style="color:#fff">{{Session::get('setfinancialyear')}}</span>
        @endif
        <div class="navbar-custom-menu">

          <ul class="nav navbar-nav align-items-center right-nav-link">
            <li class="btn-success">
              <form action="{{route('admin.change.f_year')}}" id="change_f_year" class="form-horizontal" method="post">
                @csrf
                <select name="financial_year" id="financial_year" class="custom-select form-control form-control-rounded" onchange="return this.submit();">
                  @foreach ($f_years as $f_year)
                  <option value="{{$f_year->year}}" {{ Session::get('setfinancialyear') == $f_year->year ? 'selected' : ''}}>{{$f_year->year}}</option>
                  @endforeach
                </select>
              </form>
            </li>
            <li class="btn-success"></li>
            <li class="btn-success"><a href="/admin/today-backup">Today Backup</a></li>
            <li class="nav-item">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                <span class="user-profile"><img src="{{asset('/images/user-icone.png')}}" class="img-circle" alt="user avatar"></span>
                <span class="hidden-xs">{{Session::get('user')['name']}}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <a href="/admin/financial_year">
                  <li class="dropdown-item"><i class="icon-settings mr-2"></i>Financial year</li>
                </a>
                <li class="dropdown-divider"></li>
                <a href="/admin/setting">
                  <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
                </a>
                <li class="dropdown-divider"></li>
                <a href="/profile/{{Session::get('user')['id']}}">
                  <li class="dropdown-item"><i class="icon-settings mr-2"></i> Change Password</li>
                </a>
                <li class="dropdown-divider"></li>
                <a href="/logout">
                  <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li>
                </a>
              </ul>
            </li>
          </ul>

        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{asset('/images/user-icone.png')}}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            @if(Session::has('user'))
            <p>{{Session::get('user')['name']}}</p>
            @else
            <p>Alexander Pierce</p>
            @endif
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li class="{{ (request()->segment(2) == 'dashboard') ? 'active' : '' }}"><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class="{{ (request()->segment(2) == 'doctors') ? 'active' : '' }}"><a href="/admin/doctors"><i class="fa fa-user-md"></i> <span>Doctors</span></a></li>
          <li class="{{ (request()->segment(2) == 'patients') ? 'active' : '' }}"><a href="/admin/patients"><i class="fa fa-wheelchair"></i> <span>Patients</span></a></li>
          <li class="{{ (request()->segment(2) == 'report_types') ? 'active' : '' }}"><a href="/admin/report_types"><i class="fa fa-ambulance"></i> <span>Report Types</span></a></li>
          <li class="{{ (request()->segment(2) == 'child_report_types') ? 'active' : '' }}"><a href="/admin/child_report_types"><i class="fa fa-ambulance"></i> <span>Child Report Types</span></a></li>
          <li class="{{ (request()->segment(2) == 'short_code') ? 'active' : '' }}"><a href="/admin/short_code"><i class="fa fa-ambulance"></i> <span>Short-code</span></a></li>
          <!-- <li class="{{ (request()->segment(2) == 'financial_year') ? 'active' : '' }}"><a href="/admin/financial_year"><i class="fa fa-dashboard"></i> <span>Financial year</span></a></li> -->
          <li class="{{ (request()->segment(2) == 'backup') ? 'active' : '' }}"><a href="/admin/backup"><i class="fa fa-hdd-o"></i> <span>Backup</span></a></li>
          <li class="{{ (request()->segment(2) == 'commission') ? 'active' : '' }}"><a href="/admin/commission"><i class="fa fa-file"></i> <span>Commission report</span></a></li>
          <!-- <li class="{{ (request()->segment(2) == 'setting') ? 'active' : '' }}"><a href="/admin/setting"><i class="fa fa-dashboard"></i> <span>Setting</span></a></li> -->
          <!-- <li class="{{ (request()->segment(1) == 'profile') ? 'active' : '' }}"><a href="/profile/{{Session::get('user')['id']}}"><i class="fa fa-dashboard"></i><span>Change password</span></a></li> -->
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

    @yield('content')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Create the tabs -->
      <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
          <h3 class="control-sidebar-heading">Recent Activity</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                  <p>Will be 23 on April 24th</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-user bg-yellow"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                  <p>New phone +1(800)555-1234</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                  <p>nora@example.com</p>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-file-code-o bg-green"></i>

                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                  <p>Execution time 5 seconds</p>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

          <h3 class="control-sidebar-heading">Tasks Progress</h3>
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Custom Template Design
                  <span class="label label-danger pull-right">70%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Update Resume
                  <span class="label label-success pull-right">95%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Laravel Integration
                  <span class="label label-warning pull-right">50%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">
                <h4 class="control-sidebar-subheading">
                  Back End Framework
                  <span class="label label-primary pull-right">68%</span>
                </h4>

                <div class="progress progress-xxs">
                  <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                </div>
              </a>
            </li>
          </ul>
          <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
          <form method="post">
            <h3 class="control-sidebar-heading">General Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Report panel usage
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Some information about this general settings option
              </p>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Allow mail redirect
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Other sets of options are available
              </p>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Expose author name in posts
                <input type="checkbox" class="pull-right" checked>
              </label>

              <p>
                Allow the user to show his name in blog posts
              </p>
            </div>
            <!-- /.form-group -->

            <h3 class="control-sidebar-heading">Chat Settings</h3>

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Show me as online
                <input type="checkbox" class="pull-right" checked>
              </label>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Turn off notifications
                <input type="checkbox" class="pull-right">
              </label>
            </div>
            <!-- /.form-group -->

            <div class="form-group">
              <label class="control-sidebar-subheading">
                Delete chat history
                <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
              </label>
            </div>
            <!-- /.form-group -->
          </form>
        </div>
        <!-- /.tab-pane -->
      </div>
    </aside>
    <!-- /.control-sidebar -->
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