<?php

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Wallet;
use App\Models\Patient;
use App\Models\Childrtype;
use App\Models\Patientreport;
?>

@extends('layouts.pdf')
@section('content')
<div class="container">
  <br />
  <?php
  $doctor = $_GET['doctor'];
  if ($doctor == 'all') {
  ?>
    <?php
    foreach ($doctors as $doctor) {
      $i = 1;
      $total = 0;
      $patients = Patient::where('doctors_id', $doctor->id)->get();
    ?>
      <center>
        <p style="font-size:12px;font-weight:bold;">Dr. {{$doctor->name}}</p>
        <p style="font-size:12px;font-weight:bold;">Period: {{$period}}</p>
      </center>
      <table style="border: 1px solid #fff;">
        <?php
        foreach ($patients as $key => $patient) {
          $comm = Wallet::where('patients_id', $patient->id)->first();
          $comm_amount = isset($comm) ? $comm->comm_amount : 0;
        ?>
          @if($key == 0)
          <thead>
            <tr style="background-color:#f1f1f1;">
              <th width="5%" style="font-size:12px;font-weight:bold;text-align:center;">Sr No.</th>
              <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Date</th>
              <th width="20%" style="font-size:12px;font-weight:bold;text-align:center;">Patient Name</th>
              <th width="35%" style="font-size:12px;font-weight:bold;text-align:center;">Investigation</th>
              <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Charges</th>
              <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Discount</th>
              <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Pro.Amt.</th>
            </tr>
          </thead>
          @endif
          <tbody>
            <tr>
              <td align='right' style="font-size:10px;">{{$i}}</td>
              <td style="font-size:10px;">{{Carbon::parse($patient->created_at)->format('d-M-y')}}</td>
              <td style="font-size:10px;">{{$patient->name}}</td>
              <?php
              $preports = Patientreport::where('patients_id', $patient->id)->get();
              $names = [];
              foreach ($preports as $report) {
                $childrtype = Childrtype::where('id', $report->childreport_id)->first();
                if ($childrtype) {
                  $names[] = $childrtype->name; // Add the name to the array
                }
              }
              $nameString = implode(', ', $names);
              ?>
              <td style="font-size:10px;">{{$nameString}}</td>
              <td align='right' style="font-size:10px;">{{$patient->net_amount}}</td>
              <td align='right' style="font-size:10px;">{{($patient->basic_amount - $patient->net_amount)}}</td>
              <td align='right' style="font-size:10px;">{{$comm_amount}}</td>
            </tr>
          </tbody>
          <?php $total += $comm_amount; ?>
        <?php $i++;
        } ?>
      </table>
      <table style="border: 1px solid #fff;">
        <tr>
          <td width="5%"></td>
          <td width="10%"></td>
          <td width="20%"></td>
          <td width="35%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
          <td width="10%" align='right'>{{$total}}</td>
        </tr>
      </table>
      <br />
      <br />
    <?php }
  } else {
    foreach ($doctors as $doctor) {
      $i = 1;
      $total = 0;
      $patients = Patient::where('doctors_id', $doctor->id)->get();
    ?>
      <center>
        <p style="font-size:12px;font-weight:bold;">Dr. {{$doctor->name}}</p>
        <p style="font-size:12px;font-weight:bold;">Period: {{$period}}</p>
      </center>
      <table style="border: 1px solid #fff;" class="table table-bordered table-striped">
        <thead>
          <tr style="background-color:#f1f1f1;">
            <th width="5%" style="font-size:12px;font-weight:bold;text-align:center;">Sr No.</th>
            <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Date</th>
            <th width="20%" style="font-size:12px;font-weight:bold;text-align:center;">Patient Name</th>
            <th width="35%" style="font-size:12px;font-weight:bold;text-align:center;">Investigation</th>
            <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Charges</th>
            <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Discount</th>
            <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Pro.Amt.</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($patients as $patient) {
            $comm = Wallet::where('patients_id', $patient->id)->first();
            $comm_amount = isset($comm) ? $comm->comm_amount : 0;
          ?>
            <tr>
              <td align='right' style="font-size:10px;">{{$i}}</td>
              <td style="font-size:10px;">{{Carbon::parse($patient->created_at)->format('d-M-y')}}</td>
              <td style="font-size:10px;">{{$patient->name}}</td>
              <?php
              $preports = Patientreport::where('patients_id', $patient->id)->get();
              $names = [];
              foreach ($preports as $report) {
                $childrtype = Childrtype::where('id', $report->childreport_id)->first();
                if ($childrtype) {
                  $names[] = $childrtype->name; // Add the name to the array
                }
              }
              $nameString = implode(', ', $names);
              ?>
              <td style="font-size:10px;">{{$nameString}}</td>
              <td align='right' style="font-size:10px;">{{$patient->net_amount}}</td>
              <td align='right' style="font-size:10px;">{{($patient->basic_amount - $patient->net_amount)}}</td>
              <td align='right' style="font-size:10px;">{{$comm_amount}}</td>
            </tr>
          <?php $total += $comm_amount;
            $i++;
          } ?>
          <td width="5%"></td>
          <td width="10%"></td>
          <td width="20%"></td>
          <td width="35%"></td>
          <td width="10%"></td>
          <td width="10%"></td>
          <td width="10%" align='right'>{{$total}}</td>
        </tbody>
      </table>
  <?php }
  } ?>
</div>
@endsection