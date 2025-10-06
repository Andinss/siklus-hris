@extends('layouts.editor.template')
@section('content')
    <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->
    <section class="content-header" style="margin-top: -10px; margin-bottom: -10px">
        <h1>
            <i class="fa fa-usd"></i> Price List
            <small>Price List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Price List</a></li>
            <li class="active">Price List</li>
        </ol>
    </section>

    <section class="content">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header with-border" style="height:50px !important; margin-top:-2px !important">
                        <button onClick="add()" type="button" class="btn btn-primary btn-flat"> <i
                                class="fa fa-sticky-note-o"></i> Add New</button>
                        <button onClick="history.back()" type="button" class="btn btn-primary btn-flat"> <i
                                class="fa fa-undo"></i> Back</button>
                        <button onClick="reload_table()" type="button" class="btn btn-success btn-flat"> <i
                                class="fa fa-refresh"></i> Refresh</button>
                        <!-- <button class="btn btn-danger btn-flat" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Bulk Delete</button> -->
                        <div class="box-tools pull-right">
                            <div class="tableTools-container">
                            </div>
                        </div><!-- /.box-tools -->
                    </div>
                    <div class="box-header">
                        <!-- /.panel-heading -->
                        <div class="box-body">
                            <table id="dtTable" class="table table-bordered table-hover stripe">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>City</th>
                                        <th>Lead Time</th>
                                        <th>5 Kg P</th>
                                        <th>Kg S</th>
                                        <th>Price</th>
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


    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog" style="width:40% !important">
            <div class="modal-content">
                <form action="#" id="form" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="modal-header" style="height: 60px">
                        <div class="form-group pull-right">
                            <label for="real_name" class="col-sm-4 control-label">Status</label>
                            <div class="col-sm-8 pull-right">
                                <select class="form-control" style="width: 100%;" name="status" id="status">
                                    <option value="0">Active</option>
                                    <option value="1">Not Active</option>
                                </select>
                            </div>
                        </div>
                        <h3 class="modal-title">Price List Form</h3>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" value="" name="idrack" />
                        <div class="form-body">
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-3">City</label>
                                    <div class="col-md-8">
                                        <select class="form-control select2" style="width: 100%;" name="cityid"
                                            id="cityid">
                                            @foreach ($city_list as $city_lists)
                                                <option value="{{ $city_lists->id }}">{{ $city_lists->cityname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Lead Time</label>
                                    <div class="col-md-8">
                                        <input name="leadtime" id="leadtime" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">5 Kg P</label>
                                    <div class="col-md-8">
                                        <input name="kgp" id="kgp" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Kg S</label>
                                    <div class="col-md-8">
                                        <input name="kgs" id="kgs" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Price</label>
                                    <div class="col-md-8">
                                        <input name="price" id="price" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                            class="fa fa-close"></i> Close</button>
                    <button type="button" id="btnSaveAdd" onClick="saveadd()"
                        class="btn btn-primary btn-flat pull-right" style="margin-left:5px !important"> <i
                            class="fa fa-plus-square"></i> Save & Add</button>
                    <button type="button" id="btnSave" class="btn btn-primary btn-flat pull-right"
                        style="margin-left:5px !important"> <i class="fa fa-save"></i> Save & Close</button>

                </div>
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
                "pageLength": 25,
                "scrollY": "360px",
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                ajax: "{{ url('editor/pricelist/data') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'cityname',
                        name: 'cityname'
                    },
                    {
                        data: 'leadtime',
                        name: 'leadtime'
                    },
                    {
                        data: 'kgp',
                        name: 'kgp'
                    },
                    {
                        data: 'kgs',
                        name: 'kgs'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'mstatus',
                        name: 'mstatus'
                    }
                ]
            });
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

            $('.errorPriceListName').addClass('hidden');
            $('.errorPriceListNo').addClass('hidden');

            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add PriceList'); // Set Title to Bootstrap modal title
        }

        function save() {
            var url;
            url = "{{ URL::route('editor.pricelist.store') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'cityid': $('#cityid').val(),
                    'leadtime': $('#leadtime').val(),
                    'kgp': $('#kgp').val(),
                    'kgs': $('#kgs').val(),
                    'price': $('#price').val(),
                    'status': $('#status').val()
                },
                success: function(data) {

                    $('.errorPriceListName').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.pricelistname) {
                            $('.errorPriceListName').removeClass('hidden');
                            $('.errorPriceListName').text(data.errors.pricelistname);
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
                url: "{{ URL::route('editor.pricelist.store') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'cityid': $('#cityid').val(),
                    'leadtime': $('#leadtime').val(),
                    'kgp': $('#kgp').val(),
                    'kgs': $('#kgs').val(),
                    'price': $('#price').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.errorPriceListName').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.rate) {
                            $('.errorPriceListName').removeClass('hidden');
                            $('.errorPriceListName').text(data.errors.rate);
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

            $('.errorPriceListName').addClass('hidden');

            //alert("asdad");

            $("#btnSave").attr("onclick", "update(" + id + ")");

            $("#btnSaveAdd").attr("onclick", "updateadd(" + id + ")");

            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string

            //Ajax Load data from ajax
            $.ajax({
                url: 'pricelist/edit/' + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {

                    $('[name="id_key"]').val(data.id);
                    $('[name="cityid"]').val(data.cityid);
                    $('[name="leadtime"]').val(data.leadtime);
                    $('[name="kgp"]').val(data.kgp);
                    $('[name="kgs"]').val(data.kgs);
                    $('[name="price"]').val(data.price);
                    $('[name="status"]').val(data.status);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Edit PriceList'); // Set title to Bootstrap modal title
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
                url: 'pricelist/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'cityid': $('#cityid').val(),
                    'leadtime': $('#leadtime').val(),
                    'kgp': $('#kgp').val(),
                    'kgs': $('#kgs').val(),
                    'price': $('#price').val(),
                    'status': $('#status').val()
                },
                success: function(data) {
                    $('.errorPriceListName').addClass('hidden');

                    if ((data.errors)) {
                        var options = {
                            "positionClass": "toast-bottom-right",
                            "timeOut": 1000,
                        };
                        toastr.error('Data is required!', 'Error Validation', options);

                        if (data.errors.pricelistname) {
                            $('.errorPriceListName').removeClass('hidden');
                            $('.errorPriceListName').text(data.errors.pricelistname);
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
                url: 'pricelist/edit/' + id,
                type: "PUT",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'cityid': $('#cityid').val(),
                    'leadtime': $('#leadtime').val(),
                    'kgp': $('#kgp').val(),
                    'kgs': $('#kgs').val(),
                    'price': $('#price').val(),
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

        function delete_id(id, pricelistname, date) {
            //var varnamre= $('#pricelistname').val();
            var pricelistname = pricelistname.bold();
            var date = date.bold();

            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure to delete ' + pricelistname + ' in ' + date + ' data?',
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
                                url: 'pricelist/delete/' + id,
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

        window.onload = function() {

            n2 = document.getElementById('rate');

            n2.onkeyup = n2.onchange = function(e) {
                e = e || window.event;
                var who = e.target || e.srcElement,
                    temp;
                temp = validDigits(who.value);
                who.value = addCommas(temp);
            }
            n2.onblur = function() {
                var
                    temp2 = parseFloat(validDigits(n2.value));
                if (temp2) n2.value = addCommas(temp2.toFixed(0));
            }

            n3 = document.getElementById('plusrate');

            n3.onkeyup = n3.onchange = function(e) {
                e = e || window.event;
                var who = e.target || e.srcElement,
                    temp;
                temp = validDigits(who.value);
                who.value = addCommas(temp);
            }
            n3.onblur = function() {
                var
                    temp3 = parseFloat(validDigits(n3.value));
                if (temp3) n3.value = addCommas(temp3.toFixed(0));
            }

        }
    </script>

    <!-- Add fancyBox -->
    <link rel="stylesheet" href="{{ Config::get('constants.path.plugin') }}/fancybox/jquery.fancybox.css?v=2.1.5"
        type="text/css" media="screen" />
    <script type="text/javascript"
        src="{{ Config::get('constants.path.plugin') }}/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".fancybox").fancybox();
        });
    </script>
@stop
