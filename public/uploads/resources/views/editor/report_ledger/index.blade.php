@extends('layouts.editor.template') 
@section('title', 'Buku Besar') 
@section('content')

<!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">@if(isset($cash_receive)) Edit @else Add New @endif Penerimaan Kas</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                  <li class="active">@if(isset($cash_receive)) Edit @else Add New @endif Penerimaan Kas</li> 
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                      <input type="number" name="dayfrom" id="dayfrom" class="form-control" placeholder="Day From" value="1">
                      <br/>
                      <input type="number" name="dayto" id="dayto" class="form-control" placeholder="Date From" value="31">
                      <br/>
                      <select name="month" id="month" class="form-control">
                        <option value="1">Januari</option> 
                        <option value="2">Februari</option> 
                        <option value="3">Maret</option> 
                        <option value="4">April</option> 
                        <option value="5">Mei</option> 
                        <option value="6">Juni</option> 
                        <option value="7">Juli</option> 
                        <option value="8">Agustus</option> 
                        <option value="9">September</option> 
                        <option value="10">Oktober</option> 
                        <option value="11">November</option> 
                        <option value="12">Desember</option>  
                      </select>
                      <br>
                      <select name="year" id="year" class="form-control">
                        <option value="2018">2018</option> 
                        <option value="2019">2019</option> 
                        <option value="2020">2020</option> 
                        <option value="2021">2021</option> 
                        <option value="2022">2022</option> 
                        <option value="2023">2023</option> 
                        <option value="2024">2024</option> 
                        <option value="2025">2025</option>  
                      </select> 
                      <br>
                      <a href="#" onclick="Link();" type="button" class="btn btn-flat btn-primary"><i class="fa fa-print"></i>&nbsp;&nbsp;Print</a>
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
<script>
  function Link()
  {  
      year = $("#year").val();
      month = $("#month").val();
      dayfrom = $("#dayfrom").val();
      dayto = $("#dayto").val();
      transaction_type = $("#transaction_type").val();
      if(year == '' || month == ''){
        $.alert({
          type: 'red',
          icon: 'fa fa-danger', // glyphicon glyphicon-heart
          title: 'Warning',
          content: 'Data can not be null!',
        });
      }else{
      window.location = "report-ledger/print/" + month + "/" + year + "/" + dayfrom + "/" + dayto;
    }
  }; 
</script> 
@stop