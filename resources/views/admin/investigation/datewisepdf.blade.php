<?php

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Patientreport;
?>

@extends('layouts.pdf')
@section('content')
<div class="container">
  <center>
    <p style="font-size:16px;margin-top:-12px"><b>Pramukh Sonography Color Doppler and Digital X-Ray Center</b>
      <br />
      <u>Date Wise Investigation Report</u>
      <br />
      <br />
      <b>Period:</b>&nbsp;{{$name}}
    </p>
  </center>
  <br />

  <table>
    <thead>
      <tr style="background-color:#f1f1f1">
        <th style="font-size:12px;font-weight:bold;text-align:center;">Date</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">X-Rays</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Amount</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Sonography</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Amount</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Doppler</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Amount</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Procedure</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Amount</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Special Study</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Amount</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">USG</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Amount</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Discount</th>
        <th style="font-size:12px;font-weight:bold;text-align:center;">Total</th>
      </tr>
    </thead>
    <?php
    $t_xray = 0;
    $t_sonography = 0;
    $t_doppler = 0;
    $t_procedure = 0;
    $t_special = 0;
    $t_USG = 0;
    $t_xray_a = 0;
    $t_sonography_a = 0;
    $t_doppler_a = 0;
    $t_procedure_a = 0;
    $t_special_a = 0;
    $t_discount = 0;
    $t_USG_a = 0;
    $t_total = 0;
    ?>
    @foreach($data as $key=>$dats)
    <?php
    $total = 0;
    $xray = 0;
    $sonography = 0;
    $doppler = 0;
    $procedure = 0;
    $special = 0;
    $USG = 0;
    $xray_a = 0;
    $sonography_a = 0;
    $doppler_a = 0;
    $procedure_a = 0;
    $special_a = 0;
    $USG_a = 0;
    $discount = 0;
    $formattedDate = Carbon::createFromFormat('d/m/Y', $key)->format('Y-m-d');
    $patients = Patient::whereDate('created_at', $formattedDate)->get();
    if (count($patients) > 0) {
      foreach ($patients as $patient) {
        $discount += ($patient->basic_amount - $patient->net_amount);
      }
    }
    ?>
    @foreach ($dats as $dat)
    <?php
    $xray_count = Patientreport::where('patients_id', $dat->id)->where('report_id', 4)->count();
    $sonography_count = Patientreport::where('patients_id', $dat->id)->where('report_id', 3)->count();
    $doppler_count = Patientreport::where('patients_id', $dat->id)->where('report_id', 2)->count();
    $procedure_count = Patientreport::where('patients_id', $dat->id)->where('report_id', 5)->count();
    $special_count = Patientreport::where('patients_id', $dat->id)->where('report_id', 6)->count();
    $USG_count = Patientreport::where('patients_id', $dat->id)->where('report_id', 7)->count();
    $xray_amount = Patientreport::where('patients_id', $dat->id)->where('report_id', 4)->sum('amount');
    $sonography_amount = Patientreport::where('patients_id', $dat->id)->where('report_id', 3)->sum('amount');
    $doppler_amount = Patientreport::where('patients_id', $dat->id)->where('report_id', 2)->sum('amount');
    $procedure_amount = Patientreport::where('patients_id', $dat->id)->where('report_id', 5)->sum('amount');
    $special_amount = Patientreport::where('patients_id', $dat->id)->where('report_id', 6)->sum('amount');
    $USG_amount = Patientreport::where('patients_id', $dat->id)->where('report_id', 7)->sum('amount');
    $xray += $xray_count;
    $sonography += $sonography_count;
    $doppler += $doppler_count;
    $procedure += $procedure_count;
    $special += $special_count;
    $USG += $USG_count;
    $xray_a += $xray_amount;
    $sonography_a += $sonography_amount;
    $doppler_a += $doppler_amount;
    $procedure_a += $procedure_amount;
    $special_a += $special_amount;
    $USG_a += $USG_amount;
    $total = $xray_a + $sonography_a + $doppler_a + $procedure_a + $special_a + $USG_a;
    ?>
    @endforeach
    <tbody>
      <tr>
        <td align='center' style="font-size:10px;">
          {{ \Carbon\Carbon::createFromFormat('d/m/Y', $key)->format('d/m/Y') }}
        </td>
        <td align='right' style="font-size:10px;">{{$xray}}</td>
        <td align='right' style="font-size:10px;">{{$xray_a}}</td>
        <td align='right' style="font-size:10px;">{{$sonography}}</td>
        <td align='right' style="font-size:10px;">{{$sonography_a}}</td>
        <td align='right' style="font-size:10px;">{{$doppler}}</td>
        <td align='right' style="font-size:10px;">{{$doppler_a}}</td>
        <td align='right' style="font-size:10px;">{{$procedure}}</td>
        <td align='right' style="font-size:10px;">{{$procedure_a}}</td>
        <td align='right' style="font-size:10px;">{{$special}}</td>
        <td align='right' style="font-size:10px;">{{$special_a}}</td>
        <td align='right' style="font-size:10px;">{{$USG}}</td>
        <td align='right' style="font-size:10px;">{{$USG_a}}</td>
        <td align='right' style="font-size:10px;">{{$discount}}</td>
        <td align='right' style="font-size:10px;">{{$total}}</td>
      </tr>
    </tbody>
    <?php
    $t_xray += $xray;
    $t_sonography += $sonography;
    $t_doppler += $doppler;
    $t_procedure += $procedure;
    $t_special += $special;
    $t_USG += $USG;
    $t_xray_a += $xray_a;
    $t_sonography_a += $sonography_a;
    $t_doppler_a += $doppler_a;
    $t_procedure_a += $procedure_a;
    $t_special_a += $special_a;
    $t_USG_a += $USG_a;
    $t_discount += $discount;
    $t_total += $total;
    ?>
    @endforeach
    <tr style="border-top:1px solid #000">
      <td align='center' style="font-size:10px;">
      </td>
      <td align='right' style="font-size:10px;">{{$t_xray}}</td>
      <td align='right' style="font-size:10px;">{{$t_xray_a}}</td>
      <td align='right' style="font-size:10px;">{{$t_sonography}}</td>
      <td align='right' style="font-size:10px;">{{$t_sonography_a}}</td>
      <td align='right' style="font-size:10px;">{{$t_doppler}}</td>
      <td align='right' style="font-size:10px;">{{$t_doppler_a}}</td>
      <td align='right' style="font-size:10px;">{{$t_procedure}}</td>
      <td align='right' style="font-size:10px;">{{$t_procedure_a}}</td>
      <td align='right' style="font-size:10px;">{{$t_special}}</td>
      <td align='right' style="font-size:10px;">{{$t_special_a}}</td>
      <td align='right' style="font-size:10px;">{{$t_USG}}</td>
      <td align='right' style="font-size:10px;">{{$t_USG_a}}</td>
      <td align='right' style="font-size:10px;">{{$t_discount}}</td>
      <td align='right' style="font-size:10px;">{{$t_total}}</td>
    </tr>
  </table>

</div>
@endsection