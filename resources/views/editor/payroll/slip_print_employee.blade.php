@extends('layouts.editor.template_report')
@section('title', 'Laporan Gaji')
@section('content')

    <style type="text/css">
        #print {
            position: absolute;
            right: 30px;
        }

        body {
            width: 100%;
            height: auto;
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        table {
            border-collapse: collapse;
        }

        table tr td,
        table tr th {
            vertical-align: top;
            font-size: 8pt;
            padding: 0mm;
        }

        .page {
            width: 210mm;
            padding: 10mm;
            margin: 5mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            background: url('invoice_matrix_alt2.jpg');
            background-size: 210mm auto;
            font-size: 10pt;
            position: relative;
        }

        .page h4 {
            margin: 10mm 0 0;
        }

        .page hr {
            border: 0;
            border-top: 1px solid #000;
            margin: 2mm 0;
        }

        .page .detail {
            margin: 2mm 0;
            padding: 1mm;
        }

        .page .contents table {
            width: 100%;
        }

        .page .contents table tr td {
            padding: 1mm;
        }

        .page .item {
            margin: 5mm 0;
            width: 100%;
            border: 1px solid #707070;
            overflow: hidden;
            border-radius: 1mm;
        }

        .page .item table {
            width: 100%;
            vertical-align: top;
        }

        .page .direktur {
            margin: 30mm 0 0 142mm;
            font-weight: bold;
            text-align: center;
            height: 12mm;
            width: 40mm;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                width: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }

            #print {
                display: none;
            }
        }

        .page .column {
            float: left;
            width: 33.33%;
            padding: 5px;
        }

        .page .row::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>

    @foreach ($payrolls as $payroll)
        <div class="page">
            <h4><b class="text-danger">SLIP GAJI KOHICHA CAFE {{ strtoupper($payroll->description) }}</b></h4>
            <hr>
            <div style="width: 100%; display: table;">
                <div class="detail" style="display: table-row">
                    <table border="0" style="width: 90mm">
                        <tr>
                            <td><b>Nama</b></td>
                            <td><b>:</b></td>
                            <td><b>{{ $payroll->employee_name }}</b></td>
                        </tr>
                        <tr>
                            <td>Posisi</td>
                            <td>:</td>
                            <td>{{ $payroll->position_name }}</td>
                        </tr>
                        <tr>
                            <td>ID Karyawan</td>
                            <td>:</td>
                            <td>{{ $payroll->nik }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Masuk</td>
                            <td>:</td>
                            <td>{{ $payroll->join_date }}</td>
                        </tr>
                    </table>
                    <table border="0" style="width: 90mm">
                        <tr>
                            <td>No KTP</td>
                            <td>:</td>
                            <td>{{ $payroll->identity_no }}</td>
                        </tr>
                        <tr>
                            <td>No NPWP</td>
                            <td>:</td>
                            <td>{{ $payroll->npwp }}</td>
                        </tr>
                        <tr>
                            <td>No BPJS</td>
                            <td>:</td>
                            <td>{{ $payroll->bpjs }}</td>
                        </tr>
                        <tr>
                            <td>No Rek (AN)</td>
                            <td>:</td>
                            <td>{{ $payroll->bank_name }} / {{ $payroll->bank_account }} ({{ $payroll->bank_an }})</td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr>
            <div style="width: 100%; display: table;">
                <div class="contents" style="display: table-row">
                    <table border="1" style="width: 90mm">
                        <thead>
                            <th colspan="3">PENDAPATAN</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Gaji Pokok : {{ number_format($payroll->day_in) }} Hari</td>
                                <td>:</td>
                                <td class="text-right">{{ number_format($payroll->basic) }}</td>
                            </tr>
                            <tr>
                                <td>Uang Makan</td>
                                <td>:</td>
                                <td class="text-right">{{ number_format($payroll->meal_trans_all) }}</td>
                            </tr>
                            <tr>
                                <td>Uang Lembur</td>
                                <td>:</td>
                                <td class="text-right">{{ number_format($payroll->overtime_all) }}</td>
                            </tr>
                            <tr>
                                <td><b>Total Pendapatan</b></td>
                                <td>:</td>
                                <td class="text-right">
                                    <b>{{ number_format($payroll->basic + $payroll->meal_trans_all + $payroll->overtime_all) }}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table border="1" style="width: 90mm">
                        <thead>
                            <th colspan="3">PENGURANGAN</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>BPJS TK</td>
                                <td>:</td>
                                <td class="text-right">{{ number_format($payroll->jamsostek) }}</td>
                            </tr>
                            <tr>
                                <td>BPJS</td>
                                <td>:</td>
                                <td class="text-right">{{ number_format($payroll->bpjs) }}</td>
                            </tr>
                            <tr>
                                <td>Pph 21</td>
                                <td>:</td>
                                <td class="text-right">{{ number_format($payroll->pph_21) }}</td>
                            </tr>
                            <tr>
                                <td>Potongan Lainnya</td>
                                <td>:</td>
                                <td class="text-right">{{ number_format($payroll->other_ded) }}</td>
                            </tr>
                            <tr>
                                <td><b>Total Pengurangan</b></td>
                                <td>:</td>
                                <td class="text-right">
                                    <b>{{ number_format($payroll->jamsostek + $payroll->bpjs + $payroll->pph_21 + $payroll->other_ded) }}</b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <h4 class="text-right"><b class="text-danger">TOTAL THP {{ number_format($payroll->total_netto) }}</b></h4>

            <div class="row" style="margin-top: -20px">
                <div class="column">
                    <p>Dibuat Oleh</p>
                    <p style="margin-top: 55px">(..........................)</p>
                </div>
                <div class="column"></div>
                <div class="column">
                    <p>Mengetahui</p>
                    <p style="margin-top: 55px; margin-left: -10px">(.......................)</p>
                </div>
            </div>
        </div>
    @endforeach
@endsection
{{-- @stop --}}
