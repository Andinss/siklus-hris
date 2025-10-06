@extends('layouts.editor.template')
@if(isset($cash_payment))
@section('title', 'Edit Pengeluaran Kas') 
@else
@section('title', 'Add New Pengeluaran Kas') 
@endif
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">@if(isset($cash_payment)) Edit @else Add New @endif Pengeluaran Kas</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                  <li class="active">@if(isset($cash_payment)) Edit @else Add New @endif Pengeluaran Kas</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        @if(isset($cash_payment))
                        {!! Form::model($cash_payment, array('route' => ['editor.cash-payment.update', $cash_payment->id], 'method' => 'PUT', 'files' => 'true'))!!}
                        @else
                        {!! Form::open(array('route' => 'editor.cash_payment.store', 'files' => 'true'))!!}
                        @endif
                        {{ csrf_field() }}
                            <div class="form-body"> 
                                <section>
                                  <div class="row"> 
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('employeeid', 'No Pengeluaran') }}
                                            {{ Form::text('cash_payment_no', old('cash_payment_no'), array('class' => 'form-control', 'placeholder' => 'No Pengeluaran*', 'required' => 'true', 'id' => 'cash_payment_no', 'disabled' => 'disabled')) }}
                                        </div>
                                        <div class="form-group">
                                         {{ Form::label('employeeid', 'Tanggal Pengeluaran') }}
                                         <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>   
                                           {{ Form::text('cash_payment_date', date("d-m-Y", strtotime($cash_payment->cash_payment_date)), array('class' => 'form-control', 'placeholder' => 'Date Trans*', 'required' => 'true', 'id' => 'form_field_date', 'class' => 'form-control datepicker')) }}
                                          </div><!-- /.input group --> 
                                      </div> 
                                    </div>
                                    <!-- Coloumn 2-->   
                                    <div class="col-md-5"> 
                                     <div class="form-group">
                                        {{ Form::label('employeeid', 'Akun Kredit') }}
                                        {{ Form::select('coa_id', $coa_list, old('coa_id'), array('class' => 'form-control', 'placeholder' => 'Select Akun Kredit', 'required' => 'true', 'id' => 'coa_id')) }} 
                                    </div>  
                                    <div class="form-group">
                                      <div class="form-group">
                                          {{ Form::label('employeeid', 'Jenis Pembayaran') }}
                                          {{ Form::select('pay_type_id', $pay_type_list, old('pay_type_id'), array('class' => 'form-control', 'placeholder' => 'Select Jenis Pembayaran', 'required' => 'true', 'id' => 'pay_type_id')) }} 
                                      </div>  
                                    </div>
                                    <div class="form-group" style="display: none">
                                      <label for="real_name" class="col-sm-3 control-label">Lampiran</label>
                                      <div class="col-sm-9"> 
                                        @if($cash_payment->attachment != '')
                                          <a href="{{URL::to('/') .'/uploads/cashpayment/'. $cash_payment->attachment}}" target="_blank"><i class="fa fa-download"></i> Unduh </a>
                                          <br>
                                        @endif
                                        {{ Form::file('attachment') }} 
                                      </div>
                                    </div> 
                                  </div>
                                </div>

                                <hr>
                                 <div class="col-xs-12 col-md-12"> 
                                  <div class="col-md-3" style="margin-right: 5px">
                                    <div class="form-group">
                                      <label>Keterangan</label> 
                                      {{ Form::hidden('cp_d_id', old('cp_d_id'), array('id' => 'cp_d_id')) }} 
                                      <input type="text" value="" class="form-control" id="description" name="description">
                                    </div> 
                                  </div>
                                  <div class="col-md-3" style="margin-right: 5px">
                                    <div class="form-group">
                                      <label>Akun Debit</label>
                                      {{ Form::select('coa_id', $coa_list, old('coa_id'), array('class' => 'form-control', 'placeholder' => 'Pilih Akun Debit', 'id' => 'account_d_id')) }} 
                                    </div> 
                                  </div>  
                                  <div class="col-md-2" style="margin-right: 5px">
                                    <div class="form-group">
                                      <label>Jumlah</label>
                                      <input type="text" value="" class="form-control" id="debt_show" name="debt_show" oninput="cal_sparator();">
                                      <input type="hidden" value="" class="form-control" id="debt" name="debt" oninput="cal_sparator();">
                                    </div> 
                                  </div>  
                                  <div class="col-md-1" style="margin-right: 5px">

                                    <div class="form-group">
                                     <label>Aksi</label><br/>
                                     <a href="#" onclick="savedetail();" type="button" class="btn btn-success" style="margin-left: 2px; margin-right: 2px" id="btn_add_detail"> <i class="fa fa-plus"></i> Add</a>

                                     <a href="#" onclick="updatedetail();" type="button" class="btn btn-success" style="margin-left: 2px; margin-right: 2px   ; display: none" id="btn_update_detail"> <i class="fa fa-pencil"></i> Update</a>
                                   </div>   
                                 </div>  
                                 <div>
                               </div>
                                   <div class="box-body">  
                                     <table id="dtTable" class="table table-hover">
                                      <thead>
                                       <tr>   
                                        <th>Keterangan</th> 
                                        <th>Akun Debit</th>
                                        <th>Jumlah</th> 
                                        <th>Aksi</th> 
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table> 
                                  </div>   
                                  <hr>
                                  <div class="box-footer with-border">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label for="real_name" class="col-sm-3 control-label">Keterangan</label>
                                        <div class="col-sm-9">
                                          <textarea style="height: 40px !important" class="form-control" id="remark" name="remark" onchange="saveheader();">{{ $cash_payment->remark }}</textarea>
                                        </div>
                                      </div>
                                    </div> 
                                    <button type="submit" class="btn btn-success btn-flat pull-right"><i class="fa fa-save"></i> Simpan</button>
                                    @if($cash_payment->status == 9)
                                    <a class="btn btn-primary btn-flat pull-right" name="open" style="margin-left: 2px; margin-right: 2px" onclick="cancel(id);" ><i class="fa fa-check"></i> Aktifkan</a>
                                    @else
                                    {{-- <a class="btn btn-danger btn-flat pull-right" name="cancel" style="margin-left: 2px; margin-right: 2px" onclick="cancel(id);" ><i class="fa fa-archive"></i> Archive</a>  --}}
                                    @endif  
                                   <a href="{{ URL::route('editor.cash-payment.index', ['status' => '0']) }}" type="button" class="btn btn-default btn-flat pull-right" style="margin-left: 2px; margin-right: 2px"> <i class="fa fa-close"></i> Tutup</a>
                                   <iframe src='' height="0" width="0" frameborder='0' name="print_frame"></iframe>
                                  </div>
                                </section>
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
      //datatables
      table = $('#dtTable').DataTable({ 
        processing: true,
        serverSide: true,
        "pageLength": 10, 
        "rowReorder": true,
        "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],
        ajax: "{{ url('editor/cash-payment/datadetail') }}/{{$cash_payment->id}}", 
        columns: [    
        { data: 'description', name: 'description' },
        { data: 'coa_name', name: 'coa_name' },
        { data: 'debt', name: 'debt' },
        { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
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


    function savedetail(id)
    {
     var description = $('#description').val();
     var coa_id =   $('#account_d_id').val();
     var debt =   $('#debt').val(); 

     if(description == '' || coa_id == ''){
      alert("Error validarion!");
     }else{
      save_method = 'update';  

      //Ajax Load data from ajax
      $.ajax({
        url: '../../cash-payment/savedetail/{{$cash_payment->id}}' ,
        type: "PUT",
        data: {
          '_token': $('input[name=_token]').val(), 
          'description': $('#description').val(),
          'coa_id': $('#account_d_id').val(), 
          'debt': $('#debt').val(), 
          'credit': $('#credit').val()
        },
        success: function(data) { 
          reload_table(); 
          clear_detail(); 
        },
      })
    }
  };

  function updatedetail(id)
  { 
    var cp_d_id = $('#cp_d_id').val();
    var description = $('#description').val();
    var coa_id =   $('#coa_id').val();
    var debt =   $('#debt').val(); 
    var credit =   $('#credit').val();    

    if(description == '' || coa_id == ''){
      alert("Error validarion!");
    }else{
      save_method = 'update';  

      //Ajax Load data from ajax
      $.ajax({
        url: '../../cash-payment/updatedetail/' + cp_d_id ,
        type: "POST",
        data: {
          '_token': $('input[name=_token]').val(), 
          'cp_d_id': $('#cp_d_id').val(),
          'description': $('#description').val(),
          'coa_id': $('#account_d_id').val(), 
          'debt': $('#debt').val(), 
          'credit': $('#credit').val()
        },
        success: function(data) { 
          reload_table(); 
          clear_detail(); 
        },
      })
    }
  };
  function reload_table_detail()
  {
      table_detail.ajax.reload(null, false); //reload datatable ajax 
    }

    function update_id(str, cp_d_id, debt, credit, coa_id)
    {
      clear_detail();
      console.log(debt); 

      var description = $(str).closest('tr').find('td:eq(0)').text(); 
      //var coa_id = $(str).closest('tr').find('td:eq(1)').text();  
      var debt_show = $(str).closest('tr').find('td:eq(3)').text(); 
      var credit_show = $(str).closest('tr').find('td:eq(2)').text();  

    $("#cp_d_id").val(cp_d_id);
    $("#description").val(description);
    $("#account_d_id").val(coa_id);
    $("#debt").val(debt); 
    $("#credit").val(credit); 
    $("#debt_show").val(debt_show); 
    $("#credit_show").val(credit_show);  
    $('#btn_add_detail').hide(100);
    $('#btn_update_detail').show(100); 
  };

  function clear_detail()
  {
    $('#description').val(''),
    $('#account_d_id').val(''),  
    $('#debt').val(''), 
    $('#credit').val(''),  
    $('#debt_show').val(''), 
    $('#credit_show').val('')
  }

  function delete_id(po_d_id, item_name)
  {
      //console.log(id);
      var r = confirm("Delete this data?");
      if (r == true) {   
       $.ajax({
        url : '../../cash-payment/deletedet/' + po_d_id,
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
          reload_table();
        }, 
        error: function (jqXHR, textStatus, errorThrown)
        { 
        },
      }) 
     }
   };

   function cancel(id)
   {
    var status = {{$cash_payment->status}};
    if(status == 9)
    {
     var r = confirm("Open this transaction?");
   }else{
     var r = confirm("Archive this transaction?");
   };

   if (r == true) { 
    save_method = 'post';  

      //Ajax Load data from ajax
      $.ajax({
       url: '../cash-payment/cancel/{{$cash_payment->id}}' ,
       type: "POST",
       data: {
        '_token': $('input[name=_token]').val()
      },
      success: function(data) {  
          //var loc = 'cashpayment';
          if ((data.errors)) { 
            alert("Archive error!");
          } else{
            window.location.href = "{{ URL::route('editor.cash-payment.index', ['status' => '0']) }}";
          }
        },
      })
    }
  };

  function closetr(id)
  { 

   var r = confirm("Close this transaction?"); 
   if (r == true) { 
    save_method = 'post';  

      //Ajax Load data from ajax
      $.ajax({
       url: '../../cashpayment/close/{{$cash_payment->id}}' ,
       type: "POST",
       data: {
        '_token': $('input[name=_token]').val()
      },
      success: function(data) {  
          //var loc = 'cashpayment';
          if ((data.errors)) { 
            alert("Cancel error!");
          } else{
            window.location.href = "{{ URL::route('editor.cash-payment.index') }}";
          }
        },
      })
    }
  };

function cal_sparator() { 
  var debt_show = document.getElementById('debt_show').value;
  var result = document.getElementById('debt');
  var rsdebt = (debt_show);
  result.value = rsdebt.replace(/,/g, ""); 

  var credit_show = document.getElementById('credit_show').value;
  var result = document.getElementById('credit');
  var rscredit = (credit_show);
  result.value = rscredit.replace(/,/g, ""); 
}

window.onload= function(){ 

  n2= document.getElementById('debt_show');

  n2.onkeyup=n2.onchange= function(e){
    e=e|| window.event; 
    var who=e.target || e.srcElement,temp;
    if(who.id==='debt')  temp= validDigits(who.value,0); 
    else temp= validDigits(who.value);
    who.value= addCommas(temp);
  }   
  n2.onblur= function(){
    var 
    temp2=parseFloat(validDigits(n2.value));
    if(temp2)n2.value=addCommas(temp2.toFixed(0));
  }

  n3= document.getElementById('credit_show');

  n3.onkeyup=n3.onchange= function(e){
    e=e|| window.event; 
    var who=e.target || e.srcElement,temp;
    if(who.id==='credit')  temp= validDigits(who.value,0); 
    else temp= validDigits(who.value);
    who.value= addCommas(temp);
  }   
  n3.onblur= function(){
    var 
    temp3=parseFloat(validDigits(n3.value));
    if(temp3)n3.value=addCommas(temp3.toFixed(0));
  }

}
</script>

<script src="{{Config::get('constants.path.plugin')}}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
  jQuery('.mydatepicker, #form_field_date').datepicker();

  $('#form_field_date').datepicker({ format: 'dd-mm-yyyy' });
</script>
@stop