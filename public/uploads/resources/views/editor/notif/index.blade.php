@extends('layouts.editor.template')
@section('content')
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header" style="margin-top: -10px; margin-bottom: -10px">
  <h1>
    <i class="fa fa-bell"></i> All Notification
    <small>Notification</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Notification</a></li>
    <li class="active">All Notification</li>
  </ol>
</section>

<section class="content">
{{ csrf_field() }}
  <div class="row">
    <div class="col-xs-3">
    </div>
    <div class="col-xs-5">
      <div class="box box-danger">
        <div class="box-body">
       <ul class="notifications">

       @foreach ($notif AS $notifs)
            <div class="media">
              <div class="media-left">
                  <img src="{{Config::get('constants.path.uploads')}}/user/{{ $notifs->username }}/thumbnail/{{Auth::user()->filename}}" class="img-circle" style="width: 50px; height: 50px">
              </div>
              <div class="media-body">
                <strong class="notification-title"><a href="#">{{ $notifs->username }}</a> </strong>

                <b> @if($notifs->type == "Branch Allocation" && $notifs->currency_name != "") Capital Goods @else {{$notifs->type}} @endif</b>
                <h4>
                  {{ $notifs->username }}
                  <small><i class="fa fa-clock-o"></i> {{ $notifs->updated_at }}</small>
                </h4>
                @if($notifs->type != 'EMKL Cost' && $notifs->type != 'Branch Allocation')
                <p>
                  {!! $notifs->log_desc !!}
                </p>
                @endif

                @if($notifs->type == 'EMKL Cost')
                   <p class="notification-desc">
                    Period: {{ $notifs->datefrom }} to {{ $notifs->dateto }}
                   </p>
                  @if($notifs->emkl != $notifs->emkl_to)
                   <p class="notification-desc">
                    EMKL: {{ $notifs->emkl }} to {{ $notifs->emkl_to }}
                  </p>
                  @endif
                  @if($notifs->plugin != $notifs->plugin_to)
                  <p class="notification-desc">
                    Plugin: {{ $notifs->plugin }} to {{ $notifs->plugin_to }}
                  </p>
                  @endif
                  @if($notifs->ls != $notifs->ls_to)
                  <p class="notification-desc">
                    LS: {{ $notifs->ls }} to {{ $notifs->ls_to }}
                  </p>
                  @endif
                  @if($notifs->kalog != $notifs->kalog_to)
                  <p class="notification-desc">
                  Kalog: {{ $notifs->kalog }} to {{ $notifs->kalog_to }}
                  </p>
                  @endif
                @else

                  @if($notifs->currency_name != "")

                  <p>
                    Container No: {{ $notifs->container_no }} <br>
                    PO No: {{ $notifs->po_number }}<br>
                    PO Date: {{ $notifs->po_date }}<br>
                  </p><br>
                  @endif
                  @if($notifs->type == 'Branch Allocation')
                  <p>
                    Container No: {{ $notifs->container_no }} <br>
                    PO No: {{ $notifs->po_number }}<br>
                    PO Date: {{ $notifs->po_date }}<br>
                    @if($notifs->tarik ==1)
                      Tarik: Yes<br>
                    @else
                      Tarik: No<br>
                    @endif
                  </p><br>
                  <p>
                    @php
                      foreach ($branch_global AS $branch_globals) {
                        $field_name = $branch_globals->field_name;
                        $field_nameto = $branch_globals->field_name."_to";
                        echo "&nbsp; ".$branch_globals->branch_name.": "; echo $notifs->$field_name." to " .$notifs->$field_nameto." </br>";
                      }
                    @endphp
                  </p>
                  @endif
               @endif
                  <div class="notification-meta">
                    <small class="timestamp">{{ $notifs->updated_at }}</small>
                  </div>
              </div>
         <hr>
        @endforeach
      </ul>
    </div>
    </div>
  </div>
</section>
@stop
