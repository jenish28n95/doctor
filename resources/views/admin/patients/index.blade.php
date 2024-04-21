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
         <b>Patients Lists</b> &nbsp; <a href="{{route('admin.patients.create')}}" class="bg-primary text-white text-decoration-none" style="padding:8px 12px;margin-left:15px"><i class="fa fa-plus" style="font-size:15px;">&nbsp;ADD</i></a>
         <button class="btn bg-info" style="padding:12px 12px;margin-left:15px" id="downloadSelected">Download Slips</button>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Patients Lists</li>
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
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <!-- <a href="{{route('admin.patients.create')}}" class="bg-primary text-white text-decoration-none" style="padding:12px 12px;margin-left:20px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
                     <button class="btn bg-info" style="padding:12px 12px;margin-left:20px" id="downloadSelected">Download Slips</button> -->
                  </div>
                  <div class="col-md-8">
                     {!! Form::open(['method'=>'GET', 'action'=> 'AdminPatientsController@index','class'=>'form-horizontal']) !!}
                     @csrf
                     <input type="date" name="start_date" id="start_date" class="border border-dark" value="{{ isset(request()->start_date) ? request()->start_date : date('Y-m-d') }}">
                     <input type="date" name="end_date" id="end_date" class="border border-dark" value="{{ isset(request()->end_date) ? request()->end_date : date('Y-m-d') }}">
                     <select name="session" id="session" class="border border-dark">
                        <option value="all" {{ request()->session == 'all' ? 'selected' : ''}}>All session</option>
                        <option value="Morning" {{ request()->session == 'Morning' ? 'selected' : ''}}>Morning</option>
                        <option value="Evening" {{ request()->session == 'Evening' ? 'selected' : ''}}>Evening</option>
                     </select>
                     <button type="submit" class="fa fa-search bg-default text-white"></button>
                     {!! Form::close() !!}
                  </div>
               </div>
               <!-- /.box-header -->
               <div class="box-body" style="overflow-x:auto;">
                  <table id="patientTable" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th><input type="checkbox" id="selectAll"></th>
                           <th>Action</th>
                           <th>Slip</th>
                           <th>Patient Name</th>
                           <th>Investigation</th>
                           <th>Age</th>
                           <th>Sex</th>
                           <th>Ref. Doctor</th>
                           <th>Arrival Time</th>
                           <th>Discount</th>
                           <th>Balance</th>
                           <!-- <th>Net Amount</th> -->
                           <!-- <th>Status</th> -->
                           <!-- <th>Payment Mode</th> -->
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($patients as $index =>$patient)
                        <tr style="{{ ($patient->net_amount == ($patient->cash_amount + $patient->paytm_amount)) ? 'background-color: pink;' : 'background-color: orange;' }}">
                           <td><input type="checkbox" class="checkbox" value="{{$patient->id}}"></td>
                           <td>
                              <!-- <a href="{{route('admin.patients.edit', $patient->id)}}"><i class="fa fa-edit" style="font-size:18px;background-color:rgba(255, 255, 255, 0.50);"></i></a> -->
                              <a href="{{route('admin.patients.destroy', $patient->id)}}" style="padding-left:5px" onclick="return confirm('Sure ! You want to delete reocrd ?');"><i class="fa fa-trash" style="font-size:18px;background-color:rgba(255, 255, 255, 0.50);"></i></a>
                           </td>
                           <td>
                              <?php
                              $getdetail = Slip::where('patients_id', $patient->id)->first();
                              ?>
                              @if($patient->is_slip == 1 && isset($getdetail->file))
                              <a href="/slipe/{{$getdetail->file}}" download='download'><i class="fa fa-file-pdf-o" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                              @endif
                           </td>
                           <td><a href="{{route('admin.patients.edit', $patient->id)}}" style="color: blue;">{{$patient->name}}</a></td>
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
                           <td>{{$nameString}}</td>
                           <td>{{$patient->age}}&nbsp;{{$patient->year}}</td>
                           <td>{{$patient->sex}}</td>
                           <td>{{$patient->doctors->name}}</td>
                           <td>{{$patient->arrival_time}}</td>
                           <td>
                              @if($patient->discount != '' || $patient->discount != 0 || $patient->discount != Null)
                              {{$patient->discount}}&nbsp;{{($patient->discount_type == 'per') ? '%' : 'Rs.';}}
                              @endif
                           </td>
                           <td>{{isset($patient->balance) ? $patient->balance : ''}}</td>
                           <!-- <td>{{$patient->net_amount}}</td> -->
                           <!-- <td>{{$patient->payment}}</td> -->
                           <!-- <td>{{$patient->payment_mode}}</td> -->
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               <!-- /.box-body -->

               <?php
               $total = $discount = $net = $recived = $balance = $cash_amount = $paytm_amount = 0;
               foreach ($patients as $index => $patient) {
                  $total += $patient->basic_amount;
                  $discount += $patient->discount_amount;
                  $net += $patient->net_amount;
                  $recived += $patient->cash_amount + $patient->paytm_amount;
                  $balance += $patient->balance;
                  $cash_amount += $patient->cash_amount;
                  $paytm_amount += $patient->paytm_amount;
               }
               ?>

               <div class="row" style="padding:10px">
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-4">
                     <table style="border:1px solid #000;">
                        <thead style="border:1px solid #000;">
                           <tr style="background-color:#f1f1f1">
                              <th style="border:1px solid #000;padding:5px">Payment Mode</th>
                              <th style="border:1px solid #000;padding:5px">Received</th>
                              <th style="border:1px solid #000;padding:5px">Balance</th>
                              <th style="border:1px solid #000;padding:5px">Net Amt.</th>
                           </tr>
                        </thead>
                        <tbody style="border:1px solid #000;">
                           <tr style="border:1px solid #000;">
                              <td style="border:1px solid #000;padding:5px;">Cash</td>
                              <td style="border:1px solid #000;padding:5px;text-align:right">{{$cash_amount}}</td>
                              <td style="border:1px solid #000;padding:5px;text-align:right">{{$balance}}</td>
                              <td style="border:1px solid #000;padding:5px;text-align:right">{{$cash_amount + $balance}}</td>
                           </tr>
                           <tr style="border:1px solid #000;">
                              <td style="border:1px solid #000;padding:5px;">Paytm</td>
                              <td style="border:1px solid #000;padding:5px;text-align:right">{{$paytm_amount}}</td>
                              <td style="border:1px solid #000;padding:5px;text-align:right">0</td>
                              <td style="border:1px solid #000;padding:5px;text-align:right">{{$paytm_amount}}</td>
                           </tr>
                           <tr style="border:1px solid #000;">
                              <td style="border:1px solid #000;padding:5px;">Total</td>
                              <td style="border:1px solid #000;padding:5px;text-align:right">{{$cash_amount + $paytm_amount}}</td>
                              <td style="border:1px solid #000;padding:5px;text-align:right">{{$balance}}</td>
                              <td style="border:1px solid #000;padding:5px; text-align:right">{{$net}}</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <div class="col-md-4">
                     <table style="border:1px solid #000;">
                        <tr>
                           <td style="background-color:#f1f1f1;border:1px solid #000;padding:5px;">patient</td>
                           <td style="text-align:right;border:1px solid #000;padding:5px;">{{count($patients)}}</td>
                        </tr>
                        <tr>
                           <td style="background-color:#f1f1f1;border:1px solid #000;padding:5px;">Total</td>
                           <td style="text-align:right;border:1px solid #000;padding:5px;">{{$total}}</td>
                        </tr>
                        <tr>
                           <td style="background-color:#f1f1f1;border:1px solid #000;padding:5px;">Discount</td>
                           <td style="text-align:right;border:1px solid #000;padding:5px;">{{$discount}}</td>
                        </tr>
                        <tr>
                           <td style="background-color:#f1f1f1;border:1px solid #000;padding:5px;">Net Amount</td>
                           <td style="text-align:right;border:1px solid #000;padding:5px;">{{$net}}</td>
                        </tr>
                        <tr>
                           <td style="background-color:#f1f1f1;border:1px solid #000;padding:5px;">Recived Amount</td>
                           <td style="text-align:right;border:1px solid #000;padding:5px;">{{$recived}}</td>
                        </tr>
                        <tr>
                           <td style="background-color:#f1f1f1;border:1px solid #000;padding:5px;">Balance Amount</td>
                           <td style="text-align:right;border:1px solid #000;padding:5px;">{{$balance}}</td>
                        </tr>
                     </table>
                  </div>
               </div>
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
      $("#patientTable").DataTable();
   });
</script>
<script>
   document.addEventListener("DOMContentLoaded", function() {
      const selectAllCheckbox = document.getElementById('selectAll');
      const downloadButton = document.getElementById('downloadSelected');
      const checkboxes = document.querySelectorAll('.checkbox');

      // Event listener for select all checkbox
      selectAllCheckbox.addEventListener('change', function() {
         checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
         });
      });

      // Event listener for download button
      downloadButton.addEventListener('click', function() {
         const selectedIds = [];
         checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
               selectedIds.push(checkbox.value);
            }
         });

         // Redirect to download route with selected IDs
         window.location.href = '/download?ids=' + selectedIds.join(',');
      });
   });
</script>
@endsection