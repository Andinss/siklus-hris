@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Gaji')
@section('required', 'errorEmployeeStatusName')
@section('content')

    <style type="text/css">
        @media print {
            #print {
                display: none;
            }
        }
    </style>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Gaji</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="#">Slip Gaji</a></li>
                        <li><a href="#">Gaji</a></li>
                        <li class="active">Slip Gaji</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <?php
            $bpjs = $payroll->bpjs - $payroll->total_bpjs_perusahaan;
            $jamsostek = $payroll->jamsostek - $payroll->total_jamsostek_perusahaan;
            $total_bruto = $payroll->basic + $payroll->meal_trans_all + $payroll->overtime_all;
            $total_potongan = $bpjs + $jamsostek + $payroll->pph_21 + $payroll->other_ded;
            $total_netto = $total_bruto - $total_potongan;
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box printableArea">
                        <img src="{{ Config::get('constants.path.uploads') }}/payroll_setting/{{ $payrollSetting->logo }}"
                            alt="Logo Perusahaan" class="mb-2" style="max-height: 28px;" />
                        <h3 class="font-bold text-primary my-0">{{ $payrollSetting->company_name }}</h3>
                        <address class="mb-0">{{ $payrollSetting->address }}</address>
                        <hr>
                        <h2 class="m-b-0"><b class="font-bold">SLIP GAJI</b> <span
                                class="pull-right">#{{ $payroll->id }}</span></h2>
                        <p>{{ $payroll->description }}</p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 m-b-20">
                                <div class="pull-left">
                                    <address>
                                        <p class="font-bold">{{ $payroll->employee_name }}</p>
                                        <p>Posisi: {{ $payroll->position_name }},
                                            <br>ID Karyawan : {{ $payroll->nik }},
                                            <br>Tanggal Masuk : {{ $payroll->join_date }}
                                        </p>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-6 m-b-20">
                                <div class="pull-left">
                                    <address>
                                        <p>
                                            <br /> No KTP : {{ $payroll->identity_no }}
                                            <br /> No NPWP : {{ $payroll->npwp }}
                                            <br /> No BPJS : {{ $payroll->bpjs }}
                                            <br /> No Rekening : {{ $payroll->bank_name }} / {{ $payroll->bank_account }}
                                            <br /> AN : {{ $payroll->bank_an }}
                                        </p>
                                    </address>
                                </div>
                            </div>
                            <!-- Table Slip -->
                            <div class="col-md-6">
                                <div class="table-responsive" style="clear: both;">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="2">
                                                    <h4 class="font-weight-bold my-0">Pendapatan</h4>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Gaji Pokok : {{ number_format($payroll->day_in) }} Hari</th>
                                                <th class="text-right"> {{ number_format($payroll->basic) }}</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Uang Makan</td>
                                                <td class="text-right"> {{ number_format($payroll->meal_trans_all) }}</td>
                                            </tr>
                                            <!-- <tr>
                                        <td class="text-left">Lembur Hari Biasa</td>
                                        <td class="text-right">{{ number_format($payroll->overtime) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Lembur Hari Libur</td>
                                        <td class="text-right">{{ number_format($payroll->overtime_holiday) }}</td>
                                    </tr> -->
                                            <tr>
                                                <td class="text-left">Lembur</td>
                                                <td class="text-right">{{ number_format($payroll->overtime_all) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Tunjangan BPJS kesehatan ditanggung perusahaan</td>
                                                <td class="text-right">{{ number_format($payroll->total_bpjs_perusahaan) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Tunjangan BPJS ketenagakerjaan ditanggung perusahaan
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($payroll->total_jamsostek_perusahaan) }}</td>
                                            </tr>
                                            <tr class="thead-light">
                                                <td class="text-left"><b>Total Pendapatan</b></td>
                                                <td class="text-right"><b>{{ number_format($total_bruto) }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive" style="clear: both;">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th colspan="2">
                                                    <h4 class="font-weight-bold my-0">Pengurangan</h4>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2"><b>Iuran BPJS Kesehatan</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left p-l-20">Ditanggung Perusahaan</td>
                                                <td class="text-right">{{ number_format($payroll->total_bpjs_perusahaan) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left p-l-20">Ditanggung Karyawan</td>
                                                <td class="text-right">{{ number_format($bpjs) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left font-weight-bold border-bottom border-dark">Total</td>
                                                <td class="text-right border-bottom border-dark">
                                                    {{ number_format($payroll->total_bpjs_perusahaan) }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><b>Iuran BPJS Ketenagakerjaan</b></td>
                                            </tr>
                                            <tr>
                                                <td class="text-left p-l-20">Ditanggung Perusahaan</td>
                                                <td class="text-right">
                                                    {{ number_format($payroll->total_jamsostek_perusahaan) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left p-l-20">Ditanggung Karyawan</td>
                                                <td class="text-right">{{ number_format($jamsostek) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left font-weight-bold border-bottom border-dark">Total</td>
                                                <td class="text-right border-bottom border-dark">
                                                    {{ number_format($payroll->total_bpjs_perusahaan) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Pph 21</td>
                                                <td class="text-right">{{ number_format($payroll->pph_21) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Potongan Lainnya</td>
                                                <td class="text-right">{{ number_format($payroll->other_ded) }}</td>
                                            </tr>
                                            <tr class="thead-light">
                                                <td class="text-left"><b>Total Pengurangan</b></td>
                                                <td class="text-right"><b>{{ number_format($total_potongan) }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Table Slip -->
                            <div class="col-md-12">
                                <div class="pull-left m-t-30 text-left">
                                    <p>Disetujui Oleh,</p>
                                    <img src="{{ Config::get('constants.path.uploads') }}/payroll_setting/{{ $payrollSetting->signature }}"
                                        width="50" alt="" srcset="">
                                </div>
                                <div class="pull-right m-t-30 text-right">
                                    {{ number_format($total_netto) }}
                                    <h2><b>Total THP :</b> {{ number_format($total_netto) }}</h2>
                                </div>
                                <div class="clearfix"></div>
                                {{-- <hr> --}}
                                <div class="text-right">
                                    {{-- <button class="btn btn-danger" type="submit"> Proceed to payment </button> --}}
                                    <button id="print" class="btn btn-default btn-outline print" type="button">
                                        <span><i class="fa fa-print"></i> Print</span> </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @stop

    @section('scripts')
        <script></script>
    @stop
