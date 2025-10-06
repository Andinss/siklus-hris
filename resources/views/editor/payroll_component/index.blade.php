@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Komponen Gaji')
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
                                @include('layouts.editor.template_button_master', [
                                    'add_action' => 'link',
                                    'link' => 'editor.payroll-component.create',
                                    'back_button' => true,
                                    'info_button' => true,
                                ])
                                <hr>
                                <div class="table-responsive">
                                    <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Aksi</th>
                                                <th>Kategori</th>
                                                <th>Item</th>
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
        var data = [{
                "id": "1",
                "component": "Pendapatan",
                "category": ["Gaji Pokok", "Lembur"]
            },
            {
                "id": "2",
                "component": "Benefit",
                "category": ["BPJS TK", "BPJS Kesehatan"]
            },
            {
                "id": "3",
                "component": "Potongan",
                "category": []
            }
        ];
        $(document).ready(function() {
            //datatables
            table = $('#dtTable').DataTable({
                processing: true,
                serverSide: true,
                fixedColumns: {
                    leftColumns: 4
                },
                //    dom: 'Bfrtip',
                //    buttons: [
                //         'copy', 'excel', 'print'
                //    ],
                //    data: data,
                ajax: "{{ route('editor.payroll-component.data') }}",
                bFilter: false,
                columns: [{
                        data: 'action',
                        name: 'action',
                        render: function(data, type, row) {
                            let category_id = row.id;
                            let category_name = row.category_name;

                            let urlEdit =
                                "{{ URL::route('editor.payroll-component.edit', ':id') }}";
                            urlEdit = urlEdit.replace(':id', category_id);

                            return output =
                                `<a href="javascript:void(0)" title="Hapus" onclick="delete_id(${category_id}, '${category_name}')" class="btn btn-danger btn-xs"> <i class="ti-trash"></i> Hapus</a>
              <a href="${urlEdit}" title="Edit" class="btn btn-warning btn-xs mr-2"> <i class="ti-pencil"></i> Edit</a>`;
                        }
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'payroll_component_detail',
                        name: 'payroll_component_detail',
                        render: function(data, type, row) {
                            let category_list = row.payroll_component_detail;

                            let new_list = [];
                            if (category_list.length != 0) {
                                category_list.forEach(item => {
                                    new_list.push(
                                        `<span class="label label-info ml-2">${item.payroll_component_name}</span>`
                                    );
                                });
                            }
                            return output = new_list;
                        }
                    },
                ]
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax
        }

        function delete_id(id, category_name) {
            var category_name = category_name.bold();
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + category_name + ' data?',
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
                                url: 'payroll-component/delete/' + id,
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
                    }
                }
            });
        }
    </script>
@stop
