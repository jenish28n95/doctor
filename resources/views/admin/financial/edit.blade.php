@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Financial Year
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Edit Financial Year</li>
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
               {!! Form::model($financialyear, ['method'=>'PATCH', 'action'=> ['AdminFinancialYearController@update', $financialyear->id],'files'=>true,'class'=>'form-horizontal', 'name'=>'editfinancialForm']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="year" class="col-sm-2 control-label">Year</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="year" id="year" value="{{$financialyear->year}}" placeholder="Enter year" required>
                        @if($errors->has('year'))
                        <div class="error text-danger">{{ $errors->first('year') }}</div>
                        @endif
                     </div>
                  </div>
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
      $("form[name='editfinancialForm']").validate({
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