@extends('layouts.editor.template')
@section('title')
    Form User Log
@stop
@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">
                        <i class="fa fa-plus"></i> Form
                        <small>User Log</small>
                    </h4>

                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Auth</a></li>
                        <li class="active">Form User Log</li>
                    </ol>

                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <form method="POST" action="{{ URL::route('editor.userlog.store') }}">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <select class="form-control" name="email">
                                                    <option></option>
                                                    @foreach ($users as $key => $user)
                                                        <option value="{{ $user->email }}">{{ $user->email }}</option>
                                                    @endforeach
                                                </select>
                                                <small id="emailHelp" class="form-text text-muted">We'll never share your
                                                    email with anyone else.</small>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Content</label>
                                                <input class="form-control input-daterange-datepicker" type="text"
                                                    name="daterange1" id="range">
                                                <input type="hidden" name="wrapperDateRange" id="wrapperDateRange">
                                                <input type="hidden" id="contentName" name="content">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-primary btn-md"
                                                id="btnSend">Send Email</button>
                                        </form>
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

@section('script')
    @if (isset($user))
        <script>
            function b64EncodeUnicode(str) {

                return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
                    function toSolidBytes(match, p1) {
                        return String.fromCharCode('0x' + p1);
                    }));
            }

            function b64DecodeUnicode(str) {
                return decodeURIComponent(atob(str).split('').map(function(c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                }).join(''));
            }

            $('#btnSend').prop('disabled', true)

            $('#range').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                let date = start.format('YYYY-MM-DD') + '|' + end.format('YYYY-MM-DD')
                $('#wrapperDateRange').val(date)
                // console.log('{{ URL::route('editor.userlog.dataApi') }}' + '?sort=id|desc&filter_date=' + date)
                $.ajax({
                    'url': '{{ URL::route('editor.userlog.dataApi') }}' + '?sort=id|desc&filter_date=' + date,
                    'method': 'GET',
                    'cache': false,
                    'success': function(response) {
                        console.log(JSON.stringify(response.data))

                        //   var fields = {}
                        //   var items = []
                        //   if(response){
                        //     var element = '<table>\n'
                        //         element +=   '<thead>\n'
                        //         element +=     '<tr>\n'
                        //     response.data.map(function(item){
                        //     let data = Object.keys(item)
                        //       fields = data
                        //     })
                        //
                        //     fields.map(function(item){
                        //       element += '<th>' + item + '</th>\n'
                        //       items.push(item)
                        //     })
                        //     element += '</tr> \n'
                        //     element +=  '</thead> \n'
                        //     element +=  '<tbody> \n'
                        //
                        // for(var set in response.data)
                        // {
                        //   element += '<tr> \n'
                        //   items.map(function(item){
                        //     element += '<td>'+response.data[set][item]+'</td> \n'
                        //   })
                        //   element += '</tr> \n'
                        // }
                        //
                        //
                        //     element += '</tbody> \n'
                        //     element +=  '</table>'
                        //     let dataEncode = b64EncodeUnicode(element)
                        //     console.log(b64DecodeUnicode(dataEncode))
                        $('#contentName').val(JSON.stringify(response.data))

                    }
                }).done(function() {
                    $('#btnSend').prop('disabled', false)

                })
            })

            // })
        </script>
    @endif
@stop
