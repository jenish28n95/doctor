<?php

use App\Models\Rtype;
use App\Models\Wallet;
use App\Models\Childrtype;

?>

@extends('layouts.admin')
@section('style')
<style>
  /* Add your styling here */
  .accordion {
    display: flex;
    flex-direction: column;
    max-width: 100%;
    /* Adjust as needed */
  }

  .accordion-item {
    border: 1px solid #000;
    margin-bottom: 5px;
    overflow: hidden;
  }

  .accordion-header {
    background-color: transparent;
    padding: 10px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .accordion-content {
    display: none;
    padding: 10px;
  }

  .accordion-arrow {
    transition: transform 0.3s ease-in-out;
  }

  .accordion-item.active .accordion-arrow {
    transform: rotate(180deg);
  }

  .remove-bottom-space {
    margin-bottom: 0px;
  }
</style>
@endsection
@section('content')

@php
$ids = [];
if(count($patientreports)>0){
foreach($patientreports as $emp) {
$ids[] = $emp->id;
}
}
@endphp

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header" style="display: flex; align-items: center;">
    <a href="{{ URL::to('/admin/patients') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
    <h1 style="margin-left: 10px;">
      Edit Patient
    </h1>
    <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
      <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Edit Patient</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    @if (session('success'))
    <div id="successMessage" class="alert pl-3 pt-2 pb-2" style="background-color:green;color:white">
      {{ session('success') }}
    </div>
    @endif

    <div class="box box-info">
      <div class="box-body">

        <div class="accordion p-3">
          <div class="accordion-item">
            <div class="accordion-header">
              <span><b>Show Patient Detail</b></span>
              <span class="accordion-arrow">&#9658;</span>
            </div>
            <div class="accordion-content">
              {!! Form::model($patient, ['method'=>'PATCH', 'action'=> ['AdminPatientsController@update', $patient->id],'files'=>true,'class'=>'form-horizontal', 'name'=>'editPatientForm']) !!}
              @csrf
              <div class="row">

                <!-- right column -->
                <div class="col-md-6">
                  <!-- Horizontal Form -->

                  <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{$patient->name}}" required>
                      @if($errors->has('name'))
                      <div class="error text-danger">{{ $errors->first('name') }}</div>
                      @endif
                    </div>
                  </div>
                  <!-- <div class="form-group">
                              <label for="investigation" class="col-sm-3 control-label">Investigation</label>
                              <div class="col-sm-9">
                                 <input type="text" name="investigation" id="investigation" class="form-control border border-dark mb-2" placeholder="Enter investigation" value="{{$patient->investigation}}">
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
                        <option value="{{$doctor->id}}" {{ $patient->doctors_id == $doctor->id ? 'selected' : '' }}>{{$doctor->name}}{{isset($doctor->degree) ? '-'.$doctor->degree : ''}}</option>
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
                      <input type="number" name="age" id="age" class="form-control border border-dark mb-2" value="{{$patient->age}}" placeholder="Enter Age" required>
                      @if($errors->has('age'))
                      <div class="error text-danger">{{ $errors->first('age') }}</div>
                      @endif
                    </div>
                    <div class="col-sm-5">
                      <select name="year" id="year" class="custom-select form-control form-control-rounded" required>
                        <option value="year" {{ $patient->year == 'year' ? 'selected' : '' }}>Year</option>
                        <option value="month" {{ $patient->year == 'month' ? 'selected' : '' }}>Month</option>
                        <option value="day" {{ $patient->year == 'day' ? 'selected' : '' }}>Day</option>
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
                        <input type="radio" name="sex" value="male" {{ $patient->sex == 'male' ? 'checked' : '' }}> Male
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="sex" value="female" {{ $patient->sex == 'female' ? 'checked' : '' }}> Female
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
                      <input type="number" name="mobile" id="mobile" class="form-control border border-dark mb-2" value="{{$patient->mobile}}" placeholder="Enter mobile no" maxlength="10">
                      @if($errors->has('mobile'))
                      <div class="error text-danger">{{ $errors->first('mobile') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="session" class="col-sm-3 control-label">Session</label>
                    <div class="col-sm-9">
                      <select name="session" id="session" class="custom-select form-control form-control-rounded" required>
                        <option value="Morning" {{ $patient->session == "Morning" ? 'selected' : '' }}>Morning</option>
                        <option value="Evening" {{ $patient->session == "Evening" ? 'selected' : '' }}>Evening</option>
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
                        <option value="No" {{ $patient->mediclaim == "No" ? 'selected' : '' }}>No</option>
                        <option value="Yes" {{ $patient->mediclaim == "Yes" ? 'selected' : '' }}>Yes</option>
                      </select>
                      @if($errors->has('mediclaim'))
                      <div class="error text-danger">{{ $errors->first('mediclaim') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="arrival_time" class="col-sm-3 control-label">Arrival Time</label>
                    <div class="col-sm-9">
                      <input type="text" name="arrival_time" id="arrival_time" class="form-control border border-dark mb-2" value="{{$patient->arrival_time}}" placeholder="Enter arrival time" required>
                      @if($errors->has('arrival_time'))
                      <div class="error text-danger">{{ $errors->first('arrival_time') }}</div>
                      @endif
                    </div>
                  </div>
                  <!-- <div class="form-group">
                              <label for="created_at" class="col-sm-3 control-label">Patient Created Date</label>
                              <div class="col-sm-9">
                                 <input type="date" name="created_at" id="created_at" class="form-control border border-dark mb-2" placeholder="Enter date" value="{{$patient->created_at}}" required>
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
                  {!! Form::submit('Update', ['class'=>'btn btn-success text-white mt-1']) !!}
                </div>
              </div>
              {!! Form::close() !!}
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-md-2">
            <div id="report{{$patient->id}}" onclick='addreport(this.id)' style="margin-left:10px;cursor: pointer"><i class="fa fa-plus" style="color:white;font-size:15px;background-color:green;padding:8px;">&nbsp;ADD REPORTS</i></div>
          </div>
        </div>

        <div id="showreport{{$patient->id}}" style="display:none">
          {!! Form::open(['method'=>'POST', 'action'=> 'AdminPatientsController@storeReport','files'=>true,'class'=>'form-horizontal']) !!}
          @csrf
          <input type="hidden" name="patients_id" value="{{$patient->id}}">
          <div class="row form-group" style="margin-top:15px;">
            <div class="col-sm-2" style="margin-left:10px">
              <select name="report_id" id="report_id" class="custom-select form-control form-control-rounded" required>
                <option value="">Select report</option>
                @foreach($rtypes as $pro)
                <option data-price="{{$pro->amount}}" value="{{$pro->id}}">{{$pro->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3">
              <select name="childreport_id" id="childreport_id" class="custom-select form-control form-control-rounded" required>
                <option value="">Select child report</option>
              </select>
            </div>
            <div class="col-sm-2">
              <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter amount" required>
            </div>
            <div class="col-sm-3">
              <select name="file" id="file" class="custom-select form-control form-control-rounded" required>
                <option value="">Select report</option>
              </select>
            </div>
          </div>

          {!! Form::close() !!}
        </div>
      </div>
      @if(count($patientreports)>0)
      <table id="example1" cellpadding="1" class="table table-bordered table-striped">
        <thead class="bg-primary">
          <tr>
            <th>Action</th>
            <th>Report Name</th>
            <th>Child Report Name</th>
            <th>Edit</th>
            <th>PDF</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
          @foreach($patientreports as $emp)
          <tr>
            <td>
              <a href="{{route('admin.patientsreport.destroy', $emp->id)}}" onclick="return confirm('Sure ! You want to delete ?');"><i class="fa fa-trash" style="color:white;font-size:15px;background-color:red;padding:8px;border-radius:200px;"></i></a>
            </td>
            <?php
            $r_name = Rtype::where('id', $emp->report_id)->first();
            ?>
            <td>
              {{$r_name->name}}
            </td>
            <?php
            $child_r_name = Childrtype::where('id', $emp->childreport_id)->first();
            ?>
            <td>
              {{$child_r_name->name}}
            </td>
            <td>
              <button id="editor_button_{{$emp->id}}" data-value="{{$emp->id}}" onclick="openModaledit('{{$emp->id}}')">Editor</button>
            </td>
            <td>
              <a href="{{$emp->file}}" target="_blank"><i class="fa fa-file-pdf-o" style="font-size:22px;color:red"></i></a>
            </td>
            <td>
              {{$emp->amount}}
            </td>
          </tr>

          @endforeach

          {!! Form::open(['method'=>'post', 'action'=> 'AdminPatientsController@updateDiscount', 'class'=>'form-horizontal', 'id'=>'myForm']) !!}
          @csrf
          <input type="hidden" name="id" value="{{$patient->id}}">

          <tr>
            <td colspan="5" style="text-align:right;">
              <b>
                Total Amount
              </b>
            </td>
            <td>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group remove-bottom-space">
                    <input type="number" class="form-control" name="basic_amount" id="basic_amount" oninput="calculateNetAmount()" value="{{$patient->basic_amount}}">
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td colspan="5" style="text-align:right;">
              <b>
                Discount
              </b>
            </td>
            <td>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group remove-bottom-space">
                    <select name="discount_type" id="discount_type" class="custom-select form-control form-control-rounded" oninput="calculateNetAmount()" required>
                      <option value="per" {{$patient->discount_type == 'per' ? 'selected' : ''}}>%</option>
                      <option value="fix" {{$patient->discount_type == 'fix' ? 'selected' : ''}}>Fix</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group remove-bottom-space">
                    <input type="number" class="form-control" name="discount" id="discount" value="{{$patient->discount}}" oninput="calculateNetAmount()">
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td colspan="5" style="text-align:right;">
              <b>
                Commission
              </b>
            </td>
            <td>
              <?php $wallet = Wallet::where('patients_id', $patient->id)->first();
              $comm = isset($wallet) ? $wallet->comm_amount : 0;  ?>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group remove-bottom-space">
                    <input type="number" class="form-control" name="doctor_comm" id="doctor_comm" value="{{isset($comm) ? $comm : ''}}">
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td colspan="5" style="text-align:right;">
              <b>
                Net amount
              </b>
            </td>
            <td>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group remove-bottom-space">
                    <input type="number" class="form-control" name="net_amount" id="net_amount" value="{{$patient->net_amount}}">
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <tr style="padding:5px;">
            <td colspan="5" style="text-align:right;padding:5px;">
              <b>
                Payment
              </b>
            </td>
            <td style="padding:5px;">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group remove-bottom-space">
                    <span>payment method</span>
                    <select name="payment_mode" id="payment_mode" class="custom-select form-control form-control-rounded" onchange="togglePaymentFields()">
                      <option value="cash" {{ $patient->payment_mode == 'done' ? 'selected' : '' }}>Cash</option>
                      <option value="paytm" {{ $patient->payment_mode == 'paytm' ? 'selected' : '' }}>Paytm</option>
                      <option value="cash+paytm" {{ $patient->payment_mode == 'cash+paytm' ? 'selected' : '' }}>Cash + Paytm</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3" id="cash" style="margin-left:10px;">
                  <div class="form-group remove-bottom-space">
                    <span>Enter cash amount</span>
                    <input type="number" class="form-control" name="cash_amount" id="cash_amount" placeholder="cash" value="{{$patient->cash_amount}}" oninput="updateBalance()">
                  </div>
                </div>
                <div class="col-md-3" id="paytm" style="margin-left:10px;display:none;">
                  <div class="form-group remove-bottom-space">
                    <span>Enter paytm amount</span>
                    <input type="number" class="form-control" name="paytm_amount" id="paytm_amount" placeholder="paytm" value="{{$patient->paytm_amount}}" oninput="updateBalance()">
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <tr style="padding:5px;">
            <td colspan="5" style="text-align:right;padding:5px;">
              <b>
                Balance
              </b>
            </td>
            <td style="padding:5px;">
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group remove-bottom-space">
                    <input type="number" class="form-control" name="balance" id="balance" value="{{$patient->balance}}">
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td colspan="5"></td>
            <td>
              <div class="row">
                <div class="col-md-2" style="margin-left:10px">
                  {!! Form::submit('Add', ['class'=>'btn btn-success text-white mt-1','style'=>'width:100px']) !!}
                </div>
              </div>
            </td>
          </tr>

          {!! Form::close() !!}
        </tbody>
      </table>
      @endif

    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-body">

        {!! Form::open(['method'=>'post', 'action'=> 'AdminPatientsController@storeReport', 'class'=>'form-horizontal']) !!}
        @csrf

        {!! Form::hidden('childreport_id', null, ['id' => 'modal_child_id']) !!}
        {!! Form::hidden('report_id', null, ['id' => 'modal_report_id']) !!}
        {!! Form::hidden('patients_id', $patient->id, ['id' => 'modal_patients_id']) !!}
        {!! Form::hidden('amount', $patient->id, ['id' => 'modal_amount_id']) !!}
        {!! Form::hidden('created_at', $patient->id, ['id' => 'modal_patients_created']) !!}

        <textarea id="editContent" name="editContent"></textarea>

        <center>
          {!! Form::submit('ADD', ['class'=>'btn btn-success text-white mt-1','style'=>'width:80px']) !!}
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close" onclick="closeaddModal()">Close</button>
        </center>

        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="editorModal" tabindex="-1" aria-labelledby="editorModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-body">
        @foreach($patientreports as $emp)

        {!! Form::open(['method'=>'post', 'action'=> 'AdminPatientsController@updateReportContent', 'class'=>'form-horizontal']) !!}
        @csrf
        <input type="hidden" name="patientreportid" value="{{$emp->id}}">
        <div id="editorContent_{{$emp->id}}" style="display: none;">
          <textarea id="editorContainer_{{$emp->id}}" class="ckeditor" name="report_content">{!! $emp->report_content !!}</textarea>

          <center>
            {!! Form::submit('Update', ['class'=>'btn btn-success text-white mt-1','style'=>'width:80px']) !!}
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()">Close</button>
          </center>
        </div>

        {!! Form::close() !!}
        @endforeach
      </div>
    </div>
  </div>
</div>

<!-- /.row -->
</section>
<!-- /.content -->
</div>

@endsection

@section('script')

<!-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<!-- <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script> -->

<script>
  CKEDITOR.replace('editContent', {
    height: '450px',
    width: '100%',
    on: {
      instanceReady: function(event) {
        event.editor.on('key', function(event) {
          if (event.data.keyCode === 13) { // Check if Enter key is pressed
            var editorContent = event.editor.getData();
            var atIndex = editorContent.lastIndexOf('^');
            if (atIndex !== -1) {
              // var searchTerm = editorContent.substring(atIndex + 1).trim();
              var searchTerm = editorContent.substring(atIndex + 1, atIndex + 5).trim();
              searchTerm = searchTerm.replace(/<\/?[^>]+(>|$)/g, "");
              event.cancel(); // Cancel the default Enter key behavior
              fetchRelatedContent(searchTerm);
            }
          }
        });
      }
    }
  });

  function fetchRelatedContent(searchTerm) {
    $.ajax({
      type: 'GET',
      url: '/admin/get-related-text',
      data: {
        '_token': '{{ csrf_token() }}',
        'search_term': searchTerm
      },
      success: function(response) {
        console.log(response);
        if (response.suggestion.length > 0) {
          replaceTextWithSuggestion(response.suggestion[0].value); // Replace content with the first suggestion
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', error);
      }
    });
  }

  function replaceTextWithSuggestion(value) {
    var editor = CKEDITOR.instances.editContent;
    var editorContent = editor.getData();
    var atIndex = editorContent.lastIndexOf('^');
    var newText = editorContent.substring(0, atIndex) + value + editorContent.substring(atIndex + 5);
    editor.setData(newText);
  }
</script>

<script>
  function openModaledit(id) {
    // Hide all editor content divs
    var editorContents = document.querySelectorAll("[id^='editorContent_']");
    editorContents.forEach(function(editorContent) {
      editorContent.style.display = 'none';
    });

    // Show the editor content with the specific id
    var specificEditorContent = document.getElementById('editorContent_' + id);
    specificEditorContent.style.display = 'block';

    $('#editorModal').modal('show');

  }

  var editorIds = @json(array_unique($ids));
  editorIds.forEach(function(editorId) {
    CKEDITOR.replace('editorContainer_' + editorId, {
      height: '450px',
      width: '100%',
      on: {
        instanceReady: function(event) {
          event.editor.on('key', function(event) {
            if (event.data.keyCode === 13) { // Check if Enter key is pressed
              var editorContent = event.editor.getData();
              var atIndex = editorContent.lastIndexOf('^');
              if (atIndex !== -1) {
                var searchTerm = editorContent.substring(atIndex + 1, atIndex + 5).trim();
                searchTerm = searchTerm.replace(/<\/?[^>]+(>|$)/g, "");
                event.cancel(); // Cancel the default Enter key behavior
                fetchRelatedContentDynamic(searchTerm, editorId);
              }
            }
          });
        }
      }
    });
  });


  // Function to fetch related content via AJAX
  function fetchRelatedContentDynamic(searchTerm, editorId) {
    $.ajax({
      type: 'GET',
      url: '/admin/get-related-text',
      data: {
        '_token': '{{ csrf_token() }}',
        'search_term': searchTerm
      },
      success: function(response) {
        if (response.suggestion.length > 0) {
          replaceTextWithSuggestionDynamic(response.suggestion[0].value, editorId); // Pass editorId to the function
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', error);
      }
    });
  }

  // Function to replace editor content with a suggestion
  function replaceTextWithSuggestionDynamic(value, editorId) {
    var editor = CKEDITOR.instances['editorContainer_' + editorId]; // Dynamically construct the CKEditor instance ID
    var editorContent = editor.getData();
    var atIndex = editorContent.lastIndexOf('^');
    var newText = editorContent.substring(0, atIndex) + value + editorContent.substring(atIndex + 5);
    editor.setData(newText);
  }

  function closeModal() {
    $('#editorModal').modal('hide');
  }

  function closeaddModal() {
    if (editorInstance) {
      editorInstance.setData('');
      editorInstance.destroy().then(() => {
        editorInstance = null; // Reset the instance reference
      });
    }
    $('#addModal').modal('hide');
  }
</script>

<script>
  var editorInstance;
  $(function() {
    $("form[name='editPatientForm']").validate({
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
        doctors_id: {
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
        // arrival_time: {
        //    required: true,
        // },
        // inv_time: {
        //    required: true,
        // },
        // discount: {
        //    required: true,
        // },
        // net_amount: {
        //    required: true,
        // },
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    $('#report_id').change(function() {
      var report_id = $(this).val();
      if (report_id) {
        $.ajax({
          type: 'POST',
          url: '/admin/get-child-reports',
          data: {
            '_token': '{{ csrf_token() }}',
            'report_id': report_id,
          },
          success: function(data) {
            $('#childreport_id').empty();
            $('#childreport_id').append('<option value="">Select</option>');
            $.each(data, function(key, value) {
              $('#childreport_id').append('<option data-price="' + value.amount + '" value="' + value.id + '">' + value.name + '</option>');
            });
          }
        });
      } else {
        $('#worker_name').empty();
      }
    });
    $('#childreport_id').change(function() {
      var childreport_id = $(this).val();
      var report_id = $('#report_id').val();
      if (childreport_id) {
        $.ajax({
          type: 'POST',
          url: '/admin/get-sub-child-reports',
          data: {
            '_token': '{{ csrf_token() }}',
            'childreport_id': childreport_id,
            'report_id': report_id,
          },
          success: function(data) {
            $('#file').empty();
            $('#file').append('<option value="">Select</option>');
            $.each(data.all_media, function(key, value) {
              $('#file').append('<option value="' + value.basename + '">' + value.basename + '</option>');
            });
          }
        });
      } else {
        $('#worker_name').empty();
      }
    });
    $('#file').change(function() {
      var child_id = $('#childreport_id').val();
      var report_id = $('#report_id').val();
      var selected_file = $('#file').val();
      var report_amount = $('#amount').val();

      $('#modal_child_id').val(child_id);
      $('#modal_report_id').val(report_id);
      $('#modal_patients_id').val(<?= $patient->id; ?>);
      $('#modal_amount_id').val(report_amount);
      $('#modal_patients_created').val('<?= $patient->created_at; ?>');

      if (selected_file) {
        $.ajax({
          type: 'POST',
          url: '/admin/get-file-content',
          data: {
            '_token': '{{ csrf_token() }}',
            'child_id': child_id,
            'report_id': report_id,
            'selected_file': selected_file,
            'patients_id': <?= $patient->id; ?>,
          },
          success: function(response) {
            if (response.error) {
              // CKEDITOR.instances['editContent'].setData(response.error);
            } else {
              console.log('Content retrieved successfully:', response.content);
              // CKEDITOR.instances.editContent.setData(response.content);
              openModaladd(response.content);
            }
          },
          error: function(xhr, status, error) {
            // Handle AJAX errors
            console.error(xhr.responseText);
          }
        });
      } else {
        $('#readcontent').empty();
      }
    });
    $('#discount').on('keydown', function() {
      if (e.keyCode === 13) { // Check if Enter key was pressed
        e.preventDefault(); // Prevent default form submission
        $('#myForm').submit(); // Submit the form
      }
    });
  });

  function openModaladd(content) {
    // Set the content of CKEditor in the modal
    ClassicEditor
      .create(document.querySelector('#editContent'), {
        width: '800px', // Adjust as needed
        height: '400px',
        toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'alignment:left', 'alignment:center', 'alignment:right']
      })
      .then(editor => {
        editorInstance = editor; // Store the instance reference
        editor.setData(content); // Set the content
      })
    // CKEDITOR.instances.editContent.setData(content);
    // Show the modal
    $('#addModal').modal('show');
  }

  $(document).ready(function() {
    var payment_mode = document.getElementById("payment_mode").value;
    var cash = document.getElementById("cash");
    var paytm = document.getElementById("paytm");
    if (payment_mode == 'cash') {
      cash.style.display = "block";
      paytm.style.display = "none";
    }
    if (payment_mode == 'paytm') {
      cash.style.display = "none";
      paytm.style.display = "block";
    }
    if (payment_mode == 'cash+paytm') {
      cash.style.display = "block";
      paytm.style.display = "block";
    }
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

  function calculateNetAmount() {
    var updatedNetAmount = 0;
    var basicAmount = parseFloat(document.getElementById('basic_amount').value);
    var discount = parseFloat(document.getElementById('discount').value);
    var discountType = document.getElementById('discount_type').value;
    var netAmount = parseFloat(document.getElementById('net_amount').value);
    var doctorComm = parseFloat(document.getElementById('doctor_comm').value);

    if (isNaN(discount)) {
      discount = 0;
    }

    if (discountType === 'per') {
      updatedNetAmount = basicAmount - (discount / 100 * basicAmount);
    } else if (discountType === 'fix') {
      updatedNetAmount = basicAmount - discount;
    }

    document.getElementById('net_amount').value = updatedNetAmount;
    document.getElementById('doctor_comm').value = 0;
  }

  function togglePaymentFields() {
    var paymentMode = document.getElementById('payment_mode').value;
    if (paymentMode === 'cash') {
      document.getElementById('cash').style.display = 'block';
      document.getElementById('paytm').style.display = 'none';
      document.getElementById('paytm_amount').value = 0;
    } else if (paymentMode === 'paytm') {
      document.getElementById('cash').style.display = 'none';
      document.getElementById('paytm').style.display = 'block';
      document.getElementById('cash_amount').value = 0;
    } else {
      document.getElementById('cash').style.display = 'block';
      document.getElementById('paytm').style.display = 'block';
      document.getElementById('cash_amount').value = 0;
      document.getElementById('paytm_amount').value = 0;
    }
    updateBalance();
  }

  function updateBalance() {
    var cashAmount = parseFloat(document.getElementById('cash_amount').value) || 0;
    var paytmAmount = parseFloat(document.getElementById('paytm_amount').value) || 0;
    var netAmount = parseFloat(document.getElementById('net_amount').value);
    var balance = netAmount - (cashAmount + paytmAmount);
    document.getElementById('balance').value = balance;
  }

  function addreport(cli_id) {
    var div = document.getElementById("show" + cli_id);
    if (div.style.display !== "block") {
      div.style.display = "block";
    } else {
      div.style.display = "none";
    }
  }

  $(document).ready(function() {
    // Toggle accordion content and arrow rotation when clicking on the header
    $('.accordion-header').click(function() {
      $(this).parent('.accordion-item').toggleClass('active');
      $(this).find('.accordion-arrow').text(function(_, text) {
        return text === '►' ? '▼' : '►';
      });
      $(this).next('.accordion-content').slideToggle();
      $(this).parent('.accordion-item').siblings('.accordion-item').removeClass('active').find('.accordion-content').slideUp();
      $(this).parent('.accordion-item').siblings('.accordion-item').find('.accordion-arrow').text('►');
    });
  });

  $('#report_id').on('change', function() {
    $('#amount').val($(this).find(':selected').data('price'));
  });
  $('#childreport_id').on('change', function() {
    $('#amount').val($(this).find(':selected').data('price'));
  });
</script>
@endsection