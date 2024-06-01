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
    <li class="{{ (request()->segment(2) == 'report_types') ? 'active' : '' }}"><a href="/admin/report_types"><i class="fa fa-file"></i> <span>Report Category</span></a></li>
    <li class="{{ (request()->segment(2) == 'child_report_types') ? 'active' : '' }}"><a href="/admin/child_report_types"><i class="fa fa-file-text"></i> <span>Sub Report Category</span></a></li>
    <li class="{{ (request()->segment(2) == 'short_code') ? 'active' : '' }}"><a href="/admin/short_code"><i class="fa fa-ambulance"></i> <span>Short-code</span></a></li>
    <!-- <li class="{{ (request()->segment(2) == 'financial_year') ? 'active' : '' }}"><a href="/admin/financial_year"><i class="fa fa-dashboard"></i> <span>Financial year</span></a></li> -->
    <li class="{{ (request()->segment(2) == 'backup') ? 'active' : '' }}"><a href="/admin/backup"><i class="fa fa-hdd-o"></i> <span>Backup</span></a></li>
    <li class="{{ (request()->segment(2) == 'commission') ? 'active' : '' }}"><a href="/admin/commission"><i class="fa fa-file-text-o"></i> <span>Commission report</span></a></li>
    <li class="{{ (request()->segment(2) == 'slip') ? 'active' : '' }}"><a href="/admin/slip"><i class="fa fa-file-excel-o"></i> <span>Edit Slip</span></a></li>
    <li class="{{ (request()->segment(2) == 'slip-summary') ? 'active' : '' }}"><a href="/admin/slip-summary"><i class="fa fa-file-pdf-o"></i> <span>Summary Slip</span></a></li>
    <li class="{{ (request()->segment(2) == 'flowup') ? 'active' : '' }}"><a href="/admin/flowup"><i class="fa fa-file-text"></i> <span>Follow Up</span></a></li>
    <li class="{{ (request()->segment(2) == 'investigation') ? 'active' : '' }}"><a href="/admin/investigation"><i class="fa fa-file-text"></i> <span>Investigation Report</span></a></li>
    <!-- <li class="{{ (request()->segment(1) == 'profile') ? 'active' : '' }}"><a href="/profile/{{Session::get('user')['id']}}"><i class="fa fa-dashboard"></i><span>Change password</span></a></li> -->
  </ul>
</section>