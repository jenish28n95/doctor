@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Financial Years</b>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Financial Years</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">

         <div class="col-md-4">
            <div class="box box-primary">
               <div class="box-header">
                  <h3 class="box-title">Add Financial Year</h3>
               </div>
               <div class="box-body">
                  <!-- Horizontal Form -->
                  <div class="box box-info">
                     <div class="box-header with-border">
                        <!-- <h3 class="box-title">Horizontal Form</h3> -->
                     </div>
                     <!-- /.box-header -->
                     <!-- form start -->
                     {!! Form::open(['method'=>'POST', 'action'=> 'AdminFinancialYearController@store','files'=>true,'class'=>'form-horizontal', 'name'=>'addfinancialform']) !!}
                     @csrf
                     <div class="box-body">
                        <div class="form-group">
                           <label for="year" class="col-sm-2 control-label">Year</label>
                           <div class="col-sm-10">
                              <input type="text" class="form-control" name="year" id="year" placeholder="XXXX-XXXX" pattern="[0-9]{4}-[0-9]{4}" required>
                              @if($errors->has('year'))
                              <div class="error text-danger">{{ $errors->first('year') }}</div>
                              @endif
                           </div>
                        </div>

                        <div class="form-group">
                           <div class="col-md-6 col-sm-2 control-label">
                              {!! Form::submit('Add', ['class'=>'btn btn-success text-white mt-1']) !!}
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

         <div class="col-md-8">
            <div class="box">
               <div class="box-header" style="padding:0px">
                  @if (session('success'))
                  <div id="successMessage" class="alert pl-3 pt-2 pb-2" style="background-color:green;color:white">
                     {{ session('success') }}
                  </div>
                  @endif
               </div>
               <!-- /.box-header -->
               <div class="box-body" style="overflow-x:auto;">
                  <table id="example1" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Action</th>
                           <th>Year</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($financialyears as $index =>$year)
                        <td>
                           <a href="{{route('admin.financial_year.edit', $year->id)}}"><i class="fa fa-edit" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                           <!-- <a href="{{route('admin.financial_year.destroy', $year->id)}}" onclick="return confirm('Sure ! You want to delete reocrd ?');"><i class="fa fa-trash" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a> -->
                        </td>
                        <td>{{$year->year}}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <div class="row mt-4">
                     <div class="col-sm-12" style="display:flex;justify-content:center;">
                        {{$financialyears->links('pagination::bootstrap-4')}}
                     </div>
                  </div>
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
   document.getElementById('year').addEventListener('input', function(e) {
      var target = e.target;
      var value = target.value.replace(/\D/g, '').substring(0, 8);
      var formattedValue = value.replace(/(\d{4})/, '$1-').substring(0, 9); // Add '-' after 4 digits

      target.value = formattedValue;
   });
</script>
@endsection