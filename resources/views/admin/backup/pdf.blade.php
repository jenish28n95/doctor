<?php

use Carbon\Carbon;
use App\Models\Childrtype;
use App\Models\Patientreport;
?>

@extends('layouts.pdf')
@section('content')
<div class="container">
  <center>
    <h4>Report</h4>
    <h1 style="margin-top:-10px">Doctors</h1>
    <p style="font-size:10px;margin-top:-12px">OFFICE NO.A-4,FIRST FLOOR,ENTW AP PARK,KANSHARA SHERI,<br />SURAT,SURAT,GUJRAT,395003 Gujarat</p>
  </center>
  <div class="row">
    <div class="column-left">
      <div class="d-flex align-items-center justify-content-center">
        <p><strong class="align-center title">Bill Date:</strong>{{ \Carbon\Carbon::parse(Carbon::now())->format('d-m-Y H:i:s') }}</p>
        <p><strong class="align-center title">Name:</strong></p>
        <p><strong class="align-center title">Designation:</strong></p>
        <p><strong class="align-center title">Phones :</strong></p>
        <p><strong class="align-center title">Address :</strong></p>
        <p><strong class="align-center title">Aadhar No. :</strong></p>
      </div>
    </div>
    <div class="column-right">
    </div>
    <div style="clear: both;"></div>
    <!-- Rest of your code ... -->
    <!-- Content for the center and table -->
  </div>
  <br />
  <table>
    <thead>
      <tr>
        <th>Sr.</th>
        <th>Patient Name</th>
        <th>Investigation</th>
        <th>Age</th>
        <th>Sex</th>
        <th>Ref. Doctor</th>
        <th>Arrival Time</th>
        <th>Status</th>
        <th>Payment Mode</th>
        <th>Discount</th>
        <th>Net Amount</th>
      </tr>
    </thead>
    @php
    $sum = 0;
    $p = 1;
    @endphp
    <tbody>
      @foreach($data as $key=>$da)
      <tr>
        <td>{{$p}}</td>
        <td>{{$da->name}}</td>
        <?php
        $preports = Patientreport::where('patients_id', $da->id)->get();
        $names = [];
        foreach ($preports as $report) {
          $childrtype = Childrtype::where('id', $report->childreport_id)->first();
          if ($childrtype) {
            $names[] = $childrtype->name; // Add the name to the array
          }
        }
        $nameString = implode(', ', $names);
        ?>
        <td>{{$nameString}}</td>
        <td>{{$da->age}}&nbsp;{{$da->year}}</td>
        <td>{{$da->sex}}</td>
        <td>{{$da->doctors->name}}</td>
        <td>{{ \Carbon\Carbon::parse($da->arrival_time)->format('d-m-Y') }}</td>
        <td>{{$da->payment_mode}}</td>
        <td>{{$da->payment}}</td>
        <td>{{$da->discount}}</td>
        <td>{{$da->net_amount}}</td>
        @php
        $sum += ($da->net_amount);
        $p += 1;
        @endphp
      </tr>
      @endforeach
      <tr>
        <td colspan="10">
          <b>
            <h4>Total Amount</h4>
          </b>
        </td>
        <td>
          <b>
            <h4>{{$sum}}</h4>
          </b>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection