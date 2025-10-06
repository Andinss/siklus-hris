@extends('layouts.editor.template')
@section('title', 'Event')
@section('content')

    {{-- <link href="{{asset('assets/css')}}/style.css" rel="stylesheet"> --}}
    <script src="http://cdn.rawgit.com/hilios/jQuery.countdown/2.2.0/dist/jquery.countdown.min.js"></script>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Event</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li class="active">Event</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h1>
                                        <center> Scan QR Code Untuk Absen</center>
                                    </h1>
                                </div>
                                <div class="col-md-6">
                                    <h2>
                                        <center>Contdown Event</center>
                                    </h2>
                                    <h2 style="color: red">
                                        <center>
                                            <div id="clock"></div>
                                        </center>
                                    </h2>
                                    {!! QrCode::size(400)->generate($event->no_trans) !!}
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <img class="card-img-top"
                                            src="{{ asset('uploads') }}/event/{{ $event->attachment }}" alt="Foto sampul">
                                        <div class="card-block">
                                            <h4 class="card-title">{{ $event->event_name }}</h4>
                                            <p class="card-text">{{ $event->description }}</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">{{ date('d M Y', strtotime($event->date_trans)) }}
                                            </li>
                                            <li class="list-group-item">Gedung Merah Putih</li>
                                            <li class="list-group-item">Jumlah Peserta {{ $event->participant }} Orang</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#clock').countdown('{{ date('Y/m/d', strtotime($event->date_trans)) }}', function(event) {
            var $this = $(this).html(event.strftime('' +
                '<span>%w</span> weeks ' +
                '<span>%d</span> days ' +
                '<span>%H</span> hr ' +
                '<span>%M</span> min ' +
                '<span>%S</span> sec'));
        });
    </script>
@stop
