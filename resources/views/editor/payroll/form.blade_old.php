@extends('layouts.editor.template_datatable')
@section('module', 'Setting')
@section('title', 'Gaji')
@section('required', 'errorEmployeeStatusName')
@section('content')
<style type="text/css">
  .input-sm {
    height: 22px;
    padding: 1px 3px;
    font-size: 12px;
    line-height: 2.5;
    /* If Placeholder of the input is moved up, rem/modify this. */
    border-radius: 0px;
    /*width: 90% !important;*/
  }

  .input-min-150 {
    min-width: 150px;
  }

  .custom-select-sm {
    height: 32px;
    max-height: auto;
    padding: 1px 3px;
    font-size: 12px;
    line-height: 2.5;
    /* If Placeholder of the input is moved up, rem/modify this. */
    border-radius: 0px;
  }

  th,
  td {
    overflow-y: hidden;
    white-space: nowrap;
    /* text-overflow: ellipsis; */
  }

  .modal {
    max-height: 100vh;
  }

  .modal-dialog .modal-body {
    max-height: calc(100vh - 140px);
    overflow-y: auto;
  }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.3/css/fixedColumns.dataTables.min.css">

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
    </div>

    <!-- /row -->
    <div class="row">
      <div class="col-sm-12">
        <div class="col-sm-12">
          <div class="white-box">
            <div class="button-box">
              {!! Form::model($payroll, array('route' => ['editor.payroll.update', $payroll->id], 'method' => 'PUT', 'class'=>'update', 'id'=>'form_payroll'))!!}
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="table-responsive">
                    <table id="table_payroll" class="display nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                        <tr>
                          <th rowspan="2">#</th>
                          <th rowspan="2">ID</th>
                          <th rowspan="2">Nama</th>
                          <th rowspan="2">Jabatan</th>
                          <th rowspan="2">Divisi</th>
                          <th rowspan="2">Email</th>
                          <th rowspan="2">Hari Kerja</th>
                          <th rowspan="2">Hadir</th>
                          <th rowspan="2">Alpa</th>
                          <th rowspan="2">Telat</th>
                          <th rowspan="2">Gaji Pokok</th>
                          <th colspan="2" class="text-success">
                            <center>Pendapatan</center>
                          </th>
                          <th colspan="4" class="text-danger">
                            <center>Pengurangan</center>
                          </th>
                          <th rowspan="2">Total Bruto</th>
                          <th rowspan="2">Total Potongan</th>
                          <th rowspan="2">Total THP</th>
                          <th rowspan="2">Cetak Slip</th>
                        </tr>
                        <tr>
                          <th id="thBenefitOvertime" rowspan="2" class="text-success">Uang Lembur</th>
                          <th id="thBenefitOthers" rowspan="2" class="text-success">Uang Makan</th>
                          <th id="thDeductionBPJSTK" rowspan="2" class="text-danger">BPJS TK</th>
                          <th id="thDeductionBPJSKes" rowspan="2" class="text-danger">BPJS Kesehatan</th>
                          <th id="thDeductionPPH21" rowspan="2" class="text-danger">PPH 21</th>
                          <th id="thDeductionOthers" rowspan="2" class="text-danger">Potongan Lain</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($payroll_detail as $key => $payroll_details)
                        <tr>
                          <td data-original-title="Manual" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            <input type="checkbox" id="check" name="detail[{{$payroll_details->id}}][check]" @if($payroll_details->check == 1) checked @endif>
                          </td>
                          <td data-original-title="NIK" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{$payroll_details->nik}}
                          </td>
                          <td data-original-title="Nama" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{$payroll_details->employee_name}}
                          </td>
                          <td data-original-title="Jabatan" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            @if($payroll_details->position_name !== null)
                            {{$payroll_details->position_name}}
                            @else
                            <span>-</span>
                            @endif
                          </td>
                          <td data-original-title="Divisi" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            @if($payroll_details->department_name !== null)
                            {{$payroll_details->department_name}}
                            @else
                            <span>-</span>
                            @endif
                          </td>
                          <td data-original-title="Email" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            @if($payroll_details->email !== null)
                            {{$payroll_details->email}}
                            @else
                            <span>-</span>
                            @endif
                          </td>
                          <td data-original-title="Hari Kerja" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{$payroll_details->day_in}}
                          </td>
                          </td>
                          <td data-original-title="Kehadiran" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            <a href="javascript:void(0)" class="btn btn-primary btn-xs btn-flat" onclick="absence({{$payroll_details->employee_id}}, {{$payroll_details->period_id}})"><i class="fa fa-clock-o"></i> {{$payroll_details->day_job}} Hari, PH: {{$payroll_details->day_late}} </a>
                          </td>
                          <td data-original-title="Alpa" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{ Form::text('detail['.$payroll_details->id.'][day_alpha]', old($payroll_details->day_alpha), ['id' => 'public_holiday'.$payroll_details->id, 'min' => '0', 'class' => 'form-control input-sm', 'placeholder' => '', 'oninput' => 'total()']) }}
                          </td>
                          <td data-original-title="Terlambat" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{ Form::text('detail['.$payroll_details->id.'][day_late]', old($payroll_details->day_late), ['id' => 'day_late'.$payroll_details->id, 'min' => '0', 'class' => 'form-control input-sm', 'placeholder' => '', 'oninput' => 'total()']) }}
                          </td>
                          <td data-original-title="Gaji Pokok" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{ Form::text('detail['.$payroll_details->id.'][basic]', old('detail['.$payroll_details->id.'][basic]', number_format($payroll_details->basic)), ['id' => 'basic'.$payroll_details->id, 'min' => '0', 'class' => 'form-control input-sm', 'placeholder' => '', 'oninput' => 'total()']) }}
                          </td>
                          <td id="td_benefit_overtime" class="benefit-overtime" data-original-title="Lembur: {{$payroll_details->employee_name}}" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            <div class="d-flex mx-2">
                              <?php
                                $overtime_per_hour = floor(1 / 173 * $payroll_details->basic);
                              ?>
                              
                              {{ Form::text('detail['.$payroll_details->id.'][overtime_all]', old('detail['.$payroll_details->id.'][overtime_all]', $payroll_details->overtime_all), array('class' => 'form-control input-sm input-min-150 input--success', 'placeholder' => 'Rp', 'id' => 'overtime')) }}
                              <a href="javascript:void(0)" class="btn btn-primary btn-xs btn-flat btn-icon-txt-middle mb-0 ml-1 mr-0" onclick="calculate_lembur_modal({{$payroll_details->id}},{{$payroll_details->employee_id}},{{$payroll_details->basic}},{{ $overtime_per_hour }},'{{ $payroll_details->employee_name}}')"><i class="fa fa-edit"></i></a>
                            </div>
                          </td>
                          <td id="td_meal_trans" class="benefit-meal-trans" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{ Form::text('detail['.$payroll_details->id.'][meal_trans_all]', old('detail['.$payroll_details->id.'][meal_trans_all]', $payroll_details->meal_trans_all), array('class' => 'form-control input-sm input-min-150 input--success meal_trans', 'placeholder' => 'Rp', 'id' => 'meal_trans')) }}
                          </td>
                          <td id="td_deduction_bpjs_tk" class="deduction-bpjs-tk" data-original-title="BPJS TK: {{$payroll_details->employee_name}}" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            <div class="d-flex mx-2">
                              {{ Form::text('detail['.$payroll_details->id.'][jamsostek]', old('detail['.$payroll_details->id.'][jamsostek]', $payroll_details->jamsostek), array('class' => 'form-control input-sm input-min-150 input--danger', 'placeholder' => 'Rp', 'id' => 'bpjs_tk_nominal')) }}
                              <a href="javascript:void(0)" class="btn btn-primary btn-xs btn-flat btn-icon-txt-middle mb-0 ml-1 mr-0" onclick="calculate_bpjs_modal({{$payroll_details->employee_id}}, {{$payroll_details->id}}, 'Ketenagakerjaan')"><i class="fa fa-edit"></i></a>
                            </div>
                          </td>
                          <td id="td_deduction_bpjs_kesehatan" class="deduction-bpjs-kesehatan" data-original-title="BPJS Kesehatan: {{$payroll_details->employee_name}}" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            <div class="d-flex mx-2">
                              {{ Form::text('detail['.$payroll_details->id.'][bpjs]', old('detail['.$payroll_details->id.'][bpjs]', $payroll_details->bpjs), array('class' => 'form-control input-sm input--danger', 'placeholder' => 'Rp', 'id' => 'bpjs_kesehatan_nominal')) }}
                              <a href="javascript:void(0)" class="btn btn-primary btn-xs btn-flat btn-icon-txt-middle mb-0 ml-1 mr-0" onclick="calculate_bpjs_modal({{$payroll_details->employee_id}}, {{$payroll_details->id}}, 'Kesehatan')"><i class="fa fa-edit"></i></a>
                            </div>
                          </td>
                          <td id="td_deduction_pph_21" class="deduction-pph-21" data-original-title="PPH 21: {{$payroll_details->employee_name}}" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{ Form::text('detail['.$payroll_details->id.'][pph_21]', old('detail['.$payroll_details->id.'][pph_21]', number_format($payroll_details->pph_21)), ['id' => 'pph_21_nominal', 'min' => '0', 'class' => 'form-control input-sm input-min-150 input--danger', 'placeholder' => 'Rp', 'oninput' => 'total()']) }}
                          </td>
                          <td id="td_deduction_others" class="deduction-others" data-original-title="Potongan Lain: {{$payroll_details->employee_name}}" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{ Form::text('detail['.$payroll_details->id.'][other_ded]', old('detail['.$payroll_details->id.'][other_ded]', number_format($payroll_details->other_ded)), array('class' => 'form-control input-sm input--danger', 'placeholder' => 'Rp', 'id' => 'deduction_other_nominal')) }}
                          </td>
                          <td data-original-title="Total Bruto: {{$payroll_details->employee_name}}" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{ Form::text('detail['.$payroll_details->id.'][total_bruto]', old('detail['.$payroll_details->id.'][total_bruto]', $payroll_details->total_bruto), array('id' => 'total_bruto', 'class' => 'form-control input-sm', 'placeholder' => 'Rp')) }}
                          </td>
                          <td data-original-title="Total Potongan: {{$payroll_details->employee_name}}" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{ Form::text('detail['.$payroll_details->id.'][total_ded]', old('detail['.$payroll_details->id.'][total_ded]', $payroll_details->total_ded), array('id' => 'total_ded', 'class' => 'form-control input-sm', 'placeholder' => 'Rp')) }}
                          </td>
                          <td data-original-title="Total Netto: {{$payroll_details->employee_name}}" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            {{ Form::text('detail['.$payroll_details->id.'][total_netto]', old('detail['.$payroll_details->id.'][total_netto]', $payroll_details->total_netto), array('id' => 'total_netto', 'class' => 'form-control input-sm', 'placeholder' => 'Rp')) }}
                          </td>
                          <td data-original-title="Print Slip: {{$payroll_details->employee_name}}" data-container="body" data-toggle="tooltip" data-placement="bottom">
                            <a href="{{ URL::route('editor.payroll.slip', $payroll_details->id) }}" class="btn btn-secondary btn-xs btn-flat"><i class="fa fa-print"></i> Print</a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 pull-right">
                  <!-- /.box-body -->
                  <button type="button" id="btn_submit" class="btn btn-primary pull-right btn-flat"><i class="fa fa-check"></i> Simpan</button>
                  <a href="{{ URL::route('editor.payroll.index') }}" class="btn btn-default pull-right btn-flat" style="margin-right: 10px"><i class="fa fa-close"></i> Tutup</a>
                </div>
              </div>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Attendance -->
<div class="modal fade" role="dialog" id="modal_absence" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Attendance</h3>
      </div>
      <div class="modal-body">
        <table id="dtAbsence" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Employee Name</th>
              <th>Date</th>
              <th>Type</th>
              <th>Actual In</th>
              <th>Actual Out</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <a href="#" onclick="reload_table();" type="button" class="btn btn-success">Refresh</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Attendance -->
<!-- Modal BPJS -->
<div class="modal fade" role="dialog" id="modal_bpjs" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Rincian Kalkulasi BPJS <span id="bpjs_type"></span></h3>
      </div>
      <form action="#" id="formHitungBpjs">
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-6">
              {{ Form::label('dasar_upah', 'Dasar Upah', array('class' => 'mb-0 mt-3')) }}
              {{ Form::text('dasar_upah', old('dasar_upah'), array('class' => 'form-control', 'placeholder' => 'Rp', 'id' => 'dasar_upah')) }}
            </div>
            <div class="col-6">
              {{ Form::label('perhitungan_upah', 'Perhitungan BPJS', array('class' => 'mb-0 mt-3')) }}
              {{ Form::text('perhitungan_upah', old('perhitungan_upah'), array('class' => 'form-control', 'placeholder' => 'Contoh: TK Golongan 1/ Staff', 'id' => 'perhitungan_upah')) }}
            </div>
          </div>
          <table id="dtBPJS" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th rowspan="2">Jenis Jaminan Sosial</th>
                <th colspan="2">
                  <center>Persentase Ditanggung (%)</center>
                </th>
                <th colspan="2">
                  <center>Nominal Ditanggung (Rp)</center>
                </th>
                <th rowspan="2">
                  <a href="#" id="addJaminanBPJS" type="button" class="btn btn-primary btn-block btn-flat mb-0 mr-0"><i class="fa fa-plus"></i></a>
                </th>
              </tr>
              <tr>
                <th>
                  <center>Perusahaan</center>
                </th>
                <th>
                  <center>Karyawan</center>
                </th>
                <th>
                  <center>Perusahaan</center>
                </th>
                <th>
                  <center>Karyawan</center>
                </th>
              </tr>
            </thead>
            <tbody id="dtBPJSBody">
              <tr id="dtBPJSRowInitial">
                <td>
                  {{ Form::text('bpjs_jaminan', old('bpjs_jaminan'), array('class' => 'form-control', 'placeholder' => 'masukkan nama jaminan', 'id' => 'bpjs_jaminan', 'required', 'autocomplete'=> 'off')) }}
                </td>
                <td>
                  {{ Form::text('bpjs_ditanggung_perusahaan_persentase', old('bpjs_ditanggung_perusahaan_persentase'), array('class' => 'form-control bpjs_ditanggung_perusahaan_persentase', 'placeholder' => '%', 'id' => 'bpjs_ditanggung_perusahaan_persentase_0')) }}
                </td>
                <td>
                  {{ Form::text('bpjs_ditanggung_karyawan_persentase', old('bpjs_ditanggung_karyawan_persentase'), array('class' => 'form-control bpjs_ditanggung_karyawan_persentase', 'placeholder' => '%', 'id' => 'bpjs_ditanggung_karyawan_persentase_0')) }}
                </td>
                <td>
                  {{ Form::text('bpjs_ditanggung_perusahaan_rp', old('bpjs_ditanggung_perusahaan_rp'), array('class' => 'form-control bpjs_ditanggung_perusahaan_rp', 'placeholder' => 'Rp', 'id' => 'bpjs_ditanggung_perusahaan_rp_0', 'readonly'=> true)) }}
                </td>
                <td>
                  {{ Form::text('bpjs_ditanggung_karyawan_rp', old('bpjs_ditanggung_karyawan_rp'), array('class' => 'form-control bpjs_ditanggung_karyawan_rp', 'placeholder' => 'Rp', 'id' => 'bpjs_ditanggung_karyawan_rp_0', 'readonly'=> true)) }}
                </td>
                <td>
                  <a href="#" type="button" class="btn btn-danger btn-block btn-flat mb-0 removeJaminanBPJS"><i class="fa fa-minus"></i></a>
                </td>
              </tr>
              <tr>
                <td>
                  <label class="text-capitalize mb-0">Jumlah Iuran</label>
                </td>
                <td>
                  {{ Form::text('bpjs_sum_perusahaan', old('bpjs_sum_perusahaan'), array('class' => 'form-control', 'placeholder' => '%', 'id' => 'bpjs_sum_perusahaan_percent')) }}
                </td>
                <td>
                  {{ Form::text('bpjs_sum_karyawan', old('bpjs_sum_karyawan'), array('class' => 'form-control', 'placeholder' => '%', 'id' => 'bpjs_sum_karyawan_percent')) }}
                </td>
                <td>
                  {{ Form::text('bpjs_sum_perusahaan', old('bpjs_sum_perusahaan'), array('class' => 'form-control', 'placeholder' => 'Rp', 'id' => 'bpjs_sum_perusahaan', 'readonly'=> true)) }}
                </td>
                <td>
                  {{ Form::text('bpjs_sum_karyawan', old('bpjs_sum_karyawan'), array('class' => 'form-control', 'placeholder' => 'Rp', 'id' => 'bpjs_sum_karyawan','readonly'=> true)) }}
                </td>
                <td>
                  <div></div>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <label class="text-capitalize mb-0">Total Iuran <br>(Total Ditanggung Perusahaan + Total Ditanggung Karyawan)</label>
                </td>
                <td colspan="3">
                  {{ Form::text('bpjs_total', old('bpjs_total'), array('class' => 'form-control', 'placeholder' => 'Total Iuran (Rp)', 'id' => 'bpjs_total')) }}
                  <a href="#" onclick="calculate_bpjs_auto()" class="btn btn-primary btn-block btn-flat mt-2 mb-0"><i class="fa fa-magic"></i> Kalkulasi Otomatis</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <!-- <a href="#" onclick="reload_table()" type="button" class="btn btn-danger">Reset</a> -->
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <input type="hidden" name="payroll_id" id="payroll_id">
          <input type="hidden" name="kategori" id="kategori">
          <button type="submit" class="btn btn-primary" name="simpan_kalkulasi" id="simpan_kalkulasi">Simpan Skema</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal BPJS -->
<!-- Modal Lembur/Overtime -->
<div class="modal fade" role="dialog" id="modal_lembur" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Kalkulasi Upah Lembur</h3>
      </div>
      <form action="#" id="formHitungLembur" class="formHitungLembur">
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-4">
              <div class="mb-3">
                <p class="mb-0 font-weight-bold" id="employee_name"></p>
                <p class="mb-0" id="employee_id"></p>
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                {{ Form::label('dasar_upah', 'Upah dan Tunjangan Tetap') }}
                {{ Form::text('basic_salary', old('basic_salary'), ['id' => 'basic_salary', 'min' => '0', 'class' => 'form-control form-control-sm', 'placeholder' => '', 'oninput' => 'total()']) }}
              </div>
            </div>
            <div class="col-4">
              <div class="form-group">
                {{ Form::label('overtime_per_hour', 'Upah Lembur per jam') }}
                {{ Form::text('overtime_per_hour', old('overtime_per_hour'), ['id' => 'overtime_per_hour', 'min' => '0', 'class' => 'form-control form-control-sm', 'readonly']) }}
              </div>
            </div>
          </div>
          <table id="dtlembur" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th colspan="2">
                  <center>Rate</center>
                </th>
                <!-- <th>Tarif Upah Lembur/Jam</th> -->
                <th>Upah Lembur</th>
                <th rowspan="2">
                  <a href="#" id="addItemLembur" type="button" class="btn btn-primary btn-block btn-flat mb-0 mr-0"><i class="fa fa-plus"></i></a>
                </th>
              </tr>
            </thead>
            <tbody id="dtLemburBody">
              <tr>
                <td>
                  {{ Form::date('date_overtime', old('date_overtime'), array('class' => 'form-control date_overtime', 'placeholder' => 'dd-mm-yyyy', 'required' => 'true', 'id' => 'date_overtime')) }}
                </td>
                <td>
                  {{ Form::text('jumlah_rate', old('jumlah_rate', 0), array('class' => 'form-control jumlah_rate', 'placeholder' => 'contoh: 1.5 atau 2', 'id' => 'jumlah_rate_0',)) }}
                </td>
                <td>
                  <label for="rate" class="mb-0 mt-3">
                    1/173
                  </label>
                </td>
                <!-- <td>
                  {{ Form::text('overtime_per_hour', old('overtime_per_hour'), array('class' => 'form-control overtime_per_hour', 'placeholder' => 'Rp', 'id' => 'overtime_per_hour_0', 'readonly'=> true)) }}
                </td> -->
                <td>
                  {{ Form::text('total_overtime', old('total_overtime'), array('class' => 'form-control total_overtime', 'placeholder' => 'Rp', 'id' => 'total_overtime_0', 'readonly'=> true)) }}
                </td>
                <td>
                  <a href="#" type="button" class="btn btn-danger btn-block btn-flat mb-0 removeItemLembur"><i class="fa fa-minus"></i></a>
                </td>
              </tr>
            </tbody>
            <tfooter>
              <tr>
                <td colspan="3">
                  <label class="text-capitalize mb-0">Total Upah</label>
                </td>
                <td colspan="3">
                  {{ Form::text('total_overtime_all', old('total_overtime_all'), array('class' => 'form-control', 'placeholder' => 'Total Upah (Rp)', 'id' => 'total_overtime_all')) }}
                  <a href="#" onclick="calculate_lembur_auto()" class="btn btn-primary btn-block btn-flat mt-2 mb-0"><i class="fa fa-magic"></i> Kalkulasi Otomatis</a>
                </td>
              </tr>
            </tfooter>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <input type="hidden" name="payroll_id" id="payroll_id">
          <button type="submit" class="btn btn-primary" name="simpan_kalkulasi_lembur" id="simpan_kalkulasi_lembur">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal Lembur/Overtime -->
@stop
@section('scripts')
<script>
  $(document).on("keyup", ".jumlah_rate", function(){
    $(this).autocomplete({
      source: function(request, response) {
        $.ajax({
          url: "{{ url('/api/payroll/search_overtime') }}",
          dataType: "json",
          type: "GET",
          data: {
            search: request.term
          },
          success: function(data) {
            response(data);
          }
        })
      },
      select: function(event, ui) {
        $(this).val(ui.item.value);
      }
    });
    $(this).autocomplete("option", "appendTo", ".formHitungLembur");
  });
  $(document).ready(function() {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
      $($.fn.dataTable.tables(true)).css('width', '100%');
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
    });
    // $('#payrollTable').DataTable().columns.adjust().draw();
    $("#formHitungBpjs").on("submit", function(e) {
      e.preventDefault();
      let dataTable = [];
      let totalBpjs = $("#bpjs_total").val();
      let totalBpjsPerusahaan = $("#bpjs_sum_perusahaan").val();
      let payrollId = $("input[name='payroll_id']").val();
      let kategori = $("#kategori").val();
      if (totalBpjs.length <= 0) {
        toastr.error("Maaf belum ada data di tabel kalkulasi otomatis");
      } else {

        $("#dtBPJS tbody tr#dtBPJSRowInitial").each((row, tr) => {
          let namaJaminan = $(tr).find('td input[name=bpjs_jaminan]').val();
          if (namaJaminan.length <= 0) {
            toast.error("Mohon maaf nama jaminan belum dimasukkan");
          } else {
            let sub = {
              'nama_jaminan': $(tr).find("input[name='bpjs_jaminan']").val(),
              'bpjs_ditanggung_perusahaan_persentase': $(tr).find("input[name='bpjs_ditanggung_perusahaan_persentase']").val(),
              'bpjs_ditanggung_karyawan_persentase': $(tr).find("input[name='bpjs_ditanggung_karyawan_persentase']").val(),
              'bpjs_ditanggung_perusahaan_rp': $(tr).find("input[name='bpjs_ditanggung_perusahaan_rp']").val(),
              'bpjs_ditanggung_karyawan_rp': $(tr).find("input[name='bpjs_ditanggung_karyawan_rp']").val()
            }
            dataTable.push(sub);
            // console.log(dataTable);
            $.ajax({
              url: "{{ url('/api/payroll/create_calc_bpjs') }}",
              type: "POST",
              dataType: "json",
              data: {
                'data_table': dataTable,
                'total_bpjs_perusahaan': totalBpjsPerusahaan,
                'total_bpjs': totalBpjs,
                'payroll_id': payrollId,
                'kategori': kategori
              },
              beforeSend: function() {
                $("#simpan_kalkulasi").addClass("disabled").html("Processing...").attr("disabled", true);
              },
              complete: function() {
                $("#simpan_kalkulasi").removeClass("disabled").html("Simpan Skema").attr("disabled", true);
              },
              success: function(res) {
                // console.log(res);
                if (res.success == true) {
                  
                  toastr.success(res.message);
                  $("#formHitungBpjs").trigger("reset");
                  $("#modal_bpjs").modal("hide");
                  setTimeout(() => {
                    location.reload();
                  }, 2000);
                }


              },
              error: function(error) {
                console.log(error);
              }
            });
          }
        });
      }
    });
    $("#formHitungLembur").on("submit", function(e){
      e.preventDefault();
      let payrollId = $("input[name='payroll_id']").val();
      let totalOvertime = $("#total_overtime_all").val();
      if(totalOvertime.length < 1){
        toastr.error("Maaf, belum ada data di tabel kalkulasi lembur.");
      } else {
        $.ajax({
          url: "{{ url('/api/payroll/create_calc_overtime') }}",
          type: "POST",
          dataType:"json",
          data: {
            total_overtime: totalOvertime, payroll_id: payrollId
          },
          success: function(res){
            if(res.success == true){
              toastr.success(res.message);
              setTimeout(() => {
                location.reload();
              }, 2000);
            }
          },
          error: function(error){
            console.log(error);
          }
        })
      }
    })
    $("#payrollTableq").DataTable({
      "language": {
        "emptyTable": "-"
      }
    });
    $('body').on('expanded.pushMenu collapsed.pushMenu', function() {
      setTimeout(function() {
        $.fn.dataTable.tables({
          visible: true,
          api: true
        }).columns.adjust();
      }, 350);
    });
    $('#btn_submit').on('click', function() {
      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to create data?',
        type: 'green',
        typeAnimated: true,
        buttons: {
          cancel: {
            action: function() {}
          },
          confirm: {
            text: 'CREATE',
            btnClass: 'btn-green',
            action: function() {
              $('#form_payroll').submit();
            }
          },
  
        }
      });
    });
  });
  
</script>
<script>
  var table;
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    table = $('#dtAbsence').DataTable({
      processing: true,
      serverSide: true,
      "pageLength": 3,
      ajax: "{{ url('editor/payroll/dataabsence') }}",
      columns: [{
          data: 'employee_name',
          name: 'employee_name'
        },
        {
          data: 'date_in',
          name: 'date_in'
        },
        {
          data: 'actual_in',
          render: function(data, type, row){
            let output = '<span class="label label-danger"> Tidak Masuk </span>';
            if(row.actual_in == '00:00:00'){
              return output;
            } else {
              output = '<span class="label label-success"> Masuk </span>';
              return output;
            }
          } 
        },
        {
          data: 'actual_in',
          name: 'actual_in'
        },
        {
          data: 'actual_out',
          name: 'actual_out'
        },
      ]
    });
  });

  function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax 
  }

  function absence(employee_id, period_id) {
    console.log(employee_id);
    console.log(period_id);
    var url;
    url = "{{ URL::route('editor.payroll-absence.store') }}";
    $.ajax({
      type: 'POST',
      url: url,
      data: {
        '_token': $('input[name=_token]').val(),
        'employee_id': employee_id,
        'period_id': period_id
      },
    });
    table.ajax.reload(null, false); //reload datatable ajax 

    $('#modal_absence').modal('show'); // show bootstrap modal when complete loaded
  }

  // Calculate BPJS
  function calculate_bpjs_modal(employee_id, payroll_id, type) {
    this.modify_row_bpjs();
    $("span#bpjs_type").eq(0).text(type); // set title of BPJS Type
    $("button[name='simpan_kalkulasi']").val(type); // set value button submit
    $("input[name='kategori']").val(type);
    $("input[name='payroll_id']").val(payroll_id); //set value payroll_id
    $('#modal_bpjs').modal('show'); // show bootstrap modal when complete loaded
  }

  function modify_row_bpjs() {
    let row_bpjs_index = 0;
    $('#addJaminanBPJS').on('click', function() {
      // set new row
      row_bpjs_index = row_bpjs_index + 1;
      let new_row_bpjs =
        `<tr id="dtBPJSRowInitial">
        <td>
          {{ Form::text('bpjs_jaminan', old('bpjs_jaminan'), array('class' => 'form-control', 'placeholder' => 'masukkan nama jaminan', 'id' => 'bpjs_jaminan', 'required', 'autocomplete'=> 'off')) }}
        </td>
        <td>
          {{ Form::text('bpjs_ditanggung_perusahaan_persentase', old('bpjs_ditanggung_perusahaan_persentase'), array('class' => 'form-control bpjs_ditanggung_perusahaan_persentase', 'placeholder' => '%', 'id' => 'bpjs_ditanggung_perusahaan_persentase_${row_bpjs_index}')) }}
        </td>
        <td>
          {{ Form::text('bpjs_ditanggung_karyawan_persentase', old('bpjs_ditanggung_karyawan_persentase'), array('class' => 'form-control bpjs_ditanggung_karyawan_persentase', 'placeholder' => '%', 'id' => 'bpjs_ditanggung_karyawan_persentase_${row_bpjs_index}')) }}
        </td>
        <td>
          {{ Form::text('bpjs_ditanggung_perusahaan_rp', old('bpjs_ditanggung_perusahaan_rp'), array('class' => 'form-control bpjs_ditanggung_perusahaan_rp', 'placeholder' => 'Rp', 'id' => 'bpjs_ditanggung_perusahaan_rp_${row_bpjs_index}', 'readonly'=> true)) }}
        </td>
        <td>
          {{ Form::text('bpjs_ditanggung_karyawan_rp', old('bpjs_ditanggung_karyawan_rp'), array('class' => 'form-control bpjs_ditanggung_karyawan_rp', 'placeholder' => 'Rp', 'id' => 'bpjs_ditanggung_karyawan_rp_${row_bpjs_index}', 'readonly'=> true)) }}
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
    let upah = parseInt($("#dasar_upah").val());
    let tbBPJS = $("#dtBPJS").find("tbody tr#dtBPJSRowInitial");

    for (let i = 0; i < tbBPJS.length; i++) {
      if (upah == 0 || $("#dasar_upah").val() == '') {
        toastr.error("Maaf, masukan nominal dasar upah dengan benar");
      } else {
        let totalPercentBPJSPer = 0;
        let totalPercentBPJSKar = 0;
        let totalTanggunganBPJSPer = 0;
        let totalTanggunganBPJSKar = 0;

        let valBPJSPer = $("#bpjs_ditanggung_perusahaan_persentase_" + i).val().length < 1 ? $("#bpjs_ditanggung_perusahaan_persentase_" + i).val(0) : parseFloat($("#bpjs_ditanggung_perusahaan_persentase_" + i).val());
        let valBPJSKar = $("#bpjs_ditanggung_karyawan_persentase_" + i).val().length < 1 ? $("#bpjs_ditanggung_karyawan_persentase_" + i).val(0) : parseFloat($("#bpjs_ditanggung_karyawan_persentase_" + i).val());
   
        let totalBPJSPer = (valBPJSPer / 100) * upah;
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

        $(".bpjs_ditanggung_perusahaan_rp").each(function() {
          let bpjsPerusahaanRp = isNaN($(this).val()) ?  $(this).val(0) : parseFloat($(this).val());
          totalTanggunganBPJSPer += bpjsPerusahaanRp;
        
          $("#bpjs_sum_perusahaan").val(totalTanggunganBPJSPer);
        });

        $(".bpjs_ditanggung_karyawan_rp").each(function() {
          let bpjsKaryawanRp = isNaN($(this).val())  ?  $(this).val(0) : parseFloat($(this).val());
          totalTanggunganBPJSKar += bpjsKaryawanRp;
          $("#bpjs_sum_karyawan").val(totalTanggunganBPJSKar);
        });

        let totalBpjs = parseFloat($("#bpjs_sum_perusahaan").val()) + parseFloat($("#bpjs_sum_karyawan").val());
        $("#bpjs_total").val(totalBpjs);
      }
    }
  }
  // End Calculate BPJS

  // Calculate Lembur
  function modifyRowOvertime() {
    let rowOvertimeIndex = 0;
    $("#addItemLembur").on("click", function() {
      rowOvertimeIndex += 1;
      let newRowItemLembur = `
      <tr>
        <td>
          {{ Form::date('date_overtime', old('date_overtime'), array('class' => 'form-control date_overtime', 'placeholder' => 'Tanggal', 'required' => 'true', 'id' => 'date_overtime')) }}
        </td>
        <td>
          {{ Form::text('jumlah_rate', old('jumlah_rate',0), array('class' => 'form-control jumlah_rate', 'placeholder' => 'contoh: 1,5 atau 2', 'id' => 'jumlah_rate_${rowOvertimeIndex}')) }}
        </td>
        <td>
          <label for="rate" class="mb-0 mt-3">
            1/173
          </label>
        </td>
        <td>
        {{ Form::text('total_overtime', old('total_overtime'), array('class' => 'form-control total_overtime', 'placeholder' => 'Rp', 'id' => 'total_overtime_${rowOvertimeIndex}', 'readonly'=> true)) }}
        </td>
        <td>
          <a href="#" type="button" class="btn btn-danger btn-block btn-flat mb-0 removeItemLembur"><i class="fa fa-minus"></i></a>
        </td>
      </tr>
     `;
      $("#dtLemburBody").append(newRowItemLembur);
    });
    $(document).on("click", ".removeItemLembur", function() {
    if ($("#dtLemburBody > tr").length > 1) {
      $(this).closest('tr').remove();
    }
  });
  }

  function calculate_lembur_modal(payroll_id,employee_id,basic_salary,overtime_per_hour,employee_name) {
    $('#modal_lembur').modal('show'); // show bootstrap modal when complete loaded
    this.modifyRowOvertime();
    $("#employee_name").text("Nama : "+employee_name);
    $("#employee_id").text("ID : "+employee_id);
    $("#basic_salary").val(basic_salary);
    $("#overtime_per_hour").val(overtime_per_hour);
    $("input[name='payroll_id']").val(payroll_id); //set value payroll_id
  }

  function calculate_lembur_auto(){
    let dtItemLembur = $("#dtlembur").find("tbody#dtLemburBody tr");
    let overtimePerHour = $("#overtime_per_hour").val();
    for(let i = 0; i < dtItemLembur.length ; i++){
      let rate = parseFloat($("#jumlah_rate_"+i).val());
      let totalOvertime = overtimePerHour * rate;
      $("#total_overtime_"+i).val(Math.floor(totalOvertime));
    }
    let total = 0;
    $(".total_overtime").each(function(){
      let totalOvertimeAll = parseFloat($(this).val());
      total += totalOvertimeAll;
      $("#total_overtime_all").val(total);
    });
  }
  // End Calculate Lembur

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
</script>
<script>
  $(document).ready(function() {
    $("#table_payroll").dataTable({
      "bPaginate": false,
      "ordering": false,
      // "scrollY": "380px",
      // "scrollX": true,
      // fixedColumns: true,
      // "sScrollXInner": "150%", 
      // fixedColumns:   {
      //  leftColumns: 3 
      // },
      // "scrollY": true
      "initComplete": function(settings, json) {
        $("#table_payroll").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
      },
    });

  });


  function showslip(id) {
    console.log(id);
    var url = '../../payroll/slip/' + id;
    PopupCenter(url, 'Popup_Window', '700', '650');
  }

  function showabsence(id) {
    console.log(id);
    var url = '../../payroll/absence/' + id;
    PopupCenter(url, 'Popup_Window', '700', '650');
  }

  function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox  
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow  
    if (window.focus) {
      newWindow.focus();
    }
  }
</script>

@stop