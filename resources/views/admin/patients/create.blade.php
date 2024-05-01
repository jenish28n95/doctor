@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/patients') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Add Patient
      </h1>
      <ol class=" breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Patient</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="box box-info">
         <div class="box-body">

            {!! Form::open(['method'=>'POST', 'action'=> 'AdminPatientsController@store','files'=>true,'class'=>'form-horizontal', 'name'=> 'addpatientform']) !!}
            @csrf
            <input type="hidden" name="f_year" value="{{Session::get('setfinancialyear')}}">
            <input type="hidden" name="discount_type" value="per">
            <div class="row">
               <!-- right column -->
               <div class="col-md-6">
                  <!-- Horizontal Form -->

                  <div class="form-group">
                     <label for="name" class="col-sm-3 control-label">Name</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required>
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                     </div>
                  </div>
                  <!-- <div class="form-group">
                     <label for="investigation" class="col-sm-3 control-label">Investigation</label>
                     <div class="col-sm-9">
                        <input type="text" name="investigation" id="investigation" class="form-control border border-dark mb-2" placeholder="Enter investigation">
                        @if($errors->has('investigation'))
                        <div class="error text-danger">{{ $errors->first('investigation') }}</div>
                        @endif
                     </div>
                  </div> -->
                  <div class="form-group">
                     <label for="doctors_id" class="col-sm-3 control-label">Reference Docotor</label>
                     <div class="col-sm-9">
                        <select name="doctors_id" id="doctors_id" class="custom-select form-control form-control-rounded" required>
                           <option value="">Select Doctor</option>
                           @foreach($doctors as $doctor)
                           <option value="{{$doctor->id}}">{{$doctor->name}}{{isset($doctor->degree) ? ' - '.$doctor->degree : ''}}</option>
                           @endforeach
                        </select>
                        @if($errors->has('doctors_id'))
                        <div class="error text-danger">{{ $errors->first('doctors_id') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="age" class="col-sm-3 control-label">Age</label>
                     <div class="col-sm-4">
                        <input type="number" name="age" id="age" class="form-control border border-dark mb-2" placeholder="Enter Age" required>
                        @if($errors->has('age'))
                        <div class="error text-danger">{{ $errors->first('age') }}</div>
                        @endif
                     </div>
                     <div class="col-sm-5">
                        <select name="year" id="year" class="custom-select form-control form-control-rounded" required>
                           <option value="year">Year</option>
                           <option value="month">Month</option>
                           <option value="day">Day</option>
                        </select>
                        @if($errors->has('year'))
                        <div class="error text-danger">{{ $errors->first('year') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="sex" class="col-sm-3 control-label">Gender</label>
                     <div class="col-sm-9">
                        <label class="radio-inline">
                           <input type="radio" name="sex" value="male" checked> Male
                        </label>
                        <label class="radio-inline">
                           <input type="radio" name="sex" value="female"> Female
                        </label>
                        @if($errors->has('sex'))
                        <div class="error text-danger">{{ $errors->first('sex') }}</div>
                        @endif
                     </div>
                  </div>

               </div>
               <!--/.col (right) -->

               <!-- left column -->
               <div class="col-md-6">
                  <!-- Horizontal Form -->
                  <div class="form-group">
                     <label for="mobile" class="col-sm-3 control-label">Mobile No</label>
                     <div class="col-sm-9">
                        <input type="number" name="mobile" id="mobile" class="form-control border border-dark mb-2" placeholder="Enter mobile no" minlength="10" maxlength="10">
                        @if($errors->has('mobile'))
                        <div class="error text-danger">{{ $errors->first('mobile') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="session" class="col-sm-3 control-label">Session</label>
                     <div class="col-sm-9">
                        <select name="session" id="session" class="custom-select form-control form-control-rounded" required>
                           <option value="Morning">Morning</option>
                           <option value="Evening">Evening</option>
                        </select>
                        @if($errors->has('session'))
                        <div class="error text-danger">{{ $errors->first('session') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="mediclaim" class="col-sm-3 control-label">Mediclaim</label>
                     <div class="col-sm-9">
                        <select name="mediclaim" id="mediclaim" class="custom-select form-control form-control-rounded" required>
                           <option value="No">No</option>
                           <option value="Yes">Yes</option>
                        </select>
                        @if($errors->has('mediclaim'))
                        <div class="error text-danger">{{ $errors->first('mediclaim') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="arrival_time" class="col-sm-3 control-label">Arrival Time</label>
                     <div class="col-sm-9">
                        <input type="text" name="arrival_time" id="arrival_time" class="form-control border border-dark mb-2" placeholder="Enter arrival time" autocomplete="off" required>
                        @if($errors->has('arrival_time'))
                        <div class="error text-danger">{{ $errors->first('arrival_time') }}</div>
                        @endif
                     </div>
                  </div>
                  <!-- <div class="form-group">
                     <label for="created_at" class="col-sm-3 control-label">Patient Created Date</label>
                     <div class="col-sm-9">
                        <input type="date" name="created_at" id="created_at" class="form-control border border-dark mb-2" placeholder="Enter date" autocomplete="off" required>
                        @if($errors->has('created_at'))
                        <div class="error text-danger">{{ $errors->first('created_at') }}</div>
                        @endif
                     </div>
                  </div> -->

               </div>
               <!--/.col (left) -->
            </div>

            <div class="row">
               <div class="col-md-6 control-label">
                  {!! Form::submit('Add', ['class'=>'btn btn-success text-white mt-1','style'=>'width:150px']) !!}
               </div>
            </div>
            <!-- /.row -->
            {!! Form::close() !!}

         </div>
      </div>

   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   $(function() {
      $("form[name='addpatientform']").validate({
         rules: {
            name: {
               required: true,
            },
            //mobile: {
            //   required: true,
            //},
            // investigation: {
            //    required: true,
            // },
            age: {
               required: true,
            },
            // sex: {
            //    required: true,
            // },
            session: {
               required: true,
            },
            mediclaim: {
               required: true,
            },
            arrival_time: {
               required: true,
            },
            payment: {
               required: true,
            },
            doctors_id: {
               required: true,
            }
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });
   $('#mobile').on('input', function() {
      var mobile = $(this).val();
      if (mobile.length !== 10) {
         $('#mobile-error').text('Mobile number must be exactly 10 digits.');
      } else {
         $('#mobile-error').text('');
      }
   });
   $('#age').on('input', function() {
      var age = parseInt($(this).val());
      if (isNaN(age) || age < 1 || age > 100) {
         $(this).val('');
      }
   });
   $('#arrival_time').datetimepicker({
      format: 'YYYY-MM-DD hh:mm A', // specify the format you want
      defaultDate: moment(),
      useCurrent: false // do not default to the current date/time
   });
   // $('#inv_time').datetimepicker({
   //    format: 'YYYY-MM-DD hh:mm A', // specify the format you want
   //    defaultDate: moment(),
   //    useCurrent: false // do not default to the current date/time
   // });
</script>
@endsection