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
            <select name="financial_year" id="financial_year" class="custom-select form-control form-control-rounded" onchange="return this.form.submit();">
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