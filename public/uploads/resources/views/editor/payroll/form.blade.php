@extends('layouts.editor.template')
@section('module', 'Setting')   
@section('title', 'Payroll')   
@section('required', 'errorEmployeeStatusName')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">@yield('title')</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                  <li><a href="#">@yield('module')</a></li>
                  <li class="active">@yield('title')</li>
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>

      <!-- /row -->
      <div class="row">
          <div class="col-sm-12"> 
              <div class="table-responsive"> 
                <div class="col-sm-12">
                    <div class="white-box"> 
                        <hr>
                        <div class="table-responsive">
                            <table id="table_payroll" class="table table-bordered table-hover stripe" style="background-color: #fff"> 
                              <thead>
                               <tr> 
                                  <th rowspan="2">NIK</th> 
                                  <th rowspan="2">Karyawan</th> 
                                  <th rowspan="2">Departemen</th>
                                  <th rowspan="2">Posisi</th>
                                  <th rowspan="2">Hari Kerja</th>
                                  <th rowspan="2">Gaji Pokok</th>
                                  <th colspan="4"><center>Insentif</center></th> 
                                  <th colspan="5"><center>Lembur</center></th>
                                  <th rowspan="2">Tunjangan</th> 
                                  <th colspan="5"><center>Potongan</center></th> 
                                  <th rowspan="2">Total</th>
                                  <th rowspan="2">Cetak Slip</th>
                                </tr>
                                <tr>
                                  <th>Meal Hour</th>
                                  <th>Meal</th>
                                  <th>Trans (Hour)</th>
                                  <th>Trans (Rp)</th>
                                  <th>OT Hour</th>
                                  <th>Day 6</th>
                                  <th>Holiday</th>
                                  <th>OT Hour Con</th>
                                  <th>OT (Rp)</th>
                                  <th>Absent</th>
                                  <th>Jamsostek</th>
                                  <th>BPJS &nbsp; &nbsp;</th>
                                  <th>Loan</th>
                                  <th>PPH 21</th>
                                </tr>
                               </thead> 
                                <tbody> 
                                    @foreach($payroll_detail as $key => $payroll_details)
                                    <tr>
                                        <td class="col-sm-1 col-md-1">
                                            {{$payroll_details->nik}} 
                                        </td>
                                        <td class="col-sm-1 col-md-1">
                                            {{$payroll_details->employee_name}} 
                                        </td>
                                        <td class="col-sm-1 col-md-1">
                                            {{$payroll_details->department_name}} 
                                        </td>
                                        <td class="col-sm-1 col-md-1">
                                            {{$payroll_details->position_name}} 
                                        </td>
                                        <td class="col-sm-1 col-md-1">
                                            <a  href="javascript:void(0)" onclick="absence({{$payroll_details->employee_id}}, {{$payroll_details->period_id}})">{{$payroll_details->day_job}}</a>
                                        </td>  

                                        <td class="col-sm-1 col-md-1">
                                          {{ $payroll_details->basic }}
                                        </td> 

                                        <td class="col-sm-1 col-md-1">
                                            {{ Form::text('detail['.$payroll_details->id.'][meal_trans_all]', old($payroll_details->meal_trans_all.'[meal_trans_all]', $payroll_details->meal_trans_all), ['id' => 'meal_trans_all'.$payroll_details->id, 'min' => '0', 'class' => 'form-control input-sm', 'placeholder' => '', 'oninput' => 'total()']) }} 
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->meal_trans }} 
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                             {{ Form::text('detail['.$payroll_details->id.'][transport_all]', old($payroll_details->transport_all.'[transport_all]', $payroll_details->transport_all), ['id' => 'transport_all'.$payroll_details->id, 'min' => '0', 'class' => 'form-control input-sm', 'placeholder' => '', 'oninput' => 'total()']) }} 
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->transport }}  
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                             {{ Form::text('detail['.$payroll_details->id.'][overtime_hour_actual]', old($payroll_details->overtime_hour_actual.'[overtime_hour_actual]', $payroll_details->overtime_hour_actual), ['id' => 'overtime_hour_actual'.$payroll_details->id, 'min' => '0', 'class' => 'form-control input-sm', 'placeholder' => '', 'oninput' => 'total()']) }} 
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->overtime_hour }}  
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->overtime }}  
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->overtime }}  
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->overtime }}  
                                        </td> 
                                         <td class="col-sm-1 col-md-1">
                                            {{ Form::text('detail['.$payroll_details->id.'][insentive]', old($payroll_details->insentive.'[insentive]', $payroll_details->insentive), ['id' => 'insentive'.$payroll_details->id, 'min' => '0', 'class' => 'form-control input-sm', 'placeholder' => '', 'oninput' => 'total()']) }} 
                                        </td>  
                                         <td class="col-sm-1 col-md-1">  
                                            {{ Form::text('detail['.$payroll_details->id.'][absence]', old($payroll_details->absence.'[absence]', $payroll_details->absence), ['id' => 'absence'.$payroll_details->id, 'min' => '0', 'class' => 'form-control input-sm', 'placeholder' => '', 'oninput' => 'total()']) }} 
                                        </td> 
                                        <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->jamsostek }}  
                                        </td> 

                                        <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->bpjs }}  
                                        </td> 

                                         <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->total_loan }}  
                                        </td> 

                                         <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->pph_21 }}  
                                        </td> 

                                        <td class="col-sm-1 col-md-1">
                                            {{ $payroll_details->total_netto }}  
                                        </td>  
                                        </td>   
                                    </td>  
                                    <td><a href="#" onclick="showslip({{$payroll_details->id}});"><i class="fa fa-print"></i> Print</a></td>
                                </tr>  
                                @endforeach
                            </tbody>
                        </table> 
                          <!-- /.box-body -->
                         <a href="#" type="button" id="btn_submit" class="btn btn-primary pull-right btn-flat"><i class="fa fa-check"></i> Submit</a> 
                        <a href="{{ URL::route('editor.payroll.index') }}" class="btn btn-default pull-right btn-flat" style="margin-right: 10px"><i class="fa fa-close"></i> Close</a> 
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </div>
</div>
@stop 



@section('scripts')
 
<script>
  var table;
  $(document).ready(function() {
    table = $('#dtAbsence').DataTable({ 
       processing: true,
       serverSide: true,
       fixedColumns:   {
        leftColumns: 4 
       },
       dom: 'Bfrtip',
       buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
       ], 
     ajax: "{{ url('editor/payroll/dataabsence') }}",
     columns: [  
     { data: 'date_in', name: 'date_in' }, 
     { data: 'absence_type_name', name: 'absence_type_name' }, 
     { data: 'actual_in', name: 'actual_in' }, 
     { data: 'actual_out', name: 'actual_out' }, 
     { data: 'permite_in', name: 'permite_in' }, 
     { data: 'permite_out', name: 'permite_out' }, 
     { data: 'overtime_in', name: 'overtime_in' }, 
     { data: 'overtime_out', name: 'overtime_out' }, 
     { data: 'overtime_hour_actual', name: 'overtime_hour_actual' }, 
     { data: 'overtime_hour', name: 'overtime_hour' }, 
     ]
    });
  });

  function absence(employee_id, period_id)
   { 
    console.log(employee_id);
    console.log(period_id);
      var url;
      url = "{{ URL::route('editor.payrollabsence.store') }}";
       $.ajax({
        type: 'POST',
        url: url,
        data: {
          '_token': $('input[name=_token]').val(), 
          'employee_id': employee_id, 
          'period_id': period_id
        },
      });
      table.ajax.reload(null,false); //reload datatable ajax 

      $('#modal_absence').modal('show'); // show bootstrap modal when complete loaded
    }

  $(document).ready(function () {
    $("#payrollTable").DataTable(
    {
      "language": {
        "emptyTable": "-"
      }
    } 
    );
  });
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  $('#btn_submit').on('click', function()
  { 
    $.confirm({
      title: 'Confirm!',
      content: 'Are you sure to create data?',
      type: 'green',
      typeAnimated: true,
      buttons: {
        cancel: {
          action: function () { 
          }
        },
        confirm: {
          text: 'CREATE',
          btnClass: 'btn-green',
          action: function () {  
            $('#form_payroll').submit(); 
          }
        },

      }
    });
  });

  $(document).ready(function() { 
      $("#table_payroll").dataTable( {
           "bPaginate": false,
      });
    }); 

    function showslip(id)
      {
        console.log(id);
       var url = '../../payroll/slip/' + id;
         PopupCenter(url,'Popup_Window','700','650');
      }

       function showabsence(id)
      {
        console.log(id);
       var url = '../../payroll/absence/' + id;
         PopupCenter(url,'Popup_Window','700','650');
      }

      function PopupCenter(url, title, w, h) {  
        // Fixes dual-screen position                         Most browsers      Firefox  
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;  
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;  
              
        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;  
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;  
              
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;  
        var top = ((height / 2) - (h / 2)) + dualScreenTop;  
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);  
        
        // Puts focus on the newWindow  
        if (window.focus) {  
          newWindow.focus();  
        }  
      } 
 
</script>
@stop
