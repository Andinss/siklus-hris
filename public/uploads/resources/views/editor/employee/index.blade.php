@extends('layouts.editor.template')
@section('title', 'Karyawan')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">Karyawan</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Karyawan & Aktivitas</a></li>
                  <li class="active">Karyawan</li>
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
                            <a href="{{ URL::route('editor.employee.create') }}" type="button" class="fcbtn btn btn-primary btn-outline btn-1b waves-effect">Tambah Baru</a>
                            <a href="#" onClick="history.back()" type="button" class="fcbtn btn btn-info btn-outline btn-1b waves-effect">Kembali</a>
                            <a href="#" onClick="reload_table()" type="button" class="fcbtn btn btn-warning btn-outline btn-1b waves-effect">Refresh</a> 
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Aksi</th> 
                                        <th>NIK</th>
                                        <th>Nama Karyawan</th> 
                                        <th>Departemen</th>
                                        <th>Posisi</th>
                                        <th>Level Jabatan</th>
                                        <th>Pajak</th>
                                        <th>Pendidikan</th> 
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Kontrak</th>
                                        <th>Tanggal Pensiun</th>
                                        <th>NPWP</th>
                                        <th>Gaji Pokok</th>
                                        <th>Foto</th>
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
       ajax: "{{ URL::route('editor.employee.data') }}",
       columns: [  
       { data: 'action', name: 'action', orderable: false, searchable: false }, 
       { data: 'nik', name: 'nik', "width": "5%" },
       { data: 'employee_name', name: 'employee_name', "width": "10%" }, 
       { data: 'department_name', name: 'department_name', "width": "5%" },
       { data: 'position_name', name: 'position_name', "width": "10%" },
       { data: 'staff_status_name', name: 'staff_status_name', "width": "1%" },
       { data: 'tax_status', name: 'tax_status' },
       { data: 'education_level_name', name: 'education_level_name' },
       { data: 'gender_icon', name: 'gender_icon' },
       { data: 'date_birth', name: 'date_birth', "width": "5%" },
       { data: 'join_date', name: 'join_date', "width": "5%" },
       { data: 'term_date', name: 'term_date', "width": "6%" },
       { data: 'pension_date', name: 'pension_date', "width": "6%" },
       { data: 'npwp', name: 'npwp', "width": "7%" },
       { data: 'basic', name: 'basic', "width": "2%" },
       { data: 'image', name: 'image' },
       { data: 'mstatus', name: 'mstatus' },
       ]
     });
    });

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

    function delete_id(id, employee_name)
    {
      var employee_name = employee_name.bold();

      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to delete ' + employee_name + ' data?',
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
            url : 'employee/delete/' + id,
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
