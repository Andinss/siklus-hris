@extends('layouts.editor.template')
@section('title', 'Location')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <section class="content-header" style="margin-top: -10px; margin-bottom: -10px">
        <h1>
            <i class="fa fa-map"></i> Location
            <small>Master Data</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Master Data</a></li>
            <li class="active">Location</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <!-- /.panel-heading -->
                        <div class="box-body">
                            <table id="dtTable" class="table table-bordered table-hover stripe">
                                <thead>
                                    <tr>
                                        <th width="3%">#</th>
                                        <th style="width:5%">
                                            <label class="control control--checkbox">
                                                <input type="checkbox" id="check-all" />
                                                <div class="control__indicator"></div>
                                            </label>
                                        </th>
                                        <th>Action</th>
                                        <th>Location Name</th>
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
    </section>

@stop
@section('scripts')
    <script>
        var table;
        $(document).ready(function() {
            //datatables
            table = $('#dtTable').DataTable({
                //editor 
                colReorder: true,
                fixedHeader: true,
                responsive: true,
                //rowReorder: true, 
                "rowReorder": {
                    "update": false,
                },
                //dttables 
                processing: true,
                serverSide: true,
                "pageLength": 25,
                "scrollY": "360px",
                "rowReorder": true,
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                ajax: "{{ url('editor/location/data') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'locationname',
                        name: 'locationname'
                    },
                    {
                        data: 'mstatus',
                        name: 'mstatus'
                    }
                ]
            });
            //auto number
            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            //check all
            $("#check-all").click(function() {
                $(".data-check").prop('checked', $(this).prop('checked'));
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax 
        }

        function add() {
            $("#btnSave").attr("onclick", "save()");
            $("#btnSaveAdd").attr("onclick", "saveadd()");

            $('.errorLocationName').addClass('hidden');

            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Location'); // Set Title to Bootstrap modal title
        }

        function save() {
            var url;
            url = "{{ URL::route('editor.location.store') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'locationname': $('#locationname').val(),
                    'status': $('#status').val()
                },
                success: function(data) {

                    $('.errorLocationName').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.locationname) {
                            $('.errorLocationName').removeClass('hidden');
                            $('.errorLocationName').text(data.errors.locationname);
                        }
                    } else {

                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully added data!', 'Success Alert', options);
                        $('#modal_form').modal('hide');
                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                    }
                },
            })
        };

        function saveadd() {
            $.ajax({
                type: 'POST',
                url: "{{ URL::route('editor.location.store') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'locationname': $('#locationname').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.errorLocationName').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.locationname) {
                            $('.errorLocationName').removeClass('hidden');
                            $('.errorLocationName').text(data.errors.locationname);
                        }
                    } else {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully added data!', 'Success Alert', options);

                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                    }
                },
            })
        };

        function edit(id) {

            $('.errorLocationName').addClass('hidden');

            //alert("asdad");

            $("#btnSave").attr("onclick", "update(" + id + ")");

            $("#btnSaveAdd").attr("onclick", "updateadd(" + id + ")");

            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'location/edit/' + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {

                    $('[name="id_key"]').val(data.id);
                    $('[name="locationname"]').val(data.locationname);
                    $('[name="status"]').val(data.status);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit Location'); // Set title to Bootstrap modal title
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        function update(id) {
            save_method = 'update';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'location/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'locationname': $('#locationname').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.errorLocationName').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.locationname) {
                            $('.errorLocationName').removeClass('hidden');
                            $('.errorLocationName').text(data.errors.locationname);
                        }
                    } else {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully updated data!', 'Success Alert', options);
                        $('#modal_form').modal('hide');
                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                    }
                },
            })
        };

        function updateadd(id) {
            save_method = 'update';
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'location/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'locationname': $('#locationname').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    if ((data.errors)) {
                        swal("Error!", "Gat data failed!", "error")
                    } else {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.success('Successfully updated data!', 'Success Alert', options);
                        $('#form')[0].reset(); // reset form on modals
                        reload_table();
                        $("#btnSave").attr("onclick", "save()");
                        $("#btnSaveAdd").attr("onclick", "saveadd()");
                    }
                },
            })
        };

        function delete_id(id, locationname) {

            //var varnamre= $('#locationname').val();
            var locationname = locationname.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + locationname + ' data?',
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
                                url: 'location/delete/' + id,
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

        function bulk_delete() {


            var list_id = [];
            $(".data-check:checked").each(function() {
                list_id.push(this.value);
            });
            if (list_id.length > 0) {


                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure to delete ' + list_id.length + ' data?',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        cancel: {
                            action: function() {

                            }
                        },
                        confirm: {
                            text: 'DELETE',
                            btnClass: 'btn-red',
                            action: function() {
                                $.ajax({
                                    data: {
                                        '_token': $('input[name=_token]').val(),
                                        'idkey': list_id,
                                    },
                                    url: "location/deletebulk",
                                    type: "POST",
                                    dataType: "JSON",
                                    success: function(data) {
                                        if (data.status) {


                                            reload_table();
                                        } else {
                                            alert('Failed.');
                                        }

                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        $.alert({
                                            type: 'red',
                                            icon: 'fa fa-danger', // glyphicon glyphicon-heart
                                            title: 'Warning',
                                            content: 'Error deleting data!',
                                        });
                                    }
                                });
                            }
                        },

                    }
                });
            } else {
                $.alert({
                    type: 'orange',
                    icon: 'fa fa-warning', // glyphicon glyphicon-heart
                    title: 'Warning',
                    content: 'No data selected!',
                });
            }
        }
    </script>
@stop
