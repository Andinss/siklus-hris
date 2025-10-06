@extends('layouts.editor.template')
@section('title', 'View Karyawan')  
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">@if(isset($employee)) View @else @endif Karyawan</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                  <li><a href="#">Karyawan & Aktivitas</a></li>
                  <li class="active">@if(isset($employee)) View @else @endif Karyawan</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div> 
      <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box printableArea">
                    <h3><b>CURRICULUM VITAE</b> <span class="pull-right">NIK: {{ $employee->nik }}</span></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="pull-left">
                                    <address>
                                        @if(isset($employee->image))                                     
                                        <img style="width: 100% !important" src="{{Config::get('constants.path.uploads')}}/employee/{{ $employee->image }}" alt="home" />
                                        @else
                                        <img src="{{Config::get('constants.path.plugin')}}/images/notif.png" alt="home" />
                                        <p style="color: red; font-size: 10px"><i><center> *Tidak ada foto karyawan</center></i></p>
                                        @endif

                                        <h3> &nbsp;<b class="text-danger"> <center>{{ $employee->employee_name }}</center> </b></h3>
                                    </address>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="pull-left text-left">
                                    <address>
                                        <h3>INFORMASI UMUM</h3>
                                        <h4 class="font-bold">Tanggal Masuk: {{ $employee->join_date }}</h4>
                                        <p class="text-muted m-l-30">Alamat:
                                            <br/> {{ $employee->address }}
                                            <br/> RT : {{ $employee->rt }}
                                            <br/> RW: {{ $employee->rw }} 
                                    </address>
                                </div> 
                            </div>
                            <div class="col-md-8">
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="pull-left text-left">
                                    <address> 
                                        <p><b>Nama Panggilan :</b> {{ $employee->nick_name }} </p>
                                        <p><b>No KTP :</b> {{ $employee->identity_no }} </p>
                                        <p><b>Tanggal Lahir :</b> {{ $employee->date_birth }} </p>
                                        <p><b>Tanggal Kontrak :</b> {{ $employee->term_date }} </p>
                                        <p><b>Tanggal Pensiun :</b> {{ $employee->pension_date }} </p>
                                        <p><b>Email :</b> {{ $employee->email }} </p>
                                        <p><b>NPWP :</b> {{ $employee->npwp }} </p>
                                        <p><b>No HP :</b> {{ $employee->hp }} </p>
                                        <p><b>Telepon :</b> {{ $employee->telp_2 }} </p>
                                        <p><b>Nama Akun Bank :</b> {{ $employee->bank_an }} </p> 
                                    </address>
                                </div> 
                            </div>

                            <div class="col-md-4">
                                <div class="pull-left text-left">
                                    <address>
                                        <p><b>Nama Akun Bank :</b> {{ $employee->bank_an }} </p>
                                        <p><b>Nomor Rekening :</b> {{ $employee->bank_account }} </p>
                                        <p><b>Cabang Bank :</b> {{ $employee->bank_name }} </p>
                                        <p><b>Jenis Kelamin :</b> {{ $employee->sex }} </p>
                                        <p><b>Status Pajak :</b> {{ $employee->tax_status }} </p>
                                        <p><b>Status Perkawinan :</b> {{ $employee->marital_status_id }} </p>
                                        <p><b>Status Karyawan :</b> {{ $employee->employee_status_id }} </p>
                                        <p><b>Agama :</b> {{ $employee->religion_id }} </p>
                                        <p><b>No Asuransi :</b> {{ $employee->insurance_no }} </p>
                                        <p><b>BPJS TK :</b> {{ $employee->bpjs_tk_no }} </p>
                                        <p><b>BPJS Kesehatan :</b> {{ $employee->bpjs_kesehatan_no }} </p> 
                                    </address>
                                </div> 
                            </div>

                        <div class="col-md-12">
                            <div class="table-responsive m-t-40" style="clear: both;">
                                {{-- <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Description</th>
                                            <th class="text-right">Quantity</th>
                                            <th class="text-right">Unit Cost</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>Milk Powder</td>
                                            <td class="text-right">2 </td>
                                            <td class="text-right"> $24 </td>
                                            <td class="text-right"> $48 </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>Air Conditioner</td>
                                            <td class="text-right"> 3 </td>
                                            <td class="text-right"> $500 </td>
                                            <td class="text-right"> $1500 </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td>RC Cars</td>
                                            <td class="text-right"> 20 </td>
                                            <td class="text-right"> %600 </td>
                                            <td class="text-right"> $12000 </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td>Down Coat</td>
                                            <td class="text-right"> 60 </td>
                                            <td class="text-right">$5 </td>
                                            <td class="text-right"> $300 </td>
                                        </tr>
                                    </tbody>
                                </table> --}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            {{-- <div class="pull-right m-t-30 text-right">
                                <p>Sub - Total amount: $13,848</p>
                                <p>vat (10%) : $138 </p>
                                <hr>
                                <h3><b>Total :</b> $13,986</h3>
                            </div> --}}
                            <div class="clearfix"></div>
                            <hr>
                            <div class="text-right">
                                <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
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
