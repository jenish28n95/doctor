<?php

use Carbon\Carbon;
use App\Models\Rtype;
use App\Models\Doctor;
use App\Models\Childrtype;
?>

@extends('layouts.pdf')
@section('content')
<div class="container">
  <table width="100%" style="border:1px solid #000;">
    <center>
      <p style="font-size:22px;margin-top: -1px;">PRAMUKH SONOGRAPHY COLOR DOPPLER AND<br /> DIGITAL X-RAY CENTER<br /><span style="font-size:10px;">104, 1st Floor, Shayona Complex,Jay Gangeshwar Society,Above Dairy don IceCream,Opp. Sargam Doctor House,<br />Hirabaug,Varachha Road,Surat-395006, M.8980640990</span></p>
    </center>
    <div class="row" style="margin-top: -15px;">
      <div class="column-left">
        Dr. Vijay Kotadiya
        <br />
        MD (Radiodiagnosis)
      </div>
      <div class="column-right" style="text-align: center;">
        Dr. Darshan Koshiya
        <br />
        DMRD (Radiodiagnosis)
      </div>
      <div style="clear: both;"></div>
    </div>
  </table>
  <div style="position: absolute; margin-top:2%; left: 50%; transform: translate(-50%, -50%); width: 10%; border: 1px solid #000; padding: 5px; text-align: center;">
    RECEIPT
  </div>
  <div class="row" style="font-size:13px;">
    <div class="column-left">
      <div class="d-flex align-items-center justify-content-center">
        <?php $docotr =  Doctor::where('id', $patient->doctors_id)->first();
        $name = $docotr->name . '-' . $docotr->degree;
        ?>
        <p style="margin-top: 30px;"><strong class="align-center title">Patient Name:&nbsp;</strong>{{$patient->name}}</p>
        <p style="margin-top: -5px;"><strong class="align-center title">Reference Doctor:&nbsp;</strong>{{$name}}</p>
      </div>
    </div>
    <div class="column-right" style="text-align: center;">
      <div class="d-flex align-items-center justify-content-center">
        <p style="margin-top: 30px;"><strong class="align-center title">Date:&nbsp;</strong>{{ \Carbon\Carbon::parse($patient->created_at)->format('d-m-Y') }}</p>
        <p style="margin-top: -5px;"><strong class="align-center title">Receipt No:&nbsp;</strong>{{$no}}</p>
      </div>
    </div>
    <div style="clear: both;"></div>
    <!-- Rest of your code ... -->
    <!-- Content for the center and table -->
  </div>
  <br />
  <table style="border-collapse: collapse;" style="margin-top: -25px;">
    <thead>
      <tr style="background-color:#f1f1f1;padding:5px 0px;">
        <th width="10%">Sr.</th>
        <th width="35%">Report Name</th>
        <!-- <th width="35%">Child Report Name</th> -->
        <th width="20%">Rate</th>
      </tr>
    </thead>
    @php
    $p = 1;
    @endphp
    <tbody>
      @foreach($patientreports as $emp)
      <tr style="padding:5px 0px;">
        <td style="text-align:center;">{{$p}}</td>
        <?php
        $r_name = Rtype::where('id', $emp->report_id)->first();
        ?>
        <!-- <td>
          {{$r_name->name}}
        </td> -->
        <?php
        $child_r_name = Childrtype::where('id', $emp->childreport_id)->first();
        ?>
        <td style="text-align:center;">
          {{$child_r_name->name}}
        </td>
        <td style="text-align:right;">
          {{$emp->amount}}
        </td>
      </tr>
      @php
      $p++;
      @endphp
      @endforeach
      <tr>
        <td colspan="2" style="text-align:right;">
          <b>
            Total Amount
          </b>
        </td>
        <td style="text-align:right;">
          {{isset($patient->basic_amount) ? $patient->basic_amount : 0}}
        </td>
      </tr>


      <tr>
        <td colspan="2" style="text-align:right;">
          <b>Discount</b>
        </td>
        <td style="text-align:right;">
          {{isset($patient->discount) ? $patient->discount : 0}}
        </td>
      </tr>

      <tr>
        <td colspan="2" style="text-align:right;">
          <b>Net Amount</b>
        </td>
        <td style="text-align:right;">
          {{isset($patient->net_amount) ? $patient->net_amount : 0}}
        </td>
      </tr>
      <?php
      $recived = $patient->cash_amount + $patient->paytm_amount;
      ?>
      <!-- <tr>
        <td colspan="3" style="text-align:right;">
          Received amount
        </td>
        <td style="text-align:right;">
          {{isset($recived) ? $recived : 0}}
        </td>
      </tr> -->

      <!-- <tr>
        <td colspan="3" style="text-align:right;">
          Balance
        </td>
        <td style="text-align:right;">
          {{isset($patient->balance) ? $patient->balance : 0}}
        </td>
      </tr> -->

      <tr>
        <td colspan="2" style="text-align:right;">
          <b>Amount in word</b>
        </td>
        <td style="text-align:right;">
          Rupees&nbsp;{{numberToWords($patient->net_amount)}}&nbsp;Only
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection