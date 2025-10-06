@extends('layouts.editor.template')
@if (isset($punishment))
    @section('title', 'Edit Teguran')
@else
    @section('title', 'Tambah Baru Teguran')
@endif
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        @if (isset($punishment))
                            Edit
                        @else
                            Tambah Baru
                        @endif Teguran
                    </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li class="active">
                            @if (isset($punishment))
                                Edit
                            @else
                                Tambah Baru
                            @endif Teguran
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
                                @if (isset($punishment))
                                    {!! Form::model($punishment, [
                                        'route' => ['editor.punishment.update', $punishment->id],
                                        'method' => 'PUT',
                                        'files' => 'true',
                                    ]) !!}
                                @else
                                    {!! Form::open(['route' => 'editor.punishment.store', 'files' => 'true']) !!}
                                @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('no_trans', 'No Teguran *') }}
                                                    {{ Form::text('no_trans', old('no_trans'), ['class' => 'form-control', 'placeholder' => 'No Teguran', 'required' => 'true', 'id' => 'no_trans', 'disabled' => 'disabled']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('date_trans', 'Tanggal Teguran *') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        @if (isset($punishment))
                                                            {{ Form::text('date_trans', date('d-m-Y', strtotime($punishment->date_trans)), ['class' => 'form-control', 'placeholder' => 'Tanggal Teguran', 'id' => 'date_trans', 'required' => 'true']) }}
                                                        @else
                                                            {{ Form::text('date_trans', old('date_trans'), ['class' => 'form-control', 'placeholder' => 'Tanggal Teguran', 'id' => 'date_trans', 'required' => 'true']) }}
                                                        @endif

                                                    </div><!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('employee_id', 'Nama Karyawan *') }}
                                                    {{ Form::select('employee_id', $employee_list, old('employee_id'), ['class' => 'form-control select2', 'placeholder' => 'Pilih Karyawan', 'id' => 'employee_id', 'onchange' => 'RefreshData();', 'required' => 'true']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('sk_type_id', 'Jenis SP *') }}
                                                    {{ Form::select('sk_type_id', $sktype_list, old('sk_type_id'), ['class' => 'form-control', 'placeholder' => 'Pilih Jenis SP', 'id' => 'sk_type_id', 'required' => 'true']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('punishment_id', 'No Referensi') }}
                                                    {{ Form::select('punishment_id', $punishment_list, old('punishment_id'), ['class' => 'form-control select2', 'placeholder' => 'Pilih No Referensi', 'id' => 'punishment_id']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="display: none;">
                                                <div class="form-group">
                                                    {{ Form::label('period_date', 'Tanggal Periode') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        @if (isset($punishment))
                                                            {{ Form::text('period_date', date('d-m-Y', strtotime($punishment->period_date)), ['class' => 'form-control', 'placeholder' => 'Tanggal Periode*', 'id' => 'period_date']) }}
                                                        @else
                                                            {{ Form::text('period_date', old('period_date'), ['class' => 'form-control', 'placeholder' => 'Tanggal Periode*', 'id' => 'period_date']) }}
                                                        @endif

                                                    </div><!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{ Form::label('date_from', 'Dari Tanggal') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        @if (isset($punishment))
                                                            {{ Form::text('date_from', date('d-m-Y', strtotime($punishment->date_from)), ['class' => 'form-control', 'placeholder' => 'Dari Tanggal*', 'id' => 'date_from', 'required' => 'true']) }}
                                                        @else
                                                            {{ Form::text('date_from', old('date_from'), ['class' => 'form-control', 'placeholder' => 'Dari Tanggal*', 'id' => 'date_from', 'required' => 'true']) }}
                                                        @endif

                                                    </div><!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    {{ Form::label('date_to', 'Sampai Tanggal') }}
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                        @if (isset($punishment))
                                                            {{ Form::text('date_to', date('d-m-Y', strtotime($punishment->date_to)), ['class' => 'form-control', 'placeholder' => 'Dari Tanggal*', 'id' => 'date_to', 'required' => 'true']) }}
                                                        @else
                                                            {{ Form::text('date_to', old('date_to'), ['class' => 'form-control', 'placeholder' => 'Dari Tanggal*', 'id' => 'date_to', 'required' => 'true']) }}
                                                        @endif

                                                    </div><!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('attachment', 'Lampiran') }}<br>
                                                    <span><span>Choose file</span><input type="file"
                                                            name="attachment" /></span>
                                                    <br />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    {{ Form::label('description', 'Keterangan SP Sebelumnya') }}
                                                    {{ Form::text('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Keterangan SP Sebelumnya*', 'id' => 'description']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Pelanggaran</label>
                                                    <div class="input-group">
                                                        <textarea id="violations_committed" name="violations_committed"> 
                                            @if (isset($punishment))
{{ $punishment->violations_committed }}
@endif 
                                           </textarea>
                                                    </div><!-- /.input group -->
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Persetujuan</label>
                                                    <div class="input-group">
                                                        <textarea id="cooperation_agreement" name="cooperation_agreement"> 
                                            @if (isset($punishment))
{{ $punishment->cooperation_agreement }}
@endif 
                                           </textarea>
                                                    </div><!-- /.input group -->
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="btnsave" class="btn btn-success pull-right"><i
                                                class="fa fa-check"></i> Simpan</button>
                                        <a href="{{ URL::route('editor.punishment.index') }}"
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
    @if (isset($punishment))
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
                                        url: '../../punishment/cancel/' + {{ $punishment->id }},
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
                                                    "{{ URL::route('editor.punishment.index') }}";
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
    <script src="{{ asset('assets/plugins') }}/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
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
