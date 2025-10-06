@extends('layouts.editor.template')
@section('title', 'Slip Penerimaan Kas')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title"> Penerimaan Kas</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li><a href="#">Keuangan</a></li>
                        <li class="active">Penerimaan Kas</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="white-box printableArea">
                        <style type="text/css">
                            #print {
                                position: absolute;
                                right: 30px;
                            }

                            body {
                                width: 100%;
                                height: 100%;
                                margin: 0;
                                padding: 0;
                                /*background-color: #FAFAFA;*/
                                /*font: 12pt arial;*/
                            }

                            * {
                                box-sizing: border-box;
                                -moz-box-sizing: border-box;
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
                                height: 297mm;
                                padding: 10mm;
                                margin: 10mm auto;
                                border: 1px #D3D3D3 solid;
                                border-radius: 5px;
                                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
                                background: url('invoice_matrix_alt2.jpg');
                                background-size: 210mm auto;
                                font-size: 10pt;
                                position: relative;
                            }

                            .page h2 {
                                margin: 10mm 0 0 0;
                            }

                            .page hr {
                                border: 0;
                                border-top: 1px solid #000;
                                margin: 2mm 0;
                            }

                            .page .detail {
                                border: 1px solid #707070;
                                border-radius: 1mm;
                                margin: 5mm 0 0 0mm;
                                padding: 3mm 3mm 0 3mm;
                                background-color: #f3f3f3;
                            }

                            .page .detail table {
                                margin-right: 2mm;
                                display: inline-block;
                                vertical-align: top;
                            }

                            .page .detail table tr td {
                                padding: 1mm;
                            }

                            .page .item {
                                /*outline: 1px solid blue;*/
                                margin: 5mm 0 0 0mm;
                                border: 1px solid #707070;
                                overflow: hidden;
                                border-radius: 1mm;
                            }

                            .page .item table {
                                width: 100%;
                                vertical-align: top;
                            }

                            .page .item table tr td {
                                padding: 2mm;
                            }

                            .page .item table thead tr th {
                                background-color: #e1e1e1;
                                padding: 2mm;
                            }

                            .page .item table thead tr:first-child {
                                border-radius: 1mm 0 0 0;
                                -moz-border-radius: 1mm 0 0 0;
                                -webkit-border-radius: 1mm 0 0 0;
                                border-bottom: 1px solid #707070;
                            }


                            .page .item table tbody tr {
                                border-bottom: 1px solid #acacac;
                            }

                            .page .item table tbody tr:last-child {
                                border-bottom: 1px solid #707070;
                            }

                            .page .item table tfoot tr {
                                border-bottom: 1px solid #707070;
                            }

                            .page .item table tfoot tr:last-child {
                                border-bottom: 0px solid #707070;
                            }

                            .page .item table tfoot tr th {
                                background-color: #f3f3f3;
                                padding: 2mm;
                            }

                            .page .item table tfoot tr:last-child th {
                                background-color: #e1e1e1;
                                padding: 2mm;
                            }

                            .page .direktur {
                                /*outline: 1px solid blue;*/
                                margin: 30mm 0 0 142mm;
                                font-weight: bold;
                                text-align: center;
                                height: 12mm;
                                width: 40mm;
                                font-size: 12px;
                            }

                            .page .direktur hr {
                                margin: 1mm 0;
                                border: 0px;
                                border-top: 1px solid #000;
                            }

                            .text-center {
                                text-align: center
                            }

                            .text-right {
                                text-align: right
                            }

                            .text-left {
                                text-align: left
                            }

                            .text-total {
                                font-size: 12px;
                            }

                            @page {
                                /*size: A4;*/
                                margin: 0;
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
                                    border-radius: initial;
                                    width: initial;
                                    min-height: initial;
                                    box-shadow: initial;
                                    background: initial;
                                    page-break-after: always;
                                    /*background: url('invoice_matrix_alt2.jpg');*/
                                    background-size: 100% auto;
                                }

                                #print {
                                    display: none;
                                }

                                .page .detail {
                                    background-color: #f3f3f3 !important;
                                }

                                .page .item table tfoot tr th {
                                    background-color: #f3f3f3 !important;
                                }

                                .page .item table tfoot tr:last-child th {
                                    background-color: #e1e1e1 !important;
                                }
                            }

                            @media print {
                                @page {
                                    size: 8.5in 5.5in;
                                    margin: 0cm;

                                    thead {
                                        display: table-header-group;
                                    }
                                }
                        </style>

                        <div class="book">
                            <div class="page">

                                <div id="print">
                                    <button class="btn btn-primary">
                                        <i class="fa fa-print"></i>&nbsp;&nbsp;PRINT
                                    </button>
                                </div>

                                <h2>PENERIMAAN KAS</h2>
                                <b>KOHICHA CAFE</b>
                                <hr>
                                <div class="detail">
                                    <table border="0" style="width: 60mm">
                                        <tr>
                                            <td><b>Nomor</b></td>
                                            <td>:</td>
                                            <td>{{ $cash_receive->cash_receive_no }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Tanggal</b></td>
                                            <td>:</td>
                                            <td>{{ $cash_receive->cash_receive_date }}</td>
                                        </tr>
                                    </table>
                                    <table border="0" style="width: 50mm">
                                        <tr>
                                            <td><b>Akun Debit</td>
                                            <td>:</td>
                                            <td>{{ $cash_receive->coa_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Jenis Pembayaran</b></td>
                                            <td>:</td>
                                            <td>{{ $cash_receive->pay_type_name }}</td>
                                        </tr>
                                    </table>
                                    <table border="0" style="width: 60mm">
                                        <tr>
                                            <td><b>Keterangan</b></td>
                                            <td>:</td>
                                            <td>{{ $cash_receive->remark }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="item">
                                    <table border="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-left">Keterangan</th>
                                                <th class="text-left">Akun Kredit</th>
                                                <th class="text-center">Akun Kredit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                                $total_debet = 0;
                                                $total_credit = 0;
                                            @endphp
                                            @foreach ($cash_receive_detail as $key => $cash_receive_details)
                                                <tr>
                                                    <td class="text-center">{{ $i++ }}</td>
                                                    <td class="text-left">{{ $cash_receive_details->description }}</td>
                                                    <td class="text-left">{{ $cash_receive_details->coa_name }}</td>
                                                    <td class="text-right">
                                                        {{ number_format($cash_receive_details->debt_show, 0) }}</td>
                                                    {{-- <td class="text-right">{{ number_format($cash_receive_details->credit_show,0) }}</td>  --}}
                                                    @php
                                                        $total_debet += $cash_receive_details->debt_show;
                                                        $total_credit += $cash_receive_details->credit_show;
                                                    @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="sub-total">
                                                <th class="text-right" colspan="3">Total</th>
                                                <th class="text-right"><b>{{ number_format($total_debet, 0) }}</b></th>
                                                {{-- <th class="text-right"><b>{{ number_format($total_credit,0) }}</b></th> --}}
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="direktur">
                                    <hr>
                                </div>
                            </div>
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->
    </div>
    </div>

@stop
