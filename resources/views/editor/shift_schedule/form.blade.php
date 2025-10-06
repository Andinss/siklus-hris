 @extends('layouts.editor.template')
 @section('title', 'Jadwal Shift')
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

         th,
         td {
             overflow: hidden;
             white-space: nowrap;
             text-overflow: ellipsis;
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
     <!-- Page Content -->
     <div id="page-wrapper">
         <div class="container-fluid">
             <div class="row bg-title">
                 <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                     <h4 class="page-title">@yield('title')</h4>
                 </div>
                 <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                     <ol class="breadcrumb">
                         <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                         <li><a href="#">@yield('module')</a></li>
                         <li class="active">@yield('title')</li>
                     </ol>
                 </div>
                 <!-- /.col-lg-12 -->
             </div>

             <!-- /row -->
             <div class="row">
                 <div class="col-sm-12">
                     <div class="table-responsive">
                         <div class="col-sm-12">
                             <div class="white-box">
                                 <div class="button-box">
                                     <div class="row">
                                         <div class="col-lg-12 col-md-12 col-sm-12">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label col-md-3">Periode</label>
                                                     <div class="col-md-8">
                                                         : {{ $period->description }}
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="col-md-12">
                                                 <hr>
                                                 {!! Form::model($period, [
                                                     'route' => ['editor.shift-schedule.update', $period->id, $period->id],
                                                     'method' => 'PUT',
                                                     'class' => 'update',
                                                     'id' => 'form_time',
                                                 ]) !!}
                                                 <table id="table_time" class="display nowrap" cellspacing="0"">
                                                     <thead>
                                                         <tr>
                                                             <th>#</th>
                                                             <th>ID</th>
                                                             <th>Nama</th>
                                                             @foreach ($shift_schedule_date as $shift_schedule_dates)
                                                                 @php
                                                                     $day = date(
                                                                         'D',
                                                                         strtotime($shift_schedule_dates->date_in),
                                                                     );
                                                                 @endphp
                                                                 <th style="font-size: 12px">
                                                                     {{ date('d-m-Y', strtotime($shift_schedule_dates->date_in)) }}
                                                                     <p
                                                                         @if ($dayList[$day] == 'Minggu') style="color: red; font-size: 9px" @endif>
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
                                                             $get_shift_val = [];
                                                         @endphp
                                                         @foreach ($shift_schedule_detail as $shift_schedule_details)
                                                             @php
                                                                 $get_shift_val[] = $shift_schedule_details->shift_id;
                                                                 $get_shift_text[] =
                                                                     $shift_schedule_details->shift_name;
                                                                 // print_r($get_shift_val);
                                                             @endphp
                                                         @endforeach

                                                         @foreach ($employee_list as $key => $employee_lists)
                                                             <tr>
                                                                 <td>
                                                                     {{ $i++ }}
                                                                 </td>
                                                                 <td>
                                                                     {{ $employee_lists->nik }}
                                                                 </td>
                                                                 <td>
                                                                     {{ $employee_lists->employee_name }}
                                                                 </td>
                                                                 @if (isset($shift_schedule_date))
                                                                     @php
                                                                     @endphp
                                                                     @foreach ($shift_schedule_date as $shift_schedule_dates)
                                                                         <td data-original-title="{{ $employee_lists->employee_name }} : @php
echo $dayList[$day]; @endphp, {{ date('d-m-Y', strtotime($shift_schedule_dates->date_in)) }}"
                                                                             data-container="body" data-toggle="tooltip"
                                                                             data-placement="bottom">
                                                                             @php
                                                                                 // $foo = $i_val++;
                                                                                 $foo2 = $i_val++;
                                                                                 // echo($foo);
                                                                                 // echo($foo2);
                                                                                 // print_r($get_shift_val[$foo2]);
                                                                             @endphp
                                                                             <select
                                                                                 name="detail[{{ $employee_lists->id }}_{{ $shift_schedule_dates->date_in }}][shift_id]"
                                                                                 class="form-control">
                                                                                 <option
                                                                                     value=@php print_r($get_shift_val[$foo2]); @endphp>
                                                                                     @php print_r($get_shift_text[$foo2]); @endphp</option>
                                                                                 @foreach ($shift_list as $shift_lists)
                                                                                     <option value={{ $shift_lists->id }}>
                                                                                         {{ $shift_lists->shift_name }}
                                                                                     </option>
                                                                                 @endforeach
                                                                             </select>

                                                                         </td>
                                                                     @endforeach
                                                                 @endif
                                                             </tr>
                                                         @endforeach
                                                     </tbody>
                                                 </table>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-12">
                                         <!-- /.box-body -->
                                         <a href="#" type="button" id="btn_submit"
                                             class="btn btn-primary pull-right btn-flat"><i class="fa fa-check"></i>
                                             Simpan</a>
                                         <a href="{{ URL::route('editor.shift-schedule.index', ['period' => '1']) }}"
                                             class="btn btn-default pull-right btn-flat" style="margin-right: 10px"><i
                                                 class="fa fa-close"></i> Tutup</a>
                                         {!! Form::close() !!}
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
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
     <script type="text/javascript">
         // Tabbed table headers were not sized correctly
         $(document).ready(function() {
             $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                 $($.fn.dataTable.tables(true)).css('width', '100%');
                 $($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
             });

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
                             $('#form_time').submit();
                         }
                     },

                 }
             });
         });

         $(document).ready(function() {
             $("#table_time").dataTable({
                 "bPaginate": false,
                 "ordering": false,
                 // "scrollY": true,
                 "fixedHeader": true,
                 "initComplete": function(settings, json) {
                     $("#table_time").wrap(
                         "<div style='overflow:auto; width:100%;position:relative;'></div>");
                 },

             });
             $('#table_time').DataTable().columns.adjust().draw();

             var table = $('#table_time').DataTable();

             $('#table_time').css('display', 'block');
             table.columns.adjust().draw();
         });
     </script>

 @stop
