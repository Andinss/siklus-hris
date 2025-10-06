@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Formulir Kalkulasi BPJS Ketenagakerjaan')
@section('current_page', 'BPJS TK')
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-sm-6 col-xs-12">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
                <div class="col-md-6 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                        <li><a href="#">@yield('module')</a></li>
                        <li class="active">@yield('current_page')</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <form action="{{ URL::route('editor.bpjs-tk.store') }}" id="formHitungBpjs" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <!-- <div class="col-6">
                                              {{ Form::label('basic', 'Dasar Upah', ['class' => 'mb-0 mt-3']) }}
                                              {{ Form::text('basic', old('basic'), ['class' => 'form-control', 'placeholder' => 'Rp', 'id' => 'basic', 'autocomplete' => 'off', 'required']) }}
                                            </div> -->
                                            <div class="col-6">
                                                {{ Form::label('schema_name', 'Nama Skema Perhitungan BPJS TK', ['class' => 'mb-0 mt-3']) }}
                                                {{ Form::text('schema_name', old('schema_name'), ['class' => 'form-control', 'placeholder' => 'Contoh: TK Golongan 1/ Staff', 'id' => 'schema_name', 'autocomplete' => 'off', 'required']) }}
                                            </div>
                                        </div>
                                        <table id="dtBPJS" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">Jenis Jaminan Sosial</th>
                                                    <th colspan="2">
                                                        <center>Persentase Ditanggung (%)</center>
                                                    </th>
                                                    <!-- <th colspan="2">
                                                  <center>Nominal Ditanggung (Rp)</center>
                                                </th> -->
                                                    <th rowspan="2">
                                                        <a href="#" id="addJaminanBPJS" type="button"
                                                            class="btn btn-primary btn-block btn-flat mb-0 mr-0"><i
                                                                class="fa fa-plus"></i></a>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <center>Perusahaan</center>
                                                    </th>
                                                    <th>
                                                        <center>Karyawan</center>
                                                    </th>
                                                    <!-- <th>
                                                  <center>Perusahaan</center>
                                                </th>
                                                <th>
                                                  <center>Karyawan</center>
                                                </th> -->
                                                </tr>
                                            </thead>
                                            <tbody id="dtBPJSBody">
                                                <tr id="dtBPJSRowInitial">
                                                    <td>
                                                        {{ Form::text('bpjs_jaminan[0]', old('bpjs_jaminan'), ['class' => 'form-control', 'placeholder' => 'masukkan nama jaminan', 'id' => 'bpjs_jaminan', 'required', 'autocomplete' => 'off']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('bpjs_ditanggung_perusahaan_persentase[0]', old('bpjs_ditanggung_perusahaan_persentase'), ['class' => 'form-control bpjs_ditanggung_perusahaan_persentase', 'placeholder' => '%', 'id' => 'bpjs_ditanggung_perusahaan_persentase_0', 'required', 'autocomplete' => 'off']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('bpjs_ditanggung_karyawan_persentase[0]', old('bpjs_ditanggung_karyawan_persentase'), ['class' => 'form-control bpjs_ditanggung_karyawan_persentase', 'placeholder' => '%', 'id' => 'bpjs_ditanggung_karyawan_persentase_0', 'required', 'autocomplete' => 'off']) }}
                                                    </td>
                                                    <!-- <td>
                                                  {{ Form::text('bpjs_ditanggung_perusahaan_rp[0]', old('bpjs_ditanggung_perusahaan_rp'), ['class' => 'form-control bpjs_ditanggung_perusahaan_rp', 'placeholder' => 'Rp', 'id' => 'bpjs_ditanggung_perusahaan_rp_0', 'readonly' => true]) }}
                                                </td>
                                                <td>
                                                  {{ Form::text('bpjs_ditanggung_karyawan_rp[0]', old('bpjs_ditanggung_karyawan_rp'), ['class' => 'form-control bpjs_ditanggung_karyawan_rp', 'placeholder' => 'Rp', 'id' => 'bpjs_ditanggung_karyawan_rp_0', 'readonly' => true]) }}
                                                </td> -->
                                                    <td>
                                                        <a href="#" type="button"
                                                            class="btn btn-danger btn-block btn-flat mb-0 removeJaminanBPJS"><i
                                                                class="fa fa-minus"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="text-capitalize mb-0">Jumlah Iuran</label>
                                                    </td>
                                                    <td>
                                                        {{ Form::text('bpjs_sum_perusahaan_percent', old('bpjs_sum_perusahaan_percent'), ['class' => 'form-control', 'placeholder' => '%', 'id' => 'bpjs_sum_perusahaan_percent', 'required', 'autocomplete' => 'off']) }}
                                                    </td>
                                                    <td>
                                                        {{ Form::text('bpjs_sum_karyawan_percent', old('bpjs_sum_karyawan_percent'), ['class' => 'form-control', 'placeholder' => '%', 'id' => 'bpjs_sum_karyawan_percent', 'required', 'autocomplete' => 'off']) }}
                                                    </td>
                                                    <!-- <td>
                                                  {{ Form::text('bpjs_sum_perusahaan', old('bpjs_sum_perusahaan'), ['class' => 'form-control', 'placeholder' => 'Rp', 'id' => 'bpjs_sum_perusahaan', 'readonly' => true]) }}
                                                </td>
                                                <td>
                                                  {{ Form::text('bpjs_sum_karyawan', old('bpjs_sum_karyawan'), ['class' => 'form-control', 'placeholder' => 'Rp', 'id' => 'bpjs_sum_karyawan', 'readonly' => true]) }}
                                                </td> -->
                                                    <td>
                                                        <div></div>
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                <td colspan="3">
                                                  <label class="text-capitalize mb-0">Total Iuran <br>(Total Ditanggung Perusahaan + Total Ditanggung Karyawan)</label>
                                                </td>
                                                <td>
                                                  {{ Form::text('bpjs_total', old('bpjs_total'), ['class' => 'form-control', 'placeholder' => 'Total Iuran (Rp)', 'id' => 'bpjs_total', 'required']) }}
                                                  <a href="#" onclick="calculate_bpjs_auto()" class="btn btn-primary btn-block btn-flat mt-2 mb-0"><i class="fa fa-magic"></i> Kalkulasi Otomatis</a>
                                                </td>
                                              </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <input type="hidden" name="payroll_id" id="payroll_id">
                                        <input type="hidden" name="kategori" id="kategori">
                                        <button type="submit" name="simpan_kalkulasi" id="simpan_kalkulasi"
                                            class="btn btn-success pull-right"><i class="fa fa-check"></i> Simpan
                                            Skema</button>
                                        <a href="{{ URL::route('editor.bpjs-tk.index') }}"
                                            class="btn btn-default pull-right btn-flat" style="margin-right: 10px"><i
                                                class="fa fa-close"></i> Tutup</a>
                                    </div>
                                </form>
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
        // Calculate BPJS
        this.modify_row_bpjs();

        function modify_row_bpjs() {
            let row_bpjs_index = 0;
            $('#addJaminanBPJS').on('click', function() {
                // set new row
                row_bpjs_index = row_bpjs_index + 1;
                let new_row_bpjs =
                    `<tr id="dtBPJSRowInitial">
        <td>
          {{ Form::text('bpjs_jaminan[${row_bpjs_index}]', old('bpjs_jaminan'), ['class' => 'form-control', 'placeholder' => 'masukkan nama jaminan', 'id' => 'bpjs_jaminan', 'required', 'autocomplete' => 'off']) }}
        </td>
        <td>
          {{ Form::text('bpjs_ditanggung_perusahaan_persentase[${row_bpjs_index}]', old('bpjs_ditanggung_perusahaan_persentase'), ['class' => 'form-control bpjs_ditanggung_perusahaan_persentase', 'placeholder' => '%', 'id' => 'bpjs_ditanggung_perusahaan_persentase_${row_bpjs_index}']) }}
        </td>
        <td>
          {{ Form::text('bpjs_ditanggung_karyawan_persentase[${row_bpjs_index}]', old('bpjs_ditanggung_karyawan_persentase'), ['class' => 'form-control bpjs_ditanggung_karyawan_persentase', 'placeholder' => '%', 'id' => 'bpjs_ditanggung_karyawan_persentase_${row_bpjs_index}']) }}
        </td> 
        <td>
          <a href="#" type="button" class="btn btn-danger btn-block btn-flat mb-0 removeJaminanBPJS"><i class="fa fa-minus"></i></a>
        </td>
      </tr>`;
                // Adding a row inside the tbody.
                // $('#dtBPJSBody > tr').eq(row_bpjs_index - 1).after(new_row_bpjs);
                $('#dtBPJSRowInitial').after(new_row_bpjs);
            });
            $('#dtBPJSBody').on('click', '.removeJaminanBPJS', function() {
                // Removing the current row, except dtBPJSRowInitial
                if ($("#dtBPJSBody > tr#dtBPJSRowInitial").length > 1) {
                    $(this).closest('tr').remove();
                }
            });
        }

        const calculate_bpjs_auto = () => {
            let upah = parseInt($("#basic").val());
            let tbBPJS = $("#dtBPJS").find("tbody tr#dtBPJSRowInitial");

            for (let i = 0; i < tbBPJS.length; i++) {
                if (upah == 0 || $("#basic").val() == '') {
                    toastr.error("Maaf, masukan nominal dasar upah dengan benar");
                } else {
                    let totalPercentBPJSPer = 0;
                    let totalPercentBPJSKar = 0;
                    let totalTanggunganBPJSPer = 0;
                    let totalTanggunganBPJSKar = 0;

                    let valBPJSPer = parseFloat($("#bpjs_ditanggung_perusahaan_persentase_" + i).val());
                    let totalBPJSPer = (valBPJSPer / 100) * upah;
                    let valBPJSKar = parseFloat($("#bpjs_ditanggung_karyawan_persentase_" + i).val());
                    let totalBPJSKar = (valBPJSKar / 100) * upah;
                    $("#bpjs_ditanggung_perusahaan_rp_" + i).val(Math.ceil(totalBPJSPer));
                    $("#bpjs_ditanggung_karyawan_rp_" + i).val(Math.ceil(totalBPJSKar));

                    $(".bpjs_ditanggung_perusahaan_persentase").each(function() {
                        let percentBPJSPer = parseFloat($(this).val());
                        totalPercentBPJSPer += percentBPJSPer;
                        $("#bpjs_sum_perusahaan_percent").val(totalPercentBPJSPer);
                    });

                    $(".bpjs_ditanggung_karyawan_persentase").each(function() {
                        let percentBPJSKar = parseFloat($(this).val());
                        totalPercentBPJSKar += percentBPJSKar;
                        $("#bpjs_sum_karyawan_percent").val(totalPercentBPJSKar);
                    });

                    // $(".bpjs_ditanggung_perusahaan_rp").each(function() {
                    //   let bpjsPerusahaanRp = parseFloat($(this).val());
                    //   totalTanggunganBPJSPer += bpjsPerusahaanRp;
                    //   $("#bpjs_sum_perusahaan").val(totalTanggunganBPJSPer);
                    // });

                    // $(".bpjs_ditanggung_karyawan_rp").each(function() {
                    //   let bpjsKaryawanRp = parseFloat($(this).val());
                    //   totalTanggunganBPJSKar += bpjsKaryawanRp;
                    //   $("#bpjs_sum_karyawan").val(totalTanggunganBPJSKar);
                    // });

                    let totalBpjs = parseFloat($("#bpjs_sum_perusahaan").val()) + parseFloat($("#bpjs_sum_karyawan")
                        .val());
                    $("#bpjs_total").val(totalBpjs);
                }
            }
        }
        // End Calculate BPJS
    </script>
@stop
