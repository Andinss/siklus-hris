@extends('layouts.editor.template')
@if (isset($event))
    @section('title', 'Edit Event')
@else
    @section('title', 'Tambah Baru Event')
@endif
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        @if (isset($event))
                            Edit
                        @else
                            Tambah Baru
                        @endif Event
                    </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li class="active">
                            @if (isset($event))
                                Edit
                            @else
                                Tambah Baru
                            @endif Event
                        </li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                @if (isset($event))
                                    {!! Form::model($event, ['route' => ['editor.event.update', $event->id], 'method' => 'PUT', 'files' => 'true']) !!}
                                @else
                                    {!! Form::open(['route' => 'editor.event.store', 'files' => 'true']) !!}
                                @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('no_trans', 'No Event *') }}
                                                    {{ Form::text('no_trans', old('no_trans'), ['class' => 'form-control', 'placeholder' => 'No Event', 'required' => 'true', 'id' => 'no_trans', 'disabled' => 'disabled']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('date_trans', 'Tanggal Event *') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>

                                                        @if (isset($event))
                                                            {{ Form::text('date_trans', date('d-m-Y', strtotime($event->date_trans)), ['class' => 'form-control', 'placeholder' => 'Tanggal Event', 'required' => 'true', 'id' => 'date_trans', 'required' => 'true']) }}
                                                        @else
                                                            {{ Form::text('date_trans', old('date_trans'), ['class' => 'form-control', 'placeholder' => 'Tanggal Event', 'id' => 'date_trans', 'required' => 'true']) }}
                                                        @endif
                                                    </div><!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('time_from', 'Jam') }}
                                                    {{ Form::time('time_from', old('time_from'), ['class' => 'form-control', 'placeholder' => 'Jam', 'id' => 'time_from']) }}
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('participant', 'Jumlah Peserta') }}
                                                    {{ Form::number('participant', old('participant'), ['class' => 'form-control', 'placeholder' => 'Jumlah Peserta', 'id' => 'participant']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('event_name', 'Nama Event') }}
                                                    {{ Form::text('event_name', old('event_name'), ['class' => 'form-control', 'placeholder' => 'Nama Event', 'id' => 'event_name']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('description', 'Tagline') }}
                                                    {{ Form::text('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Tagline', 'id' => 'description']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('location_id', 'Lokasi') }}
                                                    {{ Form::select('location', $location_list, old('location'), ['class' => 'form-control', 'placeholder' => 'Pilih Lokasi', 'id' => 'location']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('attachment', 'Sampul Event') }}<input type="file"
                                                        name="attachment" /> .jpg / .png</span>
                                                    <br />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="btnsave" class="btn btn-success pull-right"><i
                                                class="fa fa-check"></i> Simpan</button>
                                        <a href="{{ URL::route('editor.event.index') }}"
                                            class="btn btn-default pull-right btn-flat" style="margin-right: 10px"><i
                                                class="fa fa-close"></i> Tutup</a>
                                    </section>
                                </div>
                                {!! Form::close() !!}
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
    @if (isset($event))
        <script type="text/javascript">
            function cancel() {
                $.confirm({
                        title: 'Confirm!',
                        content: 'Are you sure to cancel this data?',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            cancel: {
                                action: function() {}
                            },
                            confirm: {
                                text: 'CANCEL',
                                btnClass: 'btn-red',
                                action: function() {
                                    $.ajax({
                                        url: '../../event/cancel/' + {{ $event->id }},
                                        type: "PUT",
                                        data: {
                                            '_token': $('input[name=_token]').val()
                                        },
                                        success: function(data) {
                                            //var loc = 'ap_invoice';
                                            if ((data.errors)) {
                                                alert("Cancel error!");
                                            } else {
                                                window.location.href =
                                                    "{{ URL::route('editor.event.index') }}";
                                            }
                                        },
                                    });
                                }
                            },
                        });
                }

                function hidebtnactive() {
                    $('#btnsave').hide(100);
                }
        </script>
    @endif

    <script>
        function showslip(id) {
            var url = '../../mutation/slip/' + id;
            PopupCenter(url, 'Popup_Window', '700', '650');
        }

        function PopupCenter(url, title, w, h) {
            // Fixes dual-screen position                         Most browsers      Firefox  
            var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
            var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

            width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement
                .clientWidth : screen.width;
            height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                .documentElement.clientHeight : screen.height;

            var left = ((width / 2) - (w / 2)) + dualScreenLeft;
            var top = ((height / 2) - (h / 2)) + dualScreenTop;
            var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top +
                ', left=' + left);

            // Puts focus on the newWindow  
            if (window.focus) {
                newWindow.focus();
            }
        }
    </script>
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ Config::get('constants.path.plugin') }}/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
        $(function() {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('violations_committed');
            CKEDITOR.replace('cooperation_agreement');
            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();
        });
    </script>
    <script
        src="{{ Config::get('constants.path.plugin') }}/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js">
    </script>
    <script type="text/javascript">
        jQuery('.mydatepicker, #date_trans').datepicker();
        jQuery('.mydatepicker, #date_from').datepicker();
        jQuery('.mydatepicker, #date_to').datepicker();
        jQuery('.mydatepicker, #period_date').datepicker();

        $('#date_trans').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#date_from').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#date_to').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#period_date').datepicker({
            format: 'dd-mm-yyyy'
        });
    </script>
@stop
