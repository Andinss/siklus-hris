@extends('layouts.editor.template')
@if (isset($preference))
    @section('title', 'Edit Preferensi')
@else
    @section('title', 'Tambah Baru Preferensi')
@endif
@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        @if (isset($preference))
                            Edit
                        @else
                            Tambah Baru
                        @endif Preferensi
                    </h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/editor') }}">Halaman Utama</a></li>
                        <li class="active">
                            @if (isset($preference))
                                Edit
                            @else
                                Tambah Baru
                            @endif Preferensi
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
                                @if (isset($preference))
                                    {!! Form::model($preference, [
                                        'route' => ['editor.preference.update', $preference->id],
                                        'method' => 'PUT',
                                        'files' => 'true',
                                    ]) !!}
                                @else
                                    {!! Form::open(['route' => 'editor.preference.store', 'files' => 'true']) !!}
                                @endif
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('company_name', 'Nama Perusahaan') }}
                                                    {{ Form::text('company_name', old('company_name'), ['class' => 'form-control', 'placeholder' => 'Nama Perusahaan', 'required' => 'true', 'id' => 'company_name']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('address', 'Alamat') }}
                                                    {{ Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => 'Alamat', 'required' => 'true', 'id' => 'address']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('phone', 'Telp') }}
                                                    {{ Form::text('phone', old('phone'), ['class' => 'form-control', 'placeholder' => 'Telp', 'required' => 'true', 'id' => 'phone']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('email', 'Email') }}
                                                    {{ Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'true', 'id' => 'email']) }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('logo', 'Logo 200 x 60 px') }}<br>
                                                    <span><span>Pilih File</span><input type="file"
                                                            name="logo" /></span>
                                                    <br />
                                                    <img src="{{ Config::get('constants.path.uploads') }}/preference/{{ $preference->logo }}"
                                                        alt="home" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="btnsave" class="btn btn-success pull-right"><i
                                                class="fa fa-check"></i> Simpan</button>
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
    @if (isset($preference))
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
                                        url: '../../preference/cancel/' + {{ $preference->id }},
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
                                                    "{{ URL::route('editor.preference.index') }}";
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

            width = window.innerWidth ? window.innerWidth : preference.preferenceElement.clientWidth ? preference
                .preferenceElement.clientWidth : screen.width;
            height = window.innerHeight ? window.innerHeight : preference.preferenceElement.clientHeight ? preference
                .preferenceElement.clientHeight : screen.height;

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
        jQuery('.mydatepicker, #preferencedate').datepicker();
        jQuery('.mydatepicker, #expireddate').datepicker();

        $('#preferencedate').datepicker({
            format: 'dd-mm-yyyy'
        });
        $('#expireddate').datepicker({
            format: 'dd-mm-yyyy'
        });
    </script>
@stop
