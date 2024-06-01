@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="display: flex; align-items: center;">
    <h1 style="margin-left: 10px;">
      <b>Investigation Report</b>
    </h1>
    <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
      <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Investigation Report</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header" style="padding:5px">
            @if (session('success'))
            <div id="successMessage" class="alert pl-3 pt-2 pb-2" style="background-color:green;color:white">
              {{ session('success') }}
            </div>
            @endif
            @if (session('error'))
            <div id="successMessage" class="alert pl-3 pt-2 pb-2" style="background-color:red;color:white">
              {{ session('error') }}
            </div>
            @endif
          </div>
          <div class="box-body" style="overflow-x:auto;">
            <form action="{{route('admin.investigation-download.report')}}" id="myInvestigationForm" class="form-horizontal" method="post">
              @csrf
              <div class="box-body">
                <div class="form-group">
                  <label for="select_year" class="col-sm-2 control-label">Select</label>
                  <div class="col-sm-6">
                    <select name="date_range" id="date_range" class="custom-select form-control form-control-rounded" required>
                      <option value="">Select</option>
                      <!-- <option value="on_date">On Day</option>
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option> -->
                      <option value="month">Month</option>
                      <option value="custom_month">Custom Month</option>
                      <option value="custom_year">Custom Year</option>
                    </select>
                  </div>
                </div>
                <div id="custom-on-date" style="display: none;">
                  <div class="form-group">
                    <label for="on_date" class="col-sm-2 control-label">Select Date:</label>
                    <div class="col-sm-6">
                      <input type="date" name="on_date" id="on_date" class="form-control border border-dark mb-2" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div id="custom-month" style="display: none;">
                  <div class="form-group">
                    <label for="custom_month_dropdown" class="col-sm-2 control-label">Select Month:</label>
                    <div class="col-sm-6">
                      <select name="custom_month_dropdown" id="custom_month_dropdown" class="custom-select form-control form-control-rounded">
                        @foreach ($monthlist as $month)
                        <option value="{{ $month['month'] }}-{{ $month['year'] }}">{{$month['month']}}-{{$month['year']}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div id="custom-dates" style="display: none;">
                  <div class="form-group">
                    <label for="start_date" class="col-sm-2 control-label">Start Date:</label>
                    <div class="col-sm-6">
                      <input type="date" name="start_date" id="start_date" class="form-control border border-dark mb-2" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="end_date" class="col-sm-2 control-label">End Date:</label>
                    <div class="col-sm-6">
                      <input type="date" name="end_date" id="end_date" class="form-control border border-dark mb-2" autocomplete="off">
                    </div>
                  </div>
                </div>
                <div id="custom-year" style="display: none;">
                  <div class="form-group">
                    <label for="select_year" class="col-sm-2 control-label">Select Financial Year</label>
                    <div class="col-sm-6">
                      <select name="select_year" id="select_year" class="custom-select form-control form-control-rounded">
                        <option value="">Select year</option>
                        @foreach ($f_years as $f_year)
                        <option value="{{$f_year->year}}">{{$f_year->year}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-4 col-sm-3 control-label">
                    <button type="button" id="get_list" class="btn btn-success text-white px-5 mt-4">View</button>
                    <button type="button" id="download_list" class="btn btn-success text-white px-5 mt-4">Download</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="row" style="margin-top:10px">
              <div class="col-md-4">
              </div>
              <div class="col-md-4" style="margin-bottom:20px">
                {!! Form::open(['method'=>'GET', 'action'=> 'AdminController@investigation','class'=>'form-horizontal']) !!}
                @csrf
                <select name="ref_doctor" id="ref_doctor" class="custom-select form-control form-control-rounded" onchange="return this.form.submit();">
                  <option value="all" {{ request()->ref_doctor == 'all' ? 'selected' : ''}}>Select Refrence doctors</option>
                  @foreach($doctors as $doctor)
                  <option value="{{$doctor->id}}" {{ request()->ref_doctor == $doctor->id ? 'selected' : '' }}>{{$doctor->name}}{{isset($doctor->degree) ? '-'.$doctor->degree : ''}}</option>
                  @endforeach
                </select>
                {!! Form::close() !!}
              </div>
              <div class="col-md-4">
              </div>
              <canvas id="monthPatientsChart" width="400" height="100" style="background-color: #B5EFF0;"></canvas>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.getElementById('date_range').addEventListener('change', function() {
    var selectedValue = this.value;

    if (selectedValue === 'custom_month') {
      document.getElementById('custom-dates').style.display = 'block';
      document.getElementById('custom-on-date').style.display = 'none';
      document.getElementById('custom-year').style.display = 'none';
      document.getElementById('custom-month').style.display = 'none';
    } else if (selectedValue === 'custom_year') {
      document.getElementById('custom-year').style.display = 'block';
      document.getElementById('custom-on-date').style.display = 'none';
      document.getElementById('custom-dates').style.display = 'none';
      document.getElementById('custom-month').style.display = 'none';
    } else if (selectedValue === 'month') {
      document.getElementById('custom-month').style.display = 'block';
      document.getElementById('custom-on-date').style.display = 'none';
      document.getElementById('custom-dates').style.display = 'none';
      document.getElementById('custom-year').style.display = 'none';
    } else if (selectedValue === 'on_date') {
      document.getElementById('custom-on-date').style.display = 'block';
      document.getElementById('custom-month').style.display = 'none';
      document.getElementById('custom-dates').style.display = 'none';
      document.getElementById('custom-year').style.display = 'none';
    } else {
      document.getElementById('custom-on-date').style.display = 'none';
      document.getElementById('custom-dates').style.display = 'none';
      document.getElementById('custom-year').style.display = 'none';
      document.getElementById('custom-month').style.display = 'none';
    }
  });
  document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('myInvestigationForm');
    var button1 = document.getElementById('get_list');
    var button2 = document.getElementById('download_list');

    button1.addEventListener('click', function() {
      // Change the form action for button 1
      form.action = "{{ route('admin.investigation-pdf.report') }}";
      // Submit the form
      form.submit();
    });

    button2.addEventListener('click', function() {
      // Change the form action for button 2
      form.action = "{{ route('admin.investigation-download.report') }}";
      // Submit the form
      form.submit();
    });
  });
</script>
<script>
  var ctx = document.getElementById('monthPatientsChart').getContext('2d');
  var months = <?php echo json_encode($months); ?>;
  var monthPatientNumbers = <?php echo json_encode($monthpatientNumbers); ?>;

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: months,
      datasets: [{
        label: 'Number of Patients',
        data: monthPatientNumbers,
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Number of Patients'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Months'
          }
        }
      }
    }
  });
</script>
@endsection