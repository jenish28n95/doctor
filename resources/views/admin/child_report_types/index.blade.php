@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Child Report Types</b> <a href="{{route('admin.child_report_types.create')}}" class="bg-primary text-white text-decoration-none" style="padding:8px 12px;margin-left:15px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Child Report Types</li>
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
                     <a href="{{route('admin.child_report_types.create')}}" class="bg-primary text-white text-decoration-none" style="padding:12px 12px;margin-left:20px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
                  </div>
               </div> -->
               <!-- /.box-header -->
               <div class="box-body" style="overflow-x:auto;">
                  <table id="childReportTable" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Action</th>
                           <th>Report Name</th>
                           <th>Child Report Name</th>
                           <th>Amount</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($childrtypes as $index =>$rtype)
                        <td>
                           <a href="{{route('admin.child_report_types.edit', $rtype->id)}}"><i class="fa fa-edit" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                           <a href="{{route('admin.child_report_types.destroy', $rtype->id)}}" onclick="return confirm('Sure ! You want to delete reocrd ?');"><i class="fa fa-trash" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                        </td>
                        <td>{{$rtype->rtypes->name}}</td>
                        <td>{{$rtype->name}}</td>
                        <td>{{$rtype->amount}}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>

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
      $("#childReportTable").DataTable();
   });
</script>
@endsection