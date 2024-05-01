<?php

use App\Models\Slip;
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
         <b>Follow Up Patients</b>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Follow Up Patients</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
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
               <div class="row">
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-4">
                     {!! Form::open(['method'=>'GET', 'action'=> 'AdminFlowupController@index','class'=>'form-horizontal']) !!}
                     @csrf
                     <select name="select_year" id="select_year" style="width:30%" class="border border-dark" onchange="return this.form.submit();">
                        <option value="">Select year</option>
                        @foreach ($f_years as $f_year)
                        <option value="{{$f_year->year}}" {{ (request()->select_year ==  $f_year->year) ? 'selected' : ''}}>{{$f_year->year}}</option>
                        @endforeach
                     </select>
                     {!! Form::close() !!}
                  </div>
               </div>
               <!-- /.box-header -->
               <div class="box-body" style="overflow-x:auto;">
                  <table id="flowuppatientTable" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Patient Name</th>
                           <!-- <th>Investigation</th> -->
                           <th>Age</th>
                           <th>Sex</th>
                           <th>Ref. Doctor</th>
                           <th>Arrival Time</th>
                           <!-- <th>Discount</th> -->
                           <!-- <th>Balance</th> -->
                           <th>Slip</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($patients as $index =>$patient)
                        <tr>
                           <td><a href="{{route('admin.patients.edit', $patient->id)}}" style="color: blue;" target="_blank">{{$patient->name}}</a></td>
                           <?php
                           $preports = Patientreport::where('patients_id', $patient->id)->get();
                           $names = [];
                           foreach ($preports as $report) {
                              $childrtype = Childrtype::where('id', $report->childreport_id)->first();
                              if ($childrtype) {
                                 $names[] = $childrtype->name;
                              }
                           }
                           $nameString = implode(', ', $names);
                           ?>
                           <!-- <td>{{$nameString}}</td> -->
                           <td>{{$patient->age}}&nbsp;{{$patient->year}}</td>
                           <td>{{$patient->sex}}</td>
                           <td>{{$patient->doctors->name}}</td>
                           <td>{{$patient->arrival_time}}</td>
                           <!-- <td>
                              @if($patient->discount != '' || $patient->discount != 0 || $patient->discount != Null)
                              {{$patient->discount}}&nbsp;{{($patient->discount_type == 'per') ? '%' : 'Rs.';}}
                              @endif
                           </td> -->
                           <!-- <td>{{isset($patient->balance) ? $patient->balance : ''}}</td> -->
                           <td>
                              <?php
                              $getdetail = Slip::where('patients_id', $patient->id)->first();
                              ?>
                              @if($patient->is_slip == 1 && isset($getdetail->file))
                              <a href="/slipe/{{$getdetail->file}}" target='_blank'><i class="fa fa-file-pdf-o" style="font-size:18px;color:black"></i></a>
                              @endif
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   $(document).ready(function() {
      $("#flowuppatientTable").DataTable();
   });
</script>
@endsection