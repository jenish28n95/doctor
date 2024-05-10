<?php

use Carbon\Carbon;
use App\Models\Patient;
?>

@extends('layouts.pdf')
@section('content')
<div class="container">
  <center>
    <p style="font-size:16px;margin-top:-12px"><b>Pramukh Sonography Color Doppler and Digital X-Ray Center</b><br /><u>Date Wise Income Report</u></p>
  </center>
  <br />

  @foreach($data as $key=>$dat)
  <p style="font-size:15px;font-weight:bold;">Date: {{\Carbon\Carbon::parse($key)->format('j F Y')}}</p>
  @php
  $sum = 0;
  $p = 1;
  @endphp
  <table>
    @foreach ($dat as $ind => $da)
    <?php
    $patient = Patient::where('id', $da->patients_id)->first();
    $pname = $patient->name;
    $amount = $patient->net_amount;
    ?>
    @if($ind == 0)
    <thead>
      <tr style="background-color:#f1f1f1">
        <th width="20%" style="font-size:12px;font-weight:bold;text-align:center;">Sr.</th>
        <th width="20%" style="font-size:12px;font-weight:bold;text-align:center;">Receipt No</th>
        <th width="50%" style="font-size:12px;font-weight:bold;text-align:center;">Patient Name</th>
        <th width="10%" style="font-size:12px;font-weight:bold;text-align:center;">Amount</th>
      </tr>
    </thead>
    @endif
    <tbody>
      <tr>
        <td align='center' style="font-size:10px;">{{ \Carbon\Carbon::parse($da->date)->format('dmY') }}/{{str_pad($p, 3, '0', STR_PAD_LEFT)}}</td>
        <td align='center' style="font-size:10px;">{{str_pad($da->sr_no, 4, '0', STR_PAD_LEFT)}}</td>
        <td align='center' style="font-size:10px;">{{$pname}}</td>
        <td align='right' style="font-size:10px;">{{$amount}}</td>
        @php
        $sum += ($amount);
        $p += 1;
        @endphp
      </tr>
    </tbody>

    @endforeach
  </table>
  <table>
    <tr>
      <td width="90%" align='right' style="font-size:12px;" colspan="3">
        <b>
          <h4>Total Amount</h4>
        </b>
      </td>
      <td width="10%" align='right' style="font-size:12px;border-top:1px solid #000">
        <b>
          <h4>{{$sum}}</h4>
        </b>
      </td>
    </tr>
  </table>
  @endforeach

</div>
@endsection