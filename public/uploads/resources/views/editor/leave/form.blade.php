@extends('layouts.editor.template')
@if(isset($leave))
@section('title', 'Edit Cuti') 
@else
@section('title', 'Tambah Baru Cuti') 
@endif
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">@if(isset($leave)) Edit @else Tambah Baru @endif Cuti</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li class="active">@if(isset($leave)) Edit @else Tambah Baru @endif Cuti</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        @if(isset($leave))
                        {!! Form::model($leave, array('route' => ['editor.leave.update', $leave->id], 'method' => 'PUT', 'files' => 'true'))!!}
                        @else
                        {!! Form::open(array('route' => 'editor.leave.store', 'files' => 'true'))!!}
                        @endif
                        {{ csrf_field() }}
                            <div class="form-body"> 
                                <section>
                									<div class="row">
                										<div class="col-md-6">
                											<div class="form-group">
                												{{ Form::label('no_trans', 'No Cuti *') }}
                												{{ Form::text('no_trans', old('no_trans'), array('class' => 'form-control', 'placeholder' => 'No Cuti *', 'required' => 'true', 'id' => 'no_trans', 'disabled' => 'disabled')) }}
                											</div>
                										</div>
                										<div class="col-md-6">
                											<div class="form-group">
                												{{ Form::label('date_trans', 'Tanggal Cuti *') }}
                												<div class="input-group">
                		                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  
                		                        {{ Form::text('date_trans', old('date_trans'), array('class' => 'form-control', 'placeholder' => 'Tanggal Cuti *', 'required' => 'true')) }}
                		                    </div>
                                        <!-- /.input group --> 
                											</div>
                										</div>   
                										<div class="col-md-6">
                											<div class="form-group">
                												{{ Form::label('employee_id', 'Nama Karyawan *') }}
                												{{ Form::select('employee_id', $employee_list, old('employee_id'), array('class' => 'form-control select2', 'placeholder' => 'Pilih karyawan', 'id' => 'employee_id', 'onchange' => 'RefreshData();')) }} 
                											</div>
                										</div>   
                										<div class="col-md-6">
                											<div class="form-group">
                												{{ Form::label('absence_type_id', 'Jenis Ijin *') }}
                												{{ Form::select('absence_type_id', $absence_type_list, old('absence_type_id'), array('class' => 'form-control', 'placeholder' => 'Pilih Jenis Ijin', 'id' => 'absence_type_id', 'onchange' => 'setdisease()')) }} 
                											</div>
                										</div>  
                										<div class="col-md-6">
                											<div class="form-group">
                												{{ Form::label('leave_from', 'Dari Tanggal *') }}
                												<div class="input-group">
                  	                         <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  
                  	                        {{ Form::text('leave_from', old('leave_from'), array('class' => 'form-control', 'placeholder' => 'Dari Tanggal*', 'required' => 'true', 'id' => 'leave_from')) }}
                  	                    </div>
                                        <!-- /.input group --> 
                											</div>
                										</div>   
                										<div class="col-md-6">
                											<div class="form-group">
                												{{ Form::label('leave_to', 'Sampai Tanggal *') }}
                												<div class="input-group">
                		                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  
                		                        {{ Form::text('leave_to', old('leave_to'), array('class' => 'form-control', 'placeholder' => 'Sampai Tanggal*', 'required' => 'true', 'id' => 'leave_to')) }}
                		                    </div>
                                        <!-- /.input group --> 
                											</div>
                										</div>    
                										<div class="col-md-6">
                											<div class="form-group">
                												{{ Form::label('attachment', 'Lampiran') }}<br>
                												<span class="btn btn-default"><input type="file" name="attachment" /></span>
                												<br/>
                											</div>
                										</div>
                									</div>  
                	                <button type="submit" id="btnsave" class="btn btn-success pull-right"><i class="fa fa-check"></i> Simpan</button>
                									<a href="{{ URL::route('editor.leave.index') }}" class="btn btn-default pull-right btn-flat" style="margin-right: 10px"><i class="fa fa-close"></i> Tutup</a> 
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
<script src="{{Config::get('constants.path.plugin')}}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
  jQuery('.mydatepicker, #date_trans').datepicker();
  jQuery('.mydatepicker, #leave_from').datepicker();
  jQuery('.mydatepicker, #leave_to').datepicker();

  $('#date_trans').datepicker({ format: 'dd-mm-yyyy' });
  $('#leave_from').datepicker({ format: 'dd-mm-yyyy' });
  $('#leave_to').datepicker({ format: 'dd-mm-yyyy' });
</script>

@if(isset($leave))  
<script type="text/javascript">
function cancel()
  {   
    $.confirm({
      title: 'Confirm!',
      content: 'Are you sure to cancel this data?',
      type: 'red',
      typeAnimated: true,
      buttons: {
        cancel: {
         action: function () { 
         }
       },
       confirm: {
        text: 'CANCEL',
        btnClass: 'btn-red',
        action: function () {
         $.ajax({
          url : '../../leave/cancel/' + {{$leave->id}},
          type: "PUT", 
          data: {
            '_token': $('input[name=_token]').val() 
          }, 
          success: function(data) {  
            //var loc = 'ap_invoice';
            if ((data.errors)) { 
              alert("Cancel error!");
            } else{
              window.location.href = "{{ URL::route('editor.leave.index') }}";
            }
          }, 
        }); 
       }
     },
    }
  });
  }  	
</script>
@endif 
@stop  
