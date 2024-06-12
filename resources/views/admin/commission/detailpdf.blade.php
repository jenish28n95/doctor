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
      $total_charge = 0;
      $total_discount = 0;
    ?>
      <center>
        <p style="font-size:12px;font-weight:bold;">Dr. {{$doctor->name}}</p>
        <p style="font-size:12px;font-weight:bold;">Period: {{$period}}</p>
      </center>
      <table style="border: 1px solid #fff;">
        <?php
        $wallets = $data->where('doctors_id', $doctor->id); ?>
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
        <?php foreach ($wallets as $key => $wallet) {
          $patients = Patient::where('id', $wallet->patients_id)->get();
          $comm_amount = isset($wallet) ? $wallet->comm_amount : 0; ?>

          <?php foreach ($patients as $key => $patient) {
          ?>
            <tbody>
              <tr>
                <td align='right' style="font-size:10px;">{{$i}}</td>
                <td align='center' style="font-size:10px;">{{Carbon::parse($patient->created_at)->format('d-M-y')}}</td>
                <td align='center' style="font-size:10px;">{{$patient->name}}</td>
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
            <?php $total += $comm_amount;
            $total_charge += $patient->net_amount;
            $total_discount += ($patient->basic_amount - $patient->net_amount); ?>
        <?php $i++;
          }
        } ?>
      </table>
      <table>
        <tr style="border-top:1px solid #000">
          <td width="5%"></td>
          <td width="10%"></td>
          <td width="20%"></td>
          <td width="35%"></td>
          <td width="10%" align='right' style="font-weight:bold;">{{$total_charge}}</td>
          <td width="10%" align='right' style="font-weight:bold;">{{$total_discount}}</td>
          <td width="10%" align='right' style="font-weight:bold;">{{$total}}</td>
        </tr>
      </table>
      <br />
      <br />
    <?php }
  } else {
    foreach ($doctors as $doctor) {
      $i = 1;
      $total = 0;
      $total_charge = 0;
      $total_discount = 0;
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
          $wallets = $data->where('doctors_id', $doctor->id);
          foreach ($wallets as $wallet) {
            $patients = Patient::where('id', $wallet->patients_id)->get();
            $comm_amount = isset($wallet) ? $wallet->comm_amount : 0;
            foreach ($patients as $key => $patient) {
          ?>
              <tr>
                <td align='right' style="font-size:10px;">{{$i}}</td>
                <td align='center' style="font-size:10px;">{{Carbon::parse($patient->created_at)->format('d-M-y')}}</td>
                <td align='center' style="font-size:10px;">{{$patient->name}}</td>
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
              $total_charge += $patient->net_amount;
              $total_discount += ($patient->basic_amount - $patient->net_amount);
              $i++;
            }
          } ?>
          <tr style="border-top:1px solid #000">
            <td width="5%"></td>
            <td width="10%"></td>
            <td width="20%"></td>
            <td width="35%"></td>
            <td width="10%" align='right' style="font-weight:bold;">{{$total_charge}}</td>
            <td width="10%" align='right' style="font-weight:bold;">{{$total_discount}}</td>
            <td width="10%" align='right' style="font-weight:bold;">{{$total}}</td>
          </tr>
        </tbody>
      </table>
  <?php }
  } ?>
</div>
@endsection