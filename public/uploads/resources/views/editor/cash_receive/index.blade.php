@extends('layouts.editor.template')
@section('title', 'Penerimaan Kas')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Penerimaan Kas</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Keuangan</a></li>
                  <li class="active">Penerimaan Kas</li>
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
                            <button type="button" onClick="add()" class="fcbtn btn btn-primary btn-outline btn-1b waves-effect"><i class="fa fa-sticky-note-o"></i>&nbsp;&nbsp;Tambah Baru</button>
                            <a href="#" onClick="history.back()" type="button" class="fcbtn btn btn-info btn-outline btn-1b waves-effect">Kembali</a>
                            <a href="#" onClick="reload_table()" type="button" class="fcbtn btn btn-warning btn-outline btn-1b waves-effect">Refresh</a> 
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Aksi</th> 
                                        <th>No Penerimaan</th> 
                                        <th>Tanggal Penerimaan</th> 
                                        <th>Akun Kas</th> 
                                        <th>Jenis Pembayaran</th>
                                        <th>Lampiran</th>
                                        <th>Keterangan</th>
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
        {!! Form::open(array('route' => 'editor.cash-receive.store', 'class'=>'form-horizontal', 'files' => 'true', 'id'=>'form_floor'))!!}
        {{ csrf_field() }} 
        <div class="modal-header">
         <h4 class="modal-title">Pilih Kode Penerimaan Kas</h4>
       </div>
       <div class="modal-body" style="display: none;"> 
        <div class="modal-body"> 
           <div class="form-body">
              <div class="col-lg-12" class="col-md-12" class="col-sm-12">
                <label class="control-label col-md-3 pull-left">Kode</label>
                <div class="col-md-9">
                   <select class="form-control" name="code_trans" id="code_trans"  placeholder="Transaction Code">
                    <option value="CASHIN">Penerimaan Kas</option> 
                    </select>
                </div>
            </div>
          </div>
        </div>
        <br> 
    </div>
    <div class="modal-footer">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
        <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</button>
          <input type="hidden" value="1" name="submit" />
      </div>  
    </div>
  </div><!-- /.modal-content -->
</form>
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
       ajax: "{{ URL::route('editor.cash-receive.data') }}",
       columns: [  
       { data: 'action', name: 'action', orderable: false, searchable: false }, 
       { data: 'cash_receive_no', name: 'cash_receive_no' },  
       { data: 'coa_name', name: 'coa_name' },
       { data: 'cash_receive_date', name: 'cash_receive_date' },
       { data: 'pay_type_name', name: 'pay_type_name' }, 
       { data: 'attachment', name: 'attachment' },
       { data: 'remark', name: 'remark' } 
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
      $('.modal-title').text('Tambah Penerimaan Kas?'); // Set Title to Bootstrap modal title
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function delete_id(id, cash_receive_name)
    {
      var cash_receive_name = cash_receive_name.bold();

      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete ' + cash_receive_name + ' data?',
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
            url : 'cash-receive/delete/' + id,
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
