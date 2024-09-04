<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/images/favicon.ico')}}">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">

  <style>
    .login-page {
      background:linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
      url("{{asset('/images/admin-backgrond.jpg')}}");
      /* background-image: url("{{asset('/images/admin-backgrond.jpg')}}"); */
      background-repeat: no-repeat;
      background-position: center;
      /* Center the image */
      background-size: cover;
      overflow-y: hidden;
    }

    .login-logo b {
      color: #fff;
    }
  </style>

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
  <link rel="stylesheet" href="{{asset('css/font-custom.css')}}">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>Admin</b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      @if (\Session::has('alert'))
      <div class="alert alert-danger">
        {!! \Session::get('alert') !!}
      </div>
      @endif
      <form action="{{route('login')}}" method="POST">
        @csrf
        <div class="form-group has-feedback">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
          <span class="fa fa-eye form-control-feedback"></span>
          <div class="input-group-append">
            <div class="input-group-text">
              <input type="checkbox" id="showPasswordCheckbox">
              <label class="input-group-text" for="showPasswordCheckbox">Show Password</label>
            </div>
          </div>
        </div>
        <div class="row">

          <!-- /.col -->
          <div class="col-xs-6">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 3 -->
  <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

  <script>
    document.getElementById("showPasswordCheckbox").addEventListener("change", function() {
      var passwordInput = document.getElementById("password");
      var checkbox = document.getElementById("showPasswordCheckbox");

      if (checkbox.checked) {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    });
  </script>

</body>

</html>