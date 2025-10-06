@extends('layouts.editor.template')
@section('title', 'Persetujuan Klaim') 
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Persetujuan Klaim</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                  <li class="active">Persetujuan Klaim</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        @if(isset($reimburse))
                        {!! Form::model($reimburse, array('route' => ['editor.reimburse-approval.update', $reimburse->id], 'method' => 'PUT', 'files' => 'true'))!!}
                        @else
                        {!! Form::open(array('route' => 'editor.cash_payment.store', 'files' => 'true'))!!}
                        @endif
                        {{ csrf_field() }}

                        <div class="white-box printableArea">
                          <h3><b>KLAIM</b> <span class="pull-right">NOMOR: {{ $reimburse->no_trans }}</span></h3>
                          <hr>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="pull-left">
                                      <address>
                                          <h3> &nbsp;<b class="text-danger">{{ $reimburse->employee_name }}</b></h3>
                                          <p class="text-muted m-l-5">NIK {{ $reimburse->nik }}
                                              <br/>Position {{ $reimburse->position_name }}
                                              <br/>Department {{ $reimburse->department_name }}</p>
                                      </address>
                                  </div>
                                  <div class="pull-right text-right">
                                      <address>
                                          {{-- <h3>Detail,</h3> --}}
                                          <p class="font-bold">Jenis Klaim {{ $reimburse->medical_type_name }}</p>
                                          <p class="text-muted m-l-30">Periode  {{ $reimburse->description }}</p> 
                                          <p><b>Tanggal :</b> <i class="fa fa-calendar"></i> {{ $reimburse->date_trans }}</p>
                                      </address>
                                  </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="table-responsive m-t-40" style="clear: both;">
                                      <table class="table table-hover">
                                          <thead>
                                              <tr>
                                                  <th>Keterangan</th>
                                                  <th class="text-right">Jumlah</th>
                                                  <th class="text-right">Total</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @php
                                               $total = 0; 
                                              @endphp
                                              @foreach($reimburse_detail AS $reimburse_details)
                                              <tr>
                                                  <td>{{ $reimburse_details->description }}</td>
                                                  <td class="text-right">{{ $reimburse_details->quantity }} </td>
                                                  <td class="text-right"> {{ number_format($reimburse_details->amount,0) }} </td>
                                              </tr>

                                              @php
                                              $total += $reimburse_details->amount;
                                              @endphp

                                              @endforeach
                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              <div class="col-md-12">
                                  <div class="pull-right m-t-30 text-right">
                                      <p>Total : @php echo number_format($total,0); @endphp</p> 
                                  </div>
                                  <div class="clearfix"></div>
                                  <hr>
                                  <div class="text-right">
                                      @if($reimburse->status==0)
                                      <button class="btn btn-danger" type="submit"> Proses Persetujuan </button>
                                      @endif
                                      <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Cetak</span> </button>
                                  </div>
                              </div>
                          </div>
                        {!! Form::close() !!}
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
<script type="text/javascript">
var table;
$(document).ready(function() {
      @if(isset($day_work->day_work))
      @if($day_work->day_work <= 183)
      $.alert({
          title: 'Reimburse ditolak!',
          content: 'Masa kerja kurang 6 bulan!',
          type: 'red',
          typeAnimated: true,
      });
      @endif
      @endif

      @if(isset($reimburse->remain_val))
      @if($reimburse->remain_val < 0)
      $.alert({
          title: 'Reimburse ditolak!',
          content: 'Julmah claim melebihi plafond!',
          type: 'red',
          typeAnimated: true,
      });
      @endif
      @endif

      //datatables
      table = $('#dtTable').DataTable({ 
      processing: true,
       serverSide: true,
       fixedColumns:   {
        leftColumns: 4 
       },
       dom: 'Bfrtip',
       buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
       ], 
        ajax: "{{ url('editor/reimburse/datadetail') }}/{{$reimburse->id}}",
        columns: [   
        { data: 'description', name: 'description' },
        // { data: 'date_claim', name: 'date_claim' }, 
        // { data: 'no_ref', name: 'no_ref' }, 
        { data: 'amount', name: 'amount' }, 
        { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
      });
      //check all
      $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
      }); 
    });
    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function add()
    {
     $("#btnSave").attr("onclick","save()");
     $("#btnSaveAdd").attr("onclick","saveadd()");

     $('.errorMaterial UsedName').addClass('hidden');

     save_method = 'add'; 
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Asset Request'); // Set Title to Bootstrap modal title
    } 

    function reload_table_detail()
    {
      table_detail.ajax.reload(null,false); //reload datatable ajax 
    }

    function saveheader(id)
    {
      save_method = 'update';  

      //Ajax Load data from ajax
      $.ajax({
        url: '../../reimburse/saveheader/{{$reimburse->id}}' ,
        type: "PUT",
        data: {
          '_token': $('input[name=_token]').val(), 
          'medicaltypeid': $('#medicaltypeid').val(),
          'employeeid': $('#employeeid').val(),
          'departmentid': $('#departmentid').val(),
          'patientname': $('#patientname').val(),
          'plafond': $('#plafond').val(),
          'used': $('#used').val(),
          'remain': $('#remain').val(),
          'remark': $('#remark').val()
        },
        success: function(data) {  
          if ((data.errors)) { 
            toastr.error('Data is required!', 'Error Validation', options);
          } 
        },
      })
    };

    function savedetail(id)
    {
      var employeeid = $("#employeeid").val();
      save_method = 'update';  

      if(employeeid == '')
      {
        var options = { 
          "positionClass": "toast-bottom-right", 
          "timeOut": 1000, 
        };
        toastr.error('Employee data is required!', 'Error Validation', options);
      }else{
          //Ajax Load data from ajax
          $.ajax({
            url: '../../reimburse/savedetail/{{$reimburse->id}}' ,
            type: "PUT",
            data: {
              '_token': $('input[name=_token]').val(), 
              'description': $('#description').val(),
              'dateclaim': $('#dateclaim').val(),
              'no_ref': $('#no_ref').val(),
              'amount': $('#amount').val(),
            },
            success: function(data) {

            
             var options = { 
              "positionClass": "toast-bottom-right", 
              "timeOut": 1000, 
            };
            toastr.success('Successfully add detail data!', 'Success Alert', options);

            if ((data.errors)) { 
              toastr.error('Data is required!', 'Error Validation', options);
            } 
            reload_table();

            $('#description').val(''),
            $('#dateclaim').val(''),
            $('#no_ref').val(''),
            $('#amount').val('')
          },
        })
      }
    };

    function delete_id(id, employeename)
    {
      //alert("asdasd");
      //var varnamre= $('#employeename').val();
      var employeename = employeename.bold();

      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete data?',
        type: 'red',
        typeAnimated: true,
        buttons: {
          cancel: {
           action: function () { 
           }
         },
         confirm: {
          text: 'DELETE',
          btnClass: 'btn-red',
          action: function () {
           $.ajax({
            url : '../../reimburse/deletedet/' + id,
            type: "DELETE",
            data: {
              '_token': $('input[name=_token]').val() 
            },
            success: function(data)
            { 
              var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
              };
              toastr.success('Successfully deleted data!', 'Success Alert', options);
              reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              $.alert({
                type: 'red',
                icon: 'fa fa-danger', // glyphicon glyphicon-heart
                title: 'Warning',
                content: 'Error deleteing data!',
              });
            }
          });
         }
       },

     }
   });
    }

    function cal_sparator_plafond() {  
      var plafond = document.getElementById('plafond').value;
      var result = document.getElementById('plafond');
      var rsamount = (plafond);
      result.value = rsamount.replace(/,/g, "");  


      n2= document.getElementById('plafond');

      n2.onkeyup=n2.onchange= function(e){
        e=e|| window.event; 
        var who=e.target || e.srcElement,temp;
        if(who.id==='plafond')  temp= validDigits(who.value,0); 
        else temp= validDigits(who.value);
        who.value= addCommas(temp);
      }   
      n2.onblur= function(){
        var 
        temp2=parseFloat(validDigits(n2.value));
        if(temp2)n2.value=addCommas(temp2.toFixed(0));
      } 
    }


    function cal_sparator_used() {  
      var used = document.getElementById('used').value;
      var result = document.getElementById('used');
      var rsamount = (used);
      result.value = rsamount.replace(/,/g, "");  


      n2= document.getElementById('used');

      n2.onkeyup=n2.onchange= function(e){
        e=e|| window.event; 
        var who=e.target || e.srcElement,temp;
        if(who.id==='used')  temp= validDigits(who.value,0); 
        else temp= validDigits(who.value);
        who.value= addCommas(temp);
      }   
      n2.onblur= function(){
        var 
        temp2=parseFloat(validDigits(n2.value));
        if(temp2)n2.value=addCommas(temp2.toFixed(0));
      } 
    }


    function cal_sparator_remain() {  
      var remain = document.getElementById('remain').value;
      var result = document.getElementById('remain');
      var rsamount = (remain);
      result.value = rsamount.replace(/,/g, "");  

      n2= document.getElementById('remain');

      n2.onkeyup=n2.onchange= function(e){
        e=e|| window.event; 
        var who=e.target || e.srcElement,temp;
        if(who.id==='remain')  temp= validDigits(who.value,0); 
        else temp= validDigits(who.value);
        who.value= addCommas(temp);
      }   
      n2.onblur= function(){
        var 
        temp2=parseFloat(validDigits(n2.value));
        if(temp2)n2.value=addCommas(temp2.toFixed(0));
      } 
    }
  </script>

   <script type="text/javascript">
    function GenerateData()
    {
      // var periodid = $('#periodidfilter').val();
      // var perioddesc = $("#periodidfilter option:selected").text();
      saveheader();

      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to generate data?',
        type: 'red',
        typeAnimated: true,
        buttons: {
          cancel: {
           action: function () { 
           }
         },
         confirm: {
          text: 'CREATE',
          btnClass: 'btn-red',
          action: function () { 
           $.ajax({
            url : '../../reimburse/generate/' + {{ $reimburse->id }},
            type: "POST",
            data: {
              '_token': $('input[name=_token]').val(), 
              'medicaltypeid': $('#medicaltypeid').val(),
              'employeeid': $('#employeeid').val(),
              'departmentid': $('#departmentid').val(),
              'patientname': $('#patientname').val(),
              'plafond': $('#plafond').val(),
              'used': $('#used').val(),
              'remain': $('#remain').val(),
              'periodid': $('#periodid').val(),
              'remark': $('#remark').val()
            },
            success: function(data)
            { 
              var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
              };
              toastr.success('Successfully genareted data!', 'Success Alert', options);
              reload_table();
              location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              $.alert({
                type: 'red',
                icon: 'fa fa-danger', // glyphicon glyphicon-heart
                title: 'Warning',
                content: 'Error generate data!',
              });
            }
          });
         }
       },

     }
   });
    }
  </script>

  <script src="{{Config::get('constants.path.plugin')}}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript">
    jQuery('.mydatepicker, #dateclaim').datepicker();
    jQuery('.mydatepicker, #date_trans').datepicker();

    $('#dateclaim').datepicker({ format: 'dd-mm-yyyy' });
    $('#date_trans').datepicker({ format: 'dd-mm-yyyy' });
  </script>

  <script type="text/javascript">
    function showslip()
    {
       var slipid = $("#slipid").value;
       var url = "{{ URL::route('editor.reimburse.slip', $reimburse->id) }}";
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
