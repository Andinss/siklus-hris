@extends('layouts.editor.template')
@if (isset($overtime))
    @section('title', 'Edit Lembur')
@else
    @section('title', 'Tambah Baru Lembur')
@endif
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        @if (isset($overtime))
                            Edit
                        @else
                            Tambah Baru
                        @endif Lembur
                    </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li class="active">
                            @if (isset($overtime))
                                Edit
                            @else
                                Tambah Baru
                            @endif Lembur
                        </li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                @if (isset($overtime))
                                    {!! Form::model($overtime, [
                                        'route' => ['editor.overtime.update', $overtime->id],
                                        'method' => 'PUT',
                                        'files' => 'true',
                                    ]) !!}
                                @else
                                    {!! Form::open(['route' => 'editor.overtime.store', 'files' => 'true']) !!}
                                @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('no_trans', 'No Lembur *') }}
                                                    {{ Form::text('no_trans', old('no_trans'), ['class' => 'form-control', 'placeholder' => 'No Lembur *', 'required' => 'true', 'id' => 'no_trans']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('date_trans', 'Tanggal Lembur *') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        {{ Form::text('date_trans', old('date_trans'), ['class' => 'form-control', 'placeholder' => 'Tanggal Lembur *', 'required' => 'true']) }}
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('employee_id', 'Nama Karyawan *') }}
                                                    {{ Form::select('employee_id', $employee_list, old('employee_id'), ['class' => 'form-control select2', 'placeholder' => 'Pilih karyawan', 'id' => 'employee_id', 'onchange' => 'RefreshData();']) }}
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            {{ Form::label('time_from', 'Dari Jam*') }}
                                                            {{ Form::time('time_from', old('time_from'), ['class' => 'form-control', 'placeholder' => 'Contoh : 16:00', 'id' => 'time_from']) }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{ Form::label('time_to', 'Sampai Jam*') }}
                                                            {{ Form::time('time_to', old('time_to'), ['class' => 'form-control', 'placeholder' => 'Contoh : 18:00', 'id' => 'time_to']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="lemburCalculateSection" class="col-md-6">
                                                <!-- lembur head -->
                                                <div id="lemburHead" class="row align-items-center g-0">
                                                    <div class="col-md px-2">
                                                        <label for="time_from" class="mb-0">Dari Jam *</label>
                                                    </div>
                                                    <div class="col-md px-2">
                                                        <label for="time_to" class="mb-0">Sampai Jam *</label>
                                                    </div>
                                                    <div class="col-md px-2">
                                                        <label for="time_sum" class="mb-0">Jumlah Jam *</label>
                                                    </div>
                                                    <div class="col-md col-lg-1">
                                                        <h2 class="my-0 text-center text-primary">
                                                            <i class="fa fa-times"></i>
                                                        </h2>
                                                    </div>
                                                    <div class="col-md px-2">
                                                        <label for="rate" class="mb-0">Rate *</label>
                                                    </div>
                                                    <div class="col-md col-lg-1 px-2">
                                                        <a href="#" id="addItemLembur" type="button"
                                                            class="btn btn-primary btn-block btn-flat mb-0 mr-0"><i
                                                                class="fa fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                <!-- end lembur head -->
                                                <hr>
                                                <!-- lembur items -->
                                                <div id="lemburContent">
                                                    <div id="itemLemburInitial" class="row g-0 mb-4 mb-md-2">
                                                        <div class="col-md px-2">
                                                            {{ Form::time('overtime_from', old('overtime_from'), ['class' => 'form-control overtime_from', 'placeholder' => 'Contoh: 16:00', 'required' => 'true', 'id' => 'overtime_from_0']) }}
                                                        </div>
                                                        <div class="col-md px-2">
                                                            {{ Form::time('overtime_to', old('overtime_to'), ['class' => 'form-control overtime_to', 'placeholder' => 'Contoh: 17:00', 'required' => 'true', 'id' => 'overtime_to_0']) }}
                                                        </div>
                                                        <div class="col-md px-2">
                                                            {{ Form::text('overtime_sum', old('overtime_sum'), ['class' => 'form-control overtime_sum', 'placeholder' => 'Contoh: 1', 'required' => 'true', 'id' => 'overtime_sum_0']) }}
                                                        </div>
                                                        <div class="col-md col-lg-1 px-2">
                                                            <h2 class="my-0 text-center text-primary">
                                                                <i class="fa fa-times"></i>
                                                            </h2>
                                                        </div>
                                                        <div class="col-md px-2">
                                                            {{ Form::text('rate_item', old('rate_item'), ['class' => 'form-control rate_item', 'placeholder' => '1.5 atau 2', 'required' => 'true', 'id' => 'rate_item_0']) }}
                                                            <input type="hidden" class="subtotal_rate" name="subtotal_rate"
                                                                id="subtotal_rate_0">
                                                        </div>
                                                        <div class="col-md col-lg-1 px-2">
                                                            <a href="#" type="button"
                                                                class="btn btn-danger btn-block btn-flat mb-0 removeItemLembur"><i
                                                                    class="fa fa-minus"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end lembur items -->
                                                <!-- lembur footer -->
                                                <div id="lemburFooter" class="row g-0 justify-content-end mb-2">
                                                    <div class="col-lg-6 px-2">
                                                        <a href="#" onclick="calculate_lembur_auto()"
                                                            class="btn btn-primary btn-block btn-flat mt-2 mb-0"><i
                                                                class="fa fa-magic"></i> Kalkulasi Otomatis</a>
                                                    </div>
                                                    <div id="calculateLemburResult" class="col-12 px-2">
                                                        <hr>
                                                        <div class="row mb-2">
                                                            <div class="col-6">
                                                                <label for="total_hour" class="mb-0">Jumlah Jam</label>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ Form::text('total_hour', old('total_hour'), ['class' => 'form-control input-sm', 'placeholder' => 'Jumlah Jam', 'id' => 'total_hour', 'readonly' => true]) }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-6">
                                                                <label for="total_rate" class="mb-0">Total Rate</label>
                                                            </div>
                                                            <div class="col-6">
                                                                {{ Form::text('total_rate', old('total_rate'), ['class' => 'form-control input-sm', 'placeholder' => 'Total Rate', 'id' => 'total_rate', 'readonly' => true]) }}
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </div>
                                                </div>
                                                <!-- lembur footer -->
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('keterangan_lembur', 'Keterangan *') }}
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                @if ($overtime)
                                                                    <input class="form-check-input" type="radio"
                                                                        name="category" id="keterangan_hari_biasa"
                                                                        value="Hari Biasa" <?php echo $overtime->category == 'Hari Biasa' ? 'checked' : ''; ?>>
                                                                @else
                                                                    <input class="form-check-input" type="radio"
                                                                        name="category" id="keterangan_hari_biasa"
                                                                        value="Hari Biasa">
                                                                @endif($overtime)
                                                                <label class="form-check-label ml-2"
                                                                    for="keterangan_hari_biasa">
                                                                    Hari Biasa
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                @if ($overtime)
                                                                    <input class="form-check-input" type="radio"
                                                                        name="category" id="keterangan_hari_libur"
                                                                        value="Hari Libur" <?php echo $overtime->category == 'Hari Libur' ? 'checked' : ''; ?>>
                                                                @else
                                                                    <input class="form-check-input" type="radio"
                                                                        name="category" id="keterangan_hari_libur"
                                                                        value="Hari Libur">
                                                                @endif
                                                                <label class="form-check-label ml-2"
                                                                    for="keterangan_hari_libur">
                                                                    Hari Libur
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                @if ($overtime)
                                                                    <input class="form-check-input" type="radio"
                                                                        name="category"
                                                                        id="keterangan_hari_libur_nasional"
                                                                        value="Hari Libur Nasional" <?php echo $overtime->category == 'Hari Libur Nasional' ? 'checked' : ''; ?>>
                                                                @else
                                                                    <input class="form-check-input" type="radio"
                                                                        name="category"
                                                                        id="keterangan_hari_libur_nasional"
                                                                        value="Hari Libur Nasional">
                                                                @endif
                                                                <label class="form-check-label ml-2"
                                                                    for="keterangan_hari_libur_nasional">
                                                                    Hari Libur Nasional
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('attachment', 'Lampiran') }}<br>
                                                    <span class="btn btn-default"><input type="file"
                                                            name="attachment" /></span>
                                                    <br />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="btnsave" class="btn btn-success pull-right"><i
                                                class="fa fa-check"></i> Simpan</button>
                                        <a href="{{ URL::route('editor.overtime.index') }}"
                                            class="btn btn-default pull-right btn-flat" style="margin-right: 10px"><i
                                                class="fa fa-close"></i> Tutup</a>
                                    </section>
                                </div>
                                {!! Form::close() !!}
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
    <script src="{{ asset('assets/plugins') }}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        jQuery('.mydatepicker, #date_trans').datepicker();
        jQuery('.mydatepicker, #overtime_from').datepicker();
        jQuery('.mydatepicker, #date_from').datepicker();
        jQuery('.mydatepicker, #overtime_to').datepicker();

        $('#date_trans').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#overtime_from').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#overtime_to').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#date_from').datepicker({
            format: 'dd-mm-yyyy'
        });

        $(document).ready(function() {
            // Calculate Lembur
            modify_item_lembur();
            calculate_lembur_auto();
            $("#total_hour").val('');
            $("#total_rate").val('');
        });

        function modify_item_lembur() {
            let item_lembur_index = 0;
            $('#addItemLembur').on('click', function() {
                // set new row
                item_lembur_index = item_lembur_index + 1;
                let new_item_lembur =
                    `<div id="itemLemburInitial" class="row g-0 mb-4 mb-md-2 itemLembur">
        <div class="col-md px-2">
          {{ Form::time('overtime_from', old('overtime_from'), ['class' => 'form-control dari_jam_item', 'placeholder' => '', 'required' => 'true', 'id' => 'overtime_from_${item_lembur_index}']) }}
        </div>  
        <div class="col-md px-2">
          {{ Form::time('overtime_to', old('overtime_to'), ['class' => 'form-control sampai_jam_item', 'placeholder' => '', 'required' => 'true', 'id' => 'overtime_to_${item_lembur_index}']) }}
        </div>   
        <div class="col-md px-2">
          {{ Form::text('overtime_sum', old('overtime_sum'), ['class' => 'form-control overtime_sum', 'placeholder' => '', 'required' => 'true', 'id' => 'overtime_sum_${item_lembur_index}']) }}
        </div>
        <div class="col-md col-lg-1 px-2">
          <h2 class="my-0 text-center text-primary">
            <i class="fa fa-times"></i>
          </h2>
        </div>
        <div class="col-md px-2">
          {{ Form::text('rate_item', old('rate_item'), ['class' => 'form-control rate_item', 'placeholder' => '', 'required' => 'true', 'id' => 'rate_item_${item_lembur_index}']) }}
          <input type="hidden" class="subtotal_rate" name="subtotal_rate" id="subtotal_rate_${item_lembur_index}">
        </div>
        <div class="col-md col-lg-1 px-2">
          <a href="#" type="button" class="btn btn-danger btn-block btn-flat mb-0 removeItemLembur"><i class="fa fa-minus"></i></a>
        </div>
      </div>`;
                // Adding an item inside the section.
                $('#itemLemburInitial').after(new_item_lembur);
            });
            $('#lemburCalculateSection').on('click', '.removeItemLembur', function() {
                // Removing the current row, except itemLemburInitial
                if ($("#lemburContent > div#itemLemburInitial").length > 1) {
                    $(this).closest('div.itemLembur').remove();
                }
            });
        }
        const calculate_lembur_auto = () => {
            let lemburItem = $("#lemburCalculateSection").find("div#lemburContent div#itemLemburInitial");
            for (let i = 0; i < lemburItem.length; i++) {
                let totalHour = 0;
                let totalRate = 0;

                $(".overtime_sum").each(function() {
                    let valHour = parseFloat($(this).val());
                    totalHour += valHour;

                    $("#total_hour").val(totalHour);
                });

                $(".subtotal_rate").each(function() {
                    let subtotalRate = parseFloat($(this).val());
                    totalRate += subtotalRate;

                    $("#total_rate").val(totalRate);
                });

            }
        }
        // End Calculate 
        $(document).on("keyup", ".rate_item", function() {
            let lemburItem = $("#lemburCalculateSection").find("div#lemburContent div#itemLemburInitial");

            for (let index = 0; index < lemburItem.length; index++) {
                let valOvertime = parseFloat($("#overtime_sum_" + index).val());
                let valRate = parseFloat($("#rate_item_" + index).val());
                let totalPengali = valOvertime * valRate;

                $("#subtotal_rate_" + index).val(totalPengali);
            }
        });
    </script>

    @if (isset($overtime))
        <script type="text/javascript">
            function cancel() {
                $.confirm({
                    title: 'Confirm!',
                    content: 'Are you sure to cancel this data?',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        cancel: {
                            action: function() {}
                        },
                        confirm: {
                            text: 'CANCEL',
                            btnClass: 'btn-red',
                            action: function() {
                                $.ajax({
                                    url: '../../overtime/cancel/' + {
                                        {
                                            $overtime - > id
                                        }
                                    },
                                    type: "PUT",
                                    data: {
                                        '_token': $('input[name=_token]').val()
                                    },
                                    success: function(data) {
                                        //var loc = 'ap_invoice';
                                        if ((data.errors)) {
                                            alert("Cancel error!");
                                        } else {
                                            window.location.href =
                                                "{{ URL::route('editor.overtime.index') }}";
                                        }
                                    },
                                });
                            }
                        },
                    }
                });
            }
        </script>
    @endif
@stop
