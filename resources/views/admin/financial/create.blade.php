@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/financial_year') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Add Financial Year
      </h1>
      <ol class=" breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Financial Year</li>
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
               {!! Form::open(['method'=>'POST', 'action'=> 'AdminFinancialYearController@store','files'=>true,'class'=>'form-horizontal', 'name'=>'addfinancialform']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="year" class="col-sm-2 control-label">Year</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="year" id="year" placeholder="Enter year" required>
                        @if($errors->has('year'))
                        <div class="error text-danger">{{ $errors->first('year') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-3 col-sm-2 control-label">
                        {!! Form::submit('Add', ['class'=>'btn btn-success text-white mt-1']) !!}
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