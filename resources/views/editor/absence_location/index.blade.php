@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Lokasi Absensi')
@section('required', 'errorEmployeeStatusName')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h6 class="page-title">@yield('title')</h6>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
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
                                @include('layouts.editor.template_button_master', [
                                    'add_action' => 'link',
                                    'link' => 'editor.absence-location.create',
                                    'back_button' => true,
                                    'info_button' => true,
                                ])
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Aksi</th>
                                                <th rowspan="2">Nama Lokasi</th>
                                                <th rowspan="2" width="400">Alamat</th>
                                                <th colspan="2">
                                                    <center>Koordinat Geografis</center>
                                                </th>
                                                <th rowspan="2">Radius Lokasi</th>
                                                <th rowspan="2">Deskripsi</th>
                                            </tr>
                                            <tr>
                                                <th>Latitude</th>
                                                <th>Longitude</th>
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
@section('scripts')
    <script>
        var table;
        //   var data = [
        //     {
        //       "id": "1",
        //       "location_name": "Siklus.id",
        //       "address": "Jl. Gn. Kerinci II No.897, RT.009/RW.012, Bintara Jaya, Bekasi Kota, Kota Bks, Jawa Barat 17136",
        //       "latitude": "-6.23304044777007",
        //       "longitude": "106.95286472883613",
        //       "radius": "20 meter",
        //       "description": "Lokasi Kantor Siklus ID"
        //     }
        //   ];
        $(document).ready(function() {
            //datatables
            table = $('#dtTable').DataTable({
                processing: true,
                serverSide: true,
                //  fixedColumns:   {
                //   leftColumns: 4
                //  },
                //  dom: 'Bfrtip',
                //  buttons: [
                //       'copy', 'excel', 'print'
                //  ],
                //    data: data,
                ajax: "{{ URL::Route('editor.absence-location.data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'location_name',
                        name: 'location_name'
                    },
                    {
                        data: 'location_address',
                        name: 'location_address'
                    },
                    {
                        data: 'location_latitude',
                        name: 'location_latitude'
                    },
                    {
                        data: 'location_longitude',
                        name: 'location_longitude'
                    },
                    {
                        data: 'location_radius',
                        name: 'location_radius'
                    },
                    {
                        data: 'location_description',
                        name: 'location_description'
                    },
                ]
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
                                url: 'absence-location/delete/' + id,
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
    </script>
@stop
