@extends('layouts.editor.template')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Profil</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                  <ol class="breadcrumb">
                    <li><a href="{{url('/')}}/editor"><i class="fa fa-dashboard"></i> Halaman Depan</a></li>
                    <li class="active">Profil</li>
                  </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
             <div class="col-sm-12">
                <div class="white-box">
                 <hr>
                   <div class="box-body">
                     <div class="table-responsive" >
						 <div class="x_panel">
						       <h2>
						         <i class="fa fa-user"></i> Profil Anda
						         <a href="{{ URL::route('editor.profile.edit') }}" class="btn btn-default pull-right btn-flat btn-lg"><i class="fa fa-pencil"></i> Edit</a>
						       </h2>
						       <hr>
						     <div class="x_content">
						           <div class="col-md-12 col-sm-12 col-xs-12 form-group">
						             <table class="table table-bordered table-hover">
						               <tr>
						                 <th>Nama</th>
						                 <td>{{Auth::user()->username}}</td>
						               </tr>
						               <tr>
						                 <th>Email</th>
						                 <td>{{Auth::user()->email}}</td>
						               </tr>
						               <tr>
						                 <th>Nama Depan</th>
						                 <td>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</td>
						               </tr>
						               <tr>
						                 <th>Tanggal Terdaftar</th>
						                 <td>{{date("d-m-Y", strtotime(Auth::user()->created_at))}}</td>
						               </tr>
						               <tr>
						                 <th>Foto</th>
						                 <td>
						                   @if(Auth::user()->filename == null)
						               <br/><a class="fancybox" rel="group" href="{{Config::get('constants.path.uploads')}}/user/placeholder.png"><img src="{{Config::get('constants.path.uploads')}}/user/thumbnail/placeholder.png" class="img-thumbnail img-responsive" /></a><br/>
						             @else
						               <br/><a class="fancybox" rel="group" href="{{Config::get('constants.path.uploads')}}/user/{{Auth::user()->username}}/{{Auth::user()->filename}}"><img src="{{Config::get('constants.path.uploads')}}/user/{{Auth::user()->username}}/thumbnail/{{Auth::user()->filename}}" class="img-thumbnail img-responsive" /></a>
						               <br/>
						             @endif
						           </td>
						               </tr>
						             </table>
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
<!-- Add fancyBox -->
<link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
@stop
