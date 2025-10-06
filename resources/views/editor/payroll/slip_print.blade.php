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
             height: auto;
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

         .page h2 {
             margin: 10mm 0 0 0;
         }

         .page hr {
             border: 0;
             border-top: 1px solid #000;
             margin: 2mm 0;
         }

         .page .detail {
             margin: 2mm 0 0 0mm;
             padding: 1mm 1mm 0 1mm;
         }

         .page .detail table {
             margin-right: 2mm;
             display: inline-block;
             vertical-align: top;
         }

         .page .detail table tr td {
             padding: 1mm;
         }

         .page .contents {
             margin: 2mm 0 0 0mm;
             padding: 1mm 1mm 0 1mm;
         }

         .page .contents table {
             margin-right: 2mm;
             width: 100%;
             display: inline-block;
             vertical-align: top;
         }

         .page .contents table tr td {
             padding: 1mm;
         }

         .page .item {
             /*outline: 1px solid blue;*/
             margin: 5mm 0 0 0mm;
             width: 100%;
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
             padding: 1mm;
         }

         .page .item table tfoot tr:last-child th {
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

             .page .detail {}

             .page .item table tfoot tr th {}

             .page .item table tfoot tr:last-child th {}
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
     <style>
         * {
             box-sizing: border-box;
         }

         /* Create three equal columns that floats next to each other */
         .page .column {
             float: left;
             width: 33.33%;
             padding: 5px;
             height: 100px;
             /* Should be removed. Only for demonstration */
         }

         /* Clear floats after the columns */
         .page .row:after {
             content: "";
             display: table;
             clear: both;
         }
     </style>


     @foreach ($payrolls as $payroll)
         <div class="page">
             <h4><b class="text-danger">SLIP GAJI KOHICHA CAFE {{ strtoupper($payroll->description) }}</b></h4>
             <hr>
             <div class="detail">
                 <table border="0" style="width: 90mm">
                     <tr>
                         <td><b>Nama</b></td>
                         <td><b>:</b> </td>
                         <td>
                             <b>{{ $payroll->employee_name }}</b>
                         </td>
                     </tr>
                     <tr>
                         <td>Posisi</td>
                         <td>: </td>
                         <td>{{ $payroll->position_name }}</td>
                     </tr>
                     <tr>
                         <td>ID Karyawan</td>
                         <td>:</td>
                         <td>{{ $payroll->nik }}</td>
                     </tr>
                     <tr>
                         <td>Tanggal Masuk</td>
                         <td>: </td>
                         <td>{{ $payroll->join_date }}</td>
                     </tr>
                 </table>

                 <table border="0" style="width: 90mm">
                     <tr>
                         <td>
                             No KTP
                         </td>
                         <td>
                             :
                         </td>
                         <td>
                             {{ $payroll->identity_no }}
                         </td>
                     </tr>
                     <tr>
                         <td>No NPWP </td>
                         <td>: </td>
                         <td>{{ $payroll->npwp }}</td>
                     </tr>
                     <tr>
                         <td>No BPJS</td>
                         <td> :</td>
                         <td>{{ $payroll->bpjs }}</td>
                     </tr>
                     <tr>
                         <td>
                             No Rek (AN)
                         </td>
                         <td>
                             :
                         </td>
                         <td>
                             {{ $payroll->bank_name }} / {{ $payroll->bank_account }} ({{ $payroll->bank_an }})
                         </td>
                     </tr>
                 </table>
             </div>
             <hr>
             <div class="contents">
                 <table border="1" style="width: 90mm">
                     <tr>
                         <th colspan="3" style="width: 100% !important"> PENDAPATAN</th>
                     </tr>
                     <tr>
                         <td style="width:  100% !important">Gaji Pokok : {{ number_format($payroll->day_in) }} Hari</td>
                         <td style="width: 10% !important">:</td>
                         <td class="text-right" style="width: 20% !important"> {{ number_format($payroll->basic) }}</td>
                     </tr>
                     <tr>
                         <td class="text-left">Uang Makan </td>
                         <td>:</td>
                         <td class="text-right"> {{ number_format($payroll->meal_trans_all) }}</td>
                     </tr>
                     <tr>
                         <td class="text-left">Uang Lembur</td>
                         <td>:</td>
                         <td class="text-right"> {{ number_format($payroll->overtime_all) }}</td>
                     </tr>
                     <tr>
                         <td class="text-left"><b>Total Pendapatan</b></td>
                         <td>:</td>
                         <td class="text-right">
                             <b>{{ number_format($payroll->basic + $payroll->meal_trans_all + $payroll->overtime_all + $payroll->insentive + $payroll->transport_all) }}</b>
                         </td>
                     </tr>
                 </table>
                 <table border="1" style="width: 90mm">
                     <thead>
                         <th colspan="3"> PENGURANGAN</th>
                     </thead>
                     <tbody>
                         <tr>
                             <td class="text-left">BPJS TK</td>
                             <td>:</td>
                             <td class="text-right">{{ number_format($payroll->jamsostek) }}</td>
                         </tr>
                         <tr>
                             <td class="text-left">BPJS</td>
                             <td>:</td>
                             <td class="text-right">{{ number_format($payroll->bpjs) }}</td>
                         </tr>
                         <tr>
                             <td class="text-left">Pph 21</td>
                             <td>:</td>
                             <td class="text-right">{{ number_format($payroll->pph_21) }}</td>
                         </tr>
                         <tr>
                             <td style="width:  100% !important">Potongan Lainnya</td>
                             <td>:</td>
                             <td class="text-right">{{ number_format($payroll->other_ded) }}</td>
                         </tr>
                         <tr>
                             <td class="text-left"><b>Total Pengurangan</b></td>
                             <td>:</td>
                             <td class="text-right">
                                 <b>{{ number_format($payroll->other_ded + $payroll->jamsostek + $payroll->bpjs + $payroll->pph_21) }}</b>
                             </td>
                         </tr>
                     </tbody>
                 </table>
             </div>
             <h4 align="right"><b class="text-danger">TOTAL THP {{ number_format($payroll->total_netto) }}</b></h4>

             <div class="row" style="margin-top: -20px">
                 <div class="column">
                     <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dibuat Oleh</p>
                     <p style="margin-top: 55px">(..........................)</p>
                 </div>
                 <div class="column">
                     <b></b>
                     <p style="margin-top: 55px"></p>
                 </div>
                 <div class="column">
                     <p>Mengetahui</p>
                     <p style="margin-top: 55px; margin-left: -10px">(.......................)</p>
                 </div>
             </div>
         </div>
     @endforeach



     </div>
     </div>

 @stop
