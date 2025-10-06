@extends('layouts.editor.template')
@section('title', 'Cuti')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Cuti</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Aktivitas</a></li>
                  <li class="active">Cuti</li>
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
                            <a href="{{ URL::route('editor.leave.create') }}" type="button" class="fcbtn btn btn-primary btn-outline btn-1b waves-effect">Tambah Baru</a>
                            <a href="#" onClick="history.back()" type="button" class="fcbtn btn btn-info btn-outline btn-1b waves-effect">Kembali</a>
                            <a href="#" onClick="reload_table()" type="button" class="fcbtn btn btn-warning btn-outline btn-1b waves-effect">Refresh</a> 
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Aksi</th> 
                                        <th>No Cuti</th>
                                        <th>Tanggal Cuti</th>
                                        <th>Nama Karyawan</th>
                                        <th>Dari Tanggal</th>
                                        <th>Sampai Tanggal</th> 
                                        <th>Hari</th>
                                        <th>Jenis Absen</th> 
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



{{-- @stop --}}
{{-- @section('scripts') --}}
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
       ajax: "{{ URL::route('editor.leave.data') }}",
       columns: [  
       { data: 'action', name: 'action', orderable: false, searchable: false }, 
       { data: 'no_trans', name: 'no_trans' },
       { data: 'date_trans', name: 'date_trans', render: function(d){return moment(d).format("DD-MM-YYYY");} },
       { data: 'employee_name', name: 'employee_name' },
       { data: 'leave_from', name: 'leave_from', render: function(d){return moment(d).format("DD-MM-YYYY");} },
       { data: 'leave_to', name: 'leave_to', render: function(d){return moment(d).format("DD-MM-YYYY");} },
       { data: 'days', name: 'days' }, 
       { data: 'absence_type_name', name: 'absence_type_name' }, 
       { data: 'btn_attachment', name: 'btn_attachment' },
       { data: 'mstatus', name: 'mstatus' }
       ]
     });
    });

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function delete_id(id, leave_name)
    {
      var leave_name = leave_name.bold();

      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete ' + leave_name + ' data?',
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
            url : 'leave/delete/' + id,
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
