@extends('layouts.editor.template')
@section('title', 'Karyawan')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h6 class="page-title">Karyawan</h6>
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
                                @include('layouts.editor.template_button_master', [
                                    'add_action' => 'link',
                                    'link' => 'editor.employee.create',
                                    'back_button' => false,
                                    'info_button' => false,
                                ])
                                <hr>
                                <div class="w-100">
                                    <form action="">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4 col-lg-3">
                                                <select class="form-control" name="status" id="status">
                                                    <option value="">Pilih Status</option>
                                                    @foreach ($employee_status_lists as $employee_status_list)
                                                        <option value="{{ $employee_status_list->employee_status_name }}">
                                                            {{ $employee_status_list->employee_status_name }}</option>
                                                    @endforeach
                                                    {{-- <option value="aktif">Aktif</option>
                                  <option value="menunggu_status">Menunggu Status</option>
                                  <option value="magang">Magang</option>
                                  <option value="pensiun">Pensiun</option>
                                  <option value="resign">Resign</option>
                                  <option value="diberhentikan">Diberhentikan</option> --}}
                                                </select>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                {{ Form::text('search', old('search'), ['class' => 'form-control', 'placeholder' => 'Cari berdasarkan Nama, ID Karyawan, atau Email', 'id' => 'search']) }}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>Nama Karyawan</th>
                                                <th>ID Karyawan</th>
                                                <th>Jabatan</th>
                                                <th>Level Jabatan</th>
                                                <th>Divisi</th>
                                                <th>Status Karyawan</th>
                                                <th>Email</th>
                                                <th>Status Pajak</th>
                                                <th>Nomor NPWP</th>
                                                <th>Nomor BPJS TK</th>
                                                <th>Nomor BPJS Kesehatan</th>
                                                <th>Pendidikan</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Tanggal Masuk</th>
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
                fixedColumns: {
                    leftColumns: 4
                },
                "initComplete": function(settings, json) {
                    $("#dtTable").wrap(
                        "<div style='overflow:auto; width:100%;position:relative;'></div>");
                },
                order: [
                    [1, 'asc']
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ],
                bFilter: false,
                ajax: {
                    url: "{{ URL::route('editor.employee.data') }}",
                    data: function(d) {
                        d.search = $('#search').val();
                        d.status = $('#status').val();
                    },
                },
                createdRow: (row, data, index) => {
                    // if (row.status == 'aktif') {
                    //   row.classList.add('bg-primary-10')
                    // } else if (row.status == 'menunggu_status') {
                    //   row.classList.add('bg-brown-10')
                    // } else if (row.status == 'magang') {
                    //   row.classList.add('bg-info-10')
                    // } else if (row.status == 'pensiun') {
                    //   row.classList.add('bg-purple-10')
                    // } else if (row.status == 'resign') {
                    //   row.classList.add('bg-warning-10')
                    // } else if (row.status == 'diberhentikan') {
                    //   row.classList.add('bg-danger-10')
                    // } else {
                    //   row.classList.add('bg-light')
                    // }
                    row.classList.add('bg-primary-10')
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'employee_name',
                        name: 'employee_name',
                        "width": "10%"
                    },
                    {
                        data: 'identity_no',
                        name: 'identity_no',
                        "width": "5%"
                    },
                    {
                        data: 'position_name',
                        name: 'position_name',
                        "width": "10%"
                    },
                    {
                        data: 'position_id',
                        name: 'position_id',
                        "width": "5%"
                    },
                    {
                        data: 'department_name',
                        name: 'department_name',
                        "width": "5%"
                    },
                    {
                        data: 'staff_status_name',
                        name: 'staff_status_name',
                        "width": "5%"
                    },
                    {
                        data: 'email',
                        name: 'email',
                        "width": "10%"
                    },
                    {
                        data: 'tax_status',
                        name: 'tax_status',
                        "width": "10%"
                    },
                    {
                        data: 'npwp',
                        name: 'npwp',
                        "width": "10%"
                    },
                    {
                        data: 'jamsostek_member',
                        name: 'jamsostek_member',
                        "width": "10%"
                    },
                    {
                        data: 'bpjs_kesehatan_no',
                        name: 'bpjs_kesehatan_no',
                        "width": "10%"
                    },
                    {
                        data: 'education_level_name',
                        name: 'education_level_name',
                        "width": "10%"
                    },
                    {
                        data: 'gender',
                        name: 'gender',
                        "width": "10%"
                    },
                    {
                        data: 'join_date',
                        name: 'join_date',
                        "width": "10%"
                    },
                    {
                        data: 'basic',
                        name: 'basic',
                        "width": "10%"
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, row) {
                            return output =
                                `<a class="fancybox" rel="group" href="{{ asset('uploads/employee') }}/${row.image}" target="_blank">
              <img src="{{ asset('uploads/employee') }}/${row.image}" class="img-thumbnail img-responsive img-employee-md" />
            </a>`
                        }
                    },
                    {
                        data: 'employee_status_name',
                        name: 'employee_status_name',
                        render: function(data, type, row) {
                            // let status = null;
                            if (row.employee_status_name == 'AKTIF') {
                                status = `<span class="label label-success"> Aktif </span>`;
                                return status;
                            } else if (row.employee_status_name == 'MENUNGGU_STATUS') {
                                status = `<span class="label label-brown"> Menunggu Status </span>`;
                                return status;
                            } else if (row.employee_status_name == 'MAGANG') {
                                status = `<span class="label label-info"> Magang </span>`;
                                return status;
                            } else if (row.employee_status_name == 'PENSIUN') {
                                status = `<span class="label label-purple"> Pensiun </span>`;
                                return status;
                            } else if (row.employee_status_name == 'RESIGN') {
                                status = `<span class="label label-warning"> Resign </span>`;
                                return status;
                            } else if (row.employee_status_name == 'DIBERHENTIKAN') {
                                status = `<span class="label label-danger"> Diberhentikan </span>`;
                                return status;
                            } else {
                                return status;
                            }
                        }
                    }
                ]
            });

            $('#status').change(function() {
                table.ajax.reload(null, false);
            });
            $('#search').on('input', function() {
                table.ajax.reload(null, false);
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax
        }

        function delete_id(id, employee_name) {
            var employee_name = employee_name.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + employee_name + ' data?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    cancel: {
                        action: function() {}
                    },
                    confirm: {
                        text: 'DELETE',
                        btnClass: 'btn-red',
                        action: function() {
                            $.ajax({
                                url: 'employee/delete/' + id,
                                type: "DELETE",
                                data: {
                                    '_token': $('input[name=_token]').val()
                                },
                                success: function(data) {
                                    var options = {
                                        "positionClass": "toast-bottom-right",
                                        "timeOut": 1000,
                                    };
                                    toastr.success('Successfully deleted data!', 'Success Alert',
                                        options);
                                    reload_table();
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
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

        function showslip(id) {
            var url = 'manual-book/show/' + id;
            PopupCenter(url, 'Popup_Window', '700', '650');
        }
    </script>

@stop
