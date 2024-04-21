<?php

use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;
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
  <?php
  $doctor = $_GET['doctor'];
  if ($doctor == 'all') {
  ?>
    <table>
      <thead>
        <tr>
          <th>Doctors Name</th>
          <th>Number of Patients</th>
          <th>Commission</th>
        </tr>
      </thead>
      <tbody>
        <?php $doctors = Doctor::where('name', '!=', 'self')->get();
        foreach ($doctors as $doctor) {
          $sum = 0;
          $count = Patient::where('doctors_id', $doctor->id)->count();
          $wallets = $data->where('doctors_id', $doctor->id);
          foreach ($wallets as $wallet) {
            $sum += $wallet->comm_amount;
          }
        ?>
          <tr>
            <td>{{$doctor->name}}</td>
            <td>{{$count}}</td>
            <td>{{$sum}}</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } else {
  ?>
    <table id="" class="table table-bordered table-striped">
      <thead>
        <tr>
          <!-- <th>Patient Name</th>
              <th>Mobile No</th>
              <th>Amount</th> -->
          <th>Number of Patients</th>
          <th>Total Commission</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0; ?>
        @foreach ($data as $da)
        <?php
        $patient = Patient::where('id', $da->patients_id)->first();
        ?>
        <!-- <tr>
          <td>{{$patient->name}}</td>
          <td>{{$patient->mobile}}</td>
          <td>{{$da->comm_amount}}</td>
        </tr> -->
        <?php $total += $da->comm_amount; ?>
        @endforeach
        <tr>
          <td>{{count($data)}}</td>
          <td>{{$total}}</td>
        </tr>
      </tbody>
    </table>
  <?php }
  ?>
</div>
@endsection