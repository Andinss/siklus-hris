@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Slip Gaji')
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">@yield('title')</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                        <li><a href="#">@yield('module')</a></li>
                        <li class="active">@yield('title')</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <div class="form-body">
                                    <section>
                                        <form action="{{ route('editor.payroll-slip.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('logo', 'Logo Perusahaan 200 x 60 px') }}<br>
                                                        <span><span>Pilih File</span><input type="file" name="logo"
                                                                accept="image/*" /></span>
                                                        <br />
                                                        <img src="{{ Config::get('constants.path.uploads') }}/payroll_setting/{{ $payrollSetting->logo }}"
                                                            alt="home" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('company_name', 'Nama Perusahaan') }}
                                                        {{ Form::text('company_name', old('company_name', $payrollSetting->company_name), ['class' => 'form-control', 'placeholder' => 'Nama Perusahaan', 'required' => 'true', 'id' => 'company_name']) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('address', 'Alamat Perusahaan') }}
                                                        {{ Form::text('address', old('address', $payrollSetting->address), ['class' => 'form-control', 'placeholder' => 'Alamat', 'required' => 'true', 'id' => 'address']) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('pic_name', 'Nama PIC') }}
                                                        {{ Form::text('pic_name', old('pic_name', $payrollSetting->pic), ['class' => 'form-control', 'placeholder' => 'Nama PIC', 'required' => 'true', 'id' => 'pic_name']) }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{ Form::label('ttd_pic', 'Tanda Tangan PIC') }}<br>
                                                        <span><span>Pilih File</span><input type="file" name="signature"
                                                                accept="image/*" /></span>
                                                        <br />
                                                        <img src="{{ Config::get('constants.path.uploads') }}/payroll_setting/{{ $payrollSetting->signature }}"
                                                            alt="home" />
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" id="btnsave" class="btn btn-success pull-right"><i
                                                    class="fa fa-check"></i> Simpan</button>
                                        </form>
                                    </section>
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
