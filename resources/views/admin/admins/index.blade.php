@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Admin Lists</b> &nbsp; <a href="{{route('admin.admins.create')}}" class="bg-primary text-white text-decoration-none" style="padding:8px 12px;margin-left:15px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Admin Lists</li>
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
               <div class="row">
               </div>
               <!-- /.box-header -->
               <div class="box-body" style="overflow-x:auto;">
                  <table id="adminTable" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Action</th>
                           <th>Name</th>
                           <!-- <th>Status</th> -->
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($admins as $index =>$admin)
                        <td>
                           <a href="{{route('admin.admins.edit', $admin->id)}}"><i class="fa fa-edit" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                           <!-- <a href="{{route('admin.admins.destroy', $admin->id)}}" onclick="return confirm('Sure ! You want to delete reocrd ?');"><i class="fa fa-trash" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a> -->
                        </td>
                        <td>{{$admin->name}}</td>
                        <!-- <td>
                           @if($admin->is_active == 1)
                           <a href="/admin/admins/active/{{$admin->id}}" class="btn btn-success">Active</a>
                           @else
                           <a href="/admin/admins/active/{{$admin->id}}" class="btn btn-danger">De-active</a>
                           @endif
                        </td> -->
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
      $("#adminTable").DataTable({
         "pageLength": 25
      });
   });
</script>
@endsection