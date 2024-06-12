<?php

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
?>

@extends('layouts.pdf')
@section('content')
<div class="container">
  <center>
    <?php $doctor = $_GET['doctor'];
    if ($doctor != 'all') {
      $doc = Doctor::where('id', $doctor)->first();
      $docname = $doc->name;
    }
    $name = ($doctor == 'all') ? 'All Doctors' : $docname;
    ?>
    <p style="font-size:12px;font-weight:bold;">Ref. Dr. : {{$name}}</p>
    <p style="font-size:12px;font-weight:bold;">Period: {{$period}}</p>
  </center>
  <br />
  <table style="border: 1px solid #fff;">
    <thead>
      <tr style="background-color:#f1f1f1;">
        <th width="5%" style="font-size:12px;font-weight:bold;text-align:center;">Sr No</th>
        <th width="40%" style="font-size:12px;font-weight:bold;text-align:center;">Doctors Name</th>
        <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Patients</th>
        <th width="15%" style="font-size:12px;font-weight:bold;text-align:center;">Charges</th>
        <th width="15%" style="font-size:12px;font-weight:bold;text-align:center;">Discount</th>
        <th width="15%" style="font-size:12px;font-weight:bold;text-align:center;">Pro. Amt</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 1;
      $total = 0;
      $total_charge = 0;
      $total_discount = 0;
      foreach ($doctors as $doctor) {
        $sum = 0;
        $patients = Patient::where('doctors_id', $doctor->id)->get();
        $count = count($patients);
        if ($count == 0) {
          continue;
        }
        $charges = 0;
        $discount = 0;
        foreach ($patients as $patient) {
          $charges += $patient->net_amount;
          $discount += ($patient->basic_amount - $patient->net_amount);
        }
        $wallets = $data->where('doctors_id', $doctor->id);
        foreach ($wallets as $wallet) {
          $sum += $wallet->comm_amount;
        }
        $total += $sum;
        $total_charge += $charges;
        $total_discount += $discount;
      ?>
        <tr>
          <td align='right' style="font-size:10px;">{{$i}}</td>
          <td align='center' style="font-size:10px;">{{$doctor->name}}</td>
          <td align='center' style="font-size:10px;">{{$count}}</td>
          <td align='center' style="font-size:10px;">{{$charges}}</td>
          <td align='center' style="font-size:10px;">{{$discount}}</td>
          <td align='right' style="font-size:10px;">{{$sum}}</td>
        </tr>
      <?php $i++;
      } ?>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td align='center' style="font-weight:bold;">{{$total_charge}}</td>
        <td align='center' style="font-weight:bold;">{{$total_discount}}</td>
        <td align='right' style="font-weight:bold;">{{$total}}</td>
      </tr>
    </tbody>
  </table>
</div>
@endsection