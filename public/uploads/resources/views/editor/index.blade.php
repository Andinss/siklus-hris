@extends('layouts.editor.template')
@section('title', 'Halaman Depan') 
@section('content')
<style type="text/css">
.jq-icon-info {
    background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR…b0vjdyFT4Cxk3e/kIqlOGoVLwwPevpYHT+00T+hWwXDf4AJAOUqWcDhbwAAAAASUVORK5CYII=);
    background-color: #31708f;
    color: #fff;
    border-color: #bce8f1;
}
</style>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Halaman Depan</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                <ol class="breadcrumb">
                    <li><a href="{{ url('/editor') }}">Halaman Depan</a></li>
                    <li class="active">Halaman Depan</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
         
        <div class="row">
            <div class="col-md-12 col-lg-4">
                <div class="white-box">
                    <h3 class="box-title"> <i class="zmdi zmdi-cake"></i>&nbsp;&nbsp;&nbsp;Karyawan Ulang Tahun</h3>
                    <ul class="basic-list">
                         @foreach($employee_birthday as $employee_birthdays)
                        <li>{{ $employee_birthdays->employee_name }} <br> {{ $employee_birthdays->position_name }}  <span class="pull-right label-success label">{{ $employee_birthdays->date_birth }}</span></li> 
                        @endforeach
                    </ul>   
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="white-box">
                     <h3 class="box-title"> <i class="zmdi zmdi-accounts-alt"></i>&nbsp;&nbsp;&nbsp;Karyawan Cuti</h3>
                     <ul class="basic-list">
                        @foreach($employee_new_employee as $employee_new_employees)
                        <li>{{ $employee_new_employees->employee_name }} <br> {{ $employee_new_employees->position_name }}  <span class="pull-right label-primary label">{{ $employee_new_employees->date_birth }}</span></li> 
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="white-box">
                     <h3 class="box-title"> <i class="zmdi zmdi-view-list"></i>&nbsp;&nbsp;&nbsp;Karyawan Baru</h3>
                     <ul class="basic-list">
                         @foreach($employee_leave as $employee_leaves)
                        <li>{{ $employee_leaves->employee_name }} <br> {{ $employee_leaves->position_name }}  <span class="pull-right label-warning label">{{ $employee_leaves->date_birth }}</span></li> 
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>    
        <!-- /.row -->
             
        </div>
        <!-- /.container-fluid -->
    </div>
@stop


@section('scripts') 
<script type="text/javascript">
$(document).ready(function() {
  $.toast({
      heading: 'Selamat datang di Spinel',
      text: '{{Auth::user()->first_name}}, kami siap membantu anda.',
      position: 'top-right',
      loaderBg: '#ff6849',
      icon: 'info',
      hideAfter: 7000,

      stack: 6
  })
});
</script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>

@stop