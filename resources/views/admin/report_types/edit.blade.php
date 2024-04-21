@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/report_types') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Edit Report Type
      </h1>
      <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Edit Report Type</li>
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
               {!! Form::model($rtype, ['method'=>'PATCH', 'action'=> ['AdminReportTypesController@update', $rtype->id],'files'=>true,'class'=>'form-horizontal', 'name'=>'editrtypeForm']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="name" class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="name" id="name" value="{{$rtype->name}}" placeholder="Enter name" required>
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="amount" class="col-sm-2 control-label">Amount</label>
                     <div class="col-sm-4">
                        <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter amount" value="{{$rtype->amount}}">
                        @if($errors->has('amount'))
                        <div class="error text-danger">{{ $errors->first('amount') }}</div>
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

      <!-- <div class="row">
         @if (session('success'))
         <div id="successMessage" class="alert pl-3 pt-2 pb-2" style="background-color:green;color:white">
            {{ session('success') }}
         </div>
         @endif
         <div class="col-12">
            <div class="box">
               <div class="box-header with-border">
                  Import Document File
               </div>

               {!! Form::open(['method'=>'POST', 'action'=> 'AdminReportTypesController@storeDocFile','files'=>true,'class'=>'form-horizontal', 'name'=>'addreportfile']) !!}
               @csrf
               <input type="hidden" name="rtype_id" value="{{$rtype->id}}">
               <div class="box-body">
                  <div class="form-group">
                     <label for="childreportid" class="col-sm-2 control-label">Child Reports</label>
                     <div class="col-sm-4">
                        <select name="childreportid" id="childreportid" class="custom-select form-control form-control-rounded" required>
                           <option value="">Select Type</option>
                           @foreach($childrtype as $rtype)
                           <option value="{{$rtype->id}}">{{$rtype->name}}</option>
                           @endforeach
                        </select>
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="file" class="col-sm-2 control-label">File</label>
                     <div class="col-sm-4">
                        <input type="file" class="form-control" name="file" id="file" placeholder="Select file" required>
                        @if($errors->has('file'))
                        <div class="error text-danger">{{ $errors->first('file') }}</div>
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
         </div>
      </div> -->

   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   $(function() {
      $("form[name='editrtypeForm']").validate({
         rules: {
            name: {
               required: true,
            },
            // amount: {
            //    required: true,
            // },
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });
</script>
@endsection