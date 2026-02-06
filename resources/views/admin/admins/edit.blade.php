@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/admins') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Edit Admin
      </h1>
      <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Edit Admin</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- right column -->
         <div class="col-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
               <div class="box-header with-border">
                  <!-- <h3 class="box-title">Horizontal Form</h3> -->
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               {!! Form::model($admin, ['method'=>'PATCH', 'action'=> ['AdminAdminController@update', $admin->id],'files'=>true,'class'=>'form-horizontal', 'name'=>'editAdminForm']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="name" class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="name" id="name" value="{{$admin->name}}" placeholder="Enter name" required>
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                     </div>
                  </div>
                  <!-- <div class="form-group">
                     <label for="is_active" class="col-sm-2 control-label">Active</label>
                     <div class="col-sm-4">
                        <select name="is_active" id="is_active" class="custom-select form-control form-control-rounded" style="width:100%" required>
                           <option value="1" {{ $admin->is_active == '1' ? 'selected' : '' }}>Active</option>
                           <option value="0" {{ $admin->is_active == '0' ? 'selected' : '' }}>De-active</option>
                        </select>
                        @if($errors->has('is_active'))
                        <div class="error text-danger">{{ $errors->first('is_active') }}</div>
                        @endif
                     </div>
                  </div> -->
                  <div class="form-group">
                     <div class="col-md-3 col-sm-2 control-label">
                        {!! Form::submit('update', ['class'=>'btn btn-success text-white mt-1']) !!}
                     </div>
                  </div>
               </div>
               {!! Form::close() !!}
            </div>
            <!-- /.box -->
         </div>
         <!--/.col (right) -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   $(function() {
      $("form[name='editAdminForm']").validate({
         rules: {
            name: {
               required: true,
            },
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });
</script>
@endsection