 @extends('layouts.editor.template')
 @section('module', 'Form Input')
 @section('title', 'Absen')
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
                                                     <label class="control-label col-md-3">Nama</label>
                                                     <div class="col-md-8">
                                                         : {{ $time->employee_name }}
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label col-md-3">ID Karyawan</label>
                                                     <div class="col-md-8">
                                                         : {{ $time->nik }}
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label col-md-3">Jabatan</label>
                                                     <div class="col-md-8">
                                                         : {{ $time->position_name }}
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label col-md-3">Email</label>
                                                     <div class="col-md-8">
                                                         : {{ $time->email }}
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label col-md-3">Divisi</label>
                                                     <div class="col-md-8">
                                                         : {{ $time->department_name }}
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label col-md-3">Jumlah Hari Kerja</label>
                                                     <div class="col-md-8">
                                                         : {{ $time->day_in }}
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label col-md-3">Nama Periode</label>
                                                     <div class="col-md-8">
                                                         : {{ $time->absence_group_name }}
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="col-md-12">
                                                 <hr>

                                                 {!! Form::model($time, [
                                                     'route' => ['editor.time.update', $time->id, $time->employee_id],
                                                     'method' => 'PUT',
                                                     'class' => 'update',
                                                     'id' => 'form_time',
                                                 ]) !!}
                                                 <table id="table_time" class="display nowrap" cellspacing="0"">
                                                     <thead>
                                                         <tr>
                                                             <th>No.</th>
                                                             <th>#</th>
                                                             <th>Hari & Tanggal</th>
                                                             <th>Shift</th>
                                                             <th>Waktu Mulai Jam Kerja</th>
                                                             <th>Waktu Berakhir Jam Kerja</th>
                                                             <th>Status Kehadiran</th>
                                                             <th>Jam Kerja</th>
                                                             <th>Waktu Check-In</th>
                                                             <th>Foto Check-In</th>
                                                             <th>Lokasi Check-In</th>
                                                             <th>Waktu Check-Out</th>
                                                             <th>Foto Check-Out</th>
                                                             <th>Lokasi Check-Out</th>
                                                             <th>Waktu Keterlambatan</th>
                                                             <th>Pulang Cepat</th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>
                                                         @foreach ($time_detail as $key => $time_details)
                                                             <tr @if ($time_details->holiday == 1 || $time_details->holiday_overtime == 1 || $time_details->actual_in == '00:00:00') style="background-color: #f5d8dd" @endif
                                                                 @if ($time_details->diff_overtime_in > 0) style="background-color: #c6e2bd" @endif>
                                                                 <td>
                                                                     {{ $key + 1 }}
                                                                 </td>
                                                                 <td>
                                                                     <input type="checkbox" id="check"
                                                                         name="detail[{{ $time_details->id }}][check]"
                                                                         @if ($time_details->check == 1) checked @endif>
                                                                 </td>
                                                                 <td @if ($time_details->holiday == 1 || $time_details->holiday_overtime == 1 || $time_details->actual_in == '00:00:00') {{-- style="background-color: #FFC0CB" --}} @if ($time_details->holiday_overtime == 1)  data-original-title="{{ $time_details->holiday_name }}" @else data-original-title="Off" @endif
                                                                     data-container="body" data-toggle="tooltip"
                                                                     data-placement="bottom" title="" @endif >
                                                                     {{ $time_details->date_in_day }},
                                                                     {{ $time_details->date_in }}
                                                                 </td>
                                                                 <td>
                                                                     <select
                                                                         name="detail[{{ $time_details->id }}][shift_id]">
                                                                         <option value="{{ $time_details->shift_id }}">
                                                                             {{ $time_details->shift_name }}</option>
                                                                         @foreach ($shift_list as $shift)
                                                                             <option value="{{ $shift->id }}">
                                                                                 {{ $shift->shift_name }}</option>
                                                                         @endforeach
                                                                     </select>
                                                                 </td>
                                                                 <td>
                                                                     <input style="width: 100px"
                                                                         class="form-control input-sm" placeholder=""
                                                                         id="{{ $time_details->id }}"
                                                                         name="detail[{{ $time_details->id }}][day_in]"
                                                                         type="time"
                                                                         value="{{ $time_details->day_in }}">
                                                                 </td>
                                                                 <td>
                                                                     <input style="width: 100px"
                                                                         class="form-control input-sm" placeholder=""
                                                                         id="{{ $time_details->id }}"
                                                                         name="detail[{{ $time_details->id }}][day_out]"
                                                                         type="time"
                                                                         value="{{ $time_details->day_out }}">
                                                                 </td>
                                                                 <td>
                                                                     <select
                                                                         name="detail[{{ $time_details->holiday }}][holiday]">
                                                                         <option value="masuk">Masuk</option>
                                                                         <option value="tidak_masuk">Tidak Masuk</option>
                                                                     </select>
                                                                     <br>
                                                                     @if ($time_details->holiday == 1 && !empty($time_details->holiday_name) && $time_details->holiday_overtime != 1)
                                                                         <!-- {{ $time_details->holiday_name }}  -->
                                                                     @elseif ($time_details->holiday == 1 && empty($time_details->holiday_name) && $time_details->holiday_overtime != 1)
                                                                         Off
                                                                     @elseif($time_details->actual_in == '00:00:00')
                                                                         {{-- {{$time_details->day_out}} --}} Tidak Masuk
                                                                     @else
                                                                         Masuk
                                                                     @endif
                                                                 </td>
                                                                 <td>
                                                                     {{-- 08:00 Jam Kerja --}}
                                                                     @if ($time_details->work_hour === 0)
                                                                         00:00 Jam Kerja
                                                                     @else
                                                                         {{ $time_details->work_hour }} Jam Kerja

                                                                     @endif
                                                                 </td>
                                                                 <!-- <td>
                                                                     {{ $time_details->start_time }}-{{ $time_details->end_time }}
                                                                  </td> -->
                                                                 <!-- <td>
                                                                    {{ $time_details->diff_actual }} Jam
                                                                  </td>  -->
                                                                 <!-- <td>
                                                                    @if ($time_details->diff_late_in > 15 && (isset($shift->shift_name) || $shift->shift_name != 'OFF'))
                                                                    {{ $time_details->diff_late_in }}
@else
    0
                                                                    @endif Menit
                                                                  </td> -->
                                                                 <!-- <td>
                                                                    @if ($time_details->diff_late_out > 15 && (isset($shift->shift_name) || $shift->shift_name != 'OFF'))
                                                                    {{ $time_details->diff_late_out }}
@else
    0
                                                                    @endif
                                                                     Menit
                                                                  </td>  -->
                                                                 <td>
                                                                     <input style="width: 70px"
                                                                         class="form-control input-sm" placeholder=""
                                                                         id="{{ $time_details->id }}"
                                                                         name="detail[{{ $time_details->id }}][actual_in]"
                                                                         type="time"
                                                                         value="{{ $time_details->actual_in }}">
                                                                 </td>
                                                                 <td>
                                                                     {{ Form::file('detail[' . $time_details->id . '][photo_path_in]', old('image'), ['class' => 'form-control', 'placeholder' => 'Karyawan', 'id' => 'image']) }}
                                                                     <small><i>.jpeg / .png file only</i></small>
                                                                     <br>
                                                                     <a class="fancybox" rel="group"
                                                                         href="{{ Storage::url($time_details->photo_path_in) }}"
                                                                         target="_blank">
                                                                         <img src="{{ Storage::url($time_details->photo_path_in) }}"
                                                                             class="img-thumbnail img-responsive img-employee-md" />
                                                                     </a>
                                                                 </td>
                                                                 <td>
                                                                     <select class="w-100 mb-2"
                                                                         name="detail[{{ $time_details->id }}][location-checkin]">
                                                                         {{-- <option value="siklus_id">Siklus ID</option>
                                                      <option value="others">Lokasi Lain</option> --}}
                                                                         @foreach ($absenceLocations as $absenceLocation)
                                                                             <option value="{{ $absenceLocation->id }}">
                                                                                 {{ $absenceLocation->location_name }}
                                                                             </option>
                                                                         @endforeach
                                                                     </select>
                                                                     {{ Form::textarea('detail[' . $time_details->id . '][location_check_in]', old('location_check_in') ?? $time_details->location_latitude_in . ',' . $time_details->location_longitude_in, ['class' => 'form-control', 'placeholder' => 'Input Nama Lokasi dan Titik Koordinat', 'rows' => '3', 'id' => 'location_check_in', 'required' => 'true']) }}
                                                                 </td>
                                                                 <td>
                                                                     <input style="width: 70px"
                                                                         class="form-control input-sm" placeholder=""
                                                                         id="{{ $time_details->id }}"
                                                                         name="detail[{{ $time_details->id }}][actual_out]"
                                                                         type="time"
                                                                         value="{{ $time_details->actual_out }}">
                                                                 </td>
                                                                 <td>
                                                                     {{ Form::file('detail[' . $time_details->id . '[photo_path_out]', old('image'), ['class' => 'form-control', 'placeholder' => 'Karyawan', 'id' => 'image']) }}
                                                                     <small><i>.jpeg / .png file only</i></small>
                                                                     <br>
                                                                     <a class="fancybox" rel="group"
                                                                         href="{{ Storage::url($time_details->photo_path_out) }}"
                                                                         target="_blank">
                                                                         <img src="{{ Storage::url($time_details->photo_path_out) }}"
                                                                             class="img-thumbnail img-responsive img-employee-md" />
                                                                     </a>
                                                                 </td>
                                                                 <td>
                                                                     <select class="w-100 mb-2"
                                                                         name="detail[{{ $time_details->id }}][location-checkout]">
                                                                         {{-- <option value="siklus_id">Siklus ID</option>
                                                      <option value="others">Lokasi Lain</option> --}}
                                                                         @foreach ($absenceLocations as $absenceLocation)
                                                                             <option value="{{ $absenceLocation->id }}">
                                                                                 {{ $absenceLocation->location_name }}
                                                                             </option>
                                                                         @endforeach
                                                                     </select>
                                                                     {{ Form::textarea('detail[' . $time_details->id . '[location_check_out]', old('location_check_out') ?? $time_details->location_latitude_out . ',' . $time_details->location_longitude_out, ['class' => 'form-control', 'placeholder' => 'Input Nama Lokasi dan Titik Koordinat', 'rows' => '3', 'id' => 'location_check_out', 'required' => 'true']) }}
                                                                 </td>
                                                                 <!-- <td>
                                                                     @if ($time_details->diff_overtime_in > 0)
                                                                        {{ $time_details->diff_overtime_in }} Jam1
                                                                     @endif
                                                                  </td> -->
                                                                 <td>
                                                                     @if ($time_details->diff_late_in > 15 && (isset($shift->shift_name) || $shift->shift_name != 'OFF'))
                                                                         {{ $time_details->diff_late_in }}
                                                                     @else
                                                                         0
                                                                     @endif Menit
                                                                 </td>
                                                                 <td>
                                                                     @if ($time_details->diff_late_out > 15 && (isset($shift->shift_name) || $shift->shift_name != 'OFF'))
                                                                         {{ $time_details->diff_late_out }}
                                                                     @else
                                                                         0
                                                                     @endif
                                                                     Menit
                                                                 </td>
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
                                         <a href="{{ URL::route('editor.time.index') }}"
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
