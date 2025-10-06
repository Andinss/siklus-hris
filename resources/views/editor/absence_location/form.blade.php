@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Formulir Lokasi Absensi')
@section('content')
    <style type="text/css">
        .dataTables_length {
            margin-top: 12px;
            margin-bottom: 12px !important;
        }
    </style>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">@yield('title')</h4>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <div class="form-body">
                                    <section>
                                        <form action="#" id="submitForm" method="POST" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('location_name', 'Nama Lokasi') }}
                                                        {{ Form::text('location_name', old('location_name'), ['class' => 'form-control', 'placeholder' => 'Nama Lokasi', 'required' => 'true', 'id' => 'location_name']) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">&nbsp;</div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('address', 'Alamat (Opsional)') }}
                                                        {{ Form::textarea('address', old('address'), ['class' => 'form-control', 'placeholder' => 'Alamat *', 'id' => 'address', 'required' => 'true']) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('coordinate', 'Koordinat Geografis') }}
                                                        <div id="absenceLocation" style="height: 200px" class="w-100 mb-3">
                                                        </div>
                                                        <div class="row mb-3 mb-md-0">
                                                            <div class="col-md-6 mb-3 mb-md-0">
                                                                {{ Form::label('latitude', 'Latitude') }}
                                                                <input id="absenceLatitude" class="form-control"
                                                                    placeholder="Latitude" name="location_latitude" />
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{ Form::label('longitude', 'Longitude') }}
                                                                <input id="absenceLongitude" class="form-control"
                                                                    placeholder="Longitude" name="location_longitude" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('inputRadius', 'Radius Lokasi') }}
                                                        {{ Form::text('inputRadius', old('inputRadius'), ['class' => 'form-control', 'placeholder' => 'Isi dengan satuan meter', 'required' => 'true', 'id' => 'inputRadius']) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('desc', 'Deskripsi (Opsional)') }}
                                                        {{ Form::textarea('desc', old('desc'), ['class' => 'form-control', 'placeholder' => 'Contoh: Lokasi Kantor', 'id' => 'desc', 'required' => 'true']) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="border">
                                            <!-- Choose Empoyee -->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-4 mb-3 mb-md-0">
                                                        {{ Form::label('employee_choose', 'Pilih Berdasarkan Karyawan') }}
                                                        {{ Form::text('employee_choose', old('employee_choose'), ['class' => 'form-control', 'placeholder' => 'Pilih Karyawan', 'id' => 'employee_choose']) }}
                                                        <div id="search-results"></div>
                                                        <div id="employee_list"></div>
                                                    </div>
                                                    <div class="col-md-4 mb-3 mb-md-0">
                                                        {{ Form::label('employee_choose_by_division', 'Pilih Berdasarkan Divisi') }}
                                                        <select class="form-control form-select w-100 mb-2"
                                                            name="pilih-divisi" id="optionPilihDivisi">
                                                            <option value="" placeholder>-- Pilih Divisi --</option>
                                                            @foreach ($departments as $department)
                                                                <option value="{{ $department->department_name }}">
                                                                    {{ $department->department_name }}</option>
                                                            @endforeach
                                                            {{-- <option value="divison_1">Divisi 1</option>
                                      <option value="others">Divisi Lain</option> --}}
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="button"
                                                            class="btn btn-secondary mt-md-5 mb-2 mr-2"><i
                                                                class="ti-plus"></i> Tambah</button>
                                                        <button type="button"
                                                            class="btn btn-outline-default mt-md-5 mb-2"><i
                                                                class="ti-search"></i> Cari</button>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="dtTable" class="display nowrap" cellspacing="0"
                                                        width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th style="max-width: 100px !important;">Aksi</th>
                                                                <th>id</th>
                                                                <th>Nama Karyawan</th>
                                                                <th>ID Karyawan</th>
                                                                <th>Jabatan</th>
                                                                <th>Divisi</th>
                                                                <th>Email</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- End Choose Empoyee -->
                                            <hr>
                                            <button type="submit" id="btnsave" class="btn btn-success pull-right"><i
                                                    class="fa fa-check"></i> Simpan</button>
                                            <a href="{{ URL::route('editor.absence-location.index') }}"
                                                class="btn btn-default btn-flat pull-right" style="margin-right: 10px"><i
                                                    class="fa fa-close"></i> Tutup</a>
                                        </form>
                                    </section>
                                </div>
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
    <!-- Leaflet JS -->
    <script src="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js"></script>
    <!-- Map Configuration -->
    <script>
        $(function() {
            // use below if you want to specify the path for leaflet's images
            //L.Icon.Default.imagePath = '@Url.Content("~/Content/img/leaflet")';

            var curLocation = [0, 0];
            // use below if you have a model
            // var curLocation = [@Model.Location.Latitude, @Model.Location.Longitude];

            if (curLocation[0] == 0 && curLocation[1] == 0) {
                curLocation = [-6.23304044777007, 106.95286472883613];
                $("#absenceLatitude").val(curLocation[0]);
                $("#absenceLongitude").val(curLocation[1]).keyup();
            }

            var map = L.map('absenceLocation').setView(curLocation, 10);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            map.attributionControl.setPrefix(false);
            // set marker
            var marker = new L.marker(curLocation, {
                draggable: 'true'
            });
            // set circle
            var circle_set = {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5
            };
            var radius = 10 //meter;
            var circle = L.circle(curLocation, radius, circle_set).addTo(map).bindPopup("Radius Absensi");

            marker.on('dragend', function(event) {
                var position = marker.getLatLng();
                marker.setLatLng(position, {
                    draggable: 'true'
                }).bindPopup(position).update();
                $("#absenceLatitude").val(position.lat);
                $("#absenceLongitude").val(position.lng).keyup();
                circle.setLatLng(position);
            });

            $("#absenceLatitude, #absenceLongitude").change(function() {
                var position = [parseInt($("#absenceLatitude").val()), parseInt($("#absenceLongitude")
                    .val())];
                marker.setLatLng(position, {
                    draggable: 'true'
                }).bindPopup(position).update();
                map.panTo(position);
            });

            //set radius
            $("#inputRadius").change(function() {
                var current_radius = parseInt($("#inputRadius").val());
                if (current_radius > 50) {
                    alert("Radius yang dimasukkan terlalu jauh")
                } else if (current_radius <= 0) {
                    alert("Anda wajib mengisi radius lokasi absensi")
                } else {
                    circle.setRadius(current_radius) //meter
                }
            });

            map.addLayer(marker);
        })
    </script>
    <!-- End Map Configuration -->
    <script>
        var table;
        // var data = [
        //   {
        //     "id": "1",
        //     "employee_name": "Abdul Lukman, S.E",
        //     "nik": "192473246",
        //     "position_name": "Teknisi",
        //     "department_name": "Operational",
        //     "email": "abdul_lukman@mail.com"
        //   }
        // ];
        $(document).ready(function() {
            let employeeArray = [];

            //datatables
            table = $('#dtTable').DataTable({
                processing: true,
                // serverSide: true,
                fixedColumns: {
                    leftColumns: 4
                },
                ordering: false,
                info: false,
                bFilter: false,
                // ajax: "{{ URL::route('editor.employee.data') }}",
                // data: data,
                columns: [{
                        data: 'action',
                        name: 'action',
                        render: function(row) {
                            console.log(row);
                            return output = `
            <a href="javascript:void(0)" title="Hapus" class="btn btn-danger btn-xs mr-2 delete-btn" data-id="">
                <i class="ti-trash"></i> Hapus
            </a>`;
                        }
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'employee_name',
                        name: 'employee_name',
                        "width": "10%"
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                        "width": "5%"
                    },
                    {
                        data: 'position_name',
                        name: 'position_name',
                        "width": "10%"
                    },
                    {
                        data: 'department_name',
                        name: 'department_name',
                        "width": "5%"
                    },
                    {
                        data: 'email',
                        name: 'email',
                        "width": "5%"
                    }
                ]
            });

            table.columns([1]).visible(false);

            $('#employee_choose').on('input', function() {
                var query = $(this).val();

                if (query.length > 2) { // Search after 3 characters or more

                    let divisiOption = $('#optionPilihDivisi').val();

                    if (divisiOption !== '') {
                        $.ajax({
                            url: '/api/employee/department',
                            type: 'GET',
                            data: {
                                employee_name: query,
                                department_name: divisiOption
                            },
                            success: function(response) {
                                if (response.status) {
                                    let employeeOptions = '';
                                    response.data.forEach(employee => {
                                        employeeOptions +=
                                            `<option value="${employee.id}" data-employee='${JSON.stringify(employee)}'>${employee.employee_name}</option>`;
                                    });
                                    console.log(response);

                                    // Populate a datalist or show a dropdown with search results
                                    $('#employee_list').html(employeeOptions);
                                } else {
                                    $('#search-results').html('<p>No employees found</p>');
                                }
                            },
                            error: function(xhr) {
                                $('#search-results').html('<p>Error occurred</p>');
                            }
                        });
                    } else {

                        $.ajax({
                            url: '/api/employee/search',
                            type: 'GET',
                            data: {
                                name: query
                            },
                            success: function(response) {
                                if (response.status) {
                                    let employeeOptions = '';
                                    response.data.forEach(employee => {
                                        employeeOptions +=
                                            `<option value="${employee.id}" data-employee='${JSON.stringify(employee)}'>${employee.employee_name}</option>`;
                                    });
                                    console.log(response);

                                    // Populate a datalist or show a dropdown with search results
                                    $('#employee_list').html(employeeOptions);
                                } else {
                                    $('#search-results').html('<p>No employees found</p>');
                                }
                            },
                            error: function(xhr) {
                                $('#search-results').html('<p>Error occurred</p>');
                            }
                        });
                    }

                } else {
                    $('#search-results').empty(); // Clear results when query is too short
                }
            });

            $(document).on('click', 'option', function() {
                let employeeData = $(this).data('employee');

                // Check if the employee already exists in the array
                let exists = employeeArray.some(emp => emp.id === employeeData.id);

                if (!exists) {
                    // If not exists, push to array and add to DataTable
                    employeeArray.push(employeeData);

                    // Add employee data to DataTable
                    table.row.add({
                        'action': '',
                        'id': employeeData.id,
                        'employee_name': employeeData.employee_name,
                        'nik': employeeData.nik,
                        'position_name': employeeData.position.position_name,
                        'department_name': employeeData.departement.department_name,
                        'email': employeeData.email
                    }).draw();

                    $('#employee_choose').val(''); // Clear the input field
                    $('#employee_list').html('');
                } else {
                    alert("Employee already added to the list");
                }
            });

            $(document).on('click', '.delete-btn', function() {
                let employeeId = $(this).data('id');

                // Remove the employee from the employeeArray
                employeeArray = employeeArray.filter(emp => emp.id !== employeeId);

                // Remove the corresponding row from the DataTable
                table.row($(this).parents('tr')).remove().draw();

                // Optionally, you can show a message
                alert('Employee removed successfully');
            });

            $('#submitForm').submit(function(e) {
                e.preventDefault();

                let locationData = {
                    location_name: $('#location_name').val(),
                    location_address: $('#address').val(),
                    location_latitude: $('#absenceLatitude').val(),
                    location_longitude: $('#absenceLongitude').val(),
                    location_radius: $('#inputRadius').val(),
                    location_description: $('#desc').val(),
                    employees: employeeArray,
                    _token: $('input[name="_token"]').val()
                };

                $.ajax({
                    url: '/editor/absence-location/store',
                    method: 'POST',
                    data: locationData,
                    success: function(response) {
                        window.location.href = '/editor/absence-location';
                        // Clear the form and DataTable
                        employeeArray = [];
                        table.clear().draw();
                    }
                });
            });
        });

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax
        }
    </script>
@stop
