@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/short_code') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Edit Short Code
      </h1>
      <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Edit Short Code</li>
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
               {!! Form::model($shortcode, ['method'=>'PATCH', 'action'=> ['AdminShortCodeController@update', $shortcode->id],'files'=>true,'class'=>'form-horizontal', 'name'=>'editShortcodeForm']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="code" class="col-sm-2 control-label">Short Code</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="code" id="code" value="{{$shortcode->code}}" placeholder="Enter short code" required>
                        <!-- <input type="text" class="form-control" name="code" id="code" value="{{$shortcode->code}}" placeholder="Enter short code" minlength="4" maxlength="4" required>
                        <p style="font-size:12px;color:red">Minimun and maximum 4 cherector only</p> -->
                        @if($errors->has('code'))
                        <div class="error text-danger">{{ $errors->first('code') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="value" class="col-sm-2 control-label">Content</label>
                     <div class="col-sm-4">
                        <textarea class="form-control" name="value" required>{{$shortcode->value}}</textarea>
                        @if($errors->has('value'))
                        <div class="error text-danger">{{ $errors->first('value') }}</div>
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
      $("form[name='editShortcodeForm']").validate({
         rules: {
            code: {
               required: true,
            },
            value: {
               required: true,
            }
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });
</script>
@endsection