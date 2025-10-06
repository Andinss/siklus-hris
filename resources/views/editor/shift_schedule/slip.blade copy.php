 @extends('layouts.editor.template')
 @section('title', 'Jadwal Shift')  
 @section('content')
 

<!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title"> Jadwal Shift</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Keuangan</a></li>
                  <li class="active">Jadwal Shift</li> 
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
                        table tr td, table tr th{vertical-align: top;font-size: 7pt;padding: -20mm; width: 320% !important;}
                        tr.border_top td {
                        border-top:-5pt solid black;
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
                          .page h2{margin: 2mm 0 0 0;}
                          .page hr{
                            border: 0;
                            border-top: 1px solid #000;
                            margin: 2mm 0;
                          }
                          .page .detail{
                            border: 1px solid #707070;
                            border-radius: 1mm;
                            margin: 3mm 0 0 0mm;
                            padding:2mm 2mm 0 2mm;
                            background-color: #f3f3f3;
                          }
                            .page .detail table{
                              margin-right: 1mm;
                              display: inline-block;
                              vertical-align: top;
                            }
                            .page .detail table tr td{
                              padding: 1mm;
                            }
                          .page .item{
                            /*outline: 1px solid blue;*/
                            margin: 3mm 0 0 0mm;
                            border: 1px solid #707070;
                            overflow: hidden;
                            border-radius: 1mm;
                          }
                            .page .item table{
                              width: 120%;
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
                          .text-total{font-size: 10px;}

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


                        @media print {
                           #scrollableDiv{
                            width: 100%;
                            height: 100%;
                            overflow: hidden;  
                           }
                          
                         }
                  </style>

                   <?php
                      $tanggal = '2015-06-03';
                      $day = date('D', strtotime($tanggal));
                      $dayList = array(
                        'Sun' => 'Minggu',
                        'Mon' => 'Senin',
                        'Tue' => 'Selasa',
                        'Wed' => 'Rabu',
                        'Thu' => 'Kamis',
                        'Fri' => 'Jumat',
                        'Sat' => 'Sabtu'
                      ); 
                  ?>
                     
                    <div class="row">
                        <div class="col-md-12">
                          <div class="book">
                            <div class="page"> 
                              <div class="text-left pull-right">
                                  <a href="{{ URL::route('editor.shift-schedule.slip-print', $period->id) }}" target="_blank" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </a>
                              </div>
                              <h2>JADWAL SHIFT</h2>
                              <h3>{{ strtoupper($period->description) }}</h3>
                              <hr> 
                               
                              <div class="item" id="scrollableDiv"  style="overflow-x:auto;">
                                <table border="1" cellspacing="0.5">
                                   <thead>
                                    <tr>
                                      {{-- <th>#</th> --}}
                                      <th style="width: 1% !important">ID</th>
                                      <th style="width: 1% !important">Nama</th>
                                      @foreach($shift_schedule_date AS $shift_schedule_dates)
                                      @php
                                        $day = date('D', strtotime($shift_schedule_dates->date_in));
                                      @endphp
                                      <th style="width: 1% !important">
                                        {{date("d-m-Y", strtotime($shift_schedule_dates->date_in))}}
                                        <p @if($dayList[$day] == 'Minggu') style="color: red; font-size: 9px" @endif>
                                          <i>
                                          @php
                                            echo $dayList[$day];
                                          @endphp
                                          </i>
                                        </p>
                                      </th> 
                                      @endforeach
                                    </tr>
                                   </thead> 
                                    <tbody> 
                                    @php
                                      $i = 1;
                                      $i_val = 0;
                                    @endphp

                                    @php
                                      $get_shift_val = array();
                                    @endphp
                                    @foreach($shift_schedule_detail as $shift_schedule_details)
                                    @php  
                                      $get_shift_val[] = $shift_schedule_details->shift_time; 
                                      $get_shift_text[] = $shift_schedule_details->shift_name; 
                                       // print_r($get_shift_val);
                                    @endphp
                                    @endforeach
    
                                    @foreach($employee_list as $key => $employee_lists)
                                    <tr> 
                                       {{--  <td>
                                           {{$i++}}      
                                        </td>  --}}
                                        <td style="width: 1% !important">
                                           {{$employee_lists->nik}}      
                                        </td>  
                                        <td style="width: 1% !important">
                                           {{$employee_lists->employee_name}}      
                                        </td>   
                                        @if(isset($shift_schedule_date))
                                        @php
                                        @endphp
                                        @foreach($shift_schedule_date AS $shift_schedule_dates)
                                         <td style="width: 1% !important"> 
                                          @php
                                              // $foo = $i_val++;
                                              $foo2 = $i_val++;
                                              // echo($foo);
                                              // echo($foo2);
                                             // print_r($get_shift_val[$foo2]);
                                          @endphp
                                            @php print_r($get_shift_text[$foo2]); @endphp @php print_r($get_shift_val[$foo2]); @endphp

                                        </td>  
                                        @endforeach 
                                        @endif
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
