@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/child_report_types') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Add Child Report Type
      </h1>
      <ol class=" breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Child Report Type</li>
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
               {!! Form::open(['method'=>'POST', 'action'=> 'AdminChildReportTypesController@store','files'=>true,'class'=>'form-horizontal', 'name'=>'addrtypeform']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="rtypes_id" class="col-sm-2 control-label">Report type</label>
                     <div class="col-sm-4">
                        <select name="rtypes_id" id="rtypes_id" class="custom-select form-control form-control-rounded" required>
                           <option value="">Select report</option>
                           @foreach($rtypes as $rtype)
                           <option value="{{$rtype->id}}">{{$rtype->name}}</option>
                           @endforeach
                        </select>
                        @if($errors->has('rtypes_id'))
                        <div class="error text-danger">{{ $errors->first('rtypes_id') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="name" class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required>
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="amount" class="col-sm-2 control-label">Amount</label>
                     <div class="col-sm-4">
                        <input type="number" name="amount" id="amount" class="form-control border border-dark mb-2" placeholder="Enter amount" required>
                        @if($errors->has('amount'))
                        <div class="error text-danger">{{ $errors->first('amount') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="file" class="col-sm-2 control-label">File</label>
                     <div class="col-sm-4">
                        <input type="file" class="form-control" name="file" id="file" placeholder="Select file">
                        @if($errors->has('file'))
                        <div class="error text-danger">{{ $errors->first('file') }}</div>
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
      $("form[name='addrtypeform']").validate({
         rules: {
            rtypes_id: {
               required: true,
            },
            name: {
               required: true,
            },
            amount: {
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