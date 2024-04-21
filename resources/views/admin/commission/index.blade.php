<?php

use App\Models\Rtype;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Childrtype;
use App\Models\Patientreport;
?>
@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <b>Commission</b>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Commission</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- right column -->
      <div class="col-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
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
          <form action="{{route('admin.commission.list')}}" id="myForm" class="form-horizontal" method="get">
            @csrf
            <div class="box-body">
              <div class="form-group">
                <label for="doctor" class="col-sm-2 control-label">Doctors</label>
                <div class="col-sm-4">
                  <select name="doctor" id="doctor" class="custom-select form-control form-control-rounded" required>
                    <option value="">Select</option>
                    <option value="all" {{ request()->doctor == 'all' ? 'selected' : ''}}>All</option>
                    @foreach ($doctors as $doctor)
                    <option value="{{$doctor->id}}" {{ request()->doctor == $doctor->id ? 'selected' : ''}}>{{$doctor->name}}</option>
                    @endforeach
                  </select>
                  @if($errors->has('doctor'))
                  <div class="error text-danger">{{ $errors->first('doctor') }}</div>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="date_range" class="col-sm-2 control-label">Select date</label>
                <div class="col-sm-4">
                  <select name="date_range" id="date_range" class="custom-select form-control form-control-rounded" required>
                    <option value="">Select</option>
                    <option value="today" {{ request()->date_range == 'today' ? 'selected' : ''}}>Today</option>
                    <option value="yesterday" {{ request()->date_range == 'yesterday' ? 'selected' : ''}}>Yesterday</option>
                    <option value="this_week" {{ request()->date_range == 'this_week' ? 'selected' : ''}}>This Week</option>
                    <option value="this_month" {{ request()->date_range == 'this_month' ? 'selected' : ''}}>This Month</option>
                    <option value="custom_month" {{ request()->date_range == 'custom_month' ? 'selected' : ''}}>Custom Month</option>
                    <option value="custom_year" {{ request()->date_range == 'custom_year' ? 'selected' : ''}}>Custom Year</option>
                  </select>
                  @if($errors->has('date_range'))
                  <div class="error text-danger">{{ $errors->first('date_range') }}</div>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="doctor" class="col-sm-2 control-label">report</label>
                <div class="col-sm-4">
                  <select name="report" id="report" class="custom-select form-control form-control-rounded" required>
                    <option value="summary">Summary</option>
                    <option value="detail">Detail</option>
                  </select>
                  @if($errors->has('doctor'))
                  <div class="error text-danger">{{ $errors->first('doctor') }}</div>
                  @endif
                </div>
              </div>
              <div id="custom-dates" style="display: none;">
                <div class="form-group">
                  <label for="start_date" class="col-sm-2 control-label">Start Date:</label>
                  <div class="col-sm-4">
                    <input type="date" name="start_date" id="start_date" class="form-control border border-dark mb-2" value="{{ request()->start_date }}" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="end_date" class="col-sm-2 control-label">End Date:</label>
                  <div class="col-sm-4">
                    <input type="date" name="end_date" id="end_date" class="form-control border border-dark mb-2" value="{{ request()->end_date }}" autocomplete="off">
                  </div>
                </div>
              </div>
              <div id="custom-year" style="<?php echo (isset($_GET['select_year']) && $_GET['select_year'] != '') ? '' : 'display: none;' ?>">
                <div class="form-group">
                  <label for="select_year" class="col-sm-2 control-label">Select Financial Year</label>
                  <div class="col-sm-4">
                    <select name="select_year" id="select_year" class="custom-select form-control form-control-rounded">
                      <option value="">Select year</option>
                      @foreach ($f_years as $f_year)
                      <option value="{{$f_year->year}}" {{ request()->select_year == $f_year->year ? 'selected' : ''}}>{{$f_year->year}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-5 col-sm-5 control-label">
                  <button type="button" id="download_list" class="btn btn-success text-white px-5 mt-4">Export</button>
                  <a href="/admin/commission" class="btn btn-danger btn-round px-5 mt-4">Clear</a>
                  <!-- {!! Form::submit('Export', ['class'=>'btn btn-success text-white mt-1','style'=>'width:150px']) !!} -->
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </section>
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
    var form = document.getElementById('myForm');
    var button1 = document.getElementById('get_list');
    var button2 = document.getElementById('download_list');

    button2.addEventListener('click', function() {
      var selectValue = document.getElementById('date_range').value;
      var startDate = document.getElementById('start_date').value;
      var endDate = document.getElementById('end_date').value;
      var selectYear = document.getElementById('select_year').value;

      if (selectValue == 'custom_month') {
        if (startDate == '') {
          alert('Please! select start date');
          return true;
        }
        if (endDate == '') {
          alert('Please! select end date');
          return true;
        }
      }

      if (selectValue == 'custom_year') {
        if (selectYear == '') {
          alert('Please! select financial year');
          return true;
        }
      }

      // Change the form action for button 2
      form.action = "{{ route('admin.commission.download') }}";
      // Submit the form
      form.submit();
    });
  });
</script>
@endsection