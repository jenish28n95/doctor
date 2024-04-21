@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/doctors') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Edit Doctor
      </h1>
      <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Edit Doctor</li>
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
               {!! Form::model($doctor, ['method'=>'PATCH', 'action'=> ['AdminDoctorsController@update', $doctor->id],'files'=>true,'class'=>'form-horizontal', 'name'=>'editDocotorForm']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="name" class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="name" id="name" value="{{$doctor->name}}" placeholder="Enter name" required>
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="degree" class="col-sm-2 control-label">Degree</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="degree" id="degree" value="{{$doctor->degree}}" placeholder="Enter Degree">
                        @if($errors->has('degree'))
                        <div class="error text-danger">{{ $errors->first('degree') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="speciality" class="col-sm-2 control-label">Speciality</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="speciality" id="speciality" value="{{$doctor->speciality}}" placeholder="Enter speciality">
                        @if($errors->has('speciality'))
                        <div class="error text-danger">{{ $errors->first('speciality') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="mobile" class="col-sm-2 control-label">Mobile No</label>
                     <div class="col-sm-4">
                        <input type="number" name="mobile" id="mobile" class="form-control border border-dark mb-2" placeholder="Enter mobile no" minlength="10" maxlength="10" value="{{$doctor->mobile}}">
                        @if($errors->has('mobile'))
                        <div class="error text-danger">{{ $errors->first('mobile') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="address" class="col-sm-2 control-label">Address</label>
                     <div class="col-sm-4">
                        <textarea name="address" id="address" value="" class="form-control border border-dark mb-2" placeholder="Enter Address">{{$doctor->address}}</textarea>
                        @if($errors->has('address'))
                        <div class="error text-danger">{{ $errors->first('address') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="email" class="col-sm-2 control-label">Email</label>
                     <div class="col-sm-4">
                        <input type="email" name="email" id="email" class="form-control border border-dark mb-2" value="{{$doctor->email}}" placeholder="Enter email">
                        @if($errors->has('email'))
                        <div class="error text-danger">{{ $errors->first('email') }}</div>
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
      $("form[name='editDocotorForm']").validate({
         rules: {
            name: {
               required: true,
            },
            //degree: {
            //   required: true,
            //},
            //speciality: {
            //   required: true,
            //},
            // address: {
            //    required: true,
            // },
            //mobile: {
            //   required: true,
            //},
            // email: {
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