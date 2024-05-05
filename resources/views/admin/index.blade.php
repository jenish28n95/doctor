@extends('layouts.admin')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <b>Dashboard</b>
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{$docotr_count}}</h3>

            <p>Doctors</p>
          </div>
          <div class="icon">
            <i class="fa fa-check-square-o"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{$today_patient_count}}</h3>

            <p>Today Patients</p>
          </div>
          <div class="icon">
            <i class="fa fa-arrow-circle-right"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-navy">
          <div class="inner">
            <h3>{{$current_month_patient_count}}</h3>

            <p>Current Month Patients</p>
          </div>
          <div class="icon">
            <i class="fa fa-arrow-circle-right"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{$total_patient_count}}</h3>

            <p>Current Finacial year Patients</p>
          </div>
          <div class="icon">
            <i class="fa fa-arrow-circle-right"></i>
          </div>
          <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->

    </div>
    <!-- /.row -->

    <div class="row" style="margin-top:30px">
      <div class="col-lg-6 col-xs-6">
        <form action="/admin/dashboard" class="form-horizontal" method="get">
          @csrf
          <select name="custom_month" id="custom_month" class="custom-select form-control form-control-rounded" onchange="return this.form.submit();">
            <option value="">Select month</option>
            @foreach ($monthlist as $month)
            <option value="{{ $month['month'] }}-{{ $month['year'] }}">{{$month['month']}}-{{$month['year']}}</option>
            @endforeach
          </select>
        </form>
        <center>
          <h4><b><?= isset(request()->custom_month) ? request()->custom_month : $monthlist[0]['month'] . '-' . $monthlist[0]['year'] ?></b></h4>
        </center>
        <canvas id="dayPatientsChart" width="400" height="200" style="background-color: #f0f0f0;"></canvas>
      </div>
      <!-- ./col -->

      <div class="col-lg-6 col-xs-6">
        <canvas id="monthPatientsChart" width="400" height="200" style="background-color: #f0f0f0;"></canvas>
      </div>
      <!-- ./col -->

    </div>

    <div class="row" style="margin-top:30px">
      <div class="col-lg-12 col-xs-12">
        <canvas id="reportsChart" width="400" height="200" style="background-color: #f0f0f0;"></canvas>
      </div>

    </div>

  </section>
  <!-- /.content -->
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  var dates = <?php echo json_encode($dates); ?>;
  var patientNumbers = <?php echo json_encode($patientNumbers); ?>;

  var ctx = document.getElementById('dayPatientsChart').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: dates,
      datasets: [{
        label: 'Number of Patients',
        data: patientNumbers,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          title: {
            display: true,
            text: 'Number of Patients'
          },
          ticks: {
            beginAtZero: true
          }
        },
        x: {
          title: {
            display: true,
            text: 'Current Month Dates'
          }
        }
      }
    }
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
<script>
  var ctx = document.getElementById('reportsChart').getContext('2d');
  var months = <?php echo json_encode($months); ?>;
  var sonographyNumbers = <?php echo json_encode($sonographyNumbers); ?>;
  var xrayNumbers = <?php echo json_encode($xrayNumbers); ?>;
  var dopplerNumbers = <?php echo json_encode($dopplerNumbers); ?>;

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: months,
      datasets: [{
        label: 'Sonography',
        data: sonographyNumbers,
        backgroundColor: 'rgba(255, 99, 132,0.2)',
        borderColor: 'rgb(255, 99, 132)',
        borderWidth: 1
      }, {
        label: 'X-ray',
        data: xrayNumbers,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }, {
        label: 'Color Doppler',
        data: dopplerNumbers,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgb(75, 192, 192)',
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