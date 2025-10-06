@extends('layouts.editor.template')
@if (isset($document))
    @section('title', 'Edit Dokumen')
@else
    @section('title', 'Tambah Baru Dokumen')
@endif
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        @if (isset($document))
                            Edit
                        @else
                            Tambah Baru
                        @endif Dokumen
                    </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li class="active">
                            @if (isset($document))
                                Edit
                            @else
                                Tambah Baru
                            @endif Dokumen
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
                                @if (isset($document))
                                    {!! Form::model($document, [
                                        'route' => ['editor.document.update', $document->id],
                                        'method' => 'PUT',
                                        'files' => 'true',
                                    ]) !!}
                                @else
                                    {!! Form::open(['route' => 'editor.document.store', 'files' => 'true']) !!}
                                @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('documentno', 'Nomor Dokumen') }}
                                                    {{ Form::text('documentno', old('documentno'), ['class' => 'form-control', 'placeholder' => 'Nomor Dokumen', 'required' => 'true', 'id' => 'documentno']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('documentname', 'Nama Dokumen') }}
                                                    {{ Form::text('documentname', old('documentname'), ['class' => 'form-control', 'placeholder' => 'Nama Dokumen', 'required' => 'true', 'id' => 'documentname']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('date_trans', 'Tanggal Dokumen *') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        @if (isset($document))
                                                            {{ Form::text('documentdate', date('d-m-Y', strtotime($document->documentdate)), ['class' => 'form-control', 'placeholder' => 'Tanggal Dokumen', 'id' => 'documentdate', 'required' => 'true']) }}
                                                        @else
                                                            {{ Form::text('documentdate', old('documentdate'), ['class' => 'form-control', 'placeholder' => 'Tanggal Dokumen', 'id' => 'documentdate', 'required' => 'true']) }}
                                                        @endif

                                                    </div><!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('date_trans', 'Tanggal Kadaluarsa *') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>

                                                        @if (isset($document))
                                                            {{ Form::text('expireddate', date('d-m-Y', strtotime($document->expireddate)), ['class' => 'form-control', 'placeholder' => 'Tanggal Kadaluarsa', 'id' => 'expireddate', 'required' => 'true']) }}
                                                        @else
                                                            {{ Form::text('expireddate', old('expireddate'), ['class' => 'form-control', 'placeholder' => 'Tanggal Kadaluarsa', 'id' => 'expireddate', 'required' => 'true']) }}
                                                        @endif

                                                    </div><!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('dayprocess', 'Hari Proses') }}
                                                    {{ Form::text('dayprocess', old('dayprocess'), ['class' => 'form-control', 'placeholder' => 'Hari Proses', 'required' => 'true', 'id' => 'dayprocess']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{ Form::label('amount', 'Nominal') }}
                                                    {{ Form::text('amount', old('amount'), ['class' => 'form-control', 'placeholder' => 'Nominal', 'required' => 'true', 'id' => 'amount']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('attachment', 'Lampiran') }}<br>
                                                    <span><span>Pilih File</span><input type="file"
                                                            name="attachment" /></span>
                                                    <br />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="btnsave" class="btn btn-success pull-right"><i
                                                class="fa fa-check"></i> Simpan</button>
                                        <a href="{{ URL::route('editor.document.index') }}"
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
    @if (isset($document))
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
                                        url: '../../document/cancel/' + {{ $document->id }},
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
                                                    "{{ URL::route('editor.document.index') }}";
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
        jQuery('.mydatepicker, #documentdate').datepicker();
        jQuery('.mydatepicker, #expireddate').datepicker();

        $('#documentdate').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#expireddate').datepicker({
            format: 'dd-mm-yyyy'
        });
    </script>
@stop
