@extends('layouts.editor.template')
@if(isset($employee))
@section('title', 'Edit Karyawan') 
@else
@section('title', 'Add New Karyawan') 
@endif
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">@if(isset($employee)) Edit @else Tambah Baru @endif Karyawan</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Karyawan & Aktivitas</a></li>
                  <li class="active">@if(isset($employee)) Edit @else Tambah Baru @endif Karyawan</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        @if(isset($employee))
                        {!! Form::model($employee, array('route' => ['editor.employee.update', $employee->id], 'method' => 'PUT', 'files' => 'true'))!!}
                        @else
                        {!! Form::open(array('route' => 'editor.employee.store', 'files' => 'true'))!!}
                        @endif
                        {{ csrf_field() }}
                            <div class="form-body"> 
                                <section>
                                <div class="sttabs tabs-style-bar">
                                    <nav style="display: none">
                                        <ul>
                                            @if(isset($employee))
                                            <li><a href="#section-bar-1" class="sticon ti-home"><span>Home</span></a></li>
                                            <li><a href="#section-bar-2" class="sticon ti-id-badge"><span>Phone</span></a></li>
                                            <li><a href="#section-bar-3" class="sticon ti-gift"><span>Birthday</span></a></li> 
                                            @else
                                            <li></li>
                                            @endif
                                        </ul>
                                    </nav>
                                    <div class="content-wrap">
                                        <section id="section-bar-1">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('nik', 'NIK *') }}
                                                    {{ Form::text('nik', old('nik'), array('class' => 'form-control', 'placeholder' => 'NIK *', 'required' => 'true', 'id' => 'nik')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('employee_name', 'Nama *', ['class' => 'control-label']) }}
                                                    {{ Form::text('employee_name', old('employee_name'), ['class' => 'form-control', 'placeholder' => 'Nama Karyawan *', 'id' => 'employee_name', 'required' => 'true']) }}
                                                </div>
                                            </div>
                                            <!--/span--> 
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('nick_name', 'Nama Panggilan') }}
                                                    {{ Form::text('nick_name', old('nick_name'), array('class' => 'form-control', 'placeholder' => 'Nama Panggilan', 'id' => 'nick_name')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('identity_no', 'No KTP *') }}
                                                    {{ Form::text('identity_no', old('identity_no'), array('class' => 'form-control', 'placeholder' => 'No KTP *', 'id' => 'identity_no', 'required' => 'true')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('date_birth', 'Tanggal Lahir *') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  
                                                        {{ Form::text('date_birth', old('date_birth'), array('class' => 'form-control', 'placeholder' => 'Tanggal Lahir *', 'id' => 'date_birth', 'required' => 'true')) }}
                                                    </div><!-- /.input group --> 
                                                  </div>
                                            </div>
                                            <!--/span--> 
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('join_date', 'Tanggal Masuk *') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  
                                                        {{ Form::text('join_date', old('join_date'), array('class' => 'form-control', 'placeholder' => 'Tanggal Masuk *', 'required' => 'true', 'id' => 'join_date')) }}
                                                    </div><!-- /.input group --> 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('term_date', 'Tanggal Kontrak') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  
                                                        {{ Form::text('term_date', old('term_date'), array('class' => 'form-control', 'placeholder' => 'Tanggal Kontrak', 'id' => 'term_date')) }}
                                                    </div><!-- /.input group --> 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('pension_date', 'Tanggal Pensiun') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  
                                                        {{ Form::text('pension_date', old('pension_date'), array('class' => 'form-control', 'placeholder' => 'Tanggal Pensiun', 'id' => 'pension_date')) }}
                                                    </div><!-- /.input group --> 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('email', 'Email *') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>  
                                                        {{ Form::text('email', old('email'), array('class' => 'form-control', 'placeholder' => 'Email*', 'id' => 'email')) }}
                                                    </div><!-- /.input group --> 
                                                  </div>
                                            </div>
                                            <!--/span-->

                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('npwp', 'NPWP') }}
                                                    {{ Form::text('npwp', old('npwp'), array('class' => 'form-control', 'placeholder' => 'NPWP', 'id' => 'npwp')) }} 
                                                </div> 
                                            </div>
                                            <!--/span--> 
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('hp', 'No HP *') }}
                                                    {{ Form::text('hp', old('hp'), array('class' => 'form-control', 'placeholder' => 'No HP *', 'id' => 'hp', 'required' => 'true')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('telp_2', 'Telpon') }}
                                                    {{ Form::text('telp_2', old('telp_2'), array('class' => 'form-control', 'placeholder' => 'Telpon', 'id' => 'telp_2')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('bank_an', 'Nama Akun Bank') }}
                                                    {{ Form::text('bank_an', old('bank_an'), array('class' => 'form-control', 'placeholder' => 'Nama Akun Bank', 'id' => 'bank_an')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('bank_account', 'No Rekening Bank') }}
                                                    {{ Form::text('bank_account', old('bank_account'), array('class' => 'form-control', 'placeholder' => 'No Rekening Bank', 'id' => 'bank_account')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('bank_name', 'Nama Bank') }}
                                                    {{ Form::text('bank_name', old('bank_name'), array('class' => 'form-control', 'placeholder' => 'Nama Bank', 'id' => 'bank_name')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('bank_branch', 'Cabang Bank') }}
                                                    {{ Form::text('bank_branch', old('bank_branch'), array('class' => 'form-control', 'placeholder' => 'Cabang Bank', 'id' => 'bank_branch')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('sex', 'Jenis Kelamin') }}
                                                    {{ Form::select('sex', $sex_list, old('sex'), array('class' => 'form-control', 'placeholder' => 'Pilih Jenis Kelamin', 'id' => 'sex')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('tax_status', 'Status Pajak') }}
                                                    {{ Form::select('tax_status', $tax_status_list, old('tax_status'), array('class' => 'form-control', 'placeholder' => 'Pilih Status Pajak', 'id' => 'tax_status')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('marital_status_id', 'Status Perkawinan') }}
                                                    {{ Form::select('marital_status_id', $marital_status_list, old('marital_status_id'), array('class' => 'form-control', 'placeholder' => 'Pilih Status Perkawinan', 'id' => 'marital_status_id')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('employee_status_id', 'Status Karyawan') }}
                                                    {{ Form::select('employee_status_id', $employee_status_list, old('employee_status_id'), array('class' => 'form-control', 'placeholder' => 'Pilih Status Karyawan', 'id' => 'employee_status_id')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('staff_status_id', 'Level Jabatan') }}
                                                    {{ Form::select('staff_status_id', $staff_status_list, old('staff_status_id'), array('class' => 'form-control', 'placeholder' => 'Select Level Jabatan', 'id' => 'staff_status_id')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('department_id', 'Departemen') }}
                                                    {{ Form::select('department_id', $department_list, old('department_id'), array('class' => 'form-control select2', 'placeholder' => 'Pilih Departemen', 'id' => 'department_id')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                            
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('position_id', 'Posisi *') }}
                                                    {{ Form::select('position_id', $position_list, old('position_id'), array('class' => 'form-control', 'placeholder' => 'Pilih Posisi *', 'id' => 'position_id')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                   {{ Form::label('religion_id', 'Agama') }}
                                                    {{ Form::select('religion_id', $religion_list, old('religion_id'), array('class' => 'form-control', 'placeholder' => 'Pilih Agama', 'id' => 'religion_id')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('insurance_no', 'No Asuransi') }}
                                                    {{ Form::text('insurance_no', old('insurance_no'), array('class' => 'form-control', 'placeholder' => 'No Asuransi', 'id' => 'insurance_no')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('bpjs_tk_no', 'BPJS TK') }}
                                                    {{ Form::text('bpjs_tk_no', old('bpjs_tk_no'), array('class' => 'form-control', 'placeholder' => 'BPJS TK*', 'id' => 'bpjs_tk_no')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('bpjs_kesehatan_no', 'BPJS Kesehatan') }}
                                                    {{ Form::text('bpjs_kesehatan_no', old('bpjs_kesehatan_no'), array('class' => 'form-control', 'placeholder' => 'BPJS Kesehatan*', 'id' => 'bpjs_kesehatan_no')) }}
                                                </div>
                                            </div>
                                            <!--/span--> 
                                        </div>  
                                        <h3 class="box-title m-t-40">Alamat</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('address', 'Alamat') }}
                                                    {{ Form::text('address', old('address'), array('class' => 'form-control', 'placeholder' => 'Alamat*', 'id' => 'address')) }} 
                                                </div> 
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('rt', 'RT') }}
                                                    {{ Form::text('rt', old('rt'), array('class' => 'form-control', 'placeholder' => 'RT*', 'id' => 'rt')) }}
                                                </div> 
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('rw', 'RW') }}
                                                    {{ Form::text('rw', old('rw'), array('class' => 'form-control', 'placeholder' => 'RW*', 'id' => 'rw')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                             <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('kelurahan', 'Kelurahan') }}
                                                    {{ Form::text('kelurahan', old('kelurahan'), array('class' => 'form-control', 'placeholder' => 'Kelurahan*', 'id' => 'kelurahan')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('kecamatan', 'Kecamatan') }}
                                                    {{ Form::text('kecamatan', old('kecamatan'), array('class' => 'form-control', 'placeholder' => 'Kecamatan*', 'id' => 'kecamatan')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('city_id', 'City') }}
                                                    {{ Form::select('city_id', $city_list, old('city_id'), array('class' => 'form-control select2', 'placeholder' => 'Pilih City', 'id' => 'city_id')) }} 
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <h3 class="box-title m-t-40">Pendidikan Terakhir</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('education_major_id', 'Pendidikan Terakhir') }}
                                                    {{ Form::select('education_major_id', $education_major_list, old('education_major_id'), array('class' => 'form-control select2', 'placeholder' => 'Pilih Pendidikan Terakhir', 'id' => 'education_major_id')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('education_level_id', 'Level Pendidikan Terakhir') }}
                                                    {{ Form::select('education_level_id', $education_level_list, old('education_level_id'), array('class' => 'form-control select2', 'placeholder' => 'Select Level Pendidikan Terakhir', 'id' => 'education_level_id')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <h3 class="box-title m-t-40">Benefit</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    @php
                                                        if(isset($basic_amt)){
                                                            $basic = $basic_amt;
                                                        }else{
                                                            $basic = 0;
                                                        };

                                                        if(isset($meal_amt)){
                                                            $meal = $meal_amt;
                                                        }else{
                                                            $meal = 0;
                                                        };

                                                        if(isset($transportall_amt)){
                                                            $transportall = $transportall_amt;
                                                        }else{
                                                            $transport_all = 0;
                                                        }; 

                                                        if(isset($insentive_amt)){
                                                            $transportall = $insentive_amt;
                                                        }else{
                                                            $insentive_all = 0;
                                                        };  
                                                    @endphp

                                                    {{ Form::label('basic', 'Gaji Pokok *') }}
                                                    {{ Form::text('basic', old('basic', $basic), array('class' => 'form-control', 'placeholder' => 'Gaji Pokok *', 'id' => 'basic', 'oninput' => 'cal_sparator();')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('meal_trans_all', 'Uang Makan') }}
                                                    {{ Form::text('meal_trans_all', old('meal_trans_all', $meal), array('class' => 'form-control', 'placeholder' => 'Uang Makan', 'id' => 'meal_trans_all')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('transport_all', 'Transport') }}
                                                    {{ Form::text('transport_all', old('transport_all', $transport_all), array('class' => 'form-control', 'placeholder' => 'Transport*', 'id' => 'transport_all')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('insentive', 'Insentif') }}
                                                    {{ Form::text('insentive_all', old('insentive_all', $insentive_all), array('class' => 'form-control', 'placeholder' => 'Insentif', 'id' => 'insentive_all')) }}
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <h3 class="box-title m-t-40">Foto</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('image', 'Karyawan', ['class' => 'control-label']) }}
                                                    {{ Form::file('image', old('image'), ['class' => 'form-control', 'placeholder' => 'Karyawan', 'id' => 'image']) }}
                                                    <p>.jpeg / .png file only</p>
                                                    <br>
                                                    <div class="col-sm-3">
                                                        @if(isset($employee->image))
                                                         <a class="image-popup-vertical-fit" href="../../../uploads/employee/{{$employee->image}}" title=""><img src="../../../uploads/employee/{{$employee->image}}" class="img-responsive" /></a>
                                                        @endif
                                                    </div>
                                                  </div>
                                            </div>
                                            <!--/span-->

                                            <div class="col-md-6">
                                                <div class="form-group"> 
                                                    {{ Form::label('image_identity', 'KTP', ['class' => 'control-label']) }}
                                                    {{ Form::file('image_identity', old('image_identity'), ['class' => 'form-control', 'placeholder' => 'KTP', 'id' => 'image_identity']) }}
                                                    <p>.jpeg / .png file only</p>
                                                    <br>
                                                    <div class="col-sm-3">
                                                        @if(isset($employee->image_identity))
                                                         <a class="image-popup-vertical-fit" href="../../../uploads/employee/{{$employee->image_identity}}" title=""><img src="../../../uploads/employee/{{$employee->image_identity}}" class="img-responsive" /></a>
                                                        @endif
                                                    </div>
                                                  </div>
                                            </div>
                                            <!--/span--> 
                                        </div>
                                        <!--/row-->
                                        <button type="submit" class="btn btn-success btn-flat pull-right" value="save" name="save"><i class="fa fa-check"></i> Simpan</button> &nbsp;&nbsp;&nbsp;
                                        @if(isset($employee))
                                        <button type="submit" class="btn btn-success btn-flat pull-right" value="saveadd" style="margin-right: 10px" name="save"><i class="fa fa-check"></i> Simpan & Tambah</button>
                                        @endif
                                        <a href="{{ URL::route('editor.employee.index') }}" class="btn btn-default btn-flat pull-right" style="margin-right: 10px"><i class="fa fa-close"></i> Tutup</a>
                                </section>
                                </div>
                                <section> 
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>


<script src="{{Config::get('constants.path.plugin')}}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
  jQuery('.mydatepicker, #date_birth').datepicker();
  jQuery('.mydatepicker, #term_date').datepicker();
  jQuery('.mydatepicker, #join_date').datepicker();
  jQuery('.mydatepicker, #pension_date').datepicker();

  $('#date_birth').datepicker({ format: 'dd-mm-yyyy' });
  $('#term_date').datepicker({ format: 'dd-mm-yyyy' });
  $('#join_date').datepicker({ format: 'dd-mm-yyyy' });
  $('#pension_date').datepicker({ format: 'dd-mm-yyyy' });
</script>

 <!-- Add fancyBox -->
 <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
 <script type="text/javascript" src="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
 <script type="text/javascript">
  $(document).ready(function() {
    $(".fancybox").fancybox();
  });
 </script>
 <script src="{{Config::get('constants.path.js')}}/cbpFWTabs.js"></script>
 <script type="text/javascript">
 (function() {

    [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
        new CBPFWTabs(el);
    });

 })();
 </script>
@stop
