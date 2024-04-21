@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="display: flex; align-items: center;">
    <h1 style="margin-left: 10px;">
      <b>Backup / Financial Slips</b>
    </h1>
    <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
      <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Backup / Financial Slips</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">

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

      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Backup</h3>
          </div>
          <div class="box-body">
            <div class="box box-info">
              <form action="{{route('admin.backup.download')}}" id="myForm" class="form-horizontal" name="" method="post">
                @csrf
                <div class="box-body">
                  <div class="form-group">
                    <label for="date_range" class="col-sm-2 control-label">Export</label>
                    <div class="col-sm-8">
                      <select name="date_range" id="date_range" class="custom-select form-control form-control-rounded" required>
                        <option value="">Select</option>
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                        <option value="custom_month">Custom Month</option>
                        <option value="custom_year">Custom Year</option>
                      </select>
                      @if($errors->has('date_range'))
                      <div class="error text-danger">{{ $errors->first('date_range') }}</div>
                      @endif
                    </div>
                  </div>
                  <div id="custom-dates" style="display: none;">
                    <div class="form-group">
                      <label for="start_date" class="col-sm-2 control-label">Start Date:</label>
                      <div class="col-sm-8">
                        <input type="date" name="start_date" id="start_date" class="form-control border border-dark mb-2" autocomplete="off">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="end_date" class="col-sm-2 control-label">End Date:</label>
                      <div class="col-sm-8">
                        <input type="date" name="end_date" id="end_date" class="form-control border border-dark mb-2" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div id="custom-year" style="display: none;">
                    <div class="form-group">
                      <label for="select_year" class="col-sm-2 control-label">Select Financial Year</label>
                      <div class="col-sm-8">
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
                    <div class="col-md-8 col-sm-3 control-label">
                      {!! Form::submit('Export', ['class'=>'btn btn-success text-white mt-1','style'=>'width:150px']) !!}
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Slips</h3>
          </div>
          <div class="box-body">
            <div class="box box-info">
              <form action="{{route('admin.year-slip.download')}}" id="mySlipForm" class="form-horizontal" method="post">
                @csrf
                <div class="box-body">
                  <div class="form-group">
                    <label for="select_year" class="col-sm-4 control-label">Select Financial Year</label>
                    <div class="col-sm-8">
                      <select name="select_year" id="select_year" class="custom-select form-control form-control-rounded" required>
                        <option value="">Select financial year</option>
                        @foreach ($f_years as $f_year)
                        <option value="{{$f_year->year}}">{{$f_year->year}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-8 col-sm-3 control-label">
                      <button type="button" id="get_list" class="btn btn-success text-white px-5 mt-4">PDF</button>
                      <button type="button" id="download_list" class="btn btn-success text-white px-5 mt-4">Zip</button>
                    </div>
                  </div>
                </div>
              </form>
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
<script>
  document.getElementById('date_range').addEventListener('change', function() {
    var selectedValue = this.value;
    if (selectedValue === 'custom_month') {
      document.getElementById('custom-dates').style.display = 'block';
      document.getElementById('custom-year').style.display = 'none';
    } else if (selectedValue === 'custom_year') {
      document.getElementById('custom-year').style.display = 'block';
      document.getElementById('custom-dates').style.display = 'none';
    } else {
      document.getElementById('custom-dates').style.display = 'none';
      document.getElementById('custom-year').style.display = 'none';
    }
  });
  document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('mySlipForm');
    var button1 = document.getElementById('get_list');
    var button2 = document.getElementById('download_list');

    button1.addEventListener('click', function() {
      // Change the form action for button 1
      form.action = "{{ route('admin.year-slip-pdf.download') }}";
      // Submit the form
      form.submit();
    });

    button2.addEventListener('click', function() {
      // Change the form action for button 2
      form.action = "{{ route('admin.year-slip.download') }}";
      // Submit the form
      form.submit();
    });
  });
</script>
@endsection