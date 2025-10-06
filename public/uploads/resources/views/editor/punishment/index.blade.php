@extends('layouts.editor.template')
@section('title', 'Teguran')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Teguran</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Aktivitas</a></li>
                  <li class="active">Teguran</li>
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
                         <div class="button-box">
                            <a href="{{ URL::route('editor.punishment.create') }}" type="button" class="fcbtn btn btn-primary btn-outline btn-1b waves-effect">Tambah Baru</a>
                            <a href="#" onClick="history.back()" type="button" class="fcbtn btn btn-info btn-outline btn-1b waves-effect">Kembali</a>
                            <a href="#" onClick="reload_table()" type="button" class="fcbtn btn btn-warning btn-outline btn-1b waves-effect">Refresh</a> 
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Aksi</th> 
                                        <th>No Teguran</th>
                                        <th>Tanggal Teguran</th>
                                        <th>Jenis Teguran</th>
                                        <th>Nama Karyawan</th>
                                        <th>Dari Tanggal</th>
                                        <th>Sampai Tanggal</th>
                                        <th>Tanggal Periode</th>
                                        <th>Keterangan</th>
                                        <th>Lampiran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </div>
</div> 
@stop
@section('popup')
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" style="width:40% !important">
    <div class="modal-content">
        {!! Form::open(array('route' => 'editor.punishment.store', 'class'=>'form-horizontal', 'files' => 'true', 'id'=>'form_floor'))!!}
        {{ csrf_field() }} 
       <div class="modal-header">
         <h4 class="modal-title">SELECT TRAINING CODE</h4>
       </div>
       <div class="modal-body"> 
         <div class="form-body">
            <div class="col-lg-12" class="col-md-12" class="col-sm-12">
              <label class="control-label col-md-4 pull-left">Transaction</label>
              <div class="col-md-8">
                 <select class="form-control" name="codetrans" id="codetrans"  placeholder="Transaction Code">
                    <option value="TRAINING">Punishment</option> 
                </select>
              </div>
          </div>
        </div>
      </div>
    <br>
    <div class="modal-footer">
      <div class="col-lg-12 col-md-12 col-sm-12">
          <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Submit</button>
          <input type="hidden" value="1" name="submit" />
          <button type="button" onclick="ClearVal()" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
      </div>  
    </div>
    {!! Form::close() !!}
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
@stop
@section('scripts')
<script> 
  var table;
  $(document).ready(function() {
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
       ajax: "{{ URL::route('editor.punishment.data') }}",
       columns: [  
       { data: 'action', name: 'action', orderable: false, searchable: false }, 
       { data: 'no_trans', name: 'no_trans' },
       { data: 'date_trans', name: 'date_trans', render: function(d){return moment(d).format("DD-MM-YYYY");} },  
       { data: 'sk_type_name', name: 'sk_type_name'},
       { data: 'employee_name', name: 'employee_name' },
       { data: 'date_from', name: 'date_from'},
       { data: 'date_to', name: 'date_to'},
       { data: 'period_date', name: 'period_date'},
       { data: 'description', name: 'description' },
       { data: 'attachment', name: 'attachment' },
       { data: 'mstatus', name: 'mstatus' }
       ]
     });
    });

    function add()
    {
      $("#btnSave").attr("onclick","save()");
      $("#btnSaveAdd").attr("onclick","saveadd()");

      $('.errorMaterial UsedName').addClass('hidden');

      save_method = 'add'; 
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Punishment'); // Set Title to Bootstrap modal title
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function delete_id(id, punishment_name)
    {
      var punishment_name = punishment_name.bold();

      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete ' + punishment_name + ' data?',
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
            url : 'punishment/delete/' + id,
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
</script> 

@stop
