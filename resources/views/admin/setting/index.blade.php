@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Setting</b>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Setting</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         @if (session('success'))
         <div id="successMessage" class="alert pl-3 pt-2 pb-2" style="background-color:green;color:white">
            {{ session('success') }}
         </div>
         @endif
         <div class="col-md-12">
            <div class="box box-primary">

               <div class="box-body1">
                  <!-- Horizontal Form -->
                  <div class="box box-info">
                     <div class="box-header with-border">
                        <!-- <h3 class="box-title">Horizontal Form</h3> -->
                     </div>
                     <!-- /.box-header -->
                     <!-- form start -->
                     {!! Form::open(['method'=>'POST', 'action'=> 'AdminSettingController@store','files'=>true,'class'=>'form-horizontal', 'name'=>'addfinancialform']) !!}
                     @csrf
                     <div class="box-body">
                        <div class="form-group">
                           <!-- <label for="year" class="col-sm-2 control-label">Commission value set</label> -->
                           <div class="col-sm-3">
                              <label for="year" class="control-label">Maximum amount threshould</label>
                              <input type="text" class="form-control" name="f_amount" id="f_amount" placeholder="Enter price" value="{{$f_setting->amount}}" required>
                           </div>
                           <div class="col-sm-3">
                              <label for="year" class="control-label">Max commission amount</label>
                              <input type="text" class="form-control" name="f_comm_amount" id="f_comm_amount" placeholder="Enter fixed rate" value="{{$f_setting->comm_amount}}" required>
                           </div>
                           <?php $value = $p_setting->comm_amount * 100 ?>
                           <div class="col-sm-3">
                              <label for="year" class="control-label">Min commission (in percentage)</label>
                              <input type="number" class="form-control" name="p_comm_amount" id="p_comm_amount" placeholder="Enter percentage" value="{{$value}}" required>
                           </div>
                        </div>

                        <!-- <div class="form-group">
                           <label for="year" class="col-sm-2 control-label">Commission in percentage</label>
                           <div class="col-sm-4">
                              <input type="text" class="form-control" name="p_amount" id="p_amount" placeholder="Enter amount" value="{{$p_setting->amount}}" required>
                           </div>
                           <?php $value = $p_setting->comm_amount * 100 ?>
                           <div class="col-sm-4">
                              <input type="text" class="form-control" name="p_comm_amount" id="p_comm_amount" placeholder="Enter percentage" value="{{$value}}" required>
                           </div>
                        </div> -->

                        <div class="form-group">
                           <div class="col-md-6 col-sm-2 control-label">
                              {!! Form::submit('Update', ['class'=>'btn btn-success text-white mt-1']) !!}
                           </div>
                        </div>
                     </div>
                     {!! Form::close() !!}
                  </div>
                  <!-- /.box -->
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
   $(function() {
      $("form[name='addfinancialform']").validate({
         rules: {
            year: {
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