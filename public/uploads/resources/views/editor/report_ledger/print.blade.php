 @extends('layouts.editor.template')
 @section('title', 'Buku Besar')  
 @section('content')
 

<!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title"> Buku Besar</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Keuangan</a></li>
                  <li class="active">Buku Besar</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div> 
      <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box printableArea"> 
                  <style type="text/css">
                      #print{
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

                        /*table{border-collapse: collapse;}*/
                        table tr td, table tr th{vertical-align: top;font-size: 8pt;padding: 0mm;}
                        tr.border_top td {
                        border-top:1pt solid black;
                        }

                        .page {
                            width: 210mm;
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
                          .page h2{margin: 10mm 0 0 0;}
                          .page hr{
                            border: 0;
                            border-top: 1px solid #000;
                            margin: 2mm 0;
                          }
                          .page .detail{
                            border: 1px solid #707070;
                            border-radius: 1mm;
                            margin: 5mm 0 0 0mm;
                            padding:3mm 3mm 0 3mm;
                            background-color: #f3f3f3;
                          }
                            .page .detail table{
                              margin-right: 2mm;
                              display: inline-block;
                              vertical-align: top;
                            }
                            .page .detail table tr td{
                              padding: 1mm;
                            }
                          .page .item{
                            /*outline: 1px solid blue;*/
                            margin: 5mm 0 0 0mm;
                            border: 1px solid #707070;
                            overflow: hidden;
                            border-radius: 1mm;
                          }
                            .page .item table{
                              width: 100%;
                              vertical-align: top;
                            }
                            .page .item table tr td{
                              padding:2mm;
                            }
                            .page .item table thead tr th{
                              background-color: #e1e1e1;
                              padding:2mm;
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
                          .page .item table tfoot tr{
                              border-bottom: 1px solid #707070;
                          }
                          .page .item table tfoot tr:last-child{
                              border-bottom: 0px solid #707070;
                          }
                          .page .item table tfoot tr th{
                              background-color: #f3f3f3;
                              padding:2mm;
                            }
                          .page .item table tfoot tr:last-child th{
                              background-color: #e1e1e1;
                              padding:2mm;
                            }
                   
                          .page .direktur{
                            /*outline: 1px solid blue;*/
                            margin: 30mm 0 0 142mm;
                            font-weight:bold;
                            text-align: center;
                            height: 12mm;
                            width: 40mm;
                            font-size: 12px;
                          }

                          .page .direktur hr{margin:1mm 0;border: 0px;border-top:1px solid #000;}
                   
                          .text-center{text-align: center}
                          .text-right{text-align: right}
                          .text-left{text-align: left}
                          .text-total{font-size: 12px;}

                        @page {
                            /*size: A4;*/
                            margin: 0;
                        }
                        @media print {
                            html, body {
                                width: 210mm;       
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
                            #print{display: none;}
                            .page .detail{
                            background-color: #f3f3f3 !important;
                          }
                          .page .item table tfoot tr th{
                              background-color: #f3f3f3 !important;
                            }
                          .page .item table tfoot tr:last-child th{
                              background-color: #e1e1e1 !important;
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
                          padding: 50px;
                          height: 300px; /* Should be removed. Only for demonstration */
                      }

                      /* Clear floats after the columns */
                     .page .row:after {
                          content: "";
                          display: table;
                          clear: both;
                      }
                  </style>
                    @php
                    $remain = $remain->amount;

                    if(isset($datareceive->amount)){
                      $cash_receive = $datareceive->amount;
                    }else{
                      $cash_receive = 0  ;
                    }; 
                   @endphp
                    @php
                     $t_total = 0; 
                     $n = 1;
                   @endphp
                    <div class="row">
                        <div class="col-md-12">
                          <div class="book">
                            <div class="page"> 
                              <div class="text-right">
                                  <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                              </div>
                              <h2>LAPORAN KAS KOHICHA CAFE</h2>
                              <h3>BULAN {{ strtoupper($datafilter->monthname) }} {{ $year }}</h3>
                              <hr>
                              <div class="detail">
                                <table border="0" style="width: 100mm">
                                  <tr>
                                    <td><b>SALDO AKHIR {{ strtoupper($datafilterbefore->monthname) }} {{ $year }}</b></td>
                                    <td>:</td>
                                    @if(isset($remain_before_amount))
                                    <td>@php echo number_format($remain_before_amount) @endphp</td>
                                    @else
                                    <td>0</td>
                                    @endif
                                  </tr>
                                  <tr>
                                    <td><b>TOTAL PENERIMAAN {{ strtoupper($datafilter->monthname) }} {{ $year }}</b></td>
                                    <td>:</td>
                                    @if(isset($datareceive->amount))
                                    <td>@php echo number_format($datareceive->amount) @endphp</td>
                                    @else
                                    <td></td>
                                    @endif
                                  </tr> 
                                  <tr>
                                    <td><b>TOTAL PENGELUARAN {{ strtoupper($datafilter->monthname) }} {{ $year }}</b></td>
                                    <td>:</td>
                                    <td>@php echo number_format($payment->amount) @endphp</td>
                                  </tr> 
                                  <tr>
                                    <td><b>SALDO PER {{ strtoupper($datafilter->monthname) }} {{ $year }}</b></td>
                                    <td>:</td>
                                    <td>{{ number_format($remain_amount) }}</td>
                                  </tr> 
                                </table>
                              </div>
                               
                              <div class="item">
                                <table border="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>  
                                                <th>No Transaksi</th>
                                                <th>Keterangan</th>
                                                <th>Debit</th>
                                                <th>Kredit</th>
                                                <th>Saldo</th>
                                            </tr>
                                        </thead>
                                        <input type="hidden" id="total_count" value="0">
                                        <tbody id="selected_items">
                                          @php
                                             $t_total = 0; 
                                             $balance = 0; 
                                             $remain = $remain + $cash_receive - $t_total; 
                                             $n = 1;
                                             $previousValue = null;
                                           @endphp
                                           @foreach($itemdata as $itemdatas)
                                           @php
                                             $balance -= $itemdatas->credit - $itemdatas->debt;
                                           @endphp 
                                             @php 
                                               $t_total += $itemdatas->debt; 
                                             @endphp
                                              @php
                                                $value = $itemdatas->no_trans; 

                                                if($previousValue) {
                                                  if($previousValue != $value){
                                                    echo '<tr class="border_top">';
                                                  }else{
                                                    echo '<tr>';
                                                  };
                                                }
                                                $previousValue = $itemdatas->no_trans;
                                              @endphp
                                              
                                                  <td>{{ $itemdatas->date_trans }}</td>
                                                  <td>{{ $itemdatas->no_trans }}</td>
                                                  <td>{{ $itemdatas->coa_name }}</td>
                                                  <td><p align="right">{{ number_format($itemdatas->debt) }}</p></td>
                                                  <td><p align="right">{{ number_format($itemdatas->credit) }}</p></td> 
                                                  <td><p align="right">@php echo number_format($balance); @endphp </p></td> 
                                                  {{-- <hr> --}}
                                              </tr> 
                                           @endforeach
                                        </tbody>
                                </table>
                              </div>
                              <br>

                              <div class="row" style="margin-top: 10px">
                                <div class="column">
                                  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dibuat Oleh</p>
                                  <p style="margin-top: 70px">(........................)</p>
                                </div>
                                <div class="column">
                                  <b></b>
                                  <p style="margin-top: 70px"></p>
                                </div>
                                <div class="column">
                                  <p>Mengetahui</p>
                                  <p style="margin-top: 70px; margin-left: -10px">(........................)</p>
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
