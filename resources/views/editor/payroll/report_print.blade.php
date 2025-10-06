 @extends('layouts.editor.template_report')
 @section('title', 'Laporan Gaji')
 @section('content')


     <!-- Page Content -->
     <div id="page-wrapper">
         <div class="row">
             <div class="col-md-12">
                 <div class="white-box printableArea">
                     <style type="text/css">
                         #print {
                             position: absolute;
                             right: 5px;
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

                         /*table{border-collapse: collapse;}*/
                         table tr td,
                         table tr th {
                             vertical-align: top;
                             font-size: 7pt;
                             padding: -20mm;
                             width: 320% !important;
                         }

                         tr.border_top td {
                             border-top: -5pt solid black;
                         }

                         .page {
                             width: 100%;
                             padding: 1mm;
                             margin: 1mm auto;
                             /*border: 1px #D3D3D3 solid;*/
                             /*border-radius: 1px;*/
                             box-shadow: 0 0 2px rgba(0, 0, 0, 0.1);
                             background: url('invoice_matrix_alt2.jpg');
                             background-size: 310mm auto;
                             font-size: 8pt;
                             position: relative;
                         }

                         .page h2 {
                             margin: 2mm 0 0 0;
                         }

                         .page hr {
                             border: 0;
                             border-top: 1px solid #000;
                             margin: 2mm 0;
                         }

                         .page .detail {
                             border: 1px solid #707070;
                             border-radius: 1mm;
                             margin: 3mm 0 0 0mm;
                             padding: 2mm 2mm 0 2mm;
                             background-color: #f3f3f3;
                         }

                         .page .detail table {
                             margin-right: 1mm;
                             display: inline-block;
                             vertical-align: top;
                         }

                         .page .detail table tr td {
                             padding: 1mm;
                         }

                         .page .item {
                             /*outline: 1px solid blue;*/
                             margin: 3mm 0 0 0mm;
                             border: 1px solid #707070;
                             overflow: hidden;
                             border-radius: 1mm;
                         }

                         .page .item table {
                             width: 120%;
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
                             font-size: 10px;
                         }
                     </style>
                     <style>
                         * {
                             box-sizing: border-box;
                         }

                         /* Create three equal columns that floats next to each other */
                         .page .column {
                             float: left;
                             width: 33.33%;
                             padding: 50px;
                             height: 300px;
                             /* Should be removed. Only for demonstration */
                         }

                         /* Clear floats after the columns */
                         .page .row:after {
                             content: "";
                             display: table;
                             clear: both;
                         }


                         @media print {
                             #scrollableDiv {
                                 width: 100%;
                                 height: 100%;
                                 overflow: hidden;
                             }

                         }
                     </style>

                     <?php
                     $tanggal = '2015-06-03';
                     $day = date('D', strtotime($tanggal));
                     $dayList = [
                         'Sun' => 'Minggu',
                         'Mon' => 'Senin',
                         'Tue' => 'Selasa',
                         'Wed' => 'Rabu',
                         'Thu' => 'Kamis',
                         'Fri' => 'Jumat',
                         'Sat' => 'Sabtu',
                     ];
                     ?>

                     <div class="row">
                         <div class="col-md-12">
                             <div class="book">
                                 <div class="page">
                                     <h2>LAPORAN GAJI</h2>
                                     <h3>{{ strtoupper($payroll->description) }}</h3>
                                     <hr>

                                     <table border="1" cellspacing="0.5">
                                         <thead>
                                             <tr>
                                             <tr>
                                                 <th rowspan="2" style="width: 1% !important;">ID</th>
                                                 <th rowspan="2" style="width: 1% !important;">Nama</th>
                                                 <th rowspan="2" style="width: 1% !important;">Posisi</th>
                                                 <th rowspan="2" style="width: 1% !important;">Hari Kerja</th>
                                                 <th rowspan="2" style="width: 1% !important;">Hadir</th>
                                                 <th rowspan="2" style="width: 1% !important;">Libur</th>
                                                 <th rowspan="2" style="width: 1% !important;">Telat</th>
                                                 <th rowspan="2" style="width: 1% !important;">Tdk Masuk</th>

                                                 <th rowspan="2" style="width: 1% !important;">Gaji Pokok</th>
                                                 <th colspan="2" style="width: 1% !important;">
                                                     <center>Uang Makan</center>
                                                 </th>
                                                 <th rowspan="2" style="width: 1% !important;">Uang Lembur</th>
                                                 <th colspan="4" style="width: 1% !important;">
                                                     <center>Potongan</center>
                                                 </th>
                                                 <th rowspan="2" style="width: 1% !important;">Total</th>
                                             </tr>
                                             <tr>
                                                 <th style="width: 1% !important;">Jamsostek</th>
                                                 <th style="width: 1% !important;">BPJS</th>
                                                 <th style="width: 1% !important;">Pph 21</th>
                                                 <th style="width: 1% !important;">Potongan Lainnya</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach ($payroll_detail as $key => $payroll_details)
                                                 <tr>
                                                     <td style="width: 1% !important; text-align: center;">
                                                         {{ $payroll_details->nik }}
                                                     </td>
                                                     <td style="width: 1% !important;">
                                                         {{ $payroll_details->employee_name }}
                                                     </td>
                                                     <td style="width: 1% !important;">
                                                         {{ $payroll_details->position_name }}
                                                     </td>
                                                     <td style="width: 1% !important; text-align: center;">
                                                         {{ $payroll_details->day_in }} Hari
                                                     </td>
                                                     <td style="width: 1% !important; text-align: center;">
                                                         {{ $payroll_details->day_job }} Hari
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ $payroll_details->public_holiday }} Hari
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ $payroll_details->day_late }}
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         @if ($payroll_details->day_alpha > 0)
                                                             Alpha : {{ $payroll_details->day_alpha }} <br>
                                                             <b>Pot : {{ $payroll_details->ded_alpha }}</b>
                                                         @endif
                                                         @if ($payroll_details->day_no_permite > 0)
                                                             Sakit Tnp Surat: {{ $payroll_details->day_no_permite }} Hari
                                                             <br>
                                                             <b>Pot :
                                                                 {{ number_format($payroll_details->ded_no_permite) }}</b>
                                                         @endif <br>
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ number_format($payroll_details->basic) }}
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ $payroll_details->meal_trans_all }}
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ $payroll_details->overtime_all }}
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ $payroll_details->jamsostek }}
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ $payroll_details->bpjs }}
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ $payroll_details->pph_21 }}
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ $payroll_details->other_ded }}
                                                     </td>
                                                     <td style="width: 1% !important; text-align: right;">
                                                         {{ $payroll_details->total_netto }}
                                                     </td>
                                                 </tr>
                                             @endforeach
                                         </tbody>
                                     </table>
                                     <br>

                                     <div class="row" style="margin-top: 10px">
                                         <div class="column">
                                             <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dibuat Oleh</p>
                                             <p style="margin-top: 70px">(................................................)
                                             </p>
                                         </div>
                                         <div class="column">
                                             <b></b>
                                             <p style="margin-top: 70px"></p>
                                         </div>
                                         <div class="column">
                                             <p>Mengetahui</p>
                                             <p style="margin-top: 70px; margin-left: -10px">
                                                 (................................................)</p>
                                         </div>
                                     </div>
                                     <div class="col-md-12">
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
