@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Short code List</b> &nbsp; <a href="{{route('admin.short_code.create')}}" class="bg-primary text-white text-decoration-none" style="padding:8px 12px;margin-left:15px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Short code List</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
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
                  <table id="shortcodeTable" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Action</th>
                           <th>Short name</th>
                           <th>Content</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($shortcodes as $index =>$shortcode)
                        <td>
                           <a href="{{route('admin.short_code.edit', $shortcode->id)}}"><i class="fa fa-edit" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                           <a href="{{route('admin.short_code.destroy', $shortcode->id)}}" onclick="return confirm('Sure ! You want to delete reocrd ?');"><i class="fa fa-trash" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                        </td>
                        <td>{{$shortcode->code}}</td>
                        <td>
                           @if(strlen($shortcode->value) > 50)
                           {!!substr($shortcode->value,0,50)!!}
                           <span class="read-more-show hide_content">More<i class="fa fa-angle-down"></i></span>
                           <span class="read-more-content"> {{substr($shortcode->value,50,strlen($shortcode->value))}}
                              <span class="read-more-hide hide_content">Less <i class="fa fa-angle-up"></i></span> </span>
                           @else
                           {{$shortcode->value}}
                           @endif
                        </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
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
   $(document).ready(function() {
      $("#shortcodeTable").DataTable();
   });
</script>
@endsection