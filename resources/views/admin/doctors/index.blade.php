<?php

use App\Models\Patient;
?>

@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Doctors Lists</b> &nbsp; <a href="{{route('admin.doctors.create')}}" class="bg-primary text-white text-decoration-none" style="padding:8px 12px;margin-left:15px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Doctors Lists</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header" style="padding:0px">
                  @if (session('success'))
                  <div id="successMessage" class="alert pl-3 pt-2 pb-2" style="background-color:green;color:white">
                     {{ session('success') }}
                  </div>
                  @endif
               </div>
               <!-- <div class="row">
                  <div class="col-md-9">
                     <a href="{{route('admin.doctors.create')}}" class="bg-primary text-white text-decoration-none" style="padding:12px 12px;margin-left:20px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
                  </div>
               </div> -->
               <!-- /.box-header -->
               <div class="box-body" style="overflow-x:auto;">
                  <table id="doctoreTable" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Action</th>
                           <th>Doctors Name</th>
                           <th>Degree</th>
                           <th>Speciality</th>
                           <th>Mobile No</th>
                           <!-- <th>Email</th> -->
                           <!-- <th>Address</th> -->
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($doctors as $index =>$doctor)
                        <td>
                           <a href="{{route('admin.doctors.edit', $doctor->id)}}"><i class="fa fa-edit" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                           <?php
                           $count_patient = 0;
                           $count_patient = Patient::where('doctors_id', $doctor->id)->count();
                           ?>
                           @if($count_patient == 0)
                           <a href="{{route('admin.doctors.destroy', $doctor->id)}}" onclick="return confirm('Sure ! You want to delete reocrd ?');"><i class="fa fa-trash" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                           @endif
                        </td>
                        <td>{{$doctor->name}}</td>
                        <td>{{$doctor->degree}}</td>
                        <td>{{$doctor->speciality}}</td>
                        <td>{{$doctor->mobile}}</td>
                        <!-- <td>{{$doctor->email}}</td> -->
                        <!-- <td>
                           @if(strlen($doctor->address) > 50)
                           {!!substr($doctor->address,0,50)!!}
                           <span class="read-more-show hide_content">More<i class="fa fa-angle-down"></i></span>
                           <span class="read-more-content"> {{substr($doctor->address,50,strlen($doctor->address))}}
                              <span class="read-more-hide hide_content">Less <i class="fa fa-angle-up"></i></span> </span>
                           @else
                           {{$doctor->address}}
                           @endif
                        </td> -->
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <div class="row mt-4">
                     <div class="col-sm-12" style="display:flex;justify-content:center;">
                        {{$doctors->links('pagination::bootstrap-4')}}
                     </div>
                  </div>
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
      $("#doctoreTable").DataTable();
   });
</script>
@endsection