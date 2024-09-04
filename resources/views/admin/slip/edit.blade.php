<?php

use App\Models\Patient;

?>

@extends('layouts.admin')

@section('style')
<!-- <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet"> -->
<link href="{{asset('css/jquery-ui.css')}}" rel="stylesheet">
<style>
  input[type="date"]::-webkit-calendar-picker-indicator {
    display: none;
  }

  .ui-datepicker .ui-datepicker-prev,
  .ui-datepicker .ui-datepicker-next {
    background-color: blanchedalmond;
  }
</style>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="display: flex; align-items: center;">
    <h1 style="margin-left: 10px;">
      <b>Slips Edit</b>
    </h1>
    <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
      <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Slips edit</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">

    <div class="box box-info">
      <div class="box-body">

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

        {!! Form::open(['method'=>'GET', 'action'=> 'AdminSlipsController@index','files'=>true,'class'=>'form-horizontal', 'name'=> 'addpatientform']) !!}
        @csrf

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="date" class="col-sm-4 control-label">Date</label>
              <div class="col-sm-7">
                <input type="date" name="selectdate" id="selectdate" value="{{ isset(request()->selectdate) ? request()->selectdate : date('Y-m-d') }}" class="form-control border border-dark mb-2">
              </div>
            </div>
          </div>

          <div class="col-md-6">
          </div>
        </div>

        <br>
        <br>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="date" class="col-sm-4 control-label">Select patient for slip</label>
              <div class="col-sm-8">
                <select name="select_patient" id="select_patient" class="custom-select form-control form-control-rounded">
                  <option value="">Select for Slip</option>
                  @foreach($patients_no_slips as $patients_no_slip)
                  <option value="{{$patients_no_slip->id}}">{{$patients_no_slip->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="date" class="col-sm-4 control-label">Deselect patient</label>
              <div class="col-sm-8">
                <select name="deselect_patient" id="deselect_patient" class="custom-select form-control form-control-rounded">
                  <option value="">Deselect for Slip</option>
                  @foreach($patients_slips as $patients_slip)
                  <option value="{{$patients_slip->id}}">{{$patients_slip->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 control-label">
            {!! Form::submit('Update', ['class'=>'btn btn-success text-white mt-1','style'=>'width:150px']) !!}
          </div>
        </div>


        {!! Form::close() !!}

        <br />
        <br />

        @if(count($slipstable)>0)
        <table id="example1" cellpadding="1" class="table table-bordered table-striped">
          <thead class="bg-primary">
            <tr>
              <th>Sr. no</th>
              <th>Recipt no</th>
              <th>Patient name</th>
              <th>PDF</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            @foreach($slipstable as $slipst)
            <tr>
              <td>
                {{$i}}
              </td>
              <td>
                {{$slipst->sr_no}}
              </td>
              <?php $patient = Patient::where('id', $slipst->patients_id)->first();
              $name = $patient->name; ?>
              <td>
                {{$name}}
              </td>
              <td>
                <a href="/slipe/{{$slipst->file}}" target="_blank"><i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i></a>
              </td>
            </tr>
            <?php $i++; ?>
            @endforeach

          </tbody>
        </table>
        @endif

      </div>
    </div>

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection

@section('script')
<!-- <script src="https://code.jquery.com/jquery-1.10.2.js"></script> -->
<!-- <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> -->
<script src="{{asset('js/jquery-ui.js')}}"></script>
<script>
  $(document).ready(function() {
    $("#selectdate").datepicker({
      dateFormat: 'yy-mm-dd', // Set the date format
      prevText: "click for previous months",
      nextText: "click for next months",
      showOtherMonths: true,
      selectOtherMonths: false,
      onSelect: function(dateText, inst) {
        // Update the input field's value when a date is selected
        $("#selectdate").val(dateText);
        // Submit the form
        $(this).closest('form').submit();
      }
    });
  });
</script>
@endsection